<?php
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php?page=dashboard");
    exit();
}

// Fetch article
$article = getArticle($pdo, $id);

if (!$article) {
    header("Location: index.php?page=dashboard");
    exit();
}

// Fetch images
$images = getArticleImages($pdo, $id);

// Handle deletion of an image
if (isset($_GET['delete_image'])) {
    if (deleteArticleImage($pdo, $_GET['delete_image'], $id)) {
        header("Location: index.php?page=edit_article&id=" . $id);
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $slug = $_POST['slug'];
    $contenu = $_POST['contenu'];
    $id_categorie = $_POST['id_categorie'];
    $is_active = ($_POST['statut'] === 'publié') ? 1 : 0;

    try {
        $pdo->beginTransaction();

        // 0. Vérifier si le slug existe déjà pour un AUTRE article
        if (slugExists($pdo, $slug, $id)) {
            throw new Exception("L'URL (slug) '$slug' est déjà utilisée par un autre article. Veuillez en choisir une autre.");
        }

        // 1. Update article
        $stmtA = $pdo->prepare("UPDATE fait_article SET titre = ?, slug = ?, contenu = ?, id_categorie = ?, is_active = ?, date_publication = CASE WHEN ? = 1 AND date_publication IS NULL THEN NOW() ELSE date_publication END WHERE id_article = ?");
        $stmtA->execute([$titre, $slug, $contenu, $id_categorie, $is_active, $is_active, $id]);

        // 2. Synchroniser les images à partir du contenu HTML (TinyMCE)
        syncArticleImagesFromContent($pdo, $id, $contenu);

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
    <h1 style="margin-bottom: 30px; font-weight: 800;">Modifier l'article (Refactorisé)</h1>
    
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
                    $categories = getAdminCategories($pdo);
                    foreach ($categories as $row) {
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
            <label>Images de l'article :</label>
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
                <?php if (empty($images)): ?>
                    <p style="font-size: 13px; color: #666; font-style: italic;">Aucune image associée. Utilisez l'éditeur TinyMCE pour en ajouter.</p>
                <?php endif; ?>
            </div>
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
