# .htaccess : Cache, Compression GZip, Minify et plus

> **Conseil :** Appliquez les optimisations **une par une**. Ce sont des modifications avancées qui peuvent provoquer des erreurs 500 si elles sont mal appliquées.

---

## Table des matières

1. [Compatibilité Internet Explorer (X-UA-Compatible)](#1-compatibilité-internet-explorer)
2. [Accès aux polices depuis les sous-domaines (CORS)](#2-accès-aux-polices-depuis-les-sous-domaines)
3. [Normalisation des types MIME](#3-normalisation-des-types-mime)
4. [Concaténation des fichiers JS et CSS](#4-concaténation-des-fichiers-js-et-css)
5. [Compression GZip (mod_deflate)](#5-compression-gzip)
6. [Cache navigateur (mod_expires)](#6-cache-navigateur)
7. [Désactivation de l'ETag](#7-désactivation-de-letag)
8. [Autorisation des cookies depuis une iFrame (P3P)](#8-autorisation-des-cookies-depuis-une-iframe)
9. [Suppression des warnings PHP](#9-suppression-des-warnings)
10. [Encodage UTF-8 par défaut](#10-encodage-utf-8-par-défaut)
11. [Redirections SEO](#11-redirections-seo)

---

## 1. Compatibilité Internet Explorer

**Pourquoi ?**
Certaines versions d'IE utilisent un moteur de rendu plus ancien (notamment pour les sites en `localhost` ou les intranets). Cette directive force IE à utiliser le moteur de rendu le plus récent disponible, ce qui améliore l'affichage et l'interprétation du JavaScript.

```apache
<IfModule mod_headers.c>
    Header set X-UA-Compatible "IE=Edge,chrome=1"
    # On exclut ce header pour les fichiers statiques (images, fonts, etc.)
    <FilesMatch "\.(js|css|gif|png|jpe?g|pdf|xml|oga|ogg|m4a|ogv|mp4|m4v|webm|svg|svgz|eot|ttf|otf|woff|ico|webp|appcache|manifest|htc|crx|xpi|safariextz|vcf)$">
        Header unset X-UA-Compatible
    </FilesMatch>
</IfModule>
```

---

## 2. Accès aux polices depuis les sous-domaines

**Pourquoi ?**
Les navigateurs bloquent par défaut le chargement de polices (fonts) depuis un domaine différent (politique CORS). Cette règle autorise l'accès aux fichiers de polices depuis tous les sous-domaines de votre site.

```apache
<FilesMatch "\.(ttf|ttc|otf|eot|woff|font\.css)$">
    <IfModule mod_headers.c>
        Header set Access-Control-Allow-Origin "*"
    </IfModule>
</FilesMatch>
```

> **Note :** Remplacez `"*"` par votre domaine exact (ex: `"https://www.monsite.com"`) pour plus de sécurité.

---

## 3. Normalisation des types MIME

**Pourquoi ?**
Un serveur mal configuré peut retourner un mauvais type MIME pour certains fichiers. Par exemple, un fichier CSS renvoyé en `text/plain` sera **ignoré** par Firefox et les navigateurs Gecko. Cette section déclare explicitement le bon type MIME pour chaque extension.

```apache
# JavaScript
AddType application/javascript         js

# Audio
AddType audio/ogg                      oga ogg
AddType audio/mp4                      m4a

# Vidéo
AddType video/ogg                      ogv
AddType video/mp4                      mp4 m4v
AddType video/webm                     webm

# SVG (requis pour les webfonts SVG sur iPad)
AddType image/svg+xml                  svg svgz
AddEncoding gzip                       svgz

# Webfonts
AddType application/vnd.ms-fontobject  eot
AddType application/x-font-ttf         ttf ttc
AddType font/opentype                  otf
AddType application/x-font-woff        woff

# Types divers
AddType image/x-icon                   ico
AddType image/webp                     webp
AddType text/cache-manifest            appcache manifest
AddType text/x-component               htc
AddType application/x-chrome-extension crx
AddType application/x-xpinstall        xpi
AddType application/octet-stream       safariextz
AddType text/x-vcard                   vcf
```

---

## 4. Concaténation des fichiers JS et CSS

**Pourquoi ?**
Réduire le nombre de requêtes HTTP en regroupant plusieurs fichiers JS ou CSS en un seul fichier `combined`. Cela améliore significativement les temps de chargement.

> **Important :** Faites des recherches complémentaires sur l'utilisation de cette technique avant de la mettre en production.

```apache
<FilesMatch "\.combined\.js$">
    Options +Includes
    AddOutputFilterByType INCLUDES application/javascript application/json
    SetOutputFilter INCLUDES
</FilesMatch>

<FilesMatch "\.combined\.css$">
    Options +Includes
    AddOutputFilterByType INCLUDES text/css
    SetOutputFilter INCLUDES
</FilesMatch>
```

---

## 5. Compression GZip

**Pourquoi ?**
Le serveur compresse les fichiers avant de les envoyer au navigateur. Cela réduit la quantité de données transférées et **accélère sensiblement le chargement des pages**. En contrepartie, cela utilise légèrement plus de CPU côté serveur (généralement négligeable).

```apache
<IfModule mod_deflate.c>

    # Correction pour les en-têtes Accept-Encoding mal formatés
    <IfModule mod_setenvif.c>
        <IfModule mod_headers.c>
            SetEnvIfNoCase ^(Accept-EncodXng|X-cept-Encoding|X{15}|~{15}|-{15})$ \
                ^((gzip|deflate)\s*,?\s*)+|[X~-]{4,13}$ HAVE_Accept-Encoding
            RequestHeader append Accept-Encoding "gzip,deflate" env=HAVE_Accept-Encoding
        </IfModule>
    </IfModule>

    # Compression pour les navigateurs modernes (mod_filter)
    <IfModule mod_filter.c>
        FilterDeclare   COMPRESS
        FilterProvider  COMPRESS DEFLATE resp=Content-Type $text/html
        FilterProvider  COMPRESS DEFLATE resp=Content-Type $text/css
        FilterProvider  COMPRESS DEFLATE resp=Content-Type $text/plain
        FilterProvider  COMPRESS DEFLATE resp=Content-Type $text/xml
        FilterProvider  COMPRESS DEFLATE resp=Content-Type $text/x-component
        FilterProvider  COMPRESS DEFLATE resp=Content-Type $application/javascript
        FilterProvider  COMPRESS DEFLATE resp=Content-Type $application/json
        FilterProvider  COMPRESS DEFLATE resp=Content-Type $application/xml
        FilterProvider  COMPRESS DEFLATE resp=Content-Type $application/xhtml+xml
        FilterProvider  COMPRESS DEFLATE resp=Content-Type $application/rss+xml
        FilterProvider  COMPRESS DEFLATE resp=Content-Type $application/atom+xml
        FilterProvider  COMPRESS DEFLATE resp=Content-Type $application/vnd.ms-fontobject
        FilterProvider  COMPRESS DEFLATE resp=Content-Type $image/svg+xml
        FilterProvider  COMPRESS DEFLATE resp=Content-Type $application/x-font-ttf
        FilterProvider  COMPRESS DEFLATE resp=Content-Type $font/opentype
        FilterChain     COMPRESS
        FilterProtocol  COMPRESS DEFLATE change=yes;byteranges=no
    </IfModule>

    # Fallback pour les anciennes versions d'Apache (sans mod_filter)
    <IfModule !mod_filter.c>
        AddOutputFilterByType DEFLATE text/html text/plain text/css application/json
        AddOutputFilterByType DEFLATE application/javascript
        AddOutputFilterByType DEFLATE text/xml application/xml text/x-component
        AddOutputFilterByType DEFLATE application/xhtml+xml application/rss+xml application/atom+xml
        AddOutputFilterByType DEFLATE image/svg+xml application/vnd.ms-fontobject application/x-font-ttf font/opentype
    </IfModule>

</IfModule>
```

---

## 6. Cache navigateur

**Pourquoi ?**
Par défaut, les fichiers ne sont **pas mis en cache** par le navigateur. En définissant une date d'expiration, on indique au navigateur de conserver les fichiers en local. Résultat : les visites suivantes sont beaucoup plus rapides car les fichiers ne sont pas re-téléchargés.

```apache
<IfModule mod_expires.c>
    ExpiresActive on

    # Règle par défaut : 1 mois pour tout ce qui n'est pas spécifié
    ExpiresDefault                          "access plus 1 month"

    # Manifeste HTML5 AppCache : jamais mis en cache
    ExpiresByType text/cache-manifest       "access plus 0 seconds"

    # HTML : jamais mis en cache (toujours frais)
    ExpiresByType text/html                 "access plus 0 seconds"

    # Données dynamiques : jamais mises en cache
    ExpiresByType text/xml                  "access plus 0 seconds"
    ExpiresByType application/xml           "access plus 0 seconds"
    ExpiresByType application/json          "access plus 0 seconds"

    # Flux RSS / Atom : 1 heure
    ExpiresByType application/rss+xml       "access plus 1 hour"
    ExpiresByType application/atom+xml      "access plus 1 hour"

    # Favicon : 1 semaine (ne peut pas être renommé)
    ExpiresByType image/x-icon              "access plus 1 week"

    # Médias (images, vidéo, audio) : 1 mois
    ExpiresByType image/gif                 "access plus 1 month"
    ExpiresByType image/png                 "access plus 1 month"
    ExpiresByType image/jpg                 "access plus 1 month"
    ExpiresByType image/jpeg                "access plus 1 month"
    ExpiresByType video/ogg                 "access plus 1 month"
    ExpiresByType audio/ogg                 "access plus 1 month"
    ExpiresByType video/mp4                 "access plus 1 month"
    ExpiresByType video/webm                "access plus 1 month"

    # Fichiers HTC (CSS3PIE) : 1 mois
    ExpiresByType text/x-component          "access plus 1 month"

    # Webfonts : 1 mois
    ExpiresByType font/truetype             "access plus 1 month"
    ExpiresByType font/opentype             "access plus 1 month"
    ExpiresByType application/x-font-woff   "access plus 1 month"
    ExpiresByType image/svg+xml             "access plus 1 month"
    ExpiresByType application/vnd.ms-fontobject "access plus 1 month"

    # CSS et JavaScript : 1 AN (fichiers peu susceptibles de changer)
    ExpiresByType text/css                  "access plus 1 year"
    ExpiresByType application/javascript    "access plus 1 year"

    <IfModule mod_headers.c>
        Header append Cache-Control "public"
    </IfModule>
</IfModule>
```

> **Attention :** Si vous mettez CSS/JS en cache pour 1 an, pensez à utiliser le **cache-busting** (ex: `style.css?v=2`) lors de chaque mise à jour.

---

## 7. Désactivation de l'ETag

**Pourquoi ?**
L'ETag est un identifiant qu'un serveur attribue à une ressource pour suivre sa version. Dans les environnements multi-serveurs, les ETags peuvent générer des requêtes inutiles car chaque serveur génère un ETag différent pour le même fichier. La désactiver force le navigateur à s'appuyer uniquement sur les headers `Cache-Control` et `Expires`, ce qui est plus fiable.

```apache
<IfModule mod_headers.c>
    Header unset ETag
</IfModule>

FileETag None
```

---

## 8. Autorisation des cookies depuis une iFrame (P3P)

**Pourquoi ?**
IE bloque par défaut les cookies provenant d'une iFrame. Cette directive envoie un header P3P qui lève cette restriction.

> **Prérequis :** Remplacez `votre-domaine.com` par votre domaine et uploadez le fichier `p3p.xml` à la racine `/w3c/`.

```apache
<IfModule mod_headers.c>
    <Location />
        Header set P3P "policyref=\"http://www.votre-domaine.com/w3c/p3p.xml\", CP=\"IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT\""
    </Location>
</IfModule>
```

---

## 9. Suppression des warnings

**Pourquoi ?**
Évite l'affichage de messages d'avertissement PHP/Apache visibles par vos visiteurs, en forçant le serveur à utiliser HTTPS.

```apache
<IfModule mod_rewrite.c>
    RewriteCond %{SERVER_PORT} !^443$
    RewriteRule ^ https://www.votre-domaine.com%{REQUEST_URI} [R=301,L]
</IfModule>
```

---

## 10. Encodage UTF-8 par défaut

**Pourquoi ?**
Garantit que tous vos fichiers texte sont interprétés en UTF-8, évitant les problèmes d'affichage des caractères spéciaux (accents, symboles, etc.).

```apache
AddDefaultCharset utf-8
AddCharset utf-8 .html .css .js .xml .json .rss .atom
```

---

## 11. Redirections SEO

Ces directives de réécriture sont essentielles pour un bon référencement naturel.

### Redirection de `index.php` vers la racine `/`

```apache
RewriteCond %{THE_REQUEST} ^[A-Z]{3,9}\ /.*index\.php\ HTTP/
RewriteRule ^(.*)index\.php$ /$1 [R=301,L]

# ou (plus simple)
RewriteRule ^index\.php$ http://www.votresite.com/ [QSA,L,R=301]
```

### Redirection non-www → www

```apache
RewriteCond %{HTTP_HOST} ^exemple\.com$
RewriteRule ^(.*) http://www.exemple.com/$1 [QSA,L,R=301]

# ou
RewriteCond %{HTTP_HOST} !^www\.site\.fr$
RewriteRule ^(.*) http://www.site.fr/$1 [QSA,L,R=301]
```

### Redirection d'un domaine vers un autre

```apache
RewriteCond %{HTTP_HOST} domaine1\.com$
RewriteRule ^(.*) http://www.domaine2.com/$1 [QSA,L,R=301]
```

### Gestion de la page d'erreur 404

```apache
ErrorDocument 404 /404.php
```

---

## Résumé des durées de cache recommandées

| Type de fichier          | Durée de cache |
|--------------------------|----------------|
| HTML, XML, JSON          | 0 seconde (pas de cache) |
| RSS / Atom               | 1 heure        |
| Favicon                  | 1 semaine      |
| Images, Vidéos, Audio    | 1 mois         |
| Webfonts                 | 1 mois         |
| CSS, JavaScript          | 1 an           |

---

*Source : Article original publié sur le blog de LIJE Creative — [lije-creative.com](https://www.lije-creative.com)*
