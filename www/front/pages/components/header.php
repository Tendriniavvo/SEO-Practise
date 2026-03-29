<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Actu Générale - 20 Minutes</title>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="/front/assets/css/style.css">
</head>
<body>

<!-- HEADER -->
<header>
  <div class="header-top">
    <a href="#" class="logo">20<span>minutes</span></a>
    <div class="search-bar">
      <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
      <input type="text" placeholder="Rechercher…" />
    </div>
    <div class="header-actions">
      <button class="btn-abonne">S'abonner</button>
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
          <li><a href="/front/pages/modules.php?page=actu_generale&categorie=<?= urlencode($cat['slug']) ?>">
              <?= htmlspecialchars($cat['nom']) ?>
          </a></li>
      <?php endforeach; ?>
    </ul>
  </nav>
</header>
