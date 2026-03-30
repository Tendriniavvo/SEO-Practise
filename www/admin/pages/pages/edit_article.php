<?php
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php?page=dashboard");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();

if (!$article) {
    header("Location: index.php?page=dashboard");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $slug = $_POST['slug'];
    $contenu = $_POST['contenu'];
    $id_categorie = $_POST['id_categorie'];
    $description = $_POST['description'];
    $alt_image = $_POST['alt_image'];
    $statut = $_POST['statut'];
    $image = $_POST['image'] ?: null; // Dans un vrai projet, gérer l'upload ici

    $stmt = $pdo->prepare("UPDATE articles SET titre = ?, slug = ?, contenu = ?, id_categorie = ?, description = ?, alt_image = ?, statut = ?, image = ? WHERE id = ?");
    $stmt->execute([$titre, $slug, $contenu, $id_categorie, $description, $alt_image, $statut, $image, $id]);
    
    header("Location: index.php?page=dashboard");
    exit();
}
?>

<div style="max-width: 800px; margin: 0 auto;">
    <h1 style="margin-bottom: 30px; font-weight: 800;">Modifier l'article "<?php echo htmlspecialchars($article['titre']); ?>"</h1>
    
    <form action="" method="POST">
        <div class="form-group">
            <label for="titre">Titre (SEO: H1 et Title) :</label>
            <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($article['titre']); ?>" required>
        </div>
        
        <div style="display: flex; gap: 20px;">
            <div class="form-group" style="flex: 1;">
                <label for="slug">Slug (URL amicale) :</label>
                <input type="text" id="slug" name="slug" value="<?php echo htmlspecialchars($article['slug']); ?>" required>
            </div>
            <div class="form-group" style="flex: 1;">
                <label for="id_categorie">Catégorie :</label>
                <select name="id_categorie" required>
                    <?php
                    $stmt = $pdo->query("SELECT * FROM categories");
                    while ($row = $stmt->fetch()) {
                        $selected = ($row['id'] == $article['id_categorie']) ? 'selected' : '';
                        echo "<option value='{$row['id']}' $selected>".htmlspecialchars($row['nom'])."</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="description">Meta Description (160 caractères max) :</label>
            <input type="text" id="description" name="description" maxlength="300" value="<?php echo htmlspecialchars($article['description']); ?>" required>
        </div>

        <div class="form-group">
            <label for="contenu">Contenu de l'article :</label>
            <textarea id="contenu" name="contenu" required><?php echo htmlspecialchars($article['contenu']); ?></textarea>
        </div>

        <div style="display: flex; gap: 20px;">
            <div class="form-group" style="flex: 1;">
                <label for="image">Nom de l'image (fictif) :</label>
                <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($article['image'] ?? ''); ?>">
            </div>
            <div class="form-group" style="flex: 1;">
                <label for="alt_image">Texte Alternatif (Alt Image SEO) :</label>
                <input type="text" id="alt_image" name="alt_image" value="<?php echo htmlspecialchars($article['alt_image'] ?? ''); ?>">
            </div>
        </div>

        <div class="form-group" style="width: 200px;">
            <label for="statut">Statut :</label>
            <select name="statut">
                <option value="brouillon" <?php if ($article['statut'] === 'brouillon') echo 'selected'; ?>>Brouillon</option>
                <option value="publié" <?php if ($article['statut'] === 'publié') echo 'selected'; ?>>Publié</option>
            </select>
        </div>

        <div style="margin-top: 40px; display: flex; align-items: center; gap: 20px;">
            <button type="submit" class="btn-admin">💾 Enregistrer les modifications</button>
            <a href="index.php?page=dashboard" style="color: #666; font-size: 0.9em; font-weight: 600;">⬅️ Annuler et retour</a>
        </div>
    </form>
</div>
