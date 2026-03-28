<?php
require_once '../config/db.php';

$slug = $_GET['slug'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM articles WHERE slug = ?");
$stmt->execute([$slug]);
$article = $stmt->fetch();

if (!$article) {
    header("HTTP/1.1 404 Not Found");
    die("Article non trouvé");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($article['titre']); ?> - Iran News</title>
    <meta name="description" content="<?php echo htmlspecialchars($article['meta_description']); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($article['meta_keywords']); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
        <p><a href="/">Retour à l'accueil</a></p>
    </header>
    <article>
        <h1><?php echo htmlspecialchars($article['titre']); ?></h1>
        <div class="meta">Publié le : <?php echo $article['date_creation']; ?></div>
        <div class="content">
            <?php echo nl2br(htmlspecialchars($article['contenu'])); ?>
        </div>
    </article>
</body>
</html>
