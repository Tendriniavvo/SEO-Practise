<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $slug = $_POST['slug'];
    $contenu = $_POST['contenu'];
    $id_categorie = $_POST['id_categorie'];
    $is_active = ($_POST['statut'] === 'publié') ? 1 : 0;

    try {
        createArticle($pdo, $titre, $slug, $contenu, $id_categorie, $is_active);
        header("Location: index.php?page=dashboard");
        exit();
    } catch (Exception $e) {
        $error = "Erreur lors de l'ajout : " . $e->getMessage();
    }
}
?>

<style>
    .admin-form-container {
        max-width: 900px;
        margin: 0 auto;
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        font-family: 'Sora', sans-serif;
    }
    .admin-form-container h1 {
        margin-bottom: 30px;
        font-size: 24px;
        color: #333;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 15px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #555;
    }
    .form-group input[type="text"],
    .form-group select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        box-sizing: border-box;
    }
    .form-group input[type="text"]:focus,
    .form-group select:focus {
        border-color: #0066cc;
        outline: none;
        box-shadow: 0 0 0 3px rgba(0,102,204,0.1);
    }
    .btn-admin {
        background: #0066cc;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.3s;
    }
    .btn-admin:hover {
        background: #0052a3;
    }
    .form-row {
        display: flex;
        gap: 20px;
    }
    .form-row .form-group {
        flex: 1;
    }
</style>

<div class="admin-form-container">
    <h1>Ajouter un nouvel article</h1>
    
    <?php if (isset($error)): ?>
        <div style="background: #fff0f2; color: #d32f2f; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #ffccd2;">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="titre">Titre (H1) :</label>
            <input type="text" id="titre" name="titre" required placeholder="Ex: Impact des sanctions sur l'économie">
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="slug">Slug (URL SEO) :</label>
                <input type="text" id="slug" name="slug" required placeholder="ex: impact-sanctions-economie">
            </div>
            <div class="form-group">
                <label for="id_categorie">Catégorie :</label>
                <select id="id_categorie" name="id_categorie" required>
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
            <label for="contenu">Contenu de l'article :</label>
            <textarea id="contenu" name="contenu"></textarea>
            <small style="color:#777; margin-top:5px; display:block;">L'éditeur TinyMCE va générer les balises HTML automatiquement.</small>
        </div>

        <div class="form-group" style="width: 200px;">
            <label for="statut">Statut :</label>
            <select id="statut" name="statut">
                <option value="brouillon">Brouillon</option>
                <option value="publié">Publié</option>
            </select>
        </div>

        <div style="margin-top: 30px; display: flex; align-items: center; gap: 20px;">
            <button type="submit" class="btn-admin">💾 Enregistrer l'article</button>
            <a href="index.php?page=dashboard" style="color: #666; font-size: 14px; text-decoration: none; font-weight: 600;">⬅️ Annuler et retour</a>
        </div>
    </form>
</div>
