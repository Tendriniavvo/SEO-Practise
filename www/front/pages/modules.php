<?php
// ─────────────────────────────────────────────
// Routeur principal
// Chemin : www/front/pages/modules.php
// ─────────────────────────────────────────────

// En-têtes de sécurité pour les bonnes pratiques Lighthouse
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Cross-Origin-Opener-Policy: same-origin");
header("Cross-Origin-Resource-Policy: same-site");
header("Permissions-Policy: geolocation=(), microphone=(), camera=(), payment=(), usb=(), interest-cohort=()");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

$csp = "default-src 'self'; "
    . "base-uri 'self'; "
    . "object-src 'none'; "
    . "frame-ancestors 'self'; "
    . "form-action 'self'; "
    . "script-src 'self' blob:; "
    . "script-src-elem 'self' blob:; "
    . "style-src 'self' 'unsafe-inline'; "
    . "font-src 'self' data:; "
    . "img-src 'self' data: https: http:; "
    . "connect-src 'self';";
header("Content-Security-Policy: " . $csp);

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../inc/fonction.php';

// Page demandée (sécurisée : lettres, chiffres, tirets, underscores uniquement)
$page = isset($_GET['page']) ? preg_replace('/[^a-z0-9_\-]/i', '', $_GET['page']) : 'actu_generale';

// Variables SEO dynamiques par page
$siteName = 'Iran War';
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$baseUrl = $scheme . '://' . $host;
$requestPath = strtok($_SERVER['REQUEST_URI'] ?? '/front/', '?') ?: '/front/';

$seoTitle = 'Actualités sur la guerre en Iran - ' . $siteName;
$seoDescription = 'Suivez les actualités et analyses sur la guerre en Iran : contexte, géopolitique et impacts internationaux.';
$seoKeywords = 'guerre en iran, actualités iran, géopolitique moyen-orient, conflits internationaux';
$seoType = 'website';
$seoCanonical = $baseUrl . $requestPath;
$seoImage = '';
$seoPreloadImage = '';

if ($page === 'article' && isset($_GET['slug'])) {
    $slug = preg_replace('/[^a-z0-9\-]/i', '', $_GET['slug']);
    $articleForTitle = getArticleBySlug($pdo, $slug);

    if (!empty($articleForTitle['titre'])) {
        $seoTitle = $articleForTitle['titre'] . ' - ' . $siteName;
        $seoDescription = truncate($articleForTitle['contenu'] ?? '', 160);
        if (empty($seoDescription)) {
            $seoDescription = 'Découvrez cet article et son analyse sur la guerre en Iran.';
        }
        $seoKeywords = 'article iran, guerre en iran, analyse géopolitique, actualité internationale';
        $seoType = 'article';
        $seoCanonical = $baseUrl . '/front/article/' . rawurlencode($slug);
        if (!empty($articleForTitle['image_url'])) {
            $imagePath = frontImageUrl($articleForTitle['image_url']);
            if (strpos($imagePath, 'http://') === 0 || strpos($imagePath, 'https://') === 0) {
                $seoImage = $imagePath;
            } else {
                $seoImage = $baseUrl . $imagePath;
            }
            $seoPreloadImage = $seoImage;
        }
    } else {
        $seoTitle = 'Article - ' . $siteName;
        $seoDescription = 'Consultez cet article lié aux actualités sur la guerre en Iran.';
    }
} elseif ($page === 'actu_generale' && isset($_GET['categorie'])) {
    $categorieSlug = preg_replace('/[^a-z0-9\-]/i', '', $_GET['categorie']);
    $categories = getCategories($pdo);
    $seoCanonical = $baseUrl . '/front/categorie/' . rawurlencode($categorieSlug);

    foreach ($categories as $cat) {
        if ($cat['slug'] === $categorieSlug) {
            $seoTitle = $cat['nom'] . ' - Actualités guerre en Iran - ' . $siteName;
            $seoDescription = 'Retrouvez les dernières informations de la catégorie ' . $cat['nom'] . ' sur la guerre en Iran.';
            $seoKeywords = strtolower($cat['nom']) . ', guerre en iran, actualités iran, seo actualités';
            break;
        }
    }
} elseif ($page === 'actu_generale') {
    $seoCanonical = $baseUrl . '/front/actualites';
}

if ($page === 'actu_generale') {
    $slugForHero = isset($_GET['categorie'])
        ? preg_replace('/[^a-z0-9\-]/i', '', $_GET['categorie'])
        : null;
    $heroForPreload = getArticleHero($pdo, $slugForHero);

    if (!empty($heroForPreload['image_url'])) {
        $heroImagePath = frontImageUrl($heroForPreload['image_url']);
        if (strpos($heroImagePath, 'http://') === 0 || strpos($heroImagePath, 'https://') === 0) {
            $seoPreloadImage = $heroImagePath;
        } else {
            $seoPreloadImage = $baseUrl . $heroImagePath;
        }
    }
}

// Layout à utiliser (extensible : on pourrait avoir layout "article", "admin", etc.)
$layout = 'default';

// Charge le layout qui lui-même inclura le contenu
$layoutFile = __DIR__ . '/layouts/' . $layout . '.php';

if (file_exists($layoutFile)) {
    require_once $layoutFile;
} else {
    http_response_code(500);
    echo "<p>Layout introuvable.</p>";
}
