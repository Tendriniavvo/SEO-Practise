<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $slug = $_POST['slug'];
    $contenu = $_POST['contenu'];
    $id_categorie = $_POST['id_categorie'];
    $description = $_POST['description'];
    $alt_image = $_POST['alt_image'];
    $statut = $_POST['statut'];
    $image = $_POST['image'] ?: null; // Dans un vrai projet, gérer l'upload ici

    $stmt = $pdo->prepare("INSERT INTO articles (titre, slug, contenu, id_categorie, description, alt_image, statut, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$titre, $slug, $contenu, $id_categorie, $description, $alt_image, $statut, $image]);
    
    header("Location: index.php?page=dashboard");
    exit();
}
?>

<div style="max-width: 800px; margin: 0 auto;">
    <h1 style="margin-bottom: 30px; font-weight: 800;">Ajouter un nouvel article</h1>
    
    <form action="" method="POST">
        <div class="form-group">
            <label for="titre">Titre (SEO: H1 et Title) :</label>
            <input type="text" id="titre" name="titre" required placeholder="Impact des sanctions sur l'économie">
        </div>
        
        <div style="display: flex; gap: 20px;">
            <div class="form-group" style="flex: 1;">
                <label for="slug">Slug (URL amicale) :</label>
                <input type="text" id="slug" name="slug" required placeholder="impact-sanctions-economie">
            </div>
            <div class="form-group" style="flex: 1;">
                <label for="id_categorie">Catégorie :</label>
                <select name="id_categorie" required>
                    <?php
                    $stmt = $pdo->query("SELECT * FROM categories");
                    while ($row = $stmt->fetch()) {
                        echo "<option value='{$row['id']}'>".htmlspecialchars($row['nom'])."</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="description">Meta Description (160 caractères max) :</label>
            <input type="text" id="description" name="description" maxlength="300" required placeholder="Résumé court pour Google...">
        </div>

        <div class="form-group">
            <label for="contenu">Contenu de l'article :</label>
            <textarea id="contenu" name="contenu" required></textarea>
        </div>

        <div style="display: flex; gap: 20px;">
            <div class="form-group" style="flex: 1;">
                <label for="image">Nom de l'image (fictif) :</label>
                <input type="text" id="image" name="image" placeholder="sanctions.jpg">
            </div>
            <div class="form-group" style="flex: 1;">
                <label for="alt_image">Texte Alternatif (Alt Image SEO) :</label>
                <input type="text" id="alt_image" name="alt_image" placeholder="Graphique montrant la chute du Rial">
            </div>
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
