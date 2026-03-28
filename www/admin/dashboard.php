<?php
session_start();
require_once '../config/db.php';

// Protection basique de la session
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Logique de suppression simple
if (isset($_GET['delete_id'])) {
    $stmtD = $pdo->prepare("DELETE FROM articles WHERE id = ?");
    $stmtD->execute([$_GET['delete_id']]);
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration - Dashboard</title>
    <style>
        body { font-family: sans-serif; max-width: 1000px; margin: auto; padding: 20px; }
        header { background: #333; color: white; padding: 15px; display: flex; justify-content: space-between; align-items: center; border-radius: 5px; margin-bottom: 20px; }
        nav a { color: #fff; text-decoration: none; margin-left: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #f4f4f4; }
        .btn { padding: 8px 15px; text-decoration: none; color: white; border-radius: 4px; font-size: 0.9em; }
        .btn-add { background: #28a745; display: inline-block; margin-bottom: 10px; }
        .btn-edit { background: #ffc107; color: #000; }
        .btn-del { background: #dc3545; }
        .statut-publié { color: green; font-weight: bold; }
        .statut-brouillon { color: gray; }
    </style>
</head>
<body>
    <header>
        <h1>Tableau de Bord - Admin</h1>
        <div>
            Bonjour, <strong><?php echo $_SESSION['admin_user']; ?></strong> |
            <a href="logout.php">Déconnexion</a> | 
            <a href="/" target="_blank">Voir le site</a>
        </div>
    </header>
    
    <main>
        <section>
            <h2>Gestion des articles</h2>
            <a href="add_article.php" class="btn btn-add">➕ Ajouter un article</a>
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Catégorie</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query("SELECT a.*, c.nom as cat_nom FROM articles a JOIN categories c ON a.id_categorie = c.id ORDER BY a.created_at DESC");
                    while ($row = $stmt->fetch()) {
                        echo "<tr>
                            <td>".htmlspecialchars($row['titre'])."</td>
                            <td>".htmlspecialchars($row['cat_nom'])."</td>
                            <td><span class='statut-{$row['statut']}'>".ucfirst($row['statut'])."</span></td>
                            <td>".date('d/m/Y', strtotime($row['created_at']))."</td>
                            <td>
                                <a href='edit_article.php?id={$row['id']}' class='btn btn-edit'>✏️ Modifier</a>
                                <a href='dashboard.php?delete_id={$row['id']}' class='btn btn-del' onclick=\"return confirm('Êtes-vous sûr ?')\">🗑️ Supprimer</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>

