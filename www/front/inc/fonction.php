<?php
require_once __DIR__ . '/../../config/db.php';

// ─────────────────────────────────────────────
// Récupère toutes les catégories (nav + routing)
// ─────────────────────────────────────────────
function getCategories($pdo) {
    try {
        $stmt = $pdo->query("SELECT id_categorie, nom, slug FROM dim_categorie ORDER BY id_categorie");
        return $stmt->fetchAll();
    } catch (\PDOException $e) {
        return [];
    }
}

// ─────────────────────────────────────────────
// Récupère l'article hero (le plus récent actif)
// d'une catégorie donnée (slug), ou tous si null
// ─────────────────────────────────────────────
function getArticleHero($pdo, $slug = null) {
    try {
        $sql = "
            SELECT
                a.id_article,
                a.titre,
                a.contenu,
                a.slug         AS article_slug,
                a.date_publication,
                c.nom          AS categorie_nom,
                c.slug         AS categorie_slug,
                i.image_url,
                i.alt_text
            FROM fait_article a
            JOIN dim_categorie c ON a.id_categorie = c.id_categorie
            LEFT JOIN fait_article_image i
                   ON i.id_article = a.id_article AND i.is_main = 1
            WHERE a.is_active = 1
        ";

        $params = [];
        if ($slug !== null) {
            $sql .= " AND c.slug = :slug";
            $params[':slug'] = $slug;
        }

        $sql .= " ORDER BY a.date_publication DESC LIMIT 1";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    } catch (\PDOException $e) {
        return null;
    }
}

// ─────────────────────────────────────────────
// Récupère les articles d'une catégorie (slug)
// avec pagination — exclut le hero
// ─────────────────────────────────────────────
function getArticlesByCategorie($pdo, $slug = null, $page = 1, $perPage = 9, $excludeId = null) {
    try {
        $offset = ($page - 1) * $perPage;

        $sql = "
            SELECT
                a.id_article,
                a.titre,
                a.contenu,
                a.slug         AS article_slug,
                a.date_publication,
                a.nb_vues,
                c.nom          AS categorie_nom,
                c.slug         AS categorie_slug,
                i.image_url,
                i.alt_text
            FROM fait_article a
            JOIN dim_categorie c ON a.id_categorie = c.id_categorie
            LEFT JOIN fait_article_image i
                   ON i.id_article = a.id_article AND i.is_main = 1
            WHERE a.is_active = 1
        ";

        $params = [];

        if ($slug !== null) {
            $sql .= " AND c.slug = :slug";
            $params[':slug'] = $slug;
        }

        if ($excludeId !== null) {
            $sql .= " AND a.id_article != :excludeId";
            $params[':excludeId'] = $excludeId;
        }

        $sql .= " ORDER BY a.date_publication DESC LIMIT :limit OFFSET :offset";

        $stmt = $pdo->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->bindValue(':limit',  $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset,  PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    } catch (\PDOException $e) {
        return [];
    }
}

// ─────────────────────────────────────────────
// Compte le nombre total d'articles (pour pagination)
// ─────────────────────────────────────────────
function countArticlesByCategorie($pdo, $slug = null, $excludeId = null) {
    try {
        $sql = "
            SELECT COUNT(*) AS total
            FROM fait_article a
            JOIN dim_categorie c ON a.id_categorie = c.id_categorie
            WHERE a.is_active = 1
        ";

        $params = [];

        if ($slug !== null) {
            $sql .= " AND c.slug = :slug";
            $params[':slug'] = $slug;
        }

        if ($excludeId !== null) {
            $sql .= " AND a.id_article != :excludeId";
            $params[':excludeId'] = $excludeId;
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch();
        return (int) $row['total'];
    } catch (\PDOException $e) {
        return 0;
    }
}

// ─────────────────────────────────────────────
// Récupère les 6 articles les plus vus (tendances sidebar)
// ─────────────────────────────────────────────
function getTendances($pdo, $limit = 6) {
    try {
        $stmt = $pdo->prepare("
            SELECT a.id_article, a.titre, a.slug AS article_slug
            FROM fait_article a
            WHERE a.is_active = 1
            ORDER BY a.nb_vues DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (\PDOException $e) {
        return [];
    }
}

// ─────────────────────────────────────────────
// Récupère les 3 articles "à ne pas manquer"
// (hors hero et hors grille principale)
// ─────────────────────────────────────────────
function getANePasManquer($pdo, $excludeId = null, $limit = 3) {
    try {
        $sql = "
            SELECT
                a.id_article,
                a.titre,
                a.slug         AS article_slug,
                i.image_url,
                i.alt_text
            FROM fait_article a
            LEFT JOIN fait_article_image i
                   ON i.id_article = a.id_article AND i.is_main = 1
            WHERE a.is_active = 1
        ";

        $params = [];
        if ($excludeId !== null) {
            $sql .= " AND a.id_article != :excludeId";
            $params[':excludeId'] = $excludeId;
        }

        $sql .= " ORDER BY a.nb_vues DESC LIMIT :limit";

        $stmt = $pdo->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (\PDOException $e) {
        return [];
    }
}

// ─────────────────────────────────────────────
// Helper : formate une date en "Il y a Xh" ou date lisible
// ─────────────────────────────────────────────
function formatDateRelative($dateStr) {
    if (empty($dateStr)) return '';
    $date = new DateTime($dateStr);
    $now  = new DateTime();
    $diff = $now->diff($date);

    if ($diff->days === 0) {
        if ($diff->h === 0) {
            return 'Il y a ' . max(1, $diff->i) . ' min';
        }
        return 'Il y a ' . $diff->h . 'h';
    } elseif ($diff->days < 7) {
        return 'Il y a ' . $diff->days . ' jour' . ($diff->days > 1 ? 's' : '');
    }

    return $date->format('d/m/Y');
}

// ─────────────────────────────────────────────
// Helper : tronque un texte proprement
// ─────────────────────────────────────────────
function truncate($text, $maxLen = 120) {
    $text = strip_tags($text);
    if (mb_strlen($text) <= $maxLen) return $text;
    return mb_substr($text, 0, $maxLen) . '…';
}

// ─────────────────────────────────────────────
// Helper : normalise l'URL d'image pour le front
// Accepte :
// - URL absolue (http://..., https://...)
// - /front/assets/img/...
// - front/assets/img/...
// - /img/..., ../img/...
// - uploads/...
// ─────────────────────────────────────────────
function frontImageUrl($imageUrl) {
    if (empty($imageUrl)) {
        return '';
    }

    $url = trim((string) $imageUrl);

    if (preg_match('#^https?://#i', $url)) {
        return $url;
    }

    if (strpos($url, '/front/assets/') === 0) {
        return $url;
    }

    if (strpos($url, 'front/assets/') === 0) {
        return '/' . $url;
    }

    if (strpos($url, '../img/') === 0) {
        return '/img/' . ltrim(substr($url, strlen('../img/')), '/');
    }

    if (strpos($url, '/img/') === 0) {
        return $url;
    }

    if (strpos($url, 'img/') === 0) {
        return '/' . $url;
    }

    if (strpos($url, 'uploads/') === 0) {
        return '/front/assets/' . $url;
    }

    if (strpos($url, '/uploads/') === 0) {
        return '/front/assets' . $url;
    }

    return '/front/assets/' . ltrim($url, '/');
}
