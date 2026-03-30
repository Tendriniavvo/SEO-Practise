<?php
function getAllArticles($pdo) {
    $stmt = $pdo->query("SELECT a.*, c.nom as cat_nom FROM fait_article a JOIN dim_categorie c ON a.id_categorie = c.id_categorie ORDER BY a.date_publication DESC");
    return $stmt->fetchAll();
}


function getArticle($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM fait_article WHERE id_article = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}


function getArticleImages($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM fait_article_image WHERE id_article = ?");
    $stmt->execute([$id]);
    return $stmt->fetchAll();
}


function getAdminCategories($pdo) {
    $stmt = $pdo->query("SELECT * FROM dim_categorie");
    return $stmt->fetchAll();
}


function slugExists($pdo, $slug, $exclude_id = null) {
    if ($exclude_id) {
        $stmt = $pdo->prepare("SELECT id_article FROM fait_article WHERE slug = ? AND id_article != ?");
        $stmt->execute([$slug, $exclude_id]);
    } else {
        $stmt = $pdo->prepare("SELECT id_article FROM fait_article WHERE slug = ?");
        $stmt->execute([$slug]);
    }
    return $stmt->fetch() ? true : false;
}


function uploadArticleImages($pdo, $id_article, $files, $alt_text) {
    $upload_dir = __DIR__ . '/../../front/assets/img/';
    
    $stmtCheckMain = $pdo->prepare("SELECT id_image FROM fait_article_image WHERE id_article = ? AND is_main = 1");
    $stmtCheckMain->execute([$id_article]);
    $has_main = $stmtCheckMain->fetch() ? true : false;

    foreach ($files['name'] as $key => $name) {
        if ($files['error'][$key] === 0) {
            $tmp_name = $files['tmp_name'][$key];
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $new_name = uniqid('art_' . $id_article . '_') . '.' . $extension;
            $upload_path = $upload_dir . $new_name;
            $db_path = '/front/assets/img/' . $new_name;

            if (move_uploaded_file($tmp_name, $upload_path)) {
                $is_main = (!$has_main && $key === 0) ? 1 : 0;
                // Troncature du alt_text à 150 caractères pour correspondre à la structure de la base
                $clean_alt = mb_substr($alt_text, 0, 150);
                
                $stmtI = $pdo->prepare("INSERT INTO fait_article_image (id_article, image_url, alt_text, is_main) VALUES (?, ?, ?, ?)");
                $stmtI->execute([$id_article, $db_path, $clean_alt, $is_main]);
                if ($is_main) $has_main = true;
            }
        }
    }
}


/**
 * Analyse le contenu HTML pour extraire les images et les synchroniser avec la base de données
 */
function syncArticleImagesFromContent($pdo, $id_article, $html_content) {
    if (empty($html_content)) return;

    // Utilisation d'une Regex pour extraire les balises img (plus robuste pour les fragments HTML)
    // On cherche src="..." et alt="..."
    preg_match_all('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $html_content, $matches);
    
    if (empty($matches[1])) return;

    // 1. Récupérer les images déjà en base pour cet article
    $stmtExisting = $pdo->prepare("SELECT image_url FROM fait_article_image WHERE id_article = ?");
    $stmtExisting->execute([$id_article]);
    $db_images = $stmtExisting->fetchAll(PDO::FETCH_COLUMN);

    // 2. Vérifier s'il y a déjà une image principale
    $stmtCheckMain = $pdo->prepare("SELECT id_image FROM fait_article_image WHERE id_article = ? AND is_main = 1");
    $stmtCheckMain->execute([$id_article]);
    $has_main = $stmtCheckMain->fetch() ? true : false;

    foreach ($matches[0] as $key => $full_tag) {
        $src = $matches[1][$key];
        
        // Extraire l'alt de la balise complète
        $alt = "";
        if (preg_match('/alt=["\']([^"\']*)["\']/i', $full_tag, $alt_matches)) {
            $alt = $alt_matches[1];
        }

        // Nettoyer l'URL pour ne garder que le chemin relatif (/front/assets/...)
        $path = parse_url($src, PHP_URL_PATH);
        
        // On ne traite que nos images locales
        if (strpos($path, '/front/assets/img/') !== false) {
            $clean_alt = mb_substr($alt, 0, 150) ?: "Image article";

            if (!in_array($path, $db_images)) {
                $is_main = (!$has_main && $key === 0) ? 1 : 0;
                $stmtI = $pdo->prepare("INSERT INTO fait_article_image (id_article, image_url, alt_text, is_main) VALUES (?, ?, ?, ?)");
                $stmtI->execute([$id_article, $path, $clean_alt, $is_main]);
                if ($is_main) $has_main = true;
                $db_images[] = $path; // Éviter de réinsérer la même image si elle est présente 2 fois
            } else {
                // Mise à jour du ALT
                $stmtU = $pdo->prepare("UPDATE fait_article_image SET alt_text = ? WHERE id_article = ? AND image_url = ?");
                $stmtU->execute([$clean_alt, $id_article, $path]);
            }
        }
    }
}

function deleteArticle($pdo, $id) {
    
    $images = getArticleImages($pdo, $id);
    foreach ($images as $img) {
        $file_path = __DIR__ . '/../../..' . $img['image_url'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
    
    // 2. Supprimer de la base (la table fait_article_image est en ON DELETE CASCADE normalement, mais on assure)
    $stmt = $pdo->prepare("DELETE FROM fait_article WHERE id_article = ?");
    return $stmt->execute([$id]);
}

/**
 * Supprime une image spécifique d'un article
 */
function deleteArticleImage($pdo, $img_id, $id_article) {
    $stmtDI = $pdo->prepare("SELECT image_url FROM fait_article_image WHERE id_image = ? AND id_article = ?");
    $stmtDI->execute([$img_id, $id_article]);
    $img_to_del = $stmtDI->fetch();

    if ($img_to_del) {
        // Supprimer le fichier physique
        $file_path = __DIR__ . '/../../..' . $img_to_del['image_url'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        // Supprimer de la base
        $stmtDDB = $pdo->prepare("DELETE FROM fait_article_image WHERE id_image = ?");
        $stmtDDB->execute([$img_id]);

        // S'assurer qu'il reste une image principale
        $stmtCheckMain = $pdo->prepare("SELECT id_image FROM fait_article_image WHERE id_article = ? AND is_main = 1");
        $stmtCheckMain->execute([$id_article]);
        if (!$stmtCheckMain->fetch()) {
            $stmtSetMain = $pdo->prepare("UPDATE fait_article_image SET is_main = 1 WHERE id_article = ? LIMIT 1");
            $stmtSetMain->execute([$id_article]);
        }
        return true;
    }
    return false;
}
?>
