<?php
require_once '../config/db.php';

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
    $meta_description = $_POST['meta_description'];
    
    $stmt = $pdo->prepare("UPDATE articles SET titre = ?, slug = ?, contenu = ?, id_categorie = ?, meta_description = ? WHERE id = ?");
    $stmt->execute([$titre, $slug, $contenu, $id_categorie, $meta_description, $id]);
    
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un article - Administration</title>
</head>
<body>
    <h1>Modifier l'article "<?php echo htmlspecialchars($article['titre']); ?>"</h1>
    <form action="" method="POST">
        <div>
            <label for="titre">Titre :</label>
            <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($article['titre']); ?>" required>
        </div>
        <div>
            <label for="slug">Slug (URL amicale) :</label>
            <input type="text" id="slug" name="slug" value="<?php echo htmlspecialchars($article['slug']); ?>" required>
        </div>
        <div>
            <label for="contenu">Contenu :</label>
            <textarea id="contenu" name="contenu" required><?php echo htmlspecialchars($article['contenu']); ?></textarea>
        </div>
        <div>
            <label for="meta_description">Meta Description (SEO) :</label>
            <input type="text" id="meta_description" name="meta_description" value="<?php echo htmlspecialchars($article['meta_description']); ?>" maxlength="160">
        </div>
        <div>
            <label for="id_categorie">Catégorie :</label>
            <select name="id_categorie" required>
                <?php
                $stmt = $pdo->query("SELECT * FROM categories");
                while ($row = $stmt->fetch()) {
                    $selected = ($row['id'] == $article['id_categorie']) ? 'selected' : '';
                    echo "<option value='{$row['id']}' $selected>{$row['nom']}</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit">Enregistrer les modifications</button>
    </form>
    <p><a href="dashboard.php">Annuler</a></p>
</body>
</html>
