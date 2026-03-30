<?php
// Logique de suppression simple
if (isset($_GET['delete_id'])) {
    $stmtD = $pdo->prepare("DELETE FROM articles WHERE id = ?");
    $stmtD->execute([$_GET['delete_id']]);
    header("Location: index.php?page=dashboard");
    exit();
}
?>

<section>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 style="margin: 0;">Gestion des articles</h2>
        <a href="index.php?page=add_article" class="btn-admin" style="margin: 0;">➕ Ajouter un article</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Catégorie</th>
                <th>Statut</th>
                <th>Date</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT a.*, c.nom as cat_nom FROM articles a JOIN categories c ON a.id_categorie = c.id ORDER BY a.created_at DESC");
            while ($row = $stmt->fetch()) {
                echo "<tr>
                    <td style='font-weight: 600;'>".htmlspecialchars($row['titre'])."</td>
                    <td>".htmlspecialchars($row['cat_nom'])."</td>
                    <td><span class='statut-{$row['statut']}'>".ucfirst($row['statut'])."</span></td>
                    <td style='color: #666; font-size: 0.9em;'>".date('d/m/Y', strtotime($row['created_at']))."</td>
                    <td style='text-align: right;'>
                        <a href='index.php?page=edit_article&id={$row['id']}' class='btn-edit'>✏️ Modifier</a>
                        <a href='index.php?page=dashboard&delete_id={$row['id']}' class='btn-del' onclick=\"return confirm('Êtes-vous sûr ?')\">🗑️ Supprimer</a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</section>
