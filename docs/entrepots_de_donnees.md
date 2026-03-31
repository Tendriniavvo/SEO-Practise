# Entrepôts de Données (Data Warehouse)
*Elsa Nègre — Université Paris-Dauphine, 2013-2014*

---

## 1. Contexte et Problématique

### Pourquoi un entrepôt de données ?

Les entreprises accumulent d'énormes quantités de **données opérationnelles** (bases de production, fichiers RH, paie, etc.) qui présentent plusieurs caractéristiques problématiques pour l'analyse :

| Caractéristique | Problème |
|---|---|
| **Distribuées** | Systèmes éparpillés dans l'entreprise |
| **Hétérogènes** | Structures et formats différents selon les systèmes |
| **Détaillées** | Trop abondantes pour une analyse directe |
| **Peu adaptées à l'analyse** | Les requêtes lourdes peuvent bloquer le système transactionnel |
| **Volatiles** | Pas d'historisation systématique |

**Exemples de questions décisionnelles typiques :**
- *Qui sont mes meilleurs clients ?*
- *Pourquoi et comment le chiffre d'affaires a-t-il baissé ?*
- *À combien s'élèvent mes ventes journalières ?*
- *Quels clients consomment beaucoup de poisson ?*

### La solution : le Data Warehouse (DW)

L'objectif est de mettre en place un **Système d'Information dédié aux applications décisionnelles** pour transformer des données de production en informations stratégiques.

```
données  ──────────────────────────►  informations
run the business                      manage the business
```

---

## 2. Définition de l'Entrepôt de Données

> **"Le DW est une collection de données orientées sujet, intégrées, non volatiles et historisées, organisées pour le support d'un processus d'aide à la décision."**
> — W.H. Inmon (1996)

En résumé : **c'est une base de données à des fins d'analyse.**

---

## 3. OLTP vs OLAP : Pourquoi pas un SGBD classique ?

| Critère | OLTP (SGBD classique) | OLAP (Data Warehouse) |
|---|---|---|
| **Utilisateurs** | Nombreux employés | Peu d'analystes |
| **Données** | Alphanumériques, détaillées, dynamiques | Numériques, résumées, statiques |
| **Requêtes** | Prédéfinies | "One-use", ad hoc |
| **Accès** | Peu de données courantes | Beaucoup d'informations historisées |
| **But** | Dépend de l'application | Prise de décision |
| **Temps d'exécution** | Court | Long |
| **Mises à jour** | Très souvent | Périodiquement |

**Exemple concret :**
Imaginons un supermarché. Le système OLTP gère chaque passage en caisse en temps réel (insert, update, delete sur les stocks). Si un analyste marketing souhaite comparer les ventes par région sur 3 ans, il ne peut pas lancer cette requête sur la base de production sans risquer de bloquer les caisses. C'est exactement le rôle du DW : absorber cette requête lourde, sans impacter les opérations quotidiennes.

---

## 4. Les 4 Caractéristiques d'un DW

### 4.1 Données orientées sujet
Le DW regroupe les informations de **différents métiers** (ventes, RH, finance…) selon des axes d'analyse, sans tenir compte de l'organisation fonctionnelle interne.

**Exemple :** Dans une compagnie d'assurance, les données *Client* et *Police* traversent horizontalement les silos Ass. Vie, Ass. Auto et Ass. Santé.

### 4.2 Données intégrées
Les données provenant de sources hétérogènes sont **normalisées et unifiées** autour d'un référentiel unique.

**Exemple d'intégration :**
```
Source A : "h,f"    ──┐
Source B : "1,0"    ──┼──► Référentiel unique : "h,f"
Source C : "homme,  ──┘
            femme"

Source D : GBP  ──┐
Source E : CHF  ──┼──► Référentiel unique : EUR
Source F : USD  ──┘
```

### 4.3 Données non volatiles
Contrairement aux bases de production (ajout, modification, suppression), le DW ne supporte que le **chargement et la lecture**. Les données ne sont jamais supprimées : elles permettent la traçabilité des décisions.

```
Base de production  :  Ajout ──► Modification ──► Suppression
Entrepôt de données :  Chargement ──────────────► Accès (lecture)
```

### 4.4 Données historisées / datées
Les données **persistent dans le temps** grâce à un référentiel temporel. On peut ainsi comparer l'état d'une donnée à différentes dates.

**Exemple :** Si Dupont déménage de Paris à Marseille entre mai 2005 et juillet 2006, le DW conserve les **deux états**, horodatés, là où la base de production n'en garderait qu'un.

---

## 5. Le Datamart

Un **datamart** est un sous-ensemble du DW, destiné à répondre aux besoins d'un secteur ou d'une fonction particulière de l'entreprise (marketing, RH, finance…).

```
DW de l'entreprise ──► Datamart Marketing
                   └──► Datamart Ressources Humaines
```

> **Analogie :** Si le DW est une grande bibliothèque nationale, un datamart en est une section spécialisée (ex. : la section Sciences, la section Histoire).

---

## 6. Architecture d'un Système Décisionnel

```
Sources ──► Entrepôt ──► Magasins (Datamarts) ──► Décideurs
```

En détail, le flux complet est :

```
[OLTP]                [ENTREPOSAGE]           [OLAP]
Sources d'info ──► Outils d'alimentation ──► Entrepôt ──► Cubes de données
                   (ETL)                              ──► Reporting
                                                      ──► Datamining
                                                      ──► Tableaux de Bord
```

---

## 7. Modélisation Multidimensionnelle

La modélisation s'aborde à trois niveaux : **conceptuel**, **logique** et **physique**.

### 7.1 Niveau Conceptuel : Dimensions, Faits et Mesures

#### Dimension
Axe d'analyse utilisé pour explorer les données (temps, géographie, produit, client…).  
Chaque dimension possède des **attributs** et est organisée en **hiérarchies**.

**Exemple — Dimension Produit :**
```
Dimension Produit
├── Clé produit (CP)       ← clé de substitution
├── Code produit
├── Description du produit
├── Famille du produit
├── Marque
├── Emballage
└── Poids
```

#### Hiérarchie
Les membres d'une dimension sont organisés selon des niveaux de granularité (paramètres).

**Exemple — Hiérarchies multiples :**
```
Dimension Temps :
  Jour ──► Semaine ──► Mois ──► Semestre ──► Année

Dimension Géographie :
  Client ──► Ville ──► Département ──► Région ──► Pays
           └─ Secteur de ventes ──► Région de ventes
```

#### Granularité
C'est le **niveau de détail** de la représentation. Plus la granularité est fine, plus les analyses sont précises, mais plus l'entrepôt est volumineux.

```
Finesse ++  ←──────────────────────────────►  Finesse --
Jour | Semaine | Mois | Trimestre | Année
↑ analyses précises                ↑ taille réduite
```

#### Fait et Mesure
- Un **fait** représente le sujet analysé : une valeur de mesure calculée selon les membres de chaque dimension.
- Une **mesure** est l'élément quantitatif sur lequel portent les analyses (chiffre d'affaires, quantité vendue, nombre d'accidents…).

**Exemple :**
> *250 000 euros* est un fait qui exprime la mesure **Coût des travaux** pour l'année **2002** et la ville **Versailles**.

La **table de fait** contient les valeurs des mesures + les clés étrangères vers les tables de dimensions.

---

### 7.2 Schémas Conceptuels

#### Modèle en Étoile (Star Schema)
Une table de fait centrale reliée à des tables de dimension indépendantes.

```
              [Dimension Temps]
                    |
[Dim. Magasin] ─── [Table de faits Achat] ─── [Dim. Produit]
                    |   - ID client
                    |   - ID temps
                    |   - ID magasin
              [Dim. Client]   - Quantité achetée
                              - Montant des achats
```

✅ Navigation facile, peu de jointures  
❌ Redondance dans les dimensions

#### Modèle en Constellation (Fact Constellation)
Plusieurs tables de faits partageant des dimensions communes.

**Exemple :** Un entrepôt scolaire avec des tables de faits distinctes pour les *Résultats*, les *Absences*, les *Sanctions disciplinaires*, etc., toutes reliées à des dimensions communes *Étudiant*, *Temps*, *Établissement*.

✅ Adapté aux analyses multi-sujets  
❌ Schéma complexe

---

### 7.3 Niveau Logique : ROLAP, MOLAP, HOLAP

| Technologie | Principe | Avantages | Inconvénients |
|---|---|---|---|
| **ROLAP** | Données dans un SGBD relationnel + moteur OLAP | Facile, peu coûteux, gros volumes | Moins performant pour les calculs |
| **MOLAP** | Données stockées dans des matrices multidimensionnelles (cubes) | Très rapide | Formats propriétaires, volumes limités |
| **HOLAP** | Hybride : données de base en relationnel + agrégats en cube | Bon compromis coût/performance | Complexité d'administration |

**Exemples de moteurs :**
- ROLAP : Mondrian
- MOLAP : Microsoft Analysis Services, Hyperion

#### Modèle en Flocon (Snowflake Schema) — niveau logique
Variante normalisée du schéma en étoile : les dimensions sont décomposées en sous-hiérarchies, réduisant la redondance.

```
[Dim. Famille] ◄── [Dim. Groupe] ◄── [Dim. Produit]
                                           |
[Dim. Division Vente] ◄── [Dim. Région] ─ [Table de faits Achat] ─ [Dim. Temps]
                                           |
                                      [Dim. Magasin]
                                           |
                                      [Dim. Client]
```

✅ Normalisation, économie d'espace  
❌ Modèle complexe, requêtes moins performantes

---

### 7.4 Niveau Physique
L'implantation dépend du logiciel. Les instructions SQL classiques sont insuffisantes :
- `CREATE TABLE ... AS ...` : recopie physique, à reprendre intégralement à chaque évolution
- `CREATE VIEW ... AS ...` : recalculé à chaque requête, trop lent sur de gros volumes

→ On recourt à des **index spéciaux**, des **vues matérialisées**, et des **optimisations propres aux SGBD**.

---

## 8. Le Cube OLAP

Le cube est la représentation multidimensionnelle centrale du DW. Il permet d'analyser une mesure selon plusieurs dimensions simultanément (temps, géographie, produits…).

**Exemple de cube — Ventes de véhicules :**

| | 2005 | 2006 | 2007 | 2008 |
|---|---|---|---|---|
| **Loiret** | 100 unités / 1 M€ | 250 / 2 M€ | 260 / 2,2 M€ | 280 / 3 M€ |
| **Eure-et-Loir** | 200 / 2 M€ | 210 / 2,1 M€ | 230 / 2,5 M€ | 220 / 2,1 M€ |
| **Gironde** | 2 / 20 k€ | 2 / 20 k€ | 5 / 55 k€ | 4 / 45 k€ |

*Troisième axe : Couleur du véhicule (Blanc, Noir, Bleu, Rouge)*

---

## 9. Opérateurs de Manipulation du Cube

### Opérations de forage (granularité)

| Opérateur | Direction | Description | Exemple |
|---|---|---|---|
| **Roll-Up** | ↑ | Agrégation vers un niveau supérieur | Département → Région |
| **Drill-Down** | ↓ | Décomposition vers un niveau inférieur | Région → Département |

**Exemple Roll-Up sur la dimension Géographie :**
```
AVANT (niveau Département) :  Loiret=100, Eure-et-Loir=200, Indre=100...  (par an)
          ↓ Roll-Up
APRÈS (niveau Région) :       Centre=551, Aquitaine=2  (pour 2005)
```

### Opérations de sélection / projection

| Opérateur | Description | Exemple |
|---|---|---|
| **Slice** | Sélection sur une dimension → tranche du cube | Année = "2005" |
| **Dice** | Cumul de sélections sur plusieurs dimensions | Département ∈ {Loir-et-Cher, Gironde} ET Année ∈ {2007, 2008} |

**Exemple Slice (Année = "2005") :**
```
AVANT : 4 années × 6 départements × toutes couleurs
      ↓ Slice (Année = 2005)
APRÈS : 1 ligne (2005) × 6 départements  →  Loiret=100, Eure-et-Loir=200...
```

**Exemple Dice :**
```
AVANT : 4 années × 6 départements
      ↓ Dice(Dept ∈ {Loir-et-Cher, Gironde}, Année ∈ {2007, 2008})
APRÈS : 2 années × 2 départements
        Loir-et-Cher 2007=4, Gironde 2007=5
        Loir-et-Cher 2008=5, Gironde 2008=4
```

### Opérations de restructuration

| Opérateur | Description |
|---|---|
| **Pivot / Rotate** | Change la face du cube visible — ex. (Région, Produit) → (Région, Mois) |
| **Nest** | Imbrique des membres de dimensions différentes dans les lignes |
| **Push** | Les membres d'une dimension deviennent le contenu des cellules |
| **Switch** | Inter-change la position des membres d'une dimension |

---

## 10. Réalisation d'un DW

### Trois approches de construction

| Approche | Principe | Avantages | Inconvénients |
|---|---|---|---|
| **Top-Down** (Inmon) | Concevoir tout le DW d'un coup | Architecture intégrée, pas de redondance | Lourd, long |
| **Bottom-Up** (Kimball) | Créer les datamarts un par un | Simple, résultats rapides | Risques de redondances à long terme |
| **Middle-Out** | Concevoir le DW, puis créer des divisions gérables | Meilleur des deux mondes, itératif | Peut nécessiter des compromis |

### 5 étapes clés de réalisation

1. **Conception** — Définir les faits, mesures, dimensions, hiérarchies et le schéma (étoile / flocon / cube)
2. **Acquisition des données (ETL)** — Extraire, Transformer, Charger
3. **Aspects techniques** — Contraintes logicielles, matérielles, humaines
4. **Restitution** — Requêteurs, outils d'analyse, datamining
5. **Administration & Maintenance** — Stratégies de rafraîchissement, évolution

### L'ETL : Extract, Transform, Load

**Extraction** — depuis différentes sources (BD, fichiers, journaux…) via :
- *Push* : règles/triggers côté source
- *Pull* : requêtes côté DW

**Transformation** — étape cruciale de cohérence :
```
Avant :  MM/JJ/AA  →  Après : JJ/MM/AA
Avant :  "D-Naiss", "Naissance", "Date-N"  →  Après : "Date-Naissance"
Avant :  GBP, CHF, USD  →  Après : EUR
Avant :  "male"/"female", "1"/"0", "h"/"f"  →  Après : "h"/"f"
```
Inclut également : tri, dédoublonnage, gestion des NULL, vérification des contraintes d'intégrité…

**Chargement** — insertion dans l'entrepôt, mise à jour des index et des résumés (agrégats pré-calculés).

> ⚠️ **ETL ≠ ELT** : dans l'ELT (Extract, Load, Transform), la transformation est réalisée directement dans le SGBD cible en SQL natif.

### Volumes typiques

| Secteur | Calcul | Volume estimé |
|---|---|---|
| Grande distribution (CA 80 Md$) | 16×10⁹ articles/an × 3 ans × 24 octets | **~1,54 To** |
| Téléphonie (100 M appels/j) | 100 M × 1 095 jours × 24 octets | **~3,94 To** |
| Cartes de crédit (50 M clients) | 50 M × 26 mois × 30 transactions × 24 octets | **~1,73 To** |

---

## 11. Solutions Existantes

### Solutions commerciales
Business Objects, Cognos, Hyperion, Microsoft (Analysis Services), SAS, Oracle, Ab Initio, IBM…

### Solutions Open Source

| Catégorie | Outils |
|---|---|
| ETL | Octopus, Kettle, CloverETL, Talend |
| Entrepôt | MySQL, PostgreSQL, Greenplum/Bizgres |
| OLAP | Mondrian, Palo |
| Reporting | Birt, Open Report, Jasper Report, JFreeReport |
| Data Mining | Weka, R-Project, Orange, Xelopes |
| Intégré | **Pentaho** (Kettle + Mondrian + JFreeReport + Weka), **SpagoBI** |

---

## 12. Exercice — Schéma en Étoile

**Contexte :** Entrepôt de données pour les ventes d'une entreprise.

```
CLIENT  (id-client, région, ville, pays, département)
PRODUIT (id-prod, catégorie, coût-unitaire, fournisseur, prix-unitaire, nom-prod)
TEMPS   (id-tps, mois, nom-mois, trimestre, année)
VENTE   (id-prod, id-tps, id-client, date-expédition, prix-de-vente, frais-de-livraison)
```

**Réponses guidées :**

**1. Table de fait et tables de dimension**
- **Table de fait :** VENTE (contient les mesures : prix-de-vente, frais-de-livraison)
- **Tables de dimension :** CLIENT, PRODUIT, TEMPS

**2. Hiérarchies**
```
CLIENT    : ville → département → région → pays
PRODUIT   : nom-prod → catégorie → fournisseur
TEMPS     : mois → trimestre → année
```

**3. Schéma en étoile**
```
         [TEMPS]
           |
[CLIENT]──[VENTE]──[PRODUIT]
```

**4. Schéma en flocon — Normalisation de TEMPS**
Dans le schéma en étoile, TEMPS contient `mois`, `trimestre` et `année` dans la même table, ce qui crée des dépendances fonctionnelles (un trimestre dépend d'une année, un mois dépend d'un trimestre). En flocon :

```
[VENTE] ──► [TEMPS_MOIS (id-tps, mois, nom-mois, id-trimestre)]
                   └──► [TEMPS_TRIMESTRE (id-trimestre, trimestre, id-année)]
                                └──► [TEMPS_ANNEE (id-année, année)]
```

---

## Références

- Golfarelli, M. & Rizzi, S. — *Data Warehouse Design: Modern Principles and Methodologies*, Osborne/McGraw-Hill, 2009
- Thomsen, E. — *OLAP Solutions: Building Multidimensional Information Systems*, John Wiley & Sons, 2002
