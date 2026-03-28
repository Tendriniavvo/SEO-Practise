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

$stmtArticles = $pdo->prepare("SELECT * FROM articles WHERE id_categorie = ? AND statut = 'publié' ORDER BY created_at DESC");
$stmtArticles->execute([$category['id']]);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Guerre en Iran : Articles sur <?php echo htmlspecialchars($category['nom']); ?></title>
    <meta name="description" content="Découvrez tous nos articles et analyses concernant <?php echo htmlspecialchars($category['nom']); ?> dans le cadre du conflit iranien de 2026.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: sans-serif; line-height: 1.6; max-width: 900px; margin: auto; padding: 20px; }
        header { border-bottom: 2px solid #333; margin-bottom: 20px; }
        article { border-bottom: 1px solid #ccc; padding: 10px 0; }
    </style>
</head>
<body>
    <header>
        <p><a href="/">Retour à l'accueil</a></p>
        <h1>Catégorie : <?php echo htmlspecialchars($category['nom']); ?></h1>
    </header>
    <main>
        <?php
        $found = false;
        while ($article = $stmtArticles->fetch()) {
            $found = true;
        ?>
            <article>
                <h2><a href="/article/<?php echo $article['slug']; ?>"><?php echo htmlspecialchars($article['titre']); ?></a></h2>
                <p><?php echo htmlspecialchars($article['description']); ?></p>
            </article>
        <?php 
        } 
        if (!$found) echo "<p>Aucun article publié dans cette catégorie pour le moment.</p>";
        ?>
    </main>
</body>
</html>

