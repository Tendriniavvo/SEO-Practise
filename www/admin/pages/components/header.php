<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Administration - Iran News</title>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="/front/assets/css/style.css">
  <link rel="stylesheet" href="/admin/assets/css/admin.css">
  <script src="https://cdn.tiny.cloud/1/ie2y8ao3tzovh9a8imlqlmtqqf52ijpn06f38tsr805fjny3/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: '#contenu',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
      
      /* Upload configuration */
      images_upload_url: '/admin/inc/upload_handler.php' + (window.location.search.includes('id=') ? '?article_id=' + new URLSearchParams(window.location.search).get('id') : ''),
      automatic_uploads: true,
      images_reuse_filename: true,
      
      /* URL handling */
      relative_urls: false,
      remove_script_host: false,
      convert_urls: true,
    });
  </script>
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
    <a href="/admin/logout.php" title="Déconnexion" class="sidebar-logout">
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
