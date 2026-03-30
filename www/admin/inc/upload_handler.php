<?php
/**
 * Gestionnaire d'upload d'images pour TinyMCE
 * Chemin : www/admin/inc/upload_handler.php
 */

session_start();
require_once __DIR__ . '/../../config/db.php';

// Vérification de la session admin
if (!isset($_SESSION['admin_id'])) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

$upload_dir = __DIR__ . '/../../front/assets/img/';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    
    if (is_uploaded_file($file['tmp_name'])) {
        // Validation basique de l'extension
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (!in_array($extension, $allowed_extensions)) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(['error' => 'Format de fichier non autorisé.']);
            exit;
        }

        // Nouveau nom unique
        $new_name = uniqid('mce_') . '.' . $extension;
        $upload_path = $upload_dir . $new_name;
        $db_path = '/front/assets/img/' . $new_name;

        if (move_uploaded_file($file['tmp_name'], $upload_path)) {
            // Si on est en train de modifier un article (ID présent dans l'URL)
            if (isset($_GET['article_id']) && is_numeric($_GET['article_id'])) {
                $stmt = $pdo->prepare("INSERT INTO fait_article_image (id_article, image_url, alt_text, is_main) VALUES (?, ?, ?, 0)");
                $stmt->execute([$_GET['article_id'], $db_path, "Image insérée via éditeur"]);
            } else {
                // Si c'est un nouvel article, on stocke temporairement le chemin en session
                if (!isset($_SESSION['temp_mce_images'])) {
                    $_SESSION['temp_mce_images'] = [];
                }
                $_SESSION['temp_mce_images'][] = $db_path;
            }

            // Réponse JSON attendue par TinyMCE
            echo json_encode(['location' => $db_path]);
        } else {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(['error' => 'Erreur lors du déplacement du fichier.']);
        }
    }
}
?>
