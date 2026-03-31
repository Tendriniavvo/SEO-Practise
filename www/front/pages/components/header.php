<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($seoTitle ?? 'Actualités sur la guerre en Iran - Iran War') ?></title>
  <meta name="description" content="<?= htmlspecialchars($seoDescription ?? 'Suivez les actualités et analyses sur la guerre en Iran.', ENT_QUOTES, 'UTF-8') ?>" />
  <meta name="keywords" content="<?= htmlspecialchars($seoKeywords ?? 'guerre en iran, actualités iran', ENT_QUOTES, 'UTF-8') ?>" />
  <link rel="canonical" href="<?= htmlspecialchars($seoCanonical ?? '', ENT_QUOTES, 'UTF-8') ?>" />

  <meta property="og:locale" content="fr_FR" />
  <meta property="og:type" content="<?= htmlspecialchars($seoType ?? 'website', ENT_QUOTES, 'UTF-8') ?>" />
  <meta property="og:site_name" content="Iran War" />
  <meta property="og:title" content="<?= htmlspecialchars($seoTitle ?? 'Actualités sur la guerre en Iran - Iran War', ENT_QUOTES, 'UTF-8') ?>" />
  <meta property="og:description" content="<?= htmlspecialchars($seoDescription ?? 'Suivez les actualités et analyses sur la guerre en Iran.', ENT_QUOTES, 'UTF-8') ?>" />
  <meta property="og:url" content="<?= htmlspecialchars($seoCanonical ?? '', ENT_QUOTES, 'UTF-8') ?>" />
  <?php if (!empty($seoImage)): ?>
    <meta property="og:image" content="<?= htmlspecialchars($seoImage, ENT_QUOTES, 'UTF-8') ?>" />
  <?php endif; ?>

  <meta name="twitter:card" content="<?= !empty($seoImage) ? 'summary_large_image' : 'summary' ?>" />
  <meta name="twitter:title" content="<?= htmlspecialchars($seoTitle ?? 'Actualités sur la guerre en Iran - Iran War', ENT_QUOTES, 'UTF-8') ?>" />
  <meta name="twitter:description" content="<?= htmlspecialchars($seoDescription ?? 'Suivez les actualités et analyses sur la guerre en Iran.', ENT_QUOTES, 'UTF-8') ?>" />
  <?php if (!empty($seoImage)): ?>
    <meta name="twitter:image" content="<?= htmlspecialchars($seoImage, ENT_QUOTES, 'UTF-8') ?>" />
  <?php endif; ?>

  <?php if (!empty($seoPreloadImage)): ?>
    <link rel="preload" as="image" href="<?= htmlspecialchars($seoPreloadImage, ENT_QUOTES, 'UTF-8') ?>" fetchpriority="high" />
  <?php endif; ?>
  <link rel="stylesheet" href="/front/assets/css/style.css">
</head>
<body>

<!-- HEADER -->
<header>
  <div class="header-top">
    <a href="/front/" class="logo" aria-label="Accueil Iran War">Iran<span>War</span></a>
    <div class="header-actions">
      <a href="/admin/logout.php" class="logout-link" title="Déconnexion" aria-label="Se déconnecter" style="color: var(--dark); display: inline-flex; align-items: center; gap: 6px; padding: 8px 10px; border-radius: 8px; transition: background 0.2s; text-decoration: none;">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
          <polyline points="16 17 21 12 16 7"></polyline>
          <line x1="21" y1="12" x2="9" y2="12"></line>
        </svg>
        <span>Déconnexion</span>
      </a>
    </div>
  </div>
  <nav>
    <ul>
      <li><a href="/front/">Accueil</a></li>
      <?php
      require_once __DIR__ . '/../../inc/fonction.php';
      // $pdo devrait être disponible grâce à l'inclusion de config/db.php dans modules.php
      $categories = getCategories($pdo);
      foreach ($categories as $cat): 
      ?>
            <li><a href="/front/categorie/<?= urlencode($cat['slug']) ?>">
              <?= htmlspecialchars($cat['nom']) ?>
          </a></li>
      <?php endforeach; ?>
    </ul>
  </nav>
</header>
