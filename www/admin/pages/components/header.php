<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Administration - Iran News</title>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="/front/assets/css/style.css">
  <style>
    /* Admin specific styles */
    .admin-container { padding: 40px 24px; max-width: 1200px; margin: 0 auto; }
    .btn-admin { background: var(--red); color: #fff; padding: 10px 20px; border-radius: 4px; font-weight: 600; display: inline-block; margin-bottom: 20px; transition: opacity 0.2s; }
    .btn-admin:hover { opacity: 0.9; color: #fff; }
    .btn-edit { background: #ffc107; color: #000; padding: 5px 10px; border-radius: 4px; font-size: 0.9em; margin-right: 5px; }
    .btn-del { background: #dc3545; color: #fff; padding: 5px 10px; border-radius: 4px; font-size: 0.9em; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
    th, td { padding: 15px; text-align: left; border-bottom: 1px solid var(--border); }
    th { background: var(--light); font-weight: 700; text-transform: uppercase; font-size: 0.8em; letter-spacing: 0.5px; }
    .statut-publié { color: #28a745; font-weight: 600; }
    .statut-brouillon { color: #6c757d; font-weight: 600; }
    
    /* Form styles */
    .form-group { margin-bottom: 20px; }
    label { display: block; margin-bottom: 8px; font-weight: 600; color: var(--mid); }
    input[type="text"], input[type="password"], textarea, select {
      width: 100%; padding: 12px; border: 1.5px solid var(--border); border-radius: 8px; font-family: 'Sora', sans-serif; font-size: 14px; background: var(--light);
    }
    textarea { height: 200px; resize: vertical; }
    input:focus, textarea:focus, select:focus { border-color: var(--red); outline: none; background: #fff; }
  </style>
</head>
<body>

<header>
  <div class="header-top">
    <a href="/admin/index.php" class="logo">ADMIN<span>IRAN</span></a>
    <div class="header-actions">
      <span style="font-size: 13px; font-weight: 600;">Bonjour, <?= htmlspecialchars($_SESSION['admin_user']) ?></span>
      <a href="/admin/logout.php" title="Déconnexion" style="color: var(--dark); display: flex; align-items: center; padding: 8px; border-radius: 50%; transition: background 0.2s;">
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
      <li><a href="/admin/index.php">Tableau de bord</a></li>
      <li><a href="/admin/index.php?page=add_article">Ajouter un article</a></li>
      <li><a href="/front/" target="_blank">Voir le site</a></li>
    </ul>
  </nav>
</header>
