<?php
// Chemin : www/front/pages/pages/article.php

$slug = isset($_GET['slug']) ? $_GET['slug'] : null;

$article = null;
if ($slug) {
    $article = getArticleBySlug($pdo, $slug);
    if ($article) {
        incrementArticleViews($pdo, $article['id_article']);
    }
}

if (!$article) {
    echo "<div class='container'><main><h1>Article introuvable</h1><p>Cet article n'existe pas ou n'est plus disponible.</p></main></div>";
    return;
}

$renderedContent = $article['contenu'];
if (!empty($article['image_url']) && !empty($renderedContent)) {
    $mainImagePath = parse_url($article['image_url'], PHP_URL_PATH) ?: $article['image_url'];

    $domContent = new DOMDocument();
    libxml_use_internal_errors(true);
    $domContent->loadHTML('<?xml encoding="utf-8" ?><div id="content-root">' . $renderedContent . '</div>');
    libxml_clear_errors();

    $root = $domContent->getElementById('content-root');
    if ($root instanceof DOMElement) {
        $toRemove = [];
        $imgNodes = $root->getElementsByTagName('img');

        foreach ($imgNodes as $imgNode) {
            if (!($imgNode instanceof DOMElement)) {
                continue;
            }

            $src = trim((string) $imgNode->getAttribute('src'));
            if ($src === '') {
                continue;
            }

            $srcPath = parse_url($src, PHP_URL_PATH) ?: $src;
            if ($srcPath === $mainImagePath) {
                $toRemove[] = $imgNode;
            }
        }

        foreach ($toRemove as $node) {
            if ($node->parentNode) {
                $node->parentNode->removeChild($node);
            }
        }

        $contentHtml = '';
        foreach ($root->childNodes as $childNode) {
            $contentHtml .= $domContent->saveHTML($childNode);
        }
        $renderedContent = $contentHtml;
    }
}

// Sidebar
$tendances = getTendances($pdo, 6);
$aNePasManquer = getANePasManquer($pdo, $article['id_article'], 3);
?>

<div class="breadcrumb">
    <a href="/front/">Accueil</a>
    <span>›</span>
    <a href="/front/categorie/<?= urlencode($article['categorie_slug']) ?>"><?= htmlspecialchars($article['categorie_nom']) ?></a>
    <span>›</span>
    <strong><?= htmlspecialchars($article['titre']) ?></strong>
</div>

<div class="container">
    <main>
        <article class="full-article">
            <header class="article-header" style="margin-bottom: 24px;">
                <span class="tag" style="margin-bottom: 10px; display: inline-block;"><?= htmlspecialchars($article['categorie_nom']) ?></span>
                <h1 style="font-size: 32px; font-weight: 800; line-height: 1.2; margin-bottom: 12px; font-family: 'Lora', serif;">
                    <?= htmlspecialchars($article['titre']) ?>
                </h1>
                <div class="meta" style="font-size: 13px; color: #666; margin-bottom: 20px;">
                    Publié le <?= formatDateRelative($article['date_publication']) ?>
                    <span class="sep">|</span>
                    <?= (int)$article['nb_vues'] ?> vues
                </div>
            </header>

            <?php if (!empty($article['image_url'])): ?>
                <figure style="margin-bottom: 30px;">
                    <img 
                        src="<?= htmlspecialchars(frontImageUrl($article['image_url'])) ?>" 
                        alt="<?= htmlspecialchars($article['alt_text'] ?? $article['titre']) ?>" 
                        style="width: 100%; max-height: 500px; object-fit: cover; border-radius: 8px;"
                    />
                </figure>
            <?php endif; ?>

            <!-- Style spécial pour encadrer le contenu riche issu de TinyMCE -->
            <style>
                .tinymce-content {
                    font-size: 16px;
                    line-height: 1.8;
                    color: #333;
                    font-family: 'Lora', serif;
                }
                .tinymce-content p {
                    margin-bottom: 20px;
                }
                .tinymce-content h1, .tinymce-content h2, .tinymce-content h3, .tinymce-content h4 {
                    margin-top: 30px;
                    margin-bottom: 15px;
                    color: var(--dark);
                    font-family: 'Sora', sans-serif;
                    font-weight: 700;
                    line-height: 1.3;
                }
                .tinymce-content img {
                    max-width: 100%; /* Empêche l'image de déborder */
                    height: auto;    /* Garde les proportions */
                    border-radius: 6px;
                    margin: 20px 0;
                    display: block;  /* Au cas où l'image serait inline */
                    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                }
                .tinymce-content a {
                    color: var(--red);
                    text-decoration: underline;
                }
                .tinymce-content ul, .tinymce-content ol {
                    margin-left: 40px;
                    margin-bottom: 20px;
                }
                .tinymce-content blockquote {
                    border-left: 4px solid var(--red);
                    padding-left: 15px;
                    margin-left: 0;
                    font-style: italic;
                    color: #555;
                    background: var(--light);
                    padding: 10px 15px;
                    border-radius: 0 6px 6px 0;
                }
            </style>

            <!-- Affichage du contenu de l'article sans altération pour respecter les balises HTML -->
            <div class="tinymce-content">
                <?= $renderedContent ?>
            </div>
        </article>
    </main>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <!-- Tendances -->
        <div class="widget">
            <div class="widget-header">🔥 Tendances</div>
            <div class="widget-body">
                <ul class="trending-list">
                    <?php if (!empty($tendances)): ?>
                        <?php foreach ($tendances as $i => $t): ?>
                        <li>
                            <span class="trend-num"><?= $i + 1 ?></span>
                            <a href="/front/article/<?= urlencode($t['article_slug']) ?>">
                                <?= htmlspecialchars($t['titre']) ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li><span>Aucune tendance disponible.</span></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- À ne pas manquer -->
        <div class="widget">
            <div class="widget-header">📰 À ne pas manquer</div>
            <div class="widget-body">
                <div style="display:flex;flex-direction:column;gap:12px">
                    <?php if (!empty($aNePasManquer)): ?>
                        <?php foreach ($aNePasManquer as $idx => $item): ?>
                        <a href="/front/article/<?= urlencode($item['article_slug']) ?>" style="display:flex;gap:10px;align-items:center">
                            <?php if (!empty($item['image_url'])): ?>
                                <img src="<?= htmlspecialchars(frontImageUrl($item['image_url'])) ?>" alt="<?= htmlspecialchars($item['alt_text'] ?? $item['titre']) ?>" style="width:60px;height:45px;border-radius:4px;flex-shrink:0;object-fit:cover" loading="lazy"/>
                            <?php else: ?>
                                <div style="width:60px;height:45px;border-radius:4px;flex-shrink:0" class="img-ph img-ph-<?= ($idx % 8) + 1 ?>"></div>
                            <?php endif; ?>
                            <span style="font-size:13px;font-weight:600;line-height:1.35">
                                <?= htmlspecialchars(truncate($item['titre'], 60)) ?>
                            </span>
                        </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </aside>
</div>
