# Optimisation d’un Site Internet

## 1. Introduction

L’optimisation d’un site web consiste à améliorer :

- La vitesse de chargement
- L’expérience utilisateur (UX)
- Le référencement (SEO)
- L’efficacité des ressources (serveur, réseau)

Objectif : rendre le site rapide, fluide et accessible.

---

## 2. Outils d’analyse des performances

### 2.1 Inspecter les éléments (DevTools)

Permet de :

- Voir le HTML/CSS en temps réel
- Identifier les styles appliqués
- Debugger l’affichage

### 2.2 Console

Utilisée pour :

- Afficher les erreurs JavaScript
- Tester du code
- Suivre les logs

### 2.3 Onglet Réseau (Network)

Permet d’analyser :

- Temps de chargement des ressources
- Nombre de requêtes HTTP
- Taille des fichiers (JS, CSS, images)

### 2.4 Onglet Application

Permet de voir :

- Le stockage local (LocalStorage, SessionStorage)
- Les cookies
- Le cache navigateur

---

## 3. Optimisation de la taille des ressources

### Objectif

Réduire le poids total de la page.

### Techniques

- Compression des images
- Redimensionnement des images
- Minification (HTML, CSS, JS)
- Mise en cache côté client

### Explication

Moins une page est lourde, plus elle se charge rapidement.
Exemple :

- Image 5MB → optimisée à 200KB = gain énorme

---

## 4. Optimisation CSS

### 4.1 Concaténation des fichiers

Regrouper plusieurs fichiers CSS en un seul.

👉 Réduit le nombre de requêtes HTTP

---

### 4.2 Images sprites

Regrouper plusieurs petites images en une seule.

👉 Permet de charger une seule image au lieu de plusieurs

---

### 4.3 Critical CSS (CSS critique)

Charger en priorité uniquement les styles nécessaires à l’affichage initial.

Outil :

- Google PageSpeed Insights

👉 Améliore le temps de rendu initial (First Paint)

---

## 5. Chargement asynchrone

### Techniques

- Lazy Loading (chargement différé)
- Priorisation des contenus visibles

### Explication

On charge d'abord :

- ce que l’utilisateur voit à l’écran

Puis :

- le reste après

👉 Améliore la perception de rapidité

---

## 6. Optimisation des requêtes HTTP

### Techniques

- Lazy loading (images, vidéos)
- Utilisation d’un CDN
- Regroupement des appels API

### Explication

Chaque requête HTTP coûte du temps.

👉 Moins de requêtes = site plus rapide

---

## 7. Optimisation JavaScript

### Techniques

- `defer` et `async`
- Tree Shaking
- Code Splitting

### Explication

- **defer** : exécute JS après HTML
- **async** : charge JS en parallèle
- **tree shaking** : supprime code inutile
- **code splitting** : charge JS à la demande

👉 Objectif : charger seulement ce qui est nécessaire

---

## 8. Optimisation serveur

### Techniques

- Compression Gzip
- Keep-Alive (connexion persistante)
- Serveur optimisé (Nginx / Apache)
- HTTPS + HTTP/2
- Cache serveur

### Explication

Le serveur doit répondre rapidement.

👉 Un bon backend = performance globale

---

## 9. SEO et Accessibilité

### SEO

- Balises title, meta
- Structure H1, H2
- Performance mobile

### Accessibilité

- Contraste des couleurs
- Lisibilité
- Navigation clavier

👉 Un site optimisé est aussi bien référencé et accessible

---

## 10. Tests et suivi

### Outils

- Google PageSpeed Insights
- Lighthouse
- GTmetrix
- Logs serveur

### Objectif

Mesurer :

- Temps de chargement
- Score performance
- Problèmes détectés

---

## 11. Actions à réaliser

- Reprendre un site existant
- Appliquer les optimisations
- Documenter les changements
- Comparer les résultats

👉 Démarche continue d’amélioration
