<?php
session_start();
require_once '../config/db.php';

// Protection basique de la session
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: dashboard.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();

if (!$article) {
    header("Location: dashboard.php");
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
    $image_to_save = $article['image']; // Conserver l'existante par défaut

    // GESTION DE L'IMAGE
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $upload_dir = '../img/';
        $file_name = time() . '_' . basename($_FILES['image']['name']);
        $target_path = $upload_dir . $file_name;
        
        // Vérification de l'extension
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed_ext)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                $image_to_save = $file_name;
            }
        }
    }

    $stmt = $pdo->prepare("UPDATE articles SET titre = ?, slug = ?, contenu = ?, id_categorie = ?, description = ?, alt_image = ?, statut = ?, image = ? WHERE id = ?");
    $stmt->execute([$titre, $slug, $contenu, $id_categorie, $description, $alt_image, $statut, $image_to_save, $id]);
    
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<!-- ...existing code... -->
<body>
    <h1>Modifier l'article "<?php echo htmlspecialchars($article['titre']); ?>"</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="titre">Titre (SEO: H1 et Title) :</label>
<!-- ...existing code... -->
        <div class="form-group">
            <label for="contenu">Contenu de l'article :</label>
            <textarea id="contenu" name="contenu" required><?php echo htmlspecialchars($article['contenu']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="image">Remplacer l'image (JPG, PNG, WEBP) :</label>
            <?php if ($article['image']) : ?>
                <p><small>Image actuelle : /img/<?php echo $article['image']; ?></small></p>
            <?php endif; ?>
            <input type="file" id="image" name="image" accept="image/*">
        </div>
        <div class="form-group">
            <label for="alt_image">Texte Alternatif (Alt Image SEO) :</label>
<!-- ...existing code... -->

        <div class="form-group">
            <label for="statut">Statut :</label>
            <select name="statut">
                <option value="brouillon" <?php if ($article['statut'] === 'brouillon') echo 'selected'; ?>>Brouillon</option>
                <option value="publié" <?php if ($article['statut'] === 'publié') echo 'selected'; ?>>Publié</option>
            </select>
        </div>
        <button type="submit" class="btn-submit">💾 Enregistrer les modifications</button>
    </form>
    <a href="dashboard.php" class="back-link">⬅️ Annuler et retour</a>
</body>
</html>

