<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($seoTitle ?? 'Actualités sur la guerre en Iran - Iran War') ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="/front/assets/css/style.css">
</head>
<body>

<!-- HEADER -->
<header>
  <div class="header-top">
    <a href="#" class="logo">Iran<span>War</span></a>
    <div class="search-bar">
      <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
      <input type="text" placeholder="Rechercher…" />
    </div>
    <div class="header-actions">
      <a href="/front/logout.php" title="Déconnexion" style="color: var(--dark); display: flex; align-items: center; padding: 8px; border-radius: 50%; transition: background 0.2s;">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
          <polyline points="16 17 21 12 16 7"></polyline>
          <line x1="21" y1="12" x2="9" y2="12"></line>
        </svg>
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
