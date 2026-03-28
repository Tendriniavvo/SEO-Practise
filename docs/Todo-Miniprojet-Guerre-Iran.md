# Todo List — Mini-projet Web Design (Mars 2026)
> Site d'informations sur la guerre en Iran · Travail en binôme · **Délai : Mardi 31 mars 2026 à 14h00**

**Livrables attendus :**
- ZIP fonctionnel dans des conteneurs Docker
- Dépôt Git public (GitHub ou GitLab)
- Document technique (captures FO/BO, modélisation BDD, login admin, numéros ETU)

---

## Légende

| Badge | Responsable |
|---|---|
| `[P]` | Développeur P |
| `[T]` | Développeur T |
| `[P+T]` | Les deux ensemble |
| `⚠️ critique` | Point de notation explicite dans le sujet |

---

## 01 — Initialisation du projet

- [ ] `[P+T]` Créer le dépôt Git public (GitHub/GitLab) — branches : `main`, `develop`, `feature/fo`, `feature/bo`
- [ ] `[P]` Configurer `docker-compose.yml` — conteneurs : PHP + MySQL (ou stack au choix) + phpMyAdmin
- [ ] `[T]` Définir la structure des dossiers — `/frontend`, `/backend`, `/database`, `/docker`
- [ ] `[P+T]` Réunion de conception : définir les entités et fonctionnalités — Articles, Catégories, Utilisateurs, Médias, Tags

---

## 02 — Base de données

- [ ] `[T]` Modéliser la base de données (MCD/MLD) — tables : `articles`, `categories`, `users`, `media`, `tags`, `tag_article`
- [ ] `[T]` Rédiger le script SQL de création (`init.sql`) — `CREATE TABLE` + contraintes FK + INDEX sur `slug` et `date`
- [ ] `[T]` Insérer les données de test (`seed.sql`) — min. 10 articles sur la guerre en Iran, 3 catégories, 1 compte admin
- [ ] `[P]` Intégrer `init.sql` dans le conteneur Docker — volume MySQL + healthcheck dans `docker-compose.yml`

---

## 03 — FrontOffice (affichage public)

- [ ] `[P]` Page d'accueil — liste des articles récents avec pagination (aperçu image + titre + date + extrait)
- [ ] `[P]` Page article — affichage complet (titre H1, corps, auteur, date, catégorie, image)
- [ ] `[P]` Page catégorie — filtre par rubrique (Diplomatie, Conflits armés, Humanitaire, Chronologie…)
- [ ] `[T]` Barre de navigation et footer — logo, menu principal, liens catégories, mentions légales
- [ ] `[T]` Page de recherche interne — formulaire GET → résultats filtrés depuis la BDD

---

## 04 — BackOffice (administration)

- [ ] `[T]` Page de login admin — identifiants par défaut `admin` / `admin`, session PHP + protection CSRF ⚠️ critique
- [ ] `[T]` Dashboard — liste des articles avec colonnes : titre, catégorie, statut, date + boutons Éditer/Supprimer
- [ ] `[T]` Formulaire ajout/édition d'article — champs : titre, slug auto, corps, catégorie, image, statut publié/brouillon
- [ ] `[P]` Gestion des catégories (CRUD complet) — ajouter, modifier, supprimer une catégorie
- [ ] `[P]` Upload et gestion des médias — stockage dans `/uploads`, miniature, nommage par slug
- [ ] `[P+T]` Middleware d'authentification — redirection vers `/login` si session absente sur toutes les routes BO

---

## 05 — SEO & Optimisation ⚠️ (critères de notation)

- [ ] `[P]` **URL Rewriting** — URLs propres et normalisées : `/article/slug-de-larticle` sans `.php` ni `?id=` ⚠️ critique
- [ ] `[P]` **Balises `<title>` dynamiques** et uniques par page — format : `Titre article | Nom du site` ⚠️ critique
- [ ] `[T]` **Balises `<meta>` dynamiques** — `description` < 160 car., `robots`, `og:title`, `og:description`, `og:image` ⚠️ critique
- [ ] `[T]` **Structure H1→H6 sémantique** — un seul `<h1>` par page = titre de l'article, `<h2>` pour les sous-sections ⚠️ critique
- [ ] `[P]` **Attribut `alt`** sur toutes les images — alt descriptif généré depuis le titre ou saisi dans le BO ⚠️ critique
- [ ] `[P+T]` **Test Lighthouse** (mobile + desktop) et corrections — cibles : LCP < 2.5s · CLS < 0.1 · INP < 200ms · score > 75 ⚠️ critique
- [ ] `[P]` Compression images (WebP) + lazy loading — `<img loading="lazy">` sur toutes les images sauf le hero (LCP)
- [ ] `[T]` `sitemap.xml` + `robots.txt` — sitemap à la racine, robots.txt bloquant `/admin` et `/login`
- [ ] `[T]` Données structurées Schema.org — JSON-LD `Article` + `BreadcrumbList` dans le `<head>` de chaque page article

---

## 06 — Docker & Livraison finale

- [ ] `[P]` Finaliser `docker-compose.yml` — services : `web` (PHP/Nginx), `db` (MySQL), `phpmyadmin` + ports documentés
- [ ] `[T]` Vérifier que le site fonctionne avec `docker compose up` — test complet : FO, BO, login, ajout article, Lighthouse
- [ ] `[P+T]` Rédiger le document technique — captures FO/BO, modélisation BDD, login admin par défaut, numéros ETU
- [ ] `[P+T]` Préparer le ZIP final et pousser sur Git — `README.md` avec instructions de lancement + URL du dépôt public

---

## Récapitulatif de la répartition

| | Développeur P | Développeur T | Les deux |
|---|---|---|---|
| **Initialisation** | Docker Compose | Structure dossiers | Dépôt Git, réunion conception |
| **Base de données** | Intégration Docker | Modélisation, SQL, seed | — |
| **FrontOffice** | Accueil, Article, Catégorie | Navigation, Recherche | — |
| **BackOffice** | CRUD catégories, Médias | Login, Dashboard, Formulaire article | Middleware auth |
| **SEO** | URL Rewriting, `<title>`, `alt`, WebP | `<meta>`, H1-H6, sitemap, Schema.org | Lighthouse |
| **Livraison** | Docker final | Test Docker | Document technique, ZIP, Git |

---

## Points de notation à ne pas oublier

Extrait du sujet — ces 6 points sont **explicitement évalués** :

1. URL normalisé (rewriting) → `[P]`
2. Structure des données avec h1, h2, ..., h6 → `[T]`
3. Utilisation des titres pour la page (`<title>`) → `[P]`
4. Utilisation des balises méta → `[T]`
5. Alt pour les images → `[P]`
6. Test sur Lighthouse local (mobile et ordinateur) → `[P+T]`

---

*Mini-projet Web Design · Mars 2026 · ITuniversity*
