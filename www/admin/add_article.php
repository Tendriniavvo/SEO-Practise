<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $slug = $_POST['slug'];
    $contenu = $_POST['contenu'];
    $id_categorie = $_POST['id_categorie'];
    $meta_description = $_POST['meta_description'];
    
    $stmt = $pdo->prepare("INSERT INTO articles (titre, slug, contenu, id_categorie, meta_description) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$titre, $slug, $contenu, $id_categorie, $meta_description]);
    
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un article - Administration</title>
</head>
<body>
    <h1>Ajouter un nouvel article</h1>
    <form action="" method="POST">
        <div>
            <label for="titre">Titre :</label>
            <input type="text" id="titre" name="titre" required>
        </div>
        <div>
            <label for="slug">Slug (URL amicale) :</label>
            <input type="text" id="slug" name="slug" required>
        </div>
        <div>
            <label for="contenu">Contenu :</label>
            <textarea id="contenu" name="contenu" required></textarea>
        </div>
        <div>
            <label for="meta_description">Meta Description (SEO) :</label>
            <input type="text" id="meta_description" name="meta_description" maxlength="160">
        </div>
        <div>
            <label for="id_categorie">Catégorie :</label>
            <select name="id_categorie" required>
                <?php
                $stmt = $pdo->query("SELECT * FROM categories");
                while ($row = $stmt->fetch()) {
                    echo "<option value='{$row['id']}'>{$row['nom']}</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit">Publier l'article</button>
    </form>
    <p><a href="dashboard.php">Annuler</a></p>
</body>
</html>
