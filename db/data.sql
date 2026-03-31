-- ============================================================
SET NAMES utf8mb4;
-- DONNÉES DE TEST — Base de données Iran News
-- Contexte : Conflit Iran / Israël / Moyen-Orient 2024-2025
-- ============================================================

USE iran_news;

-- ============================================================
-- 1. DIMENSION TEMPS
-- ============================================================

INSERT INTO dim_temps (date, annee, mois) VALUES
('2024-04-01', 2024, 4),
('2024-04-13', 2024, 4),
('2024-04-14', 2024, 4),
('2024-04-15', 2024, 4),
('2024-04-19', 2024, 4),
('2024-05-20', 2024, 5),
('2024-06-03', 2024, 6),
('2024-07-15', 2024, 7),
('2024-07-31', 2024, 7),
('2024-08-05', 2024, 8),
('2024-09-17', 2024, 9),
('2024-09-27', 2024, 9),
('2024-10-01', 2024, 10),
('2024-10-07', 2024, 10),
('2024-10-26', 2024, 10),
('2024-11-05', 2024, 11),
('2024-11-19', 2024, 11),
('2024-12-10', 2024, 12),
('2025-01-15', 2025, 1),
('2025-01-20', 2025, 1),
('2025-02-08', 2025, 2),
('2025-03-01', 2025, 3),
('2025-03-22', 2025, 3);

-- ============================================================
-- 2. AUTEURS SUPPLÉMENTAIRES
-- ============================================================

INSERT INTO dim_auteur (nom, prenom) VALUES
('Ahmadi',    'Reza'),
('Moradi',    'Sara'),
('Tehrani',   'Dariush'),
('Karimi',    'Leila'),
('Nasseri',   'Farhad'),
('Hosseini',  'Maryam');

-- ============================================================
-- 3. TABLE DE FAITS — ARTICLES
-- ============================================================

INSERT INTO fait_article (id_temps, id_categorie, id_auteur, titre, contenu, slug, nb_vues, is_active, date_publication) VALUES

-- ── MILITAIRE ──────────────────────────────────────────────

(2,  2, 2,
 'Iran lance une attaque de drones et missiles contre Israël',
 '<h2>Contexte de l''attaque</h2><p>Dans la nuit du 13 au 14 avril 2024, l''Iran a lancé plus de 300 projectiles vers Israël. Cette opération a marqué une escalade majeure dans la région.</p><h3>Points clés</h3><ul><li>Interception massive par les défenses israéliennes.</li><li>Soutien des États-Unis et de partenaires régionaux.</li><li>Riposte présentée par Téhéran comme légitime.</li></ul>',
 'iran-attaque-drones-missiles-israel-avril-2024',
 184320, TRUE, '2024-04-14 04:30:00'),

(5,  2, 3,
 'Israël frappe des installations militaires en Iran en réponse à l''attaque du 14 avril',
 '<h2>Frappe de représailles</h2><p>Le 19 avril 2024, des explosions ont été signalées près d''Ispahan. Des sources israéliennes ont évoqué une opération ciblée contre des capacités de défense iraniennes.</p><h3>Conséquences immédiates</h3><p>L''incident a renforcé la confrontation directe entre les deux pays et accru la tension régionale.</p>',
 'israel-frappe-installations-iran-ispahan-avril-2024',
 97450, TRUE, '2024-04-19 09:15:00'),

(8,  2, 2,
 'Assassinat d''Ismaïl Haniyeh à Téhéran : l''Iran promet vengeance',
 '<h2>Un assassinat à fort impact</h2><p>Le 31 juillet 2024, Ismaïl Haniyeh a été tué à Téhéran. L''Iran a dénoncé une opération extérieure et promis une réponse ferme.</p><h3>Lecture stratégique</h3><p>Cet événement a été perçu comme une atteinte directe à la crédibilité sécuritaire iranienne.</p>',
 'assassinat-haniyeh-teheran-iran-vengeance',
 215780, TRUE, '2024-07-31 11:00:00'),

(13, 2, 4,
 'L''Iran tire plus de 180 missiles balistiques sur Israël : l''«Opération Promesse Vraie 2»',
 '<h2>Deuxième salve iranienne</h2><p>Le 1er octobre 2024, l''Iran a revendiqué un tir massif de missiles balistiques contre Israël, dans le cadre de l''« Opération Promesse Vraie 2 ».</p><h3>Réactions internationales</h3><p>Les États-Unis ont soutenu l''interception et appelé à éviter une escalade incontrôlée.</p>',
 'iran-missiles-balistiques-israel-octobre-2024-operation-promesse-vraie-2',
 302100, TRUE, '2024-10-01 21:45:00'),

(15, 2, 2,
 'Israël frappe l''Iran : des sites militaires détruits dans plusieurs provinces',
 '<h2>Riposte israélienne élargie</h2><p>Le 26 octobre 2024, Israël a ciblé plusieurs installations militaires iraniennes dans différentes provinces.</p><h3>Éléments rapportés</h3><ul><li>Sites de défense antiaérienne touchés.</li><li>Dépôts de missiles endommagés.</li><li>Message de dissuasion renforcé.</li></ul>',
 'israel-frappe-iran-sites-militaires-octobre-2024',
 278900, TRUE, '2024-10-26 06:30:00'),

(18, 2, 3,
 'Programme nucléaire iranien : les États-Unis renforcent leurs sanctions',
 '<h2>Pression sur le nucléaire iranien</h2><p>En décembre 2024, Washington a annoncé de nouvelles sanctions ciblant le programme nucléaire et balistique iranien.</p><h3>Point de vigilance</h3><p>Le niveau d''enrichissement de l''uranium reste au cœur des inquiétudes internationales.</p>',
 'programme-nucleaire-iran-sanctions-usa-decembre-2024',
 143200, TRUE, '2024-12-10 14:00:00'),

(20, 2, 5,
 'Trump menace l''Iran de frappes directes si les négociations échouent',
 '<h2>Ultimatum américain</h2><p>Au début de 2025, Donald Trump a lié la reprise des négociations nucléaires à un délai court, en menaçant d''une option militaire.</p><h3>Réaction iranienne</h3><p>Téhéran a rejeté ces déclarations et dénoncé une logique de pression maximale.</p>',
 'trump-menace-iran-frappes-negociations-nucleaire-2025',
 189450, TRUE, '2025-01-20 17:30:00'),

-- ── POLITIQUE ──────────────────────────────────────────────

(1,  4, 4,
 'Bombardement du consulat iranien à Damas : Téhéran accuse Israël',
 '<h2>Incident diplomatique majeur</h2><p>Le 1er avril 2024, une frappe a détruit un bâtiment annexe du consulat iranien à Damas.</p><h3>Impact politique</h3><p>L''Iran a accusé Israël et présenté cet épisode comme le déclencheur d''une riposte régionale.</p>',
 'bombardement-consulat-iranien-damas-syrie-2024',
 112340, TRUE, '2024-04-01 16:00:00'),

(6,  4, 6,
 'Masoud Pezeshkian élu président de la République islamique d''Iran',
 '<h2>Victoire de Masoud Pezeshkian</h2><p>Le candidat réformiste a remporté l''élection présidentielle iranienne de juillet 2024.</p><h3>Enjeux de gouvernance</h3><p>Son mandat s''ouvre dans un contexte où les équilibres institutionnels restent dominés par le Guide suprême.</p>',
 'pezeshkian-elu-president-iran-reformiste-2024',
 87600, TRUE, '2024-05-20 10:00:00'),

(11, 4, 4,
 'L''Iran face à l''isolement diplomatique après la mort de Nasrallah',
 '<h2>Isolement diplomatique croissant</h2><p>Après la mort de Hassan Nasrallah, l''Iran a fait face à un repositionnement prudent de plusieurs acteurs régionaux.</p><h3>Situation internationale</h3><p>Les partenaires de Téhéran ont privilégié des appels à la retenue plutôt qu''un soutien explicite.</p>',
 'iran-isolement-diplomatique-mort-nasrallah-2024',
 76500, TRUE, '2024-09-17 13:30:00');

-- ============================================================
-- 4. IMAGES DES ARTICLES
-- ============================================================

INSERT INTO fait_article_image (id_article, image_url, alt_text, is_main) VALUES

-- Article 1 : Attaque drones avril 2024
(1, '/front/assets/img/article-01.jpg',                     'Ciel illuminé par des drones et missiles iraniens en route vers Israël',        TRUE),

-- Article 2 : Frappe Ispahan
(2, '/front/assets/img/article-02.jpg',                     'Vue aérienne d''Ispahan après la frappe israélienne',                            TRUE),

-- Article 3 : Assassinat Haniyeh
(3, '/front/assets/img/article-03.jpg',                     'Portrait officiel d''Ismaïl Haniyeh, chef politique du Hamas',                   TRUE),

-- Article 4 : Opération Promesse Vraie 2
(4, '/front/assets/img/article-04.jpg',                     'Lancement de missiles balistiques depuis le territoire iranien',                 TRUE),

-- Article 5 : Frappes israéliennes octobre 2024
(5, '/front/assets/img/article-05.jpg',                     'Carte des zones frappées par Israël en Iran en octobre 2024',                   TRUE),

-- Article 6 : Programme nucléaire
(6, '/front/assets/img/article-06.jpg',                     'Vue satellite de l''installation nucléaire de Natanz, Iran',                     TRUE),

-- Article 7 : Trump menace Iran
(7, '/front/assets/img/article-07.jpg',                     'Le président Trump lors de son discours sur la politique envers l''Iran',        TRUE),

-- Article 8 : Consulat Damas
(8, '/front/assets/img/article-08.jpg',                     'Ruines du bâtiment consulaire iranien à Damas après la frappe',                 TRUE),

-- Article 9 : Pezeshkian élu
(9, '/front/assets/img/article-09.jpg',                     'Masoud Pezeshkian célèbre sa victoire à l''élection présidentielle iranienne',   TRUE),

-- Article 10 : Iran isolement diplomatique
(10, '/front/assets/img/article-10.jpg',                    'Représentant iranien lors d''une session d''urgence au Conseil de sécurité ONU', TRUE);
