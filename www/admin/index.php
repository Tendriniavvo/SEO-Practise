<?php
// On définit la page par défaut sur "dashboard" si aucune n'est précisée dans l'URL
if (!isset($_GET['page'])) {
    $_GET['page'] = 'dashboard';
}

// On fait appel au contrôleur admin (modules.php) qui va charger le layout et le contenu
require_once __DIR__ . '/pages/modules.php';
?>
