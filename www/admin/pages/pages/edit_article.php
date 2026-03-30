<?php
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php?page=dashboard");
    exit();
}

// Fetch article
$stmt = $pdo->prepare("SELECT * FROM fait_article WHERE id_article = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();

if (!$article) {
    header("Location: index.php?page=dashboard");
    exit();
}

// Fetch images
$stmtI = $pdo->prepare("SELECT * FROM fait_article_image WHERE id_article = ?");
$stmtI->execute([$id]);
$images = $stmtI->fetchAll();

// Handle deletion of an image
if (isset($_GET['delete_image'])) {
    $img_id = $_GET['delete_image'];
    $stmtDI = $pdo->prepare("SELECT image_url FROM fait_article_image WHERE id_image = ? AND id_article = ?");
    $stmtDI->execute([$img_id, $id]);
    $img_to_del = $stmtDI->fetch();

    if ($img_to_del) {
        // Delete physical file
        $file_path = __DIR__ . '/../../..' . $img_to_del['image_url'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        // Delete from DB
        $stmtDDB = $pdo->prepare("DELETE FROM fait_article_image WHERE id_image = ?");
        $stmtDDB->execute([$img_id]);

        // Re-check if there's a main image, if not, set the first one as main
        $stmtCheckMain = $pdo->prepare("SELECT id_image FROM fait_article_image WHERE id_article = ? AND is_main = 1");
        $stmtCheckMain->execute([$id]);
        if (!$stmtCheckMain->fetch()) {
            $stmtSetMain = $pdo->prepare("UPDATE fait_article_image SET is_main = 1 WHERE id_article = ? LIMIT 1");
            $stmtSetMain->execute([$id]);
        }
    }
    header("Location: index.php?page=edit_article&id=" . $id);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $slug = $_POST['slug'];
    $contenu = $_POST['contenu'];
    $id_categorie = $_POST['id_categorie'];
    $is_active = ($_POST['statut'] === 'publié') ? 1 : 0;
    $alt_text = $_POST['alt_image'] ?: $titre;

    try {
        $pdo->beginTransaction();

        // 0. Vérifier si le slug existe déjà pour un AUTRE article
        $stmtCheck = $pdo->prepare("SELECT id_article FROM fait_article WHERE slug = ? AND id_article != ?");
        $stmtCheck->execute([$slug, $id]);
        if ($stmtCheck->fetch()) {
            throw new Exception("L'URL (slug) '$slug' est déjà utilisée par un autre article. Veuillez en choisir une autre.");
        }

        // 1. Update article
        $stmtA = $pdo->prepare("UPDATE fait_article SET titre = ?, slug = ?, contenu = ?, id_categorie = ?, is_active = ?, date_publication = CASE WHEN ? = 1 AND date_publication IS NULL THEN NOW() ELSE date_publication END WHERE id_article = ?");
        $stmtA->execute([$titre, $slug, $contenu, $id_categorie, $is_active, $is_active, $id]);

        // 2. Handle new image uploads
        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $upload_dir = __DIR__ . '/../../../uploads/articles/';
            $files = $_FILES['images'];

            // Check if there is already a main image
            $stmtCheckMain = $pdo->prepare("SELECT id_image FROM fait_article_image WHERE id_article = ? AND is_main = 1");
            $stmtCheckMain->execute([$id]);
            $has_main = $stmtCheckMain->fetch() ? true : false;

            foreach ($files['name'] as $key => $name) {
                if ($files['error'][$key] === 0) {
                    $tmp_name = $files['tmp_name'][$key];
                    $extension = pathinfo($name, PATHINFO_EXTENSION);
                    $new_name = uniqid('art_' . $id . '_') . '.' . $extension;
                    $upload_path = $upload_dir . $new_name;
                    $db_path = '/uploads/articles/' . $new_name;

                    if (move_uploaded_file($tmp_name, $upload_path)) {
                        $is_main = (!$has_main && $key === 0) ? 1 : 0;
                        $stmtI = $pdo->prepare("INSERT INTO fait_article_image (id_article, image_url, alt_text, is_main) VALUES (?, ?, ?, ?)");
                        $stmtI->execute([$id, $db_path, $alt_text, $is_main]);
                        if ($is_main) $has_main = true;
                    }
                }
            }
        }

        // 3. Update alt text for all existing images of this article
        $stmtUAlt = $pdo->prepare("UPDATE fait_article_image SET alt_text = ? WHERE id_article = ?");
        $stmtUAlt->execute([$alt_text, $id]);

        $pdo->commit();
        header("Location: index.php?page=dashboard");
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Erreur lors de la modification : " . $e->getMessage();
    }
}
?>

<div style="max-width: 800px; margin: 0 auto;">
    <h1 style="margin-bottom: 30px; font-weight: 800;">Modifier l'article (Images Multiples)</h1>
    
    <?php if (isset($error)): ?>
        <div style="background: #fff0f2; color: var(--red); padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #ffccd2;">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="titre">Titre (H1) :</label>
            <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($article['titre']); ?>" required>
        </div>
        
        <div style="display: flex; gap: 20px;">
            <div class="form-group" style="flex: 1;">
                <label for="slug">Slug (URL SEO) :</label>
                <input type="text" id="slug" name="slug" value="<?php echo htmlspecialchars($article['slug']); ?>" required>
            </div>
            <div class="form-group" style="flex: 1;">
                <label for="id_categorie">Catégorie :</label>
                <select name="id_categorie" required>
                    <?php
                    $stmt = $pdo->query("SELECT * FROM dim_categorie");
                    while ($row = $stmt->fetch()) {
                        $selected = ($row['id_categorie'] == $article['id_categorie']) ? 'selected' : '';
                        echo "<option value='{$row['id_categorie']}' $selected>".htmlspecialchars($row['nom'])."</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="contenu">Contenu de l'article (Éditeur TinyMCE) :</label>
            <textarea id="contenu" name="contenu"><?php echo htmlspecialchars($article['contenu']); ?></textarea>
        </div>

        <div class="form-group">
            <label>Images actuelles :</label>
            <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 10px;">
                <?php foreach ($images as $img): ?>
                    <div style="position: relative; width: 120px; border: 1px solid var(--border); border-radius: 8px; overflow: hidden; background: #fff;">
                        <img src="<?= $img['image_url'] ?>" style="width: 100%; height: 80px; object-fit: cover;">
                        <?php if ($img['is_main']): ?>
                            <span style="position: absolute; top: 5px; left: 5px; background: var(--red); color: #fff; font-size: 10px; padding: 2px 6px; border-radius: 10px; font-weight: 700;">Principal</span>
                        <?php endif; ?>
                        <a href="index.php?page=edit_article&id=<?= $id ?>&delete_image=<?= $img['id_image'] ?>" 
                           onclick="return confirm('Supprimer cette image ?')"
                           style="display: block; text-align: center; background: #fdfdfd; padding: 5px; font-size: 11px; color: var(--red); text-decoration: none; border-top: 1px solid var(--border); font-weight: 700;">
                           Supprimer
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="form-group">
            <label for="images">Ajouter des images :</label>
            <input type="file" id="images" name="images[]" multiple accept="image/*" style="padding: 10px; background: #fff; border: 1.5px dashed var(--border); border-radius: 8px; width: 100%;">
        </div>

        <div class="form-group">
            <label for="alt_image">Texte Alternatif pour les images (SEO) :</label>
            <?php 
                $current_alt = count($images) > 0 ? $images[0]['alt_text'] : $article['titre'];
            ?>
            <input type="text" id="alt_image" name="alt_image" value="<?php echo htmlspecialchars($current_alt); ?>" placeholder="Description des images">
        </div>

        <div class="form-group" style="width: 200px;">
            <label for="statut">Statut :</label>
            <select name="statut">
                <option value="brouillon" <?php if (!$article['is_active']) echo 'selected'; ?>>Brouillon</option>
                <option value="publié" <?php if ($article['is_active']) echo 'selected'; ?>>Publié</option>
            </select>
        </div>

        <div style="margin-top: 40px; display: flex; align-items: center; gap: 20px;">
            <button type="submit" class="btn-admin">💾 Enregistrer les modifications</button>
            <a href="index.php?page=dashboard" style="color: #666; font-size: 0.9em; font-weight: 600;">⬅️ Annuler et retour</a>
        </div>
    </form>
</div>
