<?php
// Layout Admin par défaut
require_once __DIR__ . '/../components/header.php';

echo "<main class='admin-container'>";

// Contenu spécifique à la page
$contentFile = __DIR__ . '/../pages/' . $page . '.php';
if (file_exists($contentFile)) {
    require_once $contentFile;
} else {
    echo "<div style='padding:40px;text-align:center;'><h2>Page Admin '$page' introuvable</h2></div>";
}

echo "</main>";

require_once __DIR__ . '/../components/footer.php';

// Fermeture du main-wrapper ouvert dans header.php
echo "</div>"; // Fin main-wrapper
?>
</body>
</html>
