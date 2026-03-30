<?php
// Layout par défaut
require_once __DIR__ . '/../components/header.php';

// Contenu spécifique à la page
$contentFile = __DIR__ . '/../pages/' . $page . '.php';
if (file_exists($contentFile)) {
    require_once $contentFile;
} else {
    echo "<div class='container' style='padding:40px;text-align:center;'><h2>Page '$page' introuvable</h2></div>";
}

require_once __DIR__ . '/../components/footer.php';
?>
