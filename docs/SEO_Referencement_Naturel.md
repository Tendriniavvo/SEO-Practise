# SEO : Référencement Naturel — Cours Complet
> *De la balise `<html>` au PageRank · ITuniversity · 4 modules*

---

## Table des matières

1. [Module 01 — Bases du SEO](#module-01--bases-du-seo)
2. [Module 02 — SEO On-Page](#module-02--seo-on-page)
3. [Module 03 — SEO Technique](#module-03--seo-technique)
4. [Module 04 — SEO Off-Page](#module-04--seo-off-page)
5. [Checklist SEO globale](#checklist-seo-globale)
6. [Points clés à retenir](#points-clés-à-retenir)

---

## Module 01 — Bases du SEO

### Qu'est-ce que le SEO ?

**SEO** (*Search Engine Optimization*) désigne l'ensemble des techniques visant à améliorer la visibilité d'un site web dans les **résultats organiques** (non payants) des moteurs de recherche comme Google, Bing ou DuckDuckGo.

L'objectif : apparaître en première page — idéalement dans le **top 3** — lorsqu'un utilisateur tape une requête liée à votre activité.

---

### Les 3 piliers du SEO

| Pilier | Description | Exemples concrets |
|---|---|---|
| ⚙️ **Technique** | Crawl, indexation, performance | robots.txt, sitemap.xml, HTTPS, temps de chargement |
| ✍️ **Contenu** | Mots-clés, balises, qualité éditoriale | Balise `<title>`, `<h1>`, méta description, articles de blog |
| 🔗 **Popularité** | Backlinks, autorité de domaine | Liens entrants depuis des sites tiers reconnus |

> **Analogie** : Le SEO technique est le fondations d'une maison, le contenu est les murs, et les backlinks sont la réputation dans le quartier. Les trois sont indispensables.

---

### SEO vs SEA

| Critère | SEO (organique) | SEA (payant) |
|---|---|---|
| Coût | Investissement en temps/contenu | Budget publicitaire (Google Ads) |
| Délai de résultat | 3 à 6 mois minimum | Immédiat |
| Durabilité | Effets persistants | S'arrête dès que le budget est coupé |
| Part des clics | ~70 % des clics sur le web | ~30 % des clics restants |
| Contrôle | Indirect (algorithme) | Direct (enchères, ciblage précis) |

**Quand combiner les deux ?**
- Nouveau site : lancez du SEA pendant que le SEO monte en puissance.
- Promotions saisonnières : SEA pour un pic rapide.
- Long terme : le SEO assure un trafic pérenne et gratuit.

---

### Comment fonctionne un moteur de recherche ?

```
Crawl → Indexation → Classement → SERP
```

#### 1. Crawl

**Googlebot** (le robot d'exploration de Google) parcourt le web en suivant les liens hypertextes de page en page. Il visite votre site selon un **crawl budget** (nombre de pages explorées par jour, variable selon l'autorité de votre domaine).

**Ce qui peut bloquer le crawl :**
- `robots.txt` mal configuré
- Pages sans liens entrants ("pages orphelines")
- Temps de réponse serveur trop lent (> 2 secondes)
- Redirections en chaîne

**Exemple pratique — `robots.txt` minimal :**
```
User-agent: *
Allow: /
Disallow: /admin/
Disallow: /panier/
Disallow: /search?

Sitemap: https://www.monsite.fr/sitemap.xml
```

#### 2. Indexation

Les pages explorées sont **stockées et analysées** dans l'index de Google (une base de données de plusieurs milliards de pages). Une page non indexée n'apparaît jamais dans les résultats.

**Vérifier l'indexation :**
```
# Dans Google, taper :
site:monsite.fr

# Résultat attendu : liste des pages indexées
```

**Forcer l'indexation via Google Search Console :**
1. Ouvrir Search Console → Inspection d'URL
2. Coller l'URL de la page
3. Cliquer "Demander l'indexation"

#### 3. Classement (Ranking)

L'algorithme attribue un **score** à chaque page selon 200+ facteurs. Les principaux :

- Pertinence du contenu par rapport à la requête
- Qualité et quantité des backlinks
- Core Web Vitals (performance)
- Expérience mobile
- Fraîcheur du contenu
- Autorité du domaine

#### 4. SERP (*Search Engine Results Page*)

La page de résultats peut contenir :
- **Résultats organiques** : liens classiques
- **Featured Snippet** : encadré réponse directe (position 0)
- **People Also Ask** : questions fréquentes
- **Knowledge Panel** : encadré latéral (entités connues)
- **Google Shopping** : produits
- **Local Pack** : carte + 3 établissements locaux

> **Dev tip :** `robots.txt` + codes HTTP corrects (200, 301) + temps de chargement rapide = meilleure indexation garantie.

---

### Les algorithmes Google à connaître

| Algorithme | Rôle | Ce qu'il pénalise |
|---|---|---|
| **Panda** | Qualité du contenu | Contenu mince, dupliqué, de faible valeur |
| **Penguin** | Qualité des liens | Spam de liens, keyword stuffing |
| **Hummingbird** | Compréhension sémantique | Contenu non pertinent pour l'intention |
| **Mobile-Friendly** | Compatibilité mobile | Sites non responsives |
| **Core Updates** | Mises à jour globales | Expertise, autorité, fiabilité (E-E-A-T) |

---

## Module 02 — SEO On-Page

### L'intention de recherche (*Search Intent*)

Avant d'écrire un mot, identifier l'**intention** derrière la requête de l'utilisateur est la priorité absolue. Google cherche à satisfaire cette intention avant tout.

| Type | Description | Exemple de requête | Format de contenu adapté |
|---|---|---|---|
| 🔍 **Informationnelle** | Cherche à apprendre | "comment fonctionne DNS" | Article de blog, tutoriel |
| 🧭 **Navigationnelle** | Cherche un site précis | "MDN Web Docs" | Page d'accueil, brand |
| 💳 **Transactionnelle** | Veut réaliser une action | "acheter hébergement VPS" | Page produit, landing page |
| 🤔 **Commerciale** | Compare avant d'achir | "meilleur framework JS 2024" | Article comparatif, top liste |

**Exemple d'analyse d'intention :**

Pour la requête *"apprendre le SEO"* :
- Les 10 premiers résultats Google sont des guides complets, pas des pages de vente.
- **Conclusion** : intention informationnelle → créer un article/guide détaillé, pas une page de tarifs.

---

### Recherche de mots-clés

#### Les outils

| Outil | Coût | Ce qu'il apporte |
|---|---|---|
| **Google Search Console** | Gratuit | Requêtes réelles générant des clics sur votre site |
| **Google Keyword Planner** | Gratuit (compte Ads) | Volume de recherche estimé |
| **Ahrefs** | Payant | Volume exact, difficulté, analyse concurrents |
| **Semrush** | Payant | Idem + audit de site complet |
| **Ubersuggest** | Freemium | Suggestions de longue traîne |
| **AnswerThePublic** | Freemium | Questions posées par les internautes |

#### La stratégie de la longue traîne

```
Mot-clé principal (fort volume, forte concurrence)
    ↓
"hébergement web"  →  30 000 recherches/mois  →  Difficulté : 85/100

Mots-clés longue traîne (faible volume, faible concurrence, haute intention)
    ↓
"hébergement web pas cher pour wordpress débutant"  →  200/mois  →  Difficulté : 12/100
```

**Pourquoi cibler la longue traîne ?**
- Moins compétitif → plus facile de ranker
- Intention plus précise → meilleur taux de conversion
- Représente 70% des recherches totales sur le web

#### Exemple pratique — Analyse d'un mot-clé avec Ahrefs

1. Chercher "cours SEO"
2. Regarder : Volume (ex. 2 400/mois), Keyword Difficulty (ex. 42/100)
3. Aller sur "Matching terms" → filtrer KD < 20
4. Trouver : "cours SEO gratuit débutant" (480/mois, KD 8) ✅
5. Analyser les 5 premiers résultats : quel format ? Quelle longueur ?
6. Créer un contenu **meilleur** que ce qui existe déjà.

---

### Où intégrer les mots-clés ?

```
Priorité décroissante :
1. Balise <title>
2. Balise <h1>
3. URL de la page
4. Méta description (impact CTR, pas classement direct)
5. 100 premiers mots du contenu
6. Balises <h2> et <h3>
7. Attribut alt des images
8. Corps du texte (naturellement)
```

> ⚠️ **Keyword stuffing** : La répétition abusive d'un mot-clé est pénalisée par l'algorithme **Google Penguin**. Visez une densité naturelle (~1-2%), pas mécanique.

**Mauvais exemple :**
> "Notre formation SEO vous apprend le SEO. Le SEO est important. Apprenez le SEO avec notre cours SEO."

**Bon exemple :**
> "Notre formation vous guide pas à pas dans l'art du référencement naturel, des bases techniques jusqu'aux stratégies de liens avancées."

---

### Les balises HTML essentielles

#### `<title>` — Titre de la page

```html
<!-- ✅ Bon exemple -->
<title>Apprendre le SEO en 2024 : Guide Complet pour Débutants | MonSite</title>

<!-- ❌ Mauvais exemple -->
<title>Page 1 - Mon Site</title>
```

**Règles :**
- 50–60 caractères maximum (sinon tronqué dans Google)
- Mot-clé principal **en premier**
- Unique sur chaque page du site
- Incite au clic (c'est ce que voit l'utilisateur dans la SERP)

---

#### `<meta name="description">` — Méta description

```html
<!-- ✅ Bon exemple -->
<meta name="description" content="Découvrez notre guide complet SEO 2024 : balises HTML, Core Web Vitals, backlinks. Apprenez à ranker en première page de Google, étape par étape.">

<!-- ❌ Mauvais exemple -->
<meta name="description" content="Site web de formation. Cliquez pour en savoir plus.">
```

**Règles :**
- 150–160 caractères maximum
- Résume la valeur de la page en une phrase accrocheuse
- N'influence pas directement le classement, mais améliore le **CTR** (Click-Through Rate)
- Inclure une call-to-action implicite ("Découvrez", "Apprenez", "Comparez")

---

#### `<h1>` — Titre principal

```html
<!-- ✅ Bon exemple -->
<h1>Guide Complet du SEO pour Développeurs Web en 2024</h1>

<!-- ❌ Mauvais exemple -->
<h1>Bienvenue sur notre site !</h1>
<h1>Nos formations</h1>  <!-- Deux H1 sur la même page = erreur -->
```

**Règles :**
- **Un seul `<h1>` par page**
- Contient le mot-clé principal
- Différent du `<title>` (mais proche sémantiquement)

---

#### Structure des titres `<h2>` à `<h6>`

```html
<h1>Guide SEO Complet 2024</h1>
  <h2>Les bases du SEO</h2>
    <h3>Qu'est-ce que le référencement naturel ?</h3>
    <h3>SEO vs SEA</h3>
  <h2>SEO On-Page</h2>
    <h3>Recherche de mots-clés</h3>
      <h4>Les outils gratuits</h4>
      <h4>Les outils payants</h4>
    <h3>Optimisation des balises HTML</h3>
  <h2>SEO Technique</h2>
```

> La structure Hn est une **table des matières sémantique** pour Google. Elle aide à comprendre l'architecture du contenu.

---

#### `<img alt="">` — Texte alternatif des images

```html
<!-- ✅ Bon exemple -->
<img src="audit-seo-checklist.webp" alt="Checklist d'audit SEO avec 20 points de contrôle">

<!-- ❌ Mauvais exemple -->
<img src="img001.jpg" alt="">
<img src="img001.jpg" alt="image image seo seo référencement">  <!-- Bourrage -->
```

**Règles :**
- Description précise et utile pour les malvoyants (accessibilité = SEO)
- Inclure le mot-clé si naturellement pertinent
- Nommer le fichier image de façon descriptive : `audit-seo.webp` plutôt que `DSC00123.jpg`

---

#### `<a href>` — Liens

```html
<!-- ✅ Bon exemple -->
<a href="/guide-core-web-vitals">Découvrir les Core Web Vitals</a>

<!-- ❌ Mauvais exemple -->
<a href="/page7">Cliquez ici</a>
```

**Règles :**
- Ancres descriptives (le texte du lien = signal pour Google)
- Éviter "cliquez ici", "en savoir plus", "lien"
- Ajouter `rel="noopener noreferrer"` sur les liens externes ouvrant un nouvel onglet (sécurité)

---

#### `<link rel="canonical">` — URL canonique

```html
<!-- Sur chaque page, indiquer l'URL de référence -->
<link rel="canonical" href="https://www.monsite.fr/guide-seo/">

<!-- Cas d'usage : page accessible via plusieurs URLs -->
<!-- https://monsite.fr/guide-seo -->
<!-- https://monsite.fr/guide-seo/ -->
<!-- https://monsite.fr/guide-seo?utm_source=newsletter -->
<!-- Toutes pointent vers la même canonique -->
```

**Pourquoi c'est crucial :**
Sans canonique, Google peut considérer ces URLs comme du **contenu dupliqué** et diluer votre autorité entre plusieurs versions.

---

#### `<meta name="robots">` — Contrôle de l'indexation

```html
<!-- Indexer la page et suivre les liens (défaut) -->
<meta name="robots" content="index, follow">

<!-- Ne pas indexer (page admin, panier, résultats de recherche interne) -->
<meta name="robots" content="noindex, nofollow">

<!-- Indexer mais ne pas suivre les liens -->
<meta name="robots" content="index, nofollow">
```

**Pages à mettre en `noindex` :**
- `/admin/`, `/login/`, `/panier/`
- Pages de résultats de recherche interne (`?s=`)
- Pages de pagination (ou utiliser canonique vers page 1)
- Pages de politique de confidentialité / CGU (peu de valeur SEO)

---

### Optimisation des URLs

```
# ✅ URL optimisée
https://monsite.fr/formation-seo-debutant/

# ❌ URL non optimisée
https://monsite.fr/page?id=47&cat=3&lang=fr
```

**Règles pour les URLs :**
- Courtes et lisibles par un humain
- Mots séparés par des tirets `-` (jamais `_` ni espace)
- En minuscules
- Contient le mot-clé principal
- Hiérarchie logique : `/blog/seo/guide-debutant/`

---

### Structure du contenu (Content SEO)

#### Le modèle AIDA adapté au SEO

```
A - Accroche    → H1 + 100 premiers mots avec le mot-clé
I - Intérêt     → Contexte, chiffres, statistiques
D - Désir       → Développement détaillé, exemples, valeur ajoutée
A - Action      → CTA, liens internes, partage
```

#### Maillage interne (*Internal Linking*)

Relier vos pages entre elles renforce l'autorité de chaque page et aide Googlebot à explorer votre site.

```html
<!-- Exemple de maillage interne -->
<p>
  Pour aller plus loin, consultez notre guide sur les
  <a href="/core-web-vitals/">Core Web Vitals</a> et notre article sur
  les <a href="/backlinks-seo/">stratégies de backlinks</a>.
</p>
```

**Règles du maillage interne :**
- Lier les pages "enfants" vers la page "pilier" (topic cluster)
- Varier les ancres
- Viser 3 à 5 liens internes par article
- Éviter les liens orphelins (pages sans liens entrants internes)

---

## Module 03 — SEO Technique

### Core Web Vitals

Google mesure l'expérience utilisateur via trois métriques clés, regroupées sous le nom **Core Web Vitals**, qui sont des **facteurs de classement officiels** depuis 2021.

---

#### LCP — Largest Contentful Paint

**Définition :** Temps de chargement du plus grand élément visible (image hero, bloc texte principal).

**Cible :** < 2,5 secondes ✅ | 2,5–4s ⚠️ | > 4s ❌

**Causes fréquentes de LCP lent :**
- Images non compressées
- Absence de lazy loading
- Serveur lent (Time To First Byte > 800ms)
- Polices web non préchargées

**Corrections pratiques :**

```html
<!-- Précharger l'image hero (LCP) -->
<link rel="preload" as="image" href="/hero.webp">

<!-- Attribut loading sur les autres images (pas le LCP !) -->
<img src="/article-thumbnail.webp" alt="..." loading="lazy">

<!-- Format image moderne -->
<picture>
  <source srcset="hero.webp" type="image/webp">
  <img src="hero.jpg" alt="Image principale de la page">
</picture>
```

```css
/* Réserver l'espace pour éviter le CLS */
.hero-image {
  width: 100%;
  aspect-ratio: 16 / 9;
  object-fit: cover;
}
```

---

#### INP — Interaction to Next Paint

**Définition :** Réactivité aux interactions utilisateur (clic, frappe clavier, tap).

**Cible :** < 200ms ✅ | 200–500ms ⚠️ | > 500ms ❌

> INP a remplacé FID (First Input Delay) en mars 2024.

**Causes fréquentes d'INP élevé :**
- JavaScript excessif sur le thread principal
- Long Tasks (tâches JS > 50ms)
- Hydratation lente (frameworks JS côté client)

**Corrections pratiques :**

```javascript
// ❌ Mauvais : calcul lourd bloquant le thread principal
button.addEventListener('click', () => {
  const result = lourCalculSynchrone(data); // Bloque l'UI
  afficherResultat(result);
});

// ✅ Bon : déléguer aux Web Workers ou découper avec scheduler
button.addEventListener('click', () => {
  scheduler.postTask(() => {
    const result = lourCalcul(data);
    afficherResultat(result);
  }, { priority: 'user-blocking' });
});
```

---

#### CLS — Cumulative Layout Shift

**Définition :** Mesure la stabilité visuelle. Un score élevé = les éléments bougent pendant le chargement (frustrant pour l'utilisateur).

**Cible :** < 0,1 ✅ | 0,1–0,25 ⚠️ | > 0,25 ❌

**Causes fréquentes :**
- Images sans dimensions définies
- Polices web provoquant un FOUT (*Flash of Unstyled Text*)
- Contenu injecté dynamiquement (publicités, bandeaux cookies)

**Corrections pratiques :**

```html
<!-- ✅ Toujours définir width et height sur les images -->
<img src="photo.webp" alt="Description" width="800" height="450">
```

```css
/* ✅ Stabiliser les polices web */
@font-face {
  font-family: 'MaPolice';
  src: url('/fonts/mapolice.woff2') format('woff2');
  font-display: optional; /* Évite FOUT sans CLS */
}
```

```html
<!-- ✅ Réserver l'espace pour les embeds/iframes -->
<div style="aspect-ratio: 16/9; width: 100%;">
  <iframe src="..."></iframe>
</div>
```

---

#### Mesurer les Core Web Vitals

| Outil | Type de données | Comment accéder |
|---|---|---|
| **Lighthouse** | Lab (simulation) | Chrome DevTools → onglet Lighthouse |
| **PageSpeed Insights** | Lab + Field (réel) | pagespeed.web.dev |
| **Chrome DevTools** | Lab | F12 → Performance |
| **Search Console** | Field (vrais utilisateurs) | Rapport "Expérience" |
| **Web Vitals Extension** | Field en temps réel | Extension Chrome |

**Exemple d'audit Lighthouse en ligne de commande :**

```bash
# Installer Lighthouse CLI
npm install -g lighthouse

# Auditer une URL
lighthouse https://monsite.fr --output html --output-path ./rapport.html

# Avec throttling mobile simulé
lighthouse https://monsite.fr --emulated-form-factor=mobile --output json
```

---

### HTTPS et Sécurité

HTTPS est un **facteur de classement Google** depuis 2014. Sans certificat SSL valide, Chrome affiche un avertissement "Non sécurisé" qui fait fuir les utilisateurs.

```bash
# Vérifier la configuration SSL
curl -I https://monsite.fr | grep -i "strict-transport"

# Résultat attendu :
# Strict-Transport-Security: max-age=31536000; includeSubDomains
```

**Headers HTTP importants pour le SEO :**

```nginx
# Configuration Nginx
server {
    listen 443 ssl;
    
    # Redirection HTTP → HTTPS (301 permanent)
    return 301 https://$host$request_uri;
    
    # HSTS
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
    
    # Cache statique (améliore LCP)
    location ~* \.(webp|jpg|png|css|js|woff2)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

---

### Mobile-First

Google indexe en **mobile-first** depuis 2023 : c'est la version mobile de votre site qui sert de référence pour le classement, même pour les recherches desktop.

**Checklist mobile :**

```html
<!-- Obligatoire : balise viewport -->
<meta name="viewport" content="width=device-width, initial-scale=1">
```

```css
/* Touch targets minimum 48px × 48px */
.btn, a, button {
  min-height: 48px;
  min-width: 48px;
  padding: 12px 16px;
}

/* Design responsive */
@media (max-width: 768px) {
  .nav-menu {
    flex-direction: column;
  }
  
  .article-grid {
    grid-template-columns: 1fr;
  }
}
```

**Tester la compatibilité mobile :**
- Outil Google : [search.google.com/test/mobile-friendly](https://search.google.com/test/mobile-friendly)
- Chrome DevTools → Toggle Device Toolbar (Ctrl+Shift+M)

---

### Crawl et Indexation

#### `robots.txt`

Fichier texte placé à la racine du domaine (`https://monsite.fr/robots.txt`) qui indique aux robots quelles pages crawler ou ignorer.

```
# robots.txt complet et commenté

# Règles pour tous les robots
User-agent: *
Allow: /
Disallow: /admin/
Disallow: /login/
Disallow: /panier/
Disallow: /commande/
Disallow: /compte/
Disallow: /*?s=           # Recherche interne
Disallow: /*?utm_*        # URLs avec paramètres UTM
Disallow: /wp-admin/      # Si WordPress

# Règles spécifiques à Googlebot
User-agent: Googlebot
Crawl-delay: 1            # Attendre 1s entre chaque requête

# Déclaration du sitemap
Sitemap: https://www.monsite.fr/sitemap.xml
Sitemap: https://www.monsite.fr/sitemap-images.xml
```

> ⚠️ `robots.txt` **n'empêche pas l'indexation**, il empêche le crawl. Pour désindexer, utiliser `<meta name="robots" content="noindex">`.

---

#### `sitemap.xml`

Liste structurée de toutes les URLs importantes de votre site. Facilite l'exploration par Googlebot.

```xml
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

  <url>
    <loc>https://www.monsite.fr/</loc>
    <lastmod>2024-11-15</lastmod>
    <changefreq>weekly</changefreq>
    <priority>1.0</priority>
  </url>

  <url>
    <loc>https://www.monsite.fr/guide-seo/</loc>
    <lastmod>2024-10-20</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.8</priority>
  </url>

  <url>
    <loc>https://www.monsite.fr/blog/</loc>
    <lastmod>2024-11-10</lastmod>
    <changefreq>daily</changefreq>
    <priority>0.7</priority>
  </url>

</urlset>
```

**Soumettre le sitemap dans Google Search Console :**
1. Search Console → Sitemaps (menu gauche)
2. Coller l'URL du sitemap
3. Cliquer "Envoyer"

**Sitemap Index (pour les grands sites) :**

```xml
<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <sitemap>
    <loc>https://monsite.fr/sitemap-pages.xml</loc>
  </sitemap>
  <sitemap>
    <loc>https://monsite.fr/sitemap-articles.xml</loc>
  </sitemap>
  <sitemap>
    <loc>https://monsite.fr/sitemap-produits.xml</loc>
  </sitemap>
</sitemapindex>
```

---

#### Codes HTTP et leur impact SEO

| Code | Signification | Impact SEO |
|---|---|---|
| **200 OK** | Page accessible | ✅ Idéal, indexable |
| **301 Moved Permanently** | Redirection permanente | ✅ Transmet ~90% du PageRank |
| **302 Found** | Redirection temporaire | ⚠️ Ne transmet pas le PageRank |
| **404 Not Found** | Page introuvable | ❌ Gaspillage de crawl budget |
| **410 Gone** | Page supprimée définitivement | ✅ Plus propre qu'un 404 |
| **500 Server Error** | Erreur serveur | ❌ Désindexation progressive |

**Gérer les redirections 301 (Nginx) :**

```nginx
# Redirection d'une ancienne URL vers nouvelle URL
rewrite ^/ancien-article/$ /nouvel-article/ permanent;

# Redirection de domaine (www vers non-www)
server {
    server_name www.monsite.fr;
    return 301 https://monsite.fr$request_uri;
}
```

> **Max 1 redirect** : Les chaînes de redirections (`A → B → C → D`) gaspillent le crawl budget et diluent le PageRank. Faire des redirections directes.

---

### Données structurées — Schema.org

Les données structurées permettent à Google de comprendre sémantiquement le contenu et d'afficher des **Rich Snippets** dans la SERP (étoiles de notation, prix, FAQ, etc.).

**Format recommandé : JSON-LD** (injecté dans le `<head>` ou avant `</body>`)

#### Exemple : Article de blog

```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "Guide Complet du SEO pour Développeurs 2024",
  "description": "Apprenez le SEO technique de A à Z : balises HTML, Core Web Vitals, backlinks.",
  "image": "https://monsite.fr/images/guide-seo-cover.webp",
  "author": {
    "@type": "Person",
    "name": "Jean Dupont",
    "url": "https://monsite.fr/auteur/jean-dupont/"
  },
  "publisher": {
    "@type": "Organization",
    "name": "MonSite",
    "logo": {
      "@type": "ImageObject",
      "url": "https://monsite.fr/logo.png"
    }
  },
  "datePublished": "2024-01-15",
  "dateModified": "2024-11-01"
}
</script>
```

#### Exemple : FAQ Page (génère un Rich Snippet accordéon dans Google)

```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Combien de temps faut-il pour voir les résultats SEO ?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "En général, les premiers résultats significatifs apparaissent entre 3 et 6 mois après le début des optimisations, selon la concurrence et l'autorité du domaine."
      }
    },
    {
      "@type": "Question",
      "name": "Quelle est la différence entre SEO et SEA ?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Le SEO (référencement naturel) cible les résultats organiques gratuits sur le long terme. Le SEA (Search Engine Advertising) désigne les annonces payantes à effet immédiat mais qui s'arrêtent dès la fin du budget."
      }
    }
  ]
}
</script>
```

#### Exemple : Produit e-commerce

```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "Formation SEO Complète",
  "description": "4 modules pour maîtriser le référencement naturel.",
  "image": "https://monsite.fr/formation-seo.webp",
  "offers": {
    "@type": "Offer",
    "price": "97.00",
    "priceCurrency": "EUR",
    "availability": "https://schema.org/InStock",
    "url": "https://monsite.fr/formation-seo/"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.8",
    "reviewCount": "142"
  }
}
</script>
```

**Tester les données structurées :**
- [schema.org/validator](https://validator.schema.org/) — Valide la syntaxe
- [search.google.com/test/rich-results](https://search.google.com/test/rich-results) — Vérifie les Rich Snippets

---

## Module 04 — SEO Off-Page

### Comprendre le PageRank

Le **PageRank** est l'algorithme originel de Google (1998, Larry Page). Il attribue une valeur à une page en fonction de la **quantité** et de la **qualité** des pages qui y pointent.

```
PageRank(A) = (1 - d) + d × Σ [ PageRank(Bi) / NbLiens(Bi) ]

d = facteur d'amortissement (0.85)
Bi = pages qui pointent vers A
NbLiens(Bi) = nombre total de liens sortants de Bi
```

En pratique : un lien depuis le Monde.fr (DA très élevé) vaut 1 000x plus qu'un lien depuis un blog inconnu.

---

### Qualité d'un backlink

| Critère | ✅ Bon signal | ❌ Mauvais signal |
|---|---|---|
| **Domain Authority** | Site reconnu, ancienneté, trafic élevé | Site récent, peu de trafic |
| **Pertinence thématique** | Même secteur / thématique | Hors-sujet total |
| **Texte d'ancre** | Ancre descriptive précise | "cliquez ici", ancre générique |
| **Type de lien** | `do-follow` (transmet le PageRank) | `nofollow` (ne transmet pas) |
| **Position** | Dans le corps du texte | Footer, sidebar |
| **Contexte éditorial** | Lien naturel dans un article de qualité | Ajouté artificiellement dans un annuaire |

**Liens toxiques à éviter :**
- Fermes de liens (*link farms*)
- PBN (*Private Blog Networks*)
- Liens achetés en masse
- Commentaires de spam
- Échanges de liens réciproques à grande échelle

> Risque : **Pénalité manuelle Google** → désindexation partielle ou totale du site.

**Désavouer des liens toxiques :**
```
# Fichier disavow.txt à soumettre dans Google Search Console
# Désavouer un domaine entier
domain:spamsite.com

# Désavouer une URL précise
https://linkfarm.biz/page/lien-vers-vous
```

---

### Stratégies d'acquisition de backlinks

#### 1. Content Marketing — Le contenu de référence

Créer du contenu si complet et utile que d'autres sites y font naturellement référence.

**Types de contenu qui génèrent des liens :**
- Guides ultra-complets ("Le guide ultime de…")
- Études de cas avec données originales
- Infographies partageables
- Outils gratuits en ligne
- Statistiques et recherches sectorielles

**Exemple pratique :**
> Vous créez un guide "100 statistiques SEO 2024 avec sources". Les blogueurs et journalistes qui écrivent sur le SEO auront besoin de ces données et citeront votre article.

#### 2. Guest Blogging

Écrire des articles invités sur des blogs ou médias de votre secteur.

**Processus :**
1. Identifier des blogs avec DA > 30 dans votre thématique
2. Analyser leur ligne éditoriale
3. Proposer 3 sujets par email personnalisé
4. Rédiger un article de qualité irréprochable
5. Inclure 1 à 2 liens naturels vers votre site

**Template d'email de prospection :**
```
Objet : Proposition d'article invité — [Sujet précis]

Bonjour [Prénom],

J'ai lu votre article sur [titre article] — votre angle sur [point précis] m'a particulièrement intéressé.

Je suis [votre expertise] et j'aimerais vous proposer un article invité sur :
"[Titre article 1]" ou "[Titre article 2]"

Ces sujets correspondraient à votre audience car [raison précise].

Cordialement,
[Votre nom]
```

#### 3. Digital PR

Obtenir des mentions dans la presse en ligne (journaux, magazines, sites d'actualité).

**Techniques :**
- Répondre aux journalistes via **HARO** (Help A Reporter Out) ou **Connectively**
- Émettre des communiqués de presse pour des événements réels
- Partager des études ou données exclusives

#### 4. Open Source / Dev Tools

Spécifique aux développeurs. Publier des bibliothèques, plugins, ou outils open source génère naturellement des backlinks lorsque d'autres devs les utilisent et en parlent.

**Exemples :**
- Plugin WordPress → backlinks depuis la doc et les tutoriels
- Package npm → README, articles Medium, tutoriels YouTube
- Outil de génération/analyse en ligne → citations spontanées

#### 5. Link Reclamation

Identifier les mentions de votre marque en ligne qui ne contiennent **pas** de lien, et contacter les auteurs pour qu'ils l'ajoutent.

**Processus :**
1. Chercher `"NomDeVotreMaque" -site:votremarque.fr` sur Google
2. Identifier les mentions sans lien
3. Contacter le webmaster par email
4. Demander poliment l'ajout d'un lien

---

### Autorité de domaine (DA / DR)

**Domain Authority (Moz)** et **Domain Rating (Ahrefs)** sont des métriques tierces (non officielles Google) qui estiment l'autorité globale d'un domaine sur une échelle de 0 à 100.

```
DA 0-20   → Nouveau site ou site peu lié
DA 20-40  → Site établi avec quelques backlinks
DA 40-60  → Site avec une bonne notoriété sectorielle
DA 60-80  → Forte autorité (médias, plateformes)
DA 80-100 → Géants du web (Wikipedia, Amazon, NYT...)
```

**Améliorer son DA :**
- Obtenir des backlinks de qualité (plus de poids que la quantité)
- Supprimer ou désavouer les liens toxiques
- Créer du contenu de référence régulièrement
- Patience : cela prend des mois/années

---

## Checklist SEO globale

### On-Page

- [ ] Balise `<title>` unique, 50-60 caractères, mot-clé en premier
- [ ] `<meta description>` incitative, < 160 caractères
- [ ] Un seul `<h1>` par page contenant le mot-clé principal
- [ ] Structure de titres `<h2>` à `<h6>` logique et hiérarchique
- [ ] URL courte, lisible, avec le mot-clé, en minuscules
- [ ] Attribut `alt` sur toutes les images
- [ ] Ancres de liens descriptives (pas de "cliquez ici")
- [ ] Lien canonique défini sur chaque page
- [ ] Mots-clés placés naturellement dans les 100 premiers mots
- [ ] Maillage interne entre les pages connexes
- [ ] Contenu unique, sans duplication

### Technique

- [ ] HTTPS activé avec certificat SSL valide
- [ ] Balise `<meta name="viewport">` présente
- [ ] Design mobile responsive (CSS media queries)
- [ ] Touch targets ≥ 48px
- [ ] LCP < 2,5 secondes
- [ ] INP < 200 millisecondes
- [ ] CLS < 0,1
- [ ] Images en format WebP avec dimensions définies
- [ ] `robots.txt` configuré et testé
- [ ] `sitemap.xml` soumis dans Google Search Console
- [ ] Aucune erreur 404 non gérée
- [ ] Redirections 301 directes (pas de chaînes)
- [ ] Schema.org implémenté (Article, FAQ, Product selon le cas)
- [ ] Données structurées validées avec Rich Results Test
- [ ] Temps de réponse serveur (TTFB) < 800ms
- [ ] Compression Gzip / Brotli activée

### Off-Page

- [ ] Profil de backlinks analysé (Ahrefs / Search Console)
- [ ] Aucun lien toxique (ou désavoué si existant)
- [ ] Textes d'ancre variés et naturels
- [ ] Stratégie de content marketing en place
- [ ] Google Business Profile configuré (si local)
- [ ] Suivi des performances dans Google Search Console
- [ ] Suivi du trafic organique dans Google Analytics 4
- [ ] Mentions de marque récupérées (link reclamation)

---

## Points clés à retenir

1. **Le SEO est un investissement long terme** — les résultats arrivent en 3 à 6 mois minimum. Ne pas abandonner après 4 semaines.

2. **En tant que développeur, vous contrôlez ~80% des facteurs techniques** qui influencent le classement : structure HTML, performance, indexation, données structurées.

3. **Priorité absolue : HTTPS + Mobile-First + Core Web Vitals.** Ce sont les fondations sans lesquelles le reste ne sert à rien.

4. **Le contenu de qualité reste le facteur #1** : répondre précisément à l'intention de l'utilisateur, avec de la profondeur et de l'originalité.

5. **Mesurer avec Google Search Console (gratuit)** pour suivre le trafic organique, les requêtes, les erreurs de crawl et l'état des Core Web Vitals.

6. **Les backlinks de qualité font la différence** entre deux sites au contenu équivalent. Un lien depuis un site d'autorité vaut infiniment plus que dix liens depuis des sites inconnus.

7. **Jamais de black hat** : keyword stuffing, fermes de liens, cloaking — les pénalités Google peuvent détruire des années de travail en quelques jours.

---

## Ressources pour aller plus loin

| Ressource | URL | Coût |
|---|---|---|
| Google Search Console | search.google.com/search-console | Gratuit |
| PageSpeed Insights | pagespeed.web.dev | Gratuit |
| Rich Results Test | search.google.com/test/rich-results | Gratuit |
| Mobile-Friendly Test | search.google.com/test/mobile-friendly | Gratuit |
| Google Search Central (doc officielle) | developers.google.com/search | Gratuit |
| Ahrefs Webmaster Tools | ahrefs.com/webmaster-tools | Gratuit (limité) |
| Schema.org | schema.org | Gratuit |
| Lighthouse CLI | npmjs.com/package/lighthouse | Gratuit |

---

*Cours réalisé par ITuniversity · 4 modules · Cours complet*
*Niveau : Développeurs Web · Mise à jour : 2024*
