<?php require_once '../config/db.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Guerre en Iran 2026 : Actualités, Histoire et Enjeux</title>
    <meta name="description" content="Suivez en direct l'actualité du conflit en Iran. Analyses géopolitiques, rapports humanitaires et contexte historique de la guerre de 2026.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: sans-serif; line-height: 1.6; max-width: 900px; margin: auto; padding: 20px; }
        header { border-bottom: 2px solid #333; margin-bottom: 20px; }
        article { border-bottom: 1px solid #ccc; padding: 10px 0; }
        .article-img { max-width: 100%; height: auto; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <header>
        <h1>Guerre en Iran : Dossier Spécial 2026</h1>
        <nav>
            <strong>Catégories :</strong>
            <?php
            $stmtC = $pdo->query("SELECT * FROM categories");
            while ($cat = $stmtC->fetch()) {
                echo " | <a href='/categorie/{$cat['slug']}'>".htmlspecialchars($cat['nom'])."</a>";
            }
            ?>
        </nav>
    </header>
    
    <main>
        <section>
            <h2>Derniers Articles sur le Conflit</h2>
            <?php
            $stmt = $pdo->query("SELECT a.*, c.nom as cat_nom FROM articles a JOIN categories c ON a.id_categorie = c.id ORDER BY a.created_at DESC");
            while ($row = $stmt->fetch()) {
            ?>
                <article>

                    <h3><a href="/article/<?php echo $row['slug']; ?>"><?php echo htmlspecialchars($row['titre']); ?></a></h3>
                    <p><em>Publié le <?php echo date('d/m/Y', strtotime($row['created_at'])); ?> dans <strong><?php echo htmlspecialchars($row['cat_nom']); ?></strong></em></p>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                </article>
            <?php } ?>
        </section>
    </main>
</body>
</html>

