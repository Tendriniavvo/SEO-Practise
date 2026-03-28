<?php
require_once '../config/db.php';

$slug = $_GET['slug'] ?? '';
$stmt = $pdo->prepare("SELECT a.*, c.nom as cat_nom FROM articles a JOIN categories c ON a.id_categorie = c.id WHERE a.slug = ?");
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
    <title><?php echo htmlspecialchars($article['titre']); ?> - Analyse de la Guerre en Iran 2026</title>
    <meta name="description" content="<?php echo htmlspecialchars($article['description']); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: sans-serif; line-height: 1.6; max-width: 900px; margin: auto; padding: 20px; }
        header { border-bottom: 2px solid #333; margin-bottom: 20px; }
        .breadcrumb { font-style: italic; margin-bottom: 10px; }
        .meta { font-size: 0.9em; color: #666; margin-bottom: 20px; }
        .content { margin-top: 20px; text-align: justify; }
        .article-img { max-width: 100%; height: auto; border: 1px solid #ddd; display: block; margin: 20px 0; }
    </style>
</head>
<body>
    <header>
        <p class="breadcrumb"><a href="/">Accueil</a> > <?php echo htmlspecialchars($article['cat_nom']); ?></p>
        <h1><?php echo htmlspecialchars($article['titre']); ?></h1>
    </header>
    
    <main>
        <div class="meta">
            Publié le <?php echo date('d/m/Y H:i', strtotime($article['created_at'])); ?> 
            <?php if (!empty($article['updated_at'])) : ?>
                (Mis à jour le <?php echo date('d/m/Y H:i', strtotime($article['updated_at'])); ?>)
            <?php endif; ?>
        </div>

        <?php if (!empty($article['image'])) : ?>
            <img src="/img/<?php echo htmlspecialchars($article['image']); ?>" 
                 alt="<?php echo htmlspecialchars($article['alt_image']); ?>" 
                 class="article-img">
        <?php endif; ?>

        <div class="content">
            <?php echo nl2br(htmlspecialchars($article['contenu'])); ?>
        </div>
    </main>
    
    <footer>
        <p>&copy; 2026 Projet Guerre en Iran - S6 SEO Mini-Projet</p>
    </footer>
</body>
</html>

