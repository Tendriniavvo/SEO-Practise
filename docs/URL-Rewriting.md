# URL Rewriting — Guide Complet Apache (.htaccess)

> **Conseil :** Testez chaque règle dans un environnement de développement avant la mise en production. Une règle mal écrite peut provoquer des boucles infinies ou des erreurs 500.

---

## Table des matières

1. [Qu'est-ce que l'URL Rewriting ?](#1-quest-ce-que-lurl-rewriting)
2. [Prérequis et activation](#2-prérequis-et-activation)
3. [Syntaxe de base](#3-syntaxe-de-base)
4. [Drapeaux (Flags)](#4-drapeaux-flags)
5. [Expressions régulières essentielles](#5-expressions-régulières-essentielles)
6. [RewriteCond — Les conditions](#6-rewritecond--les-conditions)
7. [Exemples progressifs](#7-exemples-progressifs)
8. [Cas d'usage réels et complets](#8-cas-dusage-réels-et-complets)
9. [Redirections SEO](#9-redirections-seo)
10. [Sécurité via URL Rewriting](#10-sécurité-via-url-rewriting)
11. [Débogage et erreurs fréquentes](#11-débogage-et-erreurs-fréquentes)
12. [URL Rewriting avec PHP](#12-url-rewriting-avec-php)
13. [URL Rewriting avec Nginx](#13-url-rewriting-avec-nginx)
14. [Résumé des flags](#14-résumé-des-flags)

---

## 1. Qu'est-ce que l'URL Rewriting ?

L'URL Rewriting (réécriture d'URL) permet de **transformer des URLs dynamiques et techniques en URLs propres, lisibles et optimisées pour le SEO**, sans modifier la structure réelle des fichiers sur le serveur.

### Pourquoi l'utiliser ?

| Objectif | Exemple concret |
|---|---|
| **SEO** | `/articles/article.php?id=12` → `/articles/guide-seo-debutant` |
| **Masquer la technologie** | `/produit.php?id=5` → `/produit/chaussures-running` |
| **Simplifier la navigation** | URL courte et mémorisable pour les utilisateurs |
| **Gérer les redirections** | Conserver le PageRank lors d'une refonte |
| **Sécurité** | Masquer l'extension `.php`, bloquer des patterns d'attaque |

### La transformation type

```
# URL technique (interne, jamais vue par l'utilisateur)
http://www.notre-site.com/articles/article.php?id=12&page=2&rubrique=5

# URL propre (affichée dans le navigateur et indexée par Google)
http://www.notre-site.com/articles/guide-seo-complet-2-5.html
```

> Le serveur reçoit la requête pour l'URL propre, la **traduit en interne** vers l'URL technique, exécute le script PHP, et renvoie le résultat. L'utilisateur et Google ne voient jamais `article.php?id=12`.

---

## 2. Prérequis et activation

### Sur Apache (hébergement mutualisé ou VPS)

Le module `mod_rewrite` doit être activé sur le serveur. Sur un hébergement mutualisé, il l'est généralement par défaut.

**Vérifier si mod_rewrite est actif :**
```bash
# En ligne de commande (accès SSH)
apache2ctl -M | grep rewrite

# Résultat attendu :
# rewrite_module (shared)
```

**Activer mod_rewrite sur Ubuntu/Debian :**
```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

**Autoriser le .htaccess dans la configuration Apache (`/etc/apache2/apache2.conf`) :**
```apache
<Directory /var/www/html>
    AllowOverride All   # ← Indispensable pour que .htaccess soit lu
    Require all granted
</Directory>
```

### Structure d'un fichier `.htaccess`

Le fichier `.htaccess` se place à la **racine de votre site** (même niveau que `index.php`).

```
www/
├── .htaccess        ← Ici
├── index.php
├── pages/
│   ├── article.php
│   └── produit.php
└── assets/
```

### Base minimale obligatoire

Chaque fichier `.htaccess` utilisant le rewriting doit commencer par :

```apache
Options +FollowSymlinks
RewriteEngine On
```

- `Options +FollowSymlinks` → Autorise le serveur à suivre les liens symboliques (requis par `mod_rewrite`)
- `RewriteEngine On` → Active le moteur de réécriture

---

## 3. Syntaxe de base

### Structure d'une règle RewriteRule

```apache
RewriteRule [pattern] [substitution] [flags]
```

| Partie | Description |
|---|---|
| `pattern` | Expression régulière qui correspond à l'URL **demandée** par le visiteur |
| `substitution` | URL **réelle** vers laquelle rediriger en interne (ou `-` pour stopper) |
| `flags` | Options entre crochets `[L]`, `[R=301]`, `[NC]`, etc. |

### Premier exemple minimal

```apache
Options +FollowSymlinks
RewriteEngine On

RewriteRule ^essai.html$ test.html [L]
```

**Décomposition :**
- `^` → début de l'URL
- `essai.html` → correspond exactement à cette chaîne
- `$` → fin de l'URL
- `test.html` → fichier réel servi
- `[L]` → Last (arrêter l'évaluation des règles suivantes)

**Résultat :** L'URL `/essai.html` affiche le contenu de `test.html` sans que l'utilisateur ne le sache.

---

## 4. Drapeaux (Flags)

Les flags modifient le comportement de chaque règle. Ils se placent entre `[ ]`, séparés par des virgules.

| Flag | Abréviation | Description |
|---|---|---|
| `[Last]` | `[L]` | Arrête l'évaluation des règles suivantes si celle-ci correspond |
| `[Redirect=301]` | `[R=301]` | Redirection HTTP permanente (visible par le navigateur) |
| `[Redirect=302]` | `[R=302]` | Redirection temporaire |
| `[NoCase]` | `[NC]` | Insensible à la casse (`Article.html` = `article.html`) |
| `[QueryString]` | `[QSA]` | Conserve les paramètres GET (`?utm_source=...`) |
| `[End]` | `[END]` | Arrête toutes les évaluations (même les .htaccess parents) |
| `[Forbidden]` | `[F]` | Renvoie une erreur 403 |
| `[Gone]` | `[G]` | Renvoie une erreur 410 (page définitivement supprimée) |
| `[NoSubReq]` | `[NS]` | Ne s'applique pas aux sous-requêtes internes |
| `[Type=...]` | `[T=text/html]` | Force le type MIME de la réponse |
| `[Chain]` | `[C]` | Enchaîne avec la règle suivante (s'applique uniquement si celle-ci correspond) |

**Exemples combinés :**
```apache
# Redirection permanente, insensible à la casse, conserve les paramètres
RewriteRule ^ancien-article.html$ /nouvel-article/ [R=301,L,NC,QSA]
```

---

## 5. Expressions régulières essentielles

Le `pattern` d'une `RewriteRule` utilise les **expressions régulières PCRE** (Perl Compatible Regular Expressions).

| Symbole | Signification | Exemple |
|---|---|---|
| `^` | Début de la chaîne | `^pages/` → commence par "pages/" |
| `$` | Fin de la chaîne | `\.html$` → se termine par ".html" |
| `.` | N'importe quel caractère (1 fois) | `a.c` → "abc", "a1c" |
| `.*` | N'importe quoi (0 fois ou plus) | `.*` → tout ou rien |
| `.+` | N'importe quoi (1 fois ou plus) | `.+` → au moins un caractère |
| `?` | Caractère optionnel (0 ou 1 fois) | `https?` → "http" ou "https" |
| `*` | Répétition (0 fois ou plus) | `[0-9]*` → "", "1", "123" |
| `+` | Répétition (1 fois ou plus) | `[0-9]+` → "1", "123" |
| `[abc]` | Un des caractères listés | `[aeiou]` → une voyelle |
| `[a-z]` | Plage de caractères | `[a-z0-9]` → lettre minuscule ou chiffre |
| `[^abc]` | Aucun des caractères listés | `[^/]+` → tout sauf "/" |
| `(abc)` | Groupe capturant | `(article)` → capture "article" dans `$1` |
| `$1` | Référence au 1er groupe capturant | Réutilise la valeur capturée |
| `$2` | Référence au 2ème groupe capturant | |
| `\` | Échappement | `\.` → un point littéral (pas "n'importe quel caractère") |
| `[_a-z0-9-]` | Lettres, chiffres, tirets, underscores | Typique pour un slug d'URL |

### Patterns courants pour les URLs

```apache
# Un slug d'article (lettres minuscules, chiffres, tirets)
([a-z0-9-]+)

# Un identifiant numérique
([0-9]+)

# Un slug avec underscores aussi
([_a-z0-9-]+)

# N'importe quel chemin
(.*)

# Un segment d'URL sans slash
([^/]+)

# Extension optionnelle (.html ou rien)
([a-z0-9-]+)(\.html)?$
```

---

## 6. RewriteCond — Les conditions

`RewriteCond` ajoute une **condition** qui doit être vraie pour que la `RewriteRule` suivante s'applique. On peut enchaîner plusieurs `RewriteCond` (toutes doivent être vraies par défaut).

### Syntaxe

```apache
RewriteCond [variable] [pattern] [flags]
```

### Variables serveur les plus utiles

| Variable | Contient |
|---|---|
| `%{HTTP_HOST}` | Nom de domaine (ex: `www.monsite.fr`) |
| `%{REQUEST_URI}` | Chemin de l'URL (ex: `/blog/article`) |
| `%{QUERY_STRING}` | Paramètres GET (ex: `id=5&page=2`) |
| `%{SERVER_PORT}` | Port (80 pour HTTP, 443 pour HTTPS) |
| `%{REQUEST_FILENAME}` | Chemin complet du fichier demandé |
| `%{HTTPS}` | "on" si HTTPS, vide sinon |
| `%{HTTP_REFERER}` | URL de la page précédente |
| `%{HTTP_USER_AGENT}` | Navigateur / User agent |
| `%{REMOTE_ADDR}` | Adresse IP du visiteur |
| `%{REQUEST_METHOD}` | Méthode HTTP (GET, POST…) |

### Flags de RewriteCond

| Flag | Description |
|---|---|
| `[NC]` | Insensible à la casse |
| `[OR]` | OU logique (au lieu du ET par défaut) |
| `[NV]` | No Vary (ne pas envoyer de header `Vary`) |

### Opérateurs spéciaux dans les conditions

| Opérateur | Description |
|---|---|
| `-f` | Le fichier existe |
| `!-f` | Le fichier n'existe PAS |
| `-d` | Le répertoire existe |
| `!-d` | Le répertoire n'existe PAS |
| `-l` | C'est un lien symbolique |
| `!-l` | Ce n'est pas un lien symbolique |

**Exemple : Ne réécrire que si le fichier n'existe pas (indispensable pour les frameworks)**

```apache
# Ne rediriger vers index.php QUE si le fichier ou dossier demandé n'existe pas
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?route=$1 [QSA,L]
```

---

## 7. Exemples progressifs

### Exemple 1 — Réécriture simple (1 pour 1)

```apache
Options +FollowSymlinks
RewriteEngine On

# Afficher test.html quand l'utilisateur visite essai.html
RewriteRule ^essai.html$ test.html [L]
```

---

### Exemple 2 — Capture d'un paramètre dynamique

```apache
Options +FollowSymlinks
RewriteEngine on

# /pages/article-mon-guide.html → pages/modules.php?id=mon-guide
RewriteRule ^pages/article-([_a-z0-9-]*).html$ pages/modules.php?id=$1 [L]
```

**Décomposition :**
- `([_a-z0-9-]*)` → capture le slug dans `$1`
- `pages/modules.php?id=$1` → réinjecte la valeur capturée comme paramètre GET

---

### Exemple 3 — Capture de plusieurs paramètres

```apache
Options +FollowSymlinks
RewriteEngine on

# /articles/guide-seo-12-3.html → pages/modules.php?id=12&idcat=3
RewriteRule ^/?.*/?.*-([0-9]+)-([0-9]+).html$ pages/modules.php?id=$1&idcat=$2 [L]
```

**Décomposition :**
- `^/?.*/?.*` → n'importe quel chemin avant les paramètres (le slug)
- `-([0-9]+)-([0-9]+)` → deux identifiants numériques séparés par des tirets
- `$1` → premier ID, `$2` → deuxième ID

---

### Exemple 4 — URL totalement personnalisée

```apache
# URL propre → URL technique
# /blog/2024/novembre/guide-seo → article.php?annee=2024&mois=novembre&slug=guide-seo

RewriteRule ^blog/([0-9]{4})/([a-z]+)/([a-z0-9-]+)/?$ article.php?annee=$1&mois=$2&slug=$3 [L,QSA]
```

---

### Exemple 5 — Plusieurs règles combinées

```apache
Options +FollowSymlinks
RewriteEngine On

# Page d'accueil
RewriteRule ^$   index.php  [L]

# Articles
RewriteRule ^article/([a-z0-9-]+)/?$  pages/article.php?slug=$1  [L,QSA]

# Catégories
RewriteRule ^categorie/([a-z0-9-]+)/page/([0-9]+)/?$  pages/categorie.php?cat=$1&page=$2  [L,QSA]

# Profil utilisateur
RewriteRule ^profil/([a-z0-9_]+)/?$  pages/profil.php?user=$1  [L,QSA]
```

---

## 8. Cas d'usage réels et complets

### Framework MVC — Router central (Laravel, CodeIgniter, Symfony…)

Le pattern le plus courant : toutes les requêtes sont renvoyées vers `index.php` sauf les fichiers statiques existants.

```apache
Options +FollowSymlinks
RewriteEngine On

# Ne pas réécrire si c'est un fichier physique existant
RewriteCond %{REQUEST_FILENAME} !-f
# Ne pas réécrire si c'est un répertoire existant
RewriteCond %{REQUEST_FILENAME} !-d
# Tout le reste → index.php (le router du framework prend la main)
RewriteRule ^(.*)$ index.php [QSA,L]
```

---

### WordPress — Configuration standard

```apache
# BEGIN WordPress
<IfModule mod_rewrite.c>
    Options +FollowSymlinks
    RewriteEngine On
    RewriteBase /

    # Ne pas réécrire les fichiers WordPress admin
    RewriteRule ^index\.php$ - [L]

    # Envoyer tout le reste vers index.php
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule . /index.php [L]
</IfModule>
# END WordPress
```

---

### Boutique e-commerce — URLs produits

```apache
Options +FollowSymlinks
RewriteEngine On

# /produit/chaussures-running-nike-air → produit.php?slug=chaussures-running-nike-air
RewriteRule ^produit/([a-z0-9-]+)/?$  produit.php?slug=$1  [L,QSA]

# /categorie/chaussures → categorie.php?cat=chaussures
RewriteRule ^categorie/([a-z0-9-]+)/?$  categorie.php?cat=$1  [L,QSA]

# /categorie/chaussures/page/2 → categorie.php?cat=chaussures&page=2
RewriteRule ^categorie/([a-z0-9-]+)/page/([0-9]+)/?$  categorie.php?cat=$1&page=$2  [L,QSA]

# /marque/nike → marque.php?brand=nike
RewriteRule ^marque/([a-z0-9-]+)/?$  marque.php?brand=$1  [L,QSA]
```

---

### API REST simulée

```apache
Options +FollowSymlinks
RewriteEngine On

# GET /api/users → api.php?resource=users&method=GET
# GET /api/users/42 → api.php?resource=users&id=42
# Tout passer par un seul contrôleur API

RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^api/([a-z]+)/?([0-9]*)/?$  api.php?resource=$1&id=$2  [L,QSA]
```

---

## 9. Redirections SEO

Ces redirections sont essentielles pour **conserver le PageRank** lors de modifications de structure, d'une migration, ou pour unifier les URLs.

### Forcer HTTPS (HTTP → HTTPS)

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]
</IfModule>

# Alternative via SERVER_PORT
RewriteCond %{SERVER_PORT} !^443$
RewriteRule ^(.*)$ https://www.monsite.fr/$1 [R=301,L]
```

### Non-www → www (canonique)

```apache
RewriteEngine On
RewriteCond %{HTTP_HOST} ^monsite\.fr$ [NC]
RewriteRule ^(.*)$ https://www.monsite.fr/$1 [R=301,L]
```

### www → non-www (alternative)

```apache
RewriteEngine On
RewriteCond %{HTTP_HOST} ^www\.monsite\.fr$ [NC]
RewriteRule ^(.*)$ https://monsite.fr/$1 [R=301,L]
```

> ⚠️ Choisissez **un seul** des deux (www ou non-www) et restez cohérent. C'est la version déclarée en canonique dans Google Search Console.

### Supprimer index.php de l'URL

```apache
# Rediriger /index.php vers /
RewriteCond %{THE_REQUEST} ^[A-Z]{3,9}\ /.*index\.php\ HTTP/
RewriteRule ^(.*)index\.php$ /$1 [R=301,L]

# Ou plus simple :
RewriteRule ^index\.php$ https://www.monsite.fr/ [QSA,L,R=301]
```

### Supprimer l'extension .php des URLs

```apache
# Réécriture interne : /contact → contact.php (sans redirection visible)
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME}\.php -f
RewriteRule ^([^/]+)/?$ $1.php [L]

# Si l'URL avec .php est tapée, rediriger vers sans .php (évite le contenu dupliqué)
RewriteCond %{THE_REQUEST} ^[A-Z]{3,9}\ /(.+)\.php
RewriteRule ^(.+)\.php$ /$1 [R=301,L]
```

### Redirection d'un domaine vers un autre (migration)

```apache
RewriteEngine On
RewriteCond %{HTTP_HOST} ^(www\.)?ancien-domaine\.com$ [NC]
RewriteRule ^(.*)$ https://www.nouveau-domaine.fr/$1 [R=301,L]
```

### Redirection d'une URL précise

```apache
# Article renommé
Redirect 301 /ancien-article/ https://www.monsite.fr/nouvel-article/

# Section entière déplacée
RedirectMatch 301 ^/blog/(.*)$ https://www.monsite.fr/articles/$1
```

### Gestion du trailing slash (slash final)

```apache
# Forcer le slash final sur les dossiers (cohérence SEO)
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_URI} !(.*)/$
RewriteRule ^(.*)$ https://www.monsite.fr/$1/ [R=301,L]
```

### Page d'erreur 404 personnalisée

```apache
ErrorDocument 404 /404.php
ErrorDocument 403 /403.html
ErrorDocument 500 /500.html
```

---

## 10. Sécurité via URL Rewriting

### Bloquer l'accès aux fichiers sensibles

```apache
# Bloquer l'accès au .htaccess lui-même
<Files .htaccess>
    Order allow,deny
    Deny from all
</Files>

# Bloquer les fichiers de configuration
<FilesMatch "\.(env|config|sql|log|bak|ini)$">
    Order allow,deny
    Deny from all
</FilesMatch>

# Bloquer l'accès aux fichiers PHP dans le dossier uploads
<Directory /var/www/html/uploads>
    <FilesMatch "\.php$">
        Order Deny,Allow
        Deny from all
    </FilesMatch>
</Directory>
```

### Bloquer les injections SQL et XSS basiques dans l'URL

```apache
RewriteEngine On

# Bloquer les tentatives d'injection SQL
RewriteCond %{QUERY_STRING} (union|select|insert|drop|delete|update|cast|create|char|convert|alter|declare|order by)(\s|\+|%20) [NC]
RewriteRule ^(.*)$ - [F,L]

# Bloquer les scripts XSS dans l'URL
RewriteCond %{QUERY_STRING} (<|>|%3C|%3E|script|javascript) [NC,OR]
RewriteCond %{QUERY_STRING} (\.\./|%2E%2E%2F) [NC]
RewriteRule ^(.*)$ - [F,L]
```

### Bloquer les hotlinks (vol de bande passante)

```apache
RewriteEngine On
RewriteCond %{HTTP_REFERER} !^$
RewriteCond %{HTTP_REFERER} !^https?://(www\.)?monsite\.fr/ [NC]
RewriteRule \.(jpg|jpeg|png|gif|webp|svg|mp4)$ - [F,L]
```

### Restreindre l'accès à une IP

```apache
# Autoriser seulement une IP pour /admin
<Directory /var/www/html/admin>
    Order Deny,Allow
    Deny from all
    Allow from 192.168.1.100
</Directory>

# Ou via RewriteRule
RewriteEngine On
RewriteCond %{REMOTE_ADDR} !^192\.168\.1\.100$
RewriteRule ^admin/(.*)$ - [F,L]
```

---

## 11. Débogage et erreurs fréquentes

### Activer les logs de réécriture (développement uniquement)

```apache
# Dans httpd.conf ou VirtualHost (pas dans .htaccess)
LogLevel alert rewrite:trace3

# Niveaux disponibles : trace1 (minimal) → trace8 (maximal)
```

### Erreurs courantes et solutions

| Erreur | Cause probable | Solution |
|---|---|---|
| **Erreur 500** | Syntaxe incorrecte dans .htaccess | Vérifier chaque ligne, commenter les règles une par une |
| **Boucle infinie (500)** | La règle se réécrit elle-même | Ajouter `RewriteCond %{REQUEST_FILENAME} !-f` |
| **404 après réécriture** | Le fichier cible n'existe pas | Vérifier le chemin dans la substitution |
| **Règle ignorée** | `AllowOverride None` dans la config Apache | Mettre `AllowOverride All` dans la config du VirtualHost |
| **Redirection infinie** | Redirection vers la même URL | Vérifier les conditions `RewriteCond` |
| **Paramètres GET perdus** | Flag `[QSA]` manquant | Ajouter `[QSA]` au flag |

### Tester une règle sans risque

Utiliser l'outil en ligne **[htaccess tester](https://htaccess.madewithlove.com/)** pour simuler vos règles avant déploiement.

### Isoler une règle problématique

```apache
# Commenter temporairement les règles pour isoler le problème
# RewriteRule ^article/([a-z0-9-]+)/?$ article.php?slug=$1 [L]

# Tester une règle minimale
RewriteRule ^test$ test.html [L]
```

---

## 12. URL Rewriting avec PHP

Alternative au `.htaccess` pour avoir le contrôle total côté applicatif.

### Approche : Router PHP simple

```apache
# .htaccess : envoyer tout vers index.php
Options +FollowSymlinks
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

```php
<?php
// index.php — Router minimal

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$segments = explode('/', $uri);

$controller = $segments[0] ?? 'home';
$action     = $segments[1] ?? 'index';
$param      = $segments[2] ?? null;

// Dispatch
switch ($controller) {
    case '':
    case 'home':
        require 'pages/home.php';
        break;

    case 'article':
        // /article/mon-guide → pages/article.php avec $slug = "mon-guide"
        $slug = $action;
        require 'pages/article.php';
        break;

    case 'categorie':
        $cat  = $action;
        $page = $param ?? 1;
        require 'pages/categorie.php';
        break;

    default:
        http_response_code(404);
        require 'pages/404.php';
}
```

### Générer des URLs propres en PHP

```php
<?php
// Fonction pour créer un slug depuis un titre
function slugify(string $title): string {
    $title = mb_strtolower($title, 'UTF-8');
    $title = str_replace(
        ['à','â','é','è','ê','ë','î','ï','ô','ù','û','ü','ç'],
        ['a','a','e','e','e','e','i','i','o','u','u','u','c'],
        $title
    );
    $title = preg_replace('/[^a-z0-9\s-]/', '', $title);
    $title = preg_replace('/[\s-]+/', '-', trim($title));
    return $title;
}

// Exemple
echo slugify("Guide du SEO — Débutants 2024");
// → "guide-du-seo-debutants-2024"
```

---

## 13. URL Rewriting avec Nginx

Si votre serveur tourne sur **Nginx** (pas Apache), le `.htaccess` n'existe pas. La configuration se fait dans le fichier `nginx.conf` ou dans le bloc `server {}` de votre VirtualHost.

### Équivalents Nginx des règles Apache

```nginx
server {
    listen 443 ssl;
    server_name www.monsite.fr;
    root /var/www/html;

    # Équivalent du router MVC (RewriteCond !-f && !-d → index.php)
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Passer PHP à PHP-FPM
    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Redirection HTTP → HTTPS
    server {
        listen 80;
        server_name monsite.fr www.monsite.fr;
        return 301 https://www.monsite.fr$request_uri;
    }

    # Redirection non-www → www
    server {
        listen 443 ssl;
        server_name monsite.fr;
        return 301 https://www.monsite.fr$request_uri;
    }

    # Règle de réécriture avec capture (équivalent RewriteRule)
    rewrite ^/article/([a-z0-9-]+)/?$ /article.php?slug=$1 last;

    # Bloquer l'accès aux fichiers sensibles
    location ~ /\.(env|htaccess|git) {
        deny all;
    }
}
```

---

## 14. Résumé des flags

| Flag | Code court | Utilisation typique |
|---|---|---|
| Last | `[L]` | Fin de réécriture — **toujours mettre en dernier** |
| Redirect | `[R=301]` | Redirection permanente (SEO, migration) |
| Redirect | `[R=302]` | Redirection temporaire (maintenance) |
| NoCase | `[NC]` | Insensible à la casse |
| QueryStringAppend | `[QSA]` | Conserver les paramètres `?key=value` |
| End | `[END]` | Stopper absolument toutes les réécritures |
| Forbidden | `[F]` | Bloquer l'accès (erreur 403) |
| Gone | `[G]` | Ressource supprimée définitivement (erreur 410) |
| Chain | `[C]` | Lier deux règles (la 2ème ne s'applique que si la 1ère correspond) |
| Or dans Cond | `[OR]` | Condition OU (dans RewriteCond) |
| NoSub | `[NS]` | Ne pas appliquer aux sous-requêtes |

---

## Ressources

| Ressource | URL |
|---|---|
| Documentation Apache mod_rewrite | httpd.apache.org/docs/current/mod/mod_rewrite.html |
| Expressions régulières Perl | perl.mines-albi.fr/DocFr/perlre.html |
| Testeur .htaccess en ligne | htaccess.madewithlove.com |
| Générateur de règles RewriteRule | generateit.net/mod-rewrite |
| Documentation Nginx rewrite | nginx.org/en/docs/http/ngx_http_rewrite_module.html |
| OpenClassrooms — Rewriting PHP | openclassrooms.com/fr/courses/rewriting-php |

---

*Guide complet URL Rewriting — Apache .htaccess · Niveau : Intermédiaire / Avancé*
*Couvre : Apache, PHP, Nginx · Mise à jour : 2024*
