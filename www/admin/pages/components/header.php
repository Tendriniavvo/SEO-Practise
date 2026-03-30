<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Administration - Iran News</title>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="/front/assets/css/style.css">
  <script src="https://cdn.tiny.cloud/1/ie2y8ao3tzovh9a8imlqlmtqqf52ijpn06f38tsr805fjny3/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: '#contenu',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
  </script>
  <style>
    /* Global Layout */
    body { display: flex; min-height: 100vh; background: var(--light); }
    
    /* Sidebar */
    .sidebar {
      width: 260px;
      background: var(--dark);
      color: #fff;
      display: flex;
      flex-direction: column;
      position: fixed;
      height: 100vh;
      left: 0;
      top: 0;
      z-index: 1000;
      transition: all 0.3s;
    }
    .sidebar .logo {
      padding: 30px 24px;
      font-size: 24px;
      font-weight: 800;
      color: var(--red);
      border-bottom: 1px solid rgba(255,255,255,0.1);
      text-decoration: none;
    }
    .sidebar .logo span { color: #fff; }
    
    .sidebar-nav { flex: 1; padding: 20px 0; border: none !important; }
    .sidebar-nav ul { list-style: none; padding: 0; display: block !important; border: none !important; }
    .sidebar-nav ul li { display: block !important; width: 100%; border: none !important; }
    .sidebar-nav ul li a {
      display: flex !important;
      align-items: center;
      padding: 12px 24px;
      color: rgba(255,255,255,0.7);
      text-decoration: none !important;
      font-weight: 600;
      font-size: 14px;
      transition: all 0.2s;
      gap: 12px;
      border: none !important;
    }
    .sidebar-nav ul li a:hover, .sidebar-nav ul li a.active {
      color: #fff;
      background: rgba(255,255,255,0.05);
      border-left: 4px solid var(--red);
    }
    .sidebar-nav ul li a svg { width: 18px; height: 18px; }

    /* User Profile in Sidebar */
    .sidebar-footer {
      padding: 20px;
      border-top: 1px solid rgba(255,255,255,0.1);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .user-info { display: flex; flex-direction: column; gap: 2px; }
    .user-info .name { font-size: 13px; font-weight: 700; color: #fff; }
    .user-info .role { font-size: 11px; color: rgba(255,255,255,0.5); }

    /* Main Content Area */
    .main-wrapper {
      flex: 1;
      margin-left: 260px;
      display: flex;
      flex-direction: column;
      min-width: 0;
    }

    /* Top Bar */
    .top-bar {
      height: 70px;
      background: #fff;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: flex-end;
      padding: 0 30px;
      position: sticky;
      top: 0;
      z-index: 900;
    }

    /* Admin specific styles */
    .admin-container { padding: 40px; max-width: 1200px; width: 100%; margin: 0 auto; }
    .btn-admin { background: var(--red); color: #fff; padding: 10px 20px; border-radius: 4px; font-weight: 600; display: inline-block; margin-bottom: 20px; transition: opacity 0.2s; border: none; cursor: pointer; }
    .btn-admin:hover { opacity: 0.9; color: #fff; }
    .btn-edit { background: #ffc107; color: #000; padding: 5px 10px; border-radius: 4px; font-size: 0.9em; margin-right: 5px; }
    .btn-del { background: #dc3545; color: #fff; padding: 5px 10px; border-radius: 4px; font-size: 0.9em; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border-radius: 8px; overflow: hidden; }
    th, td { padding: 15px 20px; text-align: left; border-bottom: 1px solid var(--border); }
    th { background: var(--light); font-weight: 700; text-transform: uppercase; font-size: 0.8em; letter-spacing: 0.5px; color: var(--mid); }
    .statut-publié { color: #28a745; font-weight: 600; background: #e8f5e9; padding: 4px 8px; border-radius: 4px; font-size: 12px; }
    .statut-brouillon { color: #6c757d; font-weight: 600; background: #f8f9fa; padding: 4px 8px; border-radius: 4px; font-size: 12px; }
    
    /* Form styles */
    .form-group { margin-bottom: 24px; }
    label { display: block; margin-bottom: 8px; font-weight: 600; color: var(--dark); font-size: 14px; }
    input[type="text"], input[type="password"], textarea, select {
      width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 8px; font-family: 'Sora', sans-serif; font-size: 14px; background: #fff; transition: all 0.2s;
    }
    textarea { height: 250px; resize: vertical; }
    input:focus, textarea:focus, select:focus { border-color: var(--red); outline: none; box-shadow: 0 0 0 3px rgba(232,0,29,0.05); }
  </style>
</head>
<body>

<aside class="sidebar">
  <a href="/admin/index.php" class="logo">ADMIN<span>IRAN</span></a>
  
  <nav class="sidebar-nav">
    <ul>
      <li>
        <a href="/admin/index.php?page=dashboard" class="<?= (!isset($_GET['page']) || $_GET['page'] == 'dashboard') ? 'active' : '' ?>">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
          Tableau de bord
        </a>
      </li>
      <li>
        <a href="/admin/index.php?page=add_article" class="<?= (isset($_GET['page']) && $_GET['page'] == 'add_article') ? 'active' : '' ?>">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
          Ajouter un article
        </a>
      </li>
      <li>
        <a href="/front/" target="_blank">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
          Voir le site
        </a>
      </li>
    </ul>
  </nav>

  <div class="sidebar-footer">
    <div class="user-info">
      <span class="name"><?= htmlspecialchars($_SESSION['admin_user']) ?></span>
      <span class="role">Administrateur</span>
    </div>
    <a href="/admin/logout.php" title="Déconnexion" style="color: rgba(255,255,255,0.5); transition: color 0.2s;">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
        <polyline points="16 17 21 12 16 7"></polyline>
        <line x1="21" y1="12" x2="9" y2="12"></line>
      </svg>
    </a>
  </div>
</aside>

<div class="main-wrapper">
  <header class="top-bar">
    <!-- Top bar empty or can contain search/notifications later -->
  </header>
