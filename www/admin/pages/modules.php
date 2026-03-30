<?php
// ─────────────────────────────────────────────
// Routeur Admin
// Chemin : www/admin/pages/modules.php
// ─────────────────────────────────────────────

ob_start();
session_start();
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../front/inc/fonction.php'; // On peut réutiliser les fonctions du front
require_once __DIR__ . '/../inc/fonction.php'; // Fonctions spécifiques à l'admin

// Protection basique de la session
if (!isset($_SESSION['admin_id'])) {
    header("Location: /admin/login.php");
    exit();
}

// Page demandée (sécurisée)
$page = isset($_GET['page']) ? preg_replace('/[^a-z0-9_\-]/i', '', $_GET['page']) : 'dashboard';

// Layout à utiliser
$layout = 'default';

// Charge le layout qui lui-même inclura le contenu
$layoutFile = __DIR__ . '/layouts/' . $layout . '.php';

if (file_exists($layoutFile)) {
    require_once $layoutFile;
} else {
    http_response_code(500);
    echo "<p>Layout admin introuvable.</p>";
}

ob_end_flush();
?>
