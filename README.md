# Mini-projet Webdesign & SEO (Mars 2026) - Guerre en Iran

Ce projet est une plateforme d'information sur la guerre fictive en Iran de 2026, développée pour le cours de SEO S6.

## 👥 Binôme

- **Étudiant 1** : [Rakotoarison Zonantenaina Princi /  ETU003147]
- **Étudiant 2** : [Votre Nom / Num ETU]

## 🚀 Installation & Lancement (Docker)

Le projet est entièrement conteneurisé. Pour le lancer :

1. Assurez-vous d'avoir Docker et Docker Compose installés.
2. Exécutez : `docker-compose up -d --build`
3. Le site est accessible sur : `http://localhost:8080`

## 🔐 Accès BackOffice

- **URL** : `http://localhost:8080/admin/`
- **Utilisateur** : `admin`
- **Mot de passe** : `admin123`

## 🛠️ Caractéristiques Techniques & SEO

- **URL Rewriting** : Utilisation d'un fichier `.htaccess` pour transformer `/front/article.php?slug=xxx` en `/article/xxx`.
- **Structure SEO** :
  - Balises `<h1>` uniques par page.
  - Balises `<title>` et `<meta name="description">` dynamiques basées sur le contenu de la BDD.
  - Attributs `alt` pour toutes les images gérés depuis le BackOffice.
  - Hiérarchie de titres respectée (h1, h2, h3).
- **Base de Données** : MySQL avec tables `articles`, `categories` et `utilisateurs`.

## 📁 Structure du Projet

- `www/` : Code source PHP (séparé en `front/` et `admin/`).
- `db/` : Script d'initialisation SQL.
- `Dockerfile` & `docker-compose.yml` : Configuration de l'environnement.
