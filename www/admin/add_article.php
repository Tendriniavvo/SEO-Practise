<?php
session_start();
require_once '../config/db.php';

// Protection basique de la session
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

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
    
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un article - Administration</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 8px; box-sizing: border-box; }
        textarea { height: 200px; }
        .btn-submit { background: #007bff; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px; }
        .back-link { margin-top: 20px; display: block; color: #666; }
    </style>
</head>
<body>
    <h1>Ajouter un nouvel article</h1>
    <form action="" method="POST">
        <div class="form-group">
            <label for="titre">Titre (SEO: H1 et Title) :</label>
            <input type="text" id="titre" name="titre" required placeholder="Impact des sanctions sur l'économie">
        </div>
        <div class="form-group">
            <label for="slug">Slug (URL amicale) :</label>
            <input type="text" id="slug" name="slug" required placeholder="impact-sanctions-economie">
        </div>
        <div class="form-group">
            <label for="description">Meta Description (160 caractères max) :</label>
            <input type="text" id="description" name="description" maxlength="300" required placeholder="Résumé court pour Google...">
        </div>
        <div class="form-group">
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
        <div class="form-group">
            <label for="contenu">Contenu de l'article :</label>
            <textarea id="contenu" name="contenu" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Nom de l'image (fictif) :</label>
            <input type="text" id="image" name="image" placeholder="sanctions.jpg">
        </div>
        <div class="form-group">
            <label for="alt_image">Texte Alternatif (Alt Image SEO) :</label>
            <input type="text" id="alt_image" name="alt_image" placeholder="Graphique montrant la chute du Rial">
        </div>
        <div class="form-group">
            <label for="statut">Statut :</label>
            <select name="statut">
                <option value="brouillon">Brouillon</option>
                <option value="publié">Publié</option>
            </select>
        </div>
        <button type="submit" class="btn-submit">💾 Enregistrer l'article</button>
    </form>
    <a href="dashboard.php" class="back-link">⬅️ Annuler et retour</a>
</body>
</html>

