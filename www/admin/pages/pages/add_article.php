<?php
// On vide la session temporaire des images TinyMCE si on arrive sur la page pour la première fois
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    unset($_SESSION['temp_mce_images']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $slug = $_POST['slug'];
    $contenu = $_POST['contenu'];
    $id_categorie = $_POST['id_categorie'];
    $is_active = ($_POST['statut'] === 'publié') ? 1 : 0;

    try {
        $pdo->beginTransaction();

        // 0. Vérifier si le slug existe déjà
        if (slugExists($pdo, $slug)) {
            throw new Exception("L'URL (slug) '$slug' est déjà utilisée par un autre article. Veuillez en choisir une autre.");
        }

        // 1. Gérer la dimension Temps
        $today = date('Y-m-d');
        $stmtT = $pdo->prepare("SELECT id_temps FROM dim_temps WHERE date = ?");
        $stmtT->execute([$today]);
        $dim_temps = $stmtT->fetch();

        if (!$dim_temps) {
            $stmtIT = $pdo->prepare("INSERT INTO dim_temps (date, annee, mois) VALUES (?, ?, ?)");
            $stmtIT->execute([$today, date('Y'), date('m')]);
            $id_temps = $pdo->lastInsertId();
        } else {
            $id_temps = $dim_temps['id_temps'];
        }

        // 2. Gérer l'auteur (admin par défaut)
        $id_auteur = 1;

        // 3. Insérer l'article
        $stmtA = $pdo->prepare("INSERT INTO fait_article (id_temps, id_categorie, id_auteur, titre, contenu, slug, is_active, date_publication) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $date_pub = $is_active ? date('Y-m-d H:i:s') : null;
        $stmtA->execute([$id_temps, $id_categorie, $id_auteur, $titre, $contenu, $slug, $is_active, $date_pub]);
        $id_article = $pdo->lastInsertId();

        // 4. Synchroniser les images à partir du contenu HTML (TinyMCE)
        syncArticleImagesFromContent($pdo, $id_article, $contenu);

        $pdo->commit();
        header("Location: index.php?page=dashboard");
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Erreur lors de l'ajout : " . $e->getMessage();
    }
}
?>

<div style="max-width: 800px; margin: 0 auto;">
    <h1 style="margin-bottom: 30px; font-weight: 800;">Ajouter un nouvel article (Refactorisé)</h1>
    
    <?php if (isset($error)): ?>
        <div style="background: #fff0f2; color: var(--red); padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #ffccd2;">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="titre">Titre (H1) :</label>
            <input type="text" id="titre" name="titre" required placeholder="Impact des sanctions sur l'économie">
        </div>
        
        <div style="display: flex; gap: 20px;">
            <div class="form-group" style="flex: 1;">
                <label for="slug">Slug (URL SEO) :</label>
                <input type="text" id="slug" name="slug" required placeholder="impact-sanctions-economie">
            </div>
            <div class="form-group" style="flex: 1;">
                <label for="id_categorie">Catégorie :</label>
                <select name="id_categorie" required>
                    <?php
                    $categories = getAdminCategories($pdo);
                    foreach ($categories as $row) {
                        echo "<option value='{$row['id_categorie']}'>".htmlspecialchars($row['nom'])."</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="contenu">Contenu de l'article (Éditeur TinyMCE) :</label>
            <textarea id="contenu" name="contenu"></textarea>
        </div>

        <div class="form-group" style="width: 200px;">
            <label for="statut">Statut :</label>
            <select name="statut">
                <option value="brouillon">Brouillon</option>
                <option value="publié">Publié</option>
            </select>
        </div>

        <div style="margin-top: 40px; display: flex; align-items: center; gap: 20px;">
            <button type="submit" class="btn-admin">💾 Enregistrer l'article</button>
            <a href="index.php?page=dashboard" style="color: #666; font-size: 0.9em; font-weight: 600;">⬅️ Annuler et retour</a>
        </div>
    </form>
</div>
