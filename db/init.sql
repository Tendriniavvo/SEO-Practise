CREATE DATABASE IF NOT EXISTS iran_db;
USE iran_db;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    contenu TEXT NOT NULL,
    meta_description VARCHAR(160),
    meta_keywords VARCHAR(255),
    id_categorie INT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_categorie) REFERENCES categories(id)
);

-- Insert sample data
INSERT INTO categories (nom, slug) VALUES ('Histoire', 'histoire'), ('Géopolitique', 'geopolitique');
INSERT INTO articles (titre, slug, contenu, meta_description, id_categorie) VALUES 
('L\'Iran et son héritage', 'iran-heritage', 'Contenu sur l\'héritage de l\'Iran...', 'Découvrez l\'histoire et l\'héritage culturel de l\'Iran.', 1);
