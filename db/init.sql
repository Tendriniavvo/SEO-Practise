-- ============================================
-- BASE DE DONNÉES : Guerre en Iran
-- ============================================

CREATE DATABASE IF NOT EXISTS iran_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE iran_db;

-- ============================================
-- TABLE : categories
-- ============================================
CREATE TABLE categories (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nom         VARCHAR(100) NOT NULL,
    slug        VARCHAR(100) NOT NULL UNIQUE,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- TABLE : articles
-- ============================================
CREATE TABLE articles (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    id_categorie  INT NOT NULL,
    titre         VARCHAR(255) NOT NULL,           -- → <title> et <h1>
    slug          VARCHAR(255) NOT NULL UNIQUE,    -- → URL rewriting
    description   VARCHAR(300) NOT NULL,           -- → <meta name="description">
    contenu       TEXT NOT NULL,                   -- → texte brut, pas de HTML
    image         VARCHAR(255) DEFAULT NULL,       -- → nom du fichier image
    alt_image     VARCHAR(255) DEFAULT NULL,       -- → alt="" SEO
    statut        ENUM('publié', 'brouillon') DEFAULT 'brouillon',
    created_at    DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at    DATETIME ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (id_categorie) REFERENCES categories(id) ON DELETE CASCADE
);

-- ============================================
-- TABLE : utilisateurs (Backoffice)
-- ============================================
CREATE TABLE utilisateurs (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(100) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,             -- stocké en hash bcrypt
    role        ENUM('admin', 'editeur') DEFAULT 'editeur',
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- DONNÉES : Catégories
-- ============================================
INSERT INTO categories (nom, slug) VALUES
('Actualités',   'actualites'),
('Histoire',     'histoire'),
('Politique',    'politique'),
('Humanitaire',  'humanitaire'),
('Économie',     'economie');

-- ============================================
-- DONNÉES : Utilisateur par défaut (Backoffice)
-- login : admin / admin123
-- ============================================
INSERT INTO utilisateurs (username, password, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- ============================================
-- DONNÉES : Articles exemples (texte brut uniquement)
-- ============================================
INSERT INTO articles (id_categorie, titre, slug, description, contenu, image, alt_image, statut) VALUES
(
    1,
    'Début des frappes aériennes sur Téhéran',
    'debut-frappes-aeriennes-teheran',
    'Résumé des premières frappes aériennes sur la capitale iranienne en 2026.',
    'Les premières frappes aériennes sur Téhéran ont débuté en janvier 2026. La communauté internationale a réagi avec inquiétude face à cette escalade militaire sans précédent dans la région.',
    'frappes-teheran.jpg',
    'Vue aérienne de Téhéran lors des frappes de 2026',
    'publié'
),
(
    3,
    'Position des grandes puissances face au conflit',
    'position-grandes-puissances-conflit',
    'Analyse de la position des États-Unis, Russie et Chine face à la guerre en Iran.',
    'Les États-Unis ont condamné les frappes et appelé à un cessez-le-feu immédiat. La Russie reste neutre officiellement tout en soutenant diplomatiquement Téhéran. La Chine de son côté privilégie une solution négociée.',
    'puissances-iran.jpg',
    'Représentants des grandes puissances en réunion sur la crise iranienne',
    'publié'
),
(
    4,
    'Crise humanitaire : des millions de déplacés',
    'crise-humanitaire-deplaces-iran',
    'La guerre provoque une des pires crises humanitaires de la décennie en Iran.',
    'Selon les estimations de ONU, plus de trois millions de civils ont été déplacés depuis le début du conflit. Plusieurs organisations humanitaires internationales tentent d acheminer de aide dans les zones touchées.',
    'humanitaire-iran.jpg',
    'Civils iraniens déplacés fuyant les zones de conflit',
    'publié'
);