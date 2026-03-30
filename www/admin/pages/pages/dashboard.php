<?php
// Logique de suppression simple
if (isset($_GET['delete_id'])) {
    if (deleteArticle($pdo, $_GET['delete_id'])) {
        header("Location: index.php?page=dashboard");
        exit();
    }
}
?>

<section>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 style="margin: 0;">Gestion des articles (Fonctions Centralisées)</h2>
        <a href="index.php?page=add_article" class="btn-admin" style="margin: 0;">➕ Ajouter un article</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Catégorie</th>
                <th>Statut</th>
                <th>Date Pub.</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $articles = getAllArticles($pdo);
            foreach ($articles as $row) {
                $statut_class = $row['is_active'] ? 'publié' : 'brouillon';
                $statut_label = $row['is_active'] ? 'Publié' : 'Brouillon';
                $date_pub = $row['date_publication'] ? date('d/m/Y', strtotime($row['date_publication'])) : 'Non définie';
                echo "<tr>
                    <td style='font-weight: 600;'>".htmlspecialchars($row['titre'])."</td>
                    <td>".htmlspecialchars($row['cat_nom'])."</td>
                    <td><span class='statut-{$statut_class}'>{$statut_label}</span></td>
                    <td style='color: #666; font-size: 0.9em;'>".$date_pub."</td>
                    <td style='text-align: right;'>
                        <a href='index.php?page=edit_article&id={$row['id_article']}' class='btn-edit'>✏️ Modifier</a>
                        <a href='index.php?page=dashboard&delete_id={$row['id_article']}' class='btn-del' onclick=\"return confirm('Êtes-vous sûr ?')\">🗑️ Supprimer</a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</section>
