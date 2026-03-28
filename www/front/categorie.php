<?php
require_once '../config/db.php';

$slug = $_GET['slug'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM categories WHERE slug = ?");
$stmt->execute([$slug]);
$category = $stmt->fetch();

if (!$category) {
    header("HTTP/1.1 404 Not Found");
    die("Catégorie non trouvée");
}

$stmtArticles = $pdo->prepare("SELECT * FROM articles WHERE id_categorie = ?");
$stmtArticles->execute([$category['id']]);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catégorie : <?php echo htmlspecialchars($category['nom']); ?> - Iran News</title>
    <meta name="description" content="Explorez tous les articles de la catégorie <?php echo htmlspecialchars($category['nom']); ?> sur l'Iran.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
        <p><a href="/">Retour à l'accueil</a></p>
    </header>
    <main>
        <h1>Articles dans la catégorie "<?php echo htmlspecialchars($category['nom']); ?>"</h1>
        <ul>
            <?php
            while ($article = $stmtArticles->fetch()) {
                echo "<li><a href='/article/{$article['slug']}'>{$article['titre']}</a></li>";
            }
            ?>
        </ul>
    </main>
</body>
</html>
