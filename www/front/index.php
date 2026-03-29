<?php
// On définit la page par défaut sur "actu_generale" si aucune n'est précisée dans l'URL
if (!isset($_GET['page'])) {
    $_GET['page'] = 'actu_generale';
}

// On fait appel au contrôleur principal (modules.php) qui va charger le layout et le contenu
require_once __DIR__ . '/pages/modules.php';
?>
