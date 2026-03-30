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
 'Dans la nuit du 13 au 14 avril 2024, l''Iran a lancé une attaque sans précédent contre le territoire israélien, tirant plus de 300 projectiles dont des drones kamikazes, des missiles de croisière et des missiles balistiques. C''est la première fois que l''Iran attaque directement Israël depuis son territoire. La quasi-totalité des projectiles ont été interceptés par le système de défense israélien Iron Dome, avec l''aide des États-Unis, de la Jordanie et du Royaume-Uni. Cette attaque fait suite au bombardement du consulat iranien à Damas le 1er avril 2024, attribué à Israël. Les autorités iraniennes ont qualifié cette opération de riposte légitime et l''ont baptisée « Opération Promesse Vraie ».',
 'iran-attaque-drones-missiles-israel-avril-2024',
 184320, TRUE, '2024-04-14 04:30:00'),

(5,  2, 3,
 'Israël frappe des installations militaires en Iran en réponse à l''attaque du 14 avril',
 'Le 19 avril 2024, des explosions ont été rapportées près de la ville d''Ispahan en Iran. Des sources israéliennes ont confirmé qu''il s''agissait d''une frappe ciblée menée par l''armée de l''air israélienne (Tsahal) visant des radars de défense antiaérienne iraniens. L''Iran a d''abord minimisé l''incident, affirmant que ses défenses avaient intercepté de « petits objets volants ». Cette frappe de représailles illustre la montée en puissance de la confrontation directe entre les deux pays, inaugurant un cycle d''escalade inédit au Moyen-Orient.',
 'israel-frappe-installations-iran-ispahan-avril-2024',
 97450, TRUE, '2024-04-19 09:15:00'),

(8,  2, 2,
 'Assassinat d''Ismaïl Haniyeh à Téhéran : l''Iran promet vengeance',
 'Le chef politique du Hamas, Ismaïl Haniyeh, a été tué le 31 juillet 2024 dans la capitale iranienne, où il participait à la cérémonie d''investiture du nouveau président Masoud Pezeshkian. L''Iran et le Hamas ont accusé Israël d''avoir mené cette opération. Cet assassinat, au cœur même de Téhéran, a été perçu comme une humiliation majeure pour la République islamique. Le Guide suprême Ali Khamenei a promis une «punition sévère» contre Israël, alimentant les craintes d''une nouvelle escalade régionale.',
 'assassinat-haniyeh-teheran-iran-vengeance',
 215780, TRUE, '2024-07-31 11:00:00'),

(13, 2, 4,
 'L''Iran tire plus de 180 missiles balistiques sur Israël : l''«Opération Promesse Vraie 2»',
 'Le 1er octobre 2024, l''Iran a lancé une seconde vague d''attaques directes contre Israël, tirant environ 180 missiles balistiques. Téhéran a présenté cette offensive comme une réponse à l''élimination de Hassan Nasrallah, secrétaire général du Hezbollah, tué lors d''une frappe israélienne à Beyrouth le 27 septembre 2024, ainsi qu''à l''assassinat d''Ismaïl Haniyeh en juillet. Plusieurs missiles ont atteint des zones habitées dans le sud et le centre d''Israël, faisant quelques blessés. Les États-Unis ont participé à l''interception et ont promis de « soutenir pleinement » la défense israélienne.',
 'iran-missiles-balistiques-israel-octobre-2024-operation-promesse-vraie-2',
 302100, TRUE, '2024-10-01 21:45:00'),

(15, 2, 2,
 'Israël frappe l''Iran : des sites militaires détruits dans plusieurs provinces',
 'Le 26 octobre 2024, Israël a mené sa riposte la plus significative à ce jour contre l''Iran, bombardant des installations militaires dans les provinces de Téhéran, Khuzestan et Ilam. Des systèmes de défense aérienne S-300 et des dépôts de missiles ont été détruits. Les frappes ont duré plusieurs heures et ont impliqué des dizaines d''avions de combat F-35. Le gouvernement israélien a averti qu''il était «prêt à aller plus loin» si l''Iran poursuivait ses attaques. Cette opération marque une étape qualitativement nouvelle dans la confrontation directe entre les deux puissances.',
 'israel-frappe-iran-sites-militaires-octobre-2024',
 278900, TRUE, '2024-10-26 06:30:00'),

(18, 2, 3,
 'Programme nucléaire iranien : les États-Unis renforcent leurs sanctions',
 'En décembre 2024, le département du Trésor américain a annoncé de nouvelles sanctions visant 35 entités et individus liés au programme nucléaire et balistique de l''Iran. Washington s''inquiète de la hausse de l''enrichissement d''uranium à 60%, un seuil jugé «préoccupant» par l''AIEA. Des responsables israéliens ont relancé les discussions sur une éventuelle frappe préventive contre les installations nucléaires de Natanz et Fordow, ravivant le débat international sur la prolifération nucléaire au Moyen-Orient.',
 'programme-nucleaire-iran-sanctions-usa-decembre-2024',
 143200, TRUE, '2024-12-10 14:00:00'),

(20, 2, 5,
 'Trump menace l''Iran de frappes directes si les négociations échouent',
 'Peu après son retour à la Maison-Blanche en janvier 2025, le président Donald Trump a adressé un avertissement direct à Téhéran : si l''Iran ne reprend pas les négociations sur son programme nucléaire dans un délai de 60 jours, les États-Unis envisageront des frappes militaires. Trump a également annoncé le rétablissement d''une politique de «pression maximale» avec de nouvelles sanctions économiques. L''Iran a rejeté ces ultimatums, les qualifiant de «chantage politique».',
 'trump-menace-iran-frappes-negociations-nucleaire-2025',
 189450, TRUE, '2025-01-20 17:30:00'),

-- ── POLITIQUE ──────────────────────────────────────────────

(1,  4, 4,
 'Bombardement du consulat iranien à Damas : Téhéran accuse Israël',
 'Le 1er avril 2024, un bâtiment annexe du consulat iranien à Damas, en Syrie, a été détruit par une frappe aérienne. Parmi les victimes figurent plusieurs officiers des Gardiens de la Révolution, dont le général Mohammad Reza Zahedi, un haut commandant des forces Qods en Syrie et au Liban. L''Iran a formellement accusé Israël d''être responsable et a promis une riposte. Cet événement est considéré comme le déclencheur direct de l''attaque iranienne contre Israël du 14 avril 2024.',
 'bombardement-consulat-iranien-damas-syrie-2024',
 112340, TRUE, '2024-04-01 16:00:00'),

(6,  4, 6,
 'Masoud Pezeshkian élu président de la République islamique d''Iran',
 'Le réformiste Masoud Pezeshkian a remporté l''élection présidentielle iranienne du 5 juillet 2024 face au conservateur Saïd Jalili, avec 54% des voix. Sa victoire représente un signal d''ouverture relative, notamment sur la question du dossier nucléaire et des relations avec l''Occident. Cependant, le pouvoir réel reste concentré entre les mains du Guide suprême Ali Khamenei. Pezeshkian a été investi le 30 juillet 2024, le lendemain de l''assassinat d''Ismaïl Haniyeh à Téhéran.',
 'pezeshkian-elu-president-iran-reformiste-2024',
 87600, TRUE, '2024-05-20 10:00:00'),

(11, 4, 4,
 'L''Iran face à l''isolement diplomatique après la mort de Nasrallah',
 'L''élimination du secrétaire général du Hezbollah Hassan Nasrallah le 27 septembre 2024 à Beyrouth a plongé l''Iran dans une position diplomatique difficile. Le Hezbollah, considéré comme le principal «bras armé» de Téhéran dans la région, est décapité de son chef historique. Plusieurs pays arabes ont maintenu une prudente distance vis-à-vis de l''Iran. La Russie et la Chine, alliés informels de Téhéran, ont appelé à «la retenue», sans soutien explicite à une nouvelle offensive iranienne.',
 'iran-isolement-diplomatique-mort-nasrallah-2024',
 76500, TRUE, '2024-09-17 13:30:00'),

(16, 4, 6,
 'Élection de Trump : que signifie-t-elle pour l''Iran ?',
 'La victoire de Donald Trump lors de l''élection présidentielle américaine du 5 novembre 2024 est accueillie avec inquiétude à Téhéran. Sous son premier mandat (2017-2021), Trump avait retiré les États-Unis de l''accord nucléaire JCPOA et imposé une politique de pression maximale économique. L''Iran s''attend à un renforcement des sanctions et à un soutien américain accru envers Israël. Les autorités iraniennes ont néanmoins appelé à « la prudence » et indiqué rester ouvertes à « des négociations dans le respect de leur souveraineté ».',
 'election-trump-impact-iran-politique-2024',
 134780, TRUE, '2024-11-05 22:00:00'),

(22, 4, 3,
 'Négociations indirectes Iran-États-Unis à Oman : espoir fragile',
 'En mars 2025, des sources diplomatiques ont confirmé la tenue de pourparlers indirects entre l''Iran et les États-Unis à Mascate, en Oman, portant sur le dossier nucléaire. L''Iran aurait proposé un gel temporaire de l''enrichissement à 60% en échange d''une levée partielle des sanctions. Washington n''a pas confirmé officiellement les discussions, mais le secrétaire d''État Marco Rubio a évoqué «des voies diplomatiques encore possibles». Le Congrès américain reste sceptique quant à toute concession.',
 'negociations-iran-etats-unis-oman-nucleaire-2025',
 98200, TRUE, '2025-03-01 09:00:00'),

-- ── ACTUALITÉS ─────────────────────────────────────────────

(3,  1, 5,
 'Nuit d''interceptions : comment Iron Dome a repoussé l''attaque iranienne',
 'Pendant plus de cinq heures dans la nuit du 13 au 14 avril 2024, les systèmes de défense aérienne israéliens ont travaillé sans relâche pour intercepter les vagues successives de drones et de missiles iraniens. Le système multicouche israélien — Iron Dome, David''s Sling et Arrow 3 — a fonctionné en coordination avec des chasseurs F-15 et F-35. Des destroyers américains en Méditerranée ont également abattu plusieurs missiles balistiques. Selon les autorités israéliennes, 99% des projectiles ont été neutralisés. Le coût de l''interception est estimé à plus d''un milliard de dollars.',
 'iron-dome-interception-attaque-iranienne-avril-2024',
 159870, TRUE, '2024-04-14 08:00:00'),

(4,  1, 6,
 'Réactions mondiales après l''attaque iranienne sur Israël',
 'L''attaque iranienne du 14 avril 2024 a provoqué une vague de condamnations internationales. Les États-Unis, le Royaume-Uni, la France et l''Allemagne ont unanimement condamné l''agression. Joe Biden a convoqué en urgence le G7 et affirmé son «soutien indéfectible» à Israël. La Russie et la Chine ont appelé à «la désescalade» sans condamner directement l''Iran. La Jordanie, qui a participé à l''interception de drones iraniens traversant son espace aérien, s''est retrouvée dans une position diplomatique délicate face à ses voisins arabes.',
 'reactions-mondiales-attaque-iranienne-israel-2024',
 103400, TRUE, '2024-04-15 12:00:00'),

(9,  1, 2,
 'Hezbollah affaibli, Iran sous pression : la carte du Moyen-Orient se redessine',
 'L''automne 2024 marque un tournant géopolitique majeur. L''opération israélienne «Flèches du Nord» a sévèrement dégradé les capacités militaires du Hezbollah au Liban. La mort de Nasrallah, l''élimination de plusieurs commandants et la destruction de nombreux dépôts d''armes ont fragilisé ce pilier de l''«Axe de la Résistance» iranien. Simultanément, les Houthis au Yémen continuent de tirer des missiles sur des navires en mer Rouge, forçant un rerouting massif du commerce mondial. L''Iran, affaibli sur ses fronts périphériques, fait face à une crise stratégique sans précédent.',
 'hezbollah-affaibli-iran-sous-pression-moyen-orient-2024',
 124500, TRUE, '2024-08-05 10:30:00'),

(19, 1, 5,
 'Cessez-le-feu à Gaza : l''Iran réclame la levée du blocus',
 'Le 15 janvier 2025, un accord de cessez-le-feu entre Israël et le Hamas a été conclu sous médiation qatarie, américaine et égyptienne, prévoyant la libération progressive d''otages contre des prisonniers palestiniens. L''Iran, qui soutient le Hamas, a salué cet accord comme «une victoire de la résistance», tout en réclamant la levée totale du blocus de Gaza. Des analystes estiment cependant que cet accord affaiblit la position de négociation iranienne, privant Téhéran d''un levier de pression régional important.',
 'cessez-le-feu-gaza-iran-levee-blocus-2025',
 167300, TRUE, '2025-01-15 15:00:00'),

(23, 1, 4,
 'Iran : des manifestations éclatent sur fond de crise économique et de tensions militaires',
 'En mars 2025, des rassemblements ont eu lieu dans plusieurs villes iraniennes, dont Téhéran, Ispahan et Chiraz, dénonçant la hausse du coût de la vie, la dépréciation du rial iranien et les dépenses militaires jugées excessives. La monnaie nationale a perdu plus de 30% de sa valeur depuis le début des tensions régionales en 2024. Le gouvernement a répondu par un déploiement renforcé des Bassidjis. Des militants des droits de l''homme ont signalé plusieurs arrestations de manifestants.',
 'manifestations-iran-crise-economique-tensions-militaires-2025',
 89700, TRUE, '2025-03-22 11:00:00'),

-- ── HUMANITAIRE ────────────────────────────────────────────

(7,  3, 6,
 'Gaza : bilan humanitaire catastrophique après neuf mois de guerre',
 'Au début du mois de juin 2024, le bilan humain à Gaza depuis le 7 octobre 2023 dépasse les 36 000 morts selon le ministère de la Santé du gouvernement de Gaza, dont une majorité de femmes et d''enfants. Plus de 1,7 million de personnes ont été déplacées à l''intérieur du territoire. L''ONU parle d''une «catastrophe humanitaire de grande ampleur». L''accès à l''eau potable, à la nourriture et aux soins médicaux est extrêmement limité. L''Iran a envoyé une aide humanitaire via des ONG mais celle-ci reste bloquée aux frontières.',
 'gaza-bilan-humanitaire-neuf-mois-guerre-2024',
 198450, TRUE, '2024-06-03 09:00:00'),

(10, 3, 6,
 'Liban : des dizaines de milliers de déplacés après les frappes israéliennes',
 'En septembre et octobre 2024, les opérations militaires israéliennes au Liban, ciblant les infrastructures du Hezbollah, ont provoqué le déplacement d''environ 1,2 million de Libanais selon le Haut-Commissariat des Nations unies pour les réfugiés (HCR). Des quartiers entiers de la banlieue sud de Beyrouth (Dahiyeh) ont été rasés. L''Iran a condamné ces frappes mais n''a pas envoyé d''aide directe en raison des risques d''interception. La communauté internationale a versé des fonds d''urgence, jugés insuffisants par les ONG présentes sur le terrain.',
 'liban-deplaces-frappes-israeliennes-hezbollah-2024',
 145600, TRUE, '2024-09-17 16:00:00'),

(17, 3, 4,
 'Corridors humanitaires au Liban : l''Iran exige une enquête internationale',
 'Suite au cessez-le-feu fragile au Liban en novembre 2024, l''Iran a demandé l''ouverture d''une enquête internationale sur les frappes ayant touché des infrastructures civiles, notamment des hôpitaux et des écoles dans la banlieue sud de Beyrouth. Téhéran a également réclamé une aide internationale pour la reconstruction des zones détruites. Ces demandes ont été relayées auprès du Conseil de sécurité de l''ONU par l''ambassadeur iranien, sans aboutir à une résolution contraignante en raison du veto américain.',
 'corridors-humanitaires-liban-iran-enquete-internationale-2024',
 67400, TRUE, '2024-11-19 14:30:00'),

-- ── ÉCONOMIE ───────────────────────────────────────────────

(12, 6, 5,
 'Sanctions américaines : l''économie iranienne sous forte pression',
 'Au troisième trimestre 2024, l''économie iranienne montre des signes de stress importants. L''inflation dépasse 40% et le rial a atteint un plus bas historique face au dollar. Les exportations pétrolières, principal source de revenus de l''État, sont perturbées par les nouvelles sanctions américaines ciblant les acheteurs asiatiques, notamment chinois. La Banque centrale iranienne a tenté de stabiliser le marché des changes avec des injections de devises, mais l''effet reste limité. Des économistes locaux avertissent d''un possible déficit budgétaire record en 2025.',
 'sanctions-americaines-economie-iranienne-pression-2024',
 78900, TRUE, '2024-09-17 10:00:00'),

(14, 6, 3,
 'Pétrole iranien : la Chine continue ses achats malgré les sanctions',
 'Malgré le durcissement des sanctions américaines à l''automne 2024, la Chine continue d''importer du pétrole iranien à des prix fortement décotés, représentant environ 90% des exportations pétrolières de l''Iran. Ces échanges s''effectuent en dehors du système financier international (SWIFT), via des transactions en yuan et des réseaux parallèles. Washington a menacé de sanctions secondaires contre les raffineries chinoises concernées. Pékin a rejeté ces mesures comme «une ingérence unilatérale illégale».',
 'petrole-iranien-chine-achats-malgre-sanctions-2024',
 92100, TRUE, '2024-10-07 11:00:00'),

(21, 6, 5,
 'Iran : le rial s''effondre, la population subit une inflation record',
 'En février 2025, le taux de change du rial iranien a atteint 900 000 rials pour un dollar américain sur le marché noir, contre 500 000 fin 2023. Cette dépréciation massive érode le pouvoir d''achat des ménages iraniens, déjà fragilisés par des années de sanctions. Les prix des denrées alimentaires ont augmenté de plus de 60% en un an. Le gouvernement Pezeshkian a annoncé un plan de soutien aux foyers les plus défavorisés, mais les économistes jugent les mesures insuffisantes face à l''ampleur de la crise.',
 'iran-rial-effondrement-inflation-record-2025',
 113400, TRUE, '2025-02-08 08:00:00'),

-- ── SPORT ──────────────────────────────────────────────────

(17, 5, 7,
 'Qualification de l''Iran pour la Coupe du Monde 2026 : un moment d''unité nationale',
 'Malgré un contexte géopolitique tendu, l''équipe nationale iranienne de football a officialisé sa qualification pour la Coupe du Monde 2026, qui se tiendra aux États-Unis, au Canada et au Mexique. La victoire décisive face à l''Ouzbékistan (2-0) le 19 novembre 2024 a suscité des scènes de liesse populaire dans les rues de Téhéran, rappelant que le sport conserve sa capacité à rassembler au-delà des fractures politiques. La FIFA a confirmé la participation iranienne malgré des pressions de certaines fédérations occidentales.',
 'iran-qualification-coupe-monde-2026-football',
 201300, TRUE, '2024-11-19 20:00:00');

-- ============================================================
-- 4. IMAGES DES ARTICLES
-- ============================================================

INSERT INTO fait_article_image (id_article, image_url, alt_text, is_main) VALUES

-- Article 1 : Attaque drones avril 2024
(1, 'uploads/2024/04/iran-attaque-drones-principale.jpg',   'Ciel illuminé par des drones et missiles iraniens en route vers Israël',        TRUE),
(1, 'uploads/2024/04/iron-dome-interception.jpg',           'Missiles intercepteurs du système Iron Dome en action',                          FALSE),

-- Article 2 : Frappe Ispahan
(2, 'uploads/2024/04/ispahan-apres-frappe.jpg',             'Vue aérienne d''Ispahan après la frappe israélienne',                            TRUE),

-- Article 3 : Assassinat Haniyeh
(3, 'uploads/2024/07/haniyeh-portrait.jpg',                 'Portrait officiel d''Ismaïl Haniyeh, chef politique du Hamas',                   TRUE),
(3, 'uploads/2024/07/teheran-reaction-foule.jpg',           'Foule en deuil à Téhéran après l''assassinat de Haniyeh',                       FALSE),

-- Article 4 : Opération Promesse Vraie 2
(4, 'uploads/2024/10/missiles-balistiques-iran.jpg',        'Lancement de missiles balistiques depuis le territoire iranien',                 TRUE),
(4, 'uploads/2024/10/explosion-israel-sud.jpg',             'Explosion visible dans le ciel du sud d''Israël',                               FALSE),

-- Article 5 : Frappes israéliennes octobre 2024
(5, 'uploads/2024/10/frappes-israel-iran-carte.jpg',        'Carte des zones frappées par Israël en Iran en octobre 2024',                   TRUE),
(5, 'uploads/2024/10/f35-decolle-tsahal.jpg',               'Avion de combat F-35 de Tsahal au décollage',                                   FALSE),

-- Article 6 : Programme nucléaire
(6, 'uploads/2024/12/natanz-installation-nucleaire.jpg',    'Vue satellite de l''installation nucléaire de Natanz, Iran',                    TRUE),

-- Article 7 : Trump menace Iran
(7, 'uploads/2025/01/trump-discours-iran.jpg',              'Le président Trump lors de son discours sur la politique envers l''Iran',        TRUE),

-- Article 8 : Consulat Damas
(8, 'uploads/2024/04/consulat-iranien-damas-ruines.jpg',    'Ruines du bâtiment consulaire iranien à Damas après la frappe',                 TRUE),

-- Article 9 : Pezeshkian élu
(9, 'uploads/2024/05/pezeshkian-victoire.jpg',              'Masoud Pezeshkian célèbre sa victoire à l''élection présidentielle iranienne',  TRUE),

-- Article 10 : Iran isolement diplomatique
(10, 'uploads/2024/09/iran-onu-session.jpg',                'Représentant iranien lors d''une session d''urgence au Conseil de sécurité ONU', TRUE),

-- Article 11 : Élection Trump impact Iran
(11, 'uploads/2024/11/trump-khamenei-montage.jpg',          'Montage illustrant l''antagonisme Trump-Khamenei',                              TRUE),

-- Article 12 : Négociations Oman
(12, 'uploads/2025/03/oman-diplomatie-iran-usa.jpg',        'Bâtiment du ministère des Affaires étrangères d''Oman à Mascate',               TRUE),

-- Article 13 : Iron Dome interception
(13, 'uploads/2024/04/iron-dome-systeme-complet.jpg',       'Schéma du système de défense multicouche israélien Iron Dome',                  TRUE),
(13, 'uploads/2024/04/interception-nuit.jpg',               'Traînées lumineuses des missiles intercepteurs dans le ciel nocturne israélien', FALSE),

-- Article 14 : Réactions mondiales
(14, 'uploads/2024/04/g7-urgence-reunion.jpg',              'Réunion d''urgence du G7 convoquée par Biden après l''attaque iranienne',        TRUE),

-- Article 15 : Hezbollah affaibli
(15, 'uploads/2024/08/beyrouth-dahiyeh-destruction.jpg',    'Vue de la banlieue sud de Beyrouth (Dahiyeh) après les frappes israéliennes',   TRUE),

-- Article 16 : Cessez-le-feu Gaza
(16, 'uploads/2025/01/accord-cessez-le-feu-gaza.jpg',       'Signature de l''accord de cessez-le-feu à Gaza sous médiation internationale',  TRUE),
(16, 'uploads/2025/01/gazaouis-retour.jpg',                 'Habitants de Gaza rentrant dans leurs quartiers après le cessez-le-feu',        FALSE),

-- Article 17 : Manifestations Iran
(17, 'uploads/2025/03/manifestants-teheran.jpg',            'Manifestants dans les rues de Téhéran dénonçant la crise économique',           TRUE),

-- Article 18 : Bilan humanitaire Gaza
(18, 'uploads/2024/06/gaza-aide-humanitaire.jpg',           'Convoi d''aide humanitaire attendant d''entrer dans la bande de Gaza',          TRUE),
(18, 'uploads/2024/06/gaza-enfants-deplaces.jpg',           'Enfants déplacés dans un abri de fortune à Rafah, Gaza',                       FALSE),

-- Article 19 : Déplacés Liban
(19, 'uploads/2024/09/liban-deplaces-beyrouth.jpg',         'Familles libanaises fuyant les bombardements vers le nord du pays',             TRUE),

-- Article 20 : Corridors humanitaires Liban
(20, 'uploads/2024/11/onu-conseil-securite-liban.jpg',      'Session du Conseil de sécurité de l''ONU sur la situation au Liban',            TRUE),

-- Article 21 : Sanctions économiques
(21, 'uploads/2024/09/iran-sanctions-economie.jpg',         'Tableau de bord économique illustrant la chute du rial iranien',                TRUE),

-- Article 22 : Pétrole iranien Chine
(22, 'uploads/2024/10/petrole-iran-tanker.jpg',             'Pétrolier transportant du pétrole iranien vers un port asiatique',              TRUE),

-- Article 23 : Rial effondrement
(23, 'uploads/2025/02/iran-marche-change-noir.jpg',         'Bureau de change à Téhéran affichant le taux du rial face au dollar',           TRUE),

-- Article 24 : Qualification foot Iran
(24, 'uploads/2024/11/iran-football-qualification.jpg',     'Joueurs iraniens célébrant leur qualification pour la Coupe du Monde 2026',     TRUE),
(24, 'uploads/2024/11/teheran-fete-foot.jpg',               'Scènes de fête dans les rues de Téhéran après la qualification',               FALSE);
