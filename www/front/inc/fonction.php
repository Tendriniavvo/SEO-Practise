<?php
require_once __DIR__ . '/../../config/db.php';

function getCategories($pdo) {
    try {
        $stmt = $pdo->query("SELECT id_categorie, nom, slug FROM dim_categorie");
        return $stmt->fetchAll();
    } catch (\PDOException $e) {
        return [];
    }
}
?>
