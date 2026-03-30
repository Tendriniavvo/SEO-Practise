<?php
// ─────────────────────────────────────────────
// Routeur principal
// Chemin : www/front/pages/modules.php
// ─────────────────────────────────────────────

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../inc/fonction.php';

// Page demandée (sécurisée : lettres, chiffres, tirets, underscores uniquement)
$page = isset($_GET['page']) ? preg_replace('/[^a-z0-9_\-]/i', '', $_GET['page']) : 'actu_generale';

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
