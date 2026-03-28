<?php require_once '../config/db.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration - Dashboard</title>
</head>
<body>
    <header>
        <h1>Tableau de Bord - Admin</h1>
        <nav>
            <a href="add_article.php">Ajouter un article</a> |
            <a href="/">Retour au site</a>
        </nav>
    </header>
    
    <main>
        <section>
            <h2>Gestion des articles</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query("SELECT * FROM articles");
                    while ($row = $stmt->fetch()) {
                        echo "<tr>
                            <td>".htmlspecialchars($row['titre'])."</td>
                            <td><a href='edit_article.php?id={$row['id']}'>Modifier</a> | <a href='delete_article.php?id={$row['id']}'>Supprimer</a></td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
