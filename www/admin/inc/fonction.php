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
    if (empty($html_content)) {
        $stmtClear = $pdo->prepare("DELETE FROM fait_article_image WHERE id_article = ?");
        $stmtClear->execute([$id_article]);
        return;
    }

    $html_content = stripslashes($html_content);

    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html_content);
    libxml_clear_errors();

    $images = [];
    $imgNodes = $dom->getElementsByTagName('img');

    foreach ($imgNodes as $img) {
        if (!($img instanceof DOMElement)) {
            continue;
        }

        $src = trim((string) $img->getAttribute('src'));
        if ($src === '' || stripos($src, 'data:') === 0) {
            continue;
        }

        $path = parse_url($src, PHP_URL_PATH);
        if (!$path) {
            $path = $src;
        }

        $normalizedPath = null;
        if (strpos($path, '/front/assets/img/') !== false) {
            $normalizedPath = substr($path, strpos($path, '/front/assets/img/'));
        } elseif (strpos($path, '/img/') !== false) {
            $normalizedPath = substr($path, strpos($path, '/img/'));
        } elseif (strpos($path, 'front/assets/img/') === 0) {
            $normalizedPath = '/' . $path;
        } elseif (strpos($path, '../front/assets/img/') === 0) {
            $normalizedPath = '/' . ltrim(substr($path, 3), '/');
        } elseif (strpos($path, '../img/') === 0) {
            $normalizedPath = '/' . ltrim(substr($path, 3), '/');
        }

        if ($normalizedPath === null) {
            continue;
        }

        $alt = trim((string) $img->getAttribute('alt'));
        $cleanAlt = mb_substr($alt, 0, 150);
        if ($cleanAlt === '') {
            $cleanAlt = 'Image article';
        }

        if (!isset($images[$normalizedPath])) {
            $images[$normalizedPath] = $cleanAlt;
        }
    }

    $stmtClear = $pdo->prepare("DELETE FROM fait_article_image WHERE id_article = ?");
    $stmtClear->execute([$id_article]);

    if (empty($images)) {
        return;
    }

    $stmtInsert = $pdo->prepare("INSERT INTO fait_article_image (id_article, image_url, alt_text, is_main) VALUES (?, ?, ?, ?)");
    $isMain = 1;
    foreach ($images as $imageUrl => $altText) {
        $stmtInsert->execute([$id_article, $imageUrl, $altText, $isMain]);
        $isMain = 0;
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
