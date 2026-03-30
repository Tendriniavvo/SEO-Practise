-- Base de données
SET NAMES utf8mb4;
CREATE DATABASE IF NOT EXISTS iran_news;
USE iran_news;

-- 1. Dimension Temps
CREATE TABLE dim_temps (
    id_temps INT PRIMARY KEY AUTO_INCREMENT,
    date DATE NOT NULL,
    annee INT,
    mois INT,
    UNIQUE KEY unique_date (date)
);

-- 2. Dimension Catégorie
CREATE TABLE dim_categorie (
    id_categorie INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    slug VARCHAR(50) NOT NULL UNIQUE
);

-- 3. Dimension Auteur
CREATE TABLE dim_auteur (
    id_auteur INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100)
);

-- 4. Table de Faits - ARTICLE (sans image ici)
CREATE TABLE fait_article (
    id_article INT PRIMARY KEY AUTO_INCREMENT,
    id_temps INT NOT NULL,
    id_categorie INT NOT NULL,
    id_auteur INT NOT NULL,
    titre VARCHAR(200) NOT NULL,
    contenu TEXT NOT NULL,
    slug VARCHAR(200) NOT NULL UNIQUE,
    nb_vues INT DEFAULT 0,
    is_active BOOLEAN DEFAULT FALSE,
    date_publication DATETIME,
    
    FOREIGN KEY (id_temps) REFERENCES dim_temps(id_temps) ON DELETE RESTRICT,
    FOREIGN KEY (id_categorie) REFERENCES dim_categorie(id_categorie) ON DELETE RESTRICT,
    FOREIGN KEY (id_auteur) REFERENCES dim_auteur(id_auteur) ON DELETE RESTRICT
);

-- 5. NOUVELLE TABLE : Images associées à un article (plusieurs images possibles)
CREATE TABLE fait_article_image (
    id_image INT PRIMARY KEY AUTO_INCREMENT,
    id_article INT NOT NULL,
    image_url VARCHAR(255) NOT NULL COMMENT 'chemin relatif ou URL de l image',
    alt_text VARCHAR(150) NULL COMMENT 'texte alternatif obligatoire pour SEO + Lighthouse',
    is_main BOOLEAN DEFAULT FALSE COMMENT 'image principale (une seule par article)',
    FOREIGN KEY (id_article) REFERENCES fait_article(id_article) ON DELETE CASCADE
);

-- Index pour performances
CREATE INDEX idx_article_active ON fait_article(is_active);
CREATE INDEX idx_date_publication ON fait_article(date_publication);
CREATE INDEX idx_article_slug ON fait_article(slug);
CREATE INDEX idx_image_article ON fait_article_image(id_article);
CREATE INDEX idx_image_main ON fait_article_image(is_main);

-- 6. Table admin
CREATE TABLE admin (
    id_admin INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Données de base
INSERT INTO dim_categorie (nom, slug) VALUES
('Actualités', 'actualites'),
('Militaire', 'militaire'),
('Humanitaire', 'humanitaire'),
('Politique', 'politique'),
('Sport', 'sport'), 
('Économie','economie');


INSERT INTO admin (username, password) VALUES
('admin', SHA2('admin123', 256));