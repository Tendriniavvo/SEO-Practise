<?php
// Script de routage et de choix de layout

// Paramètres de l'URL
$page = isset($_GET['page']) ? $_GET['page'] : 'actu_generale';
$layout = isset($_GET['layout']) ? $_GET['layout'] : 'default';

// Inclure le layout demandé (le layout se chargera d'inclure le header, le contenu et le footer)
$layoutFile = __DIR__ . '/layouts/' . $layout . '.php';

if (file_exists($layoutFile)) {
    require_once $layoutFile;
} else {
    echo "Erreur : Layout '$layout' introuvable.";
}
?>
