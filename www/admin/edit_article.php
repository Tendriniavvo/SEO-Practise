<?php
session_start();
require_once '../config/db.php';

// Protection basique de la session
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: dashboard.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();

if (!$article) {
    header("Location: dashboard.php");
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
    
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un article - Administration</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 8px; box-sizing: border-box; }
        textarea { height: 200px; }
        .btn-submit { background: #007bff; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px; }
        .back-link { margin-top: 20px; display: block; color: #666; }
    </style>
</head>
<body>
    <h1>Modifier l'article "<?php echo htmlspecialchars($article['titre']); ?>"</h1>
    <form action="" method="POST">
        <div class="form-group">
            <label for="titre">Titre (SEO: H1 et Title) :</label>
            <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($article['titre']); ?>" required>
        </div>
        <div class="form-group">
            <label for="slug">Slug (URL amicale) :</label>
            <input type="text" id="slug" name="slug" value="<?php echo htmlspecialchars($article['slug']); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Meta Description (160 caractères max) :</label>
            <input type="text" id="description" name="description" maxlength="300" value="<?php echo htmlspecialchars($article['description']); ?>" required>
        </div>
        <div class="form-group">
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
        <div class="form-group">
            <label for="contenu">Contenu de l'article :</label>
            <textarea id="contenu" name="contenu" required><?php echo htmlspecialchars($article['contenu']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="image">Nom de l'image (fictif) :</label>
            <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($article['image'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="alt_image">Texte Alternatif (Alt Image SEO) :</label>
            <input type="text" id="alt_image" name="alt_image" value="<?php echo htmlspecialchars($article['alt_image'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="statut">Statut :</label>
            <select name="statut">
                <option value="brouillon" <?php if ($article['statut'] === 'brouillon') echo 'selected'; ?>>Brouillon</option>
                <option value="publié" <?php if ($article['statut'] === 'publié') echo 'selected'; ?>>Publié</option>
            </select>
        </div>
        <button type="submit" class="btn-submit">💾 Enregistrer les modifications</button>
    </form>
    <a href="dashboard.php" class="back-link">⬅️ Annuler et retour</a>
</body>
</html>

