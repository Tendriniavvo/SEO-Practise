<?php require_once '../config/db.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Actualités de l'Iran - Front Office</title>
    <meta name="description" content="Tout ce qu'il faut savoir sur l'actualité de l'Iran : Histoire et Géopolitique.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
        <h1>Actualités de l'Iran</h1>
        <nav>
            <a href="/">Accueil</a>
        </nav>
    </header>
    
    <main>
        <section>
            <h2>Articles récents</h2>
            <ul>
                <?php
                $stmt = $pdo->query("SELECT * FROM articles ORDER BY date_creation DESC");
                while ($row = $stmt->fetch()) {
                    echo "<li><a href='/article/{$row['slug']}'>{$row['titre']}</a></li>";
                }
                ?>
            </ul>
        </section>
        
        <section>
            <h2>Catégories</h2>
            <ul>
                <?php
                $stmt = $pdo->query("SELECT * FROM categories");
                while ($row = $stmt->fetch()) {
                    echo "<li><a href='/categorie/{$row['slug']}'>{$row['nom']}</a></li>";
                }
                ?>
            </ul>
        </section>
    </main>
</body>
</html>
