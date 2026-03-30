<?php
// ─────────────────────────────────────────────
// Page : Actualité Générale (et toute catégorie)
// Chemin : www/front/pages/pages/actu_generale.php
// ─────────────────────────────────────────────

// $pdo est injecté par modules.php → db.php
// Les fonctions sont disponibles via fonction.php

// ── Paramètres URL ──────────────────────────
$slugCategorie = isset($_GET['categorie'])
    ? preg_replace('/[^a-z0-9\-]/i', '', $_GET['categorie'])
    : null;

$currentPage = isset($_GET['p']) && is_numeric($_GET['p'])
    ? max(1, (int) $_GET['p'])
    : 1;

$perPage = 9;

// ── Données BDD ─────────────────────────────
$hero        = getArticleHero($pdo, $slugCategorie);
$heroId      = $hero ? $hero['id_article'] : null;
$total       = countArticlesByCategorie($pdo, $slugCategorie, $heroId);
$totalPages  = $total > 0 ? (int) ceil($total / $perPage) : 1;
$articles    = getArticlesByCategorie($pdo, $slugCategorie, $currentPage, $perPage, $heroId);
$tendances   = getTendances($pdo, 6);
$aNePasManquer = getANePasManquer($pdo, $heroId, 3);

// ── Titre de la page ────────────────────────
$categories    = getCategories($pdo);
$titrePage     = 'Actualité Générale';
foreach ($categories as $cat) {
    if ($cat['slug'] === $slugCategorie) {
        $titrePage = htmlspecialchars($cat['nom']);
        break;
    }
}

// ── Helper URL pagination ───────────────────
function paginationUrl($p, $slug) {
    $base = '?page=actu_generale';
    if ($slug) $base .= '&categorie=' . urlencode($slug);
    return $base . '&p=' . $p;
}
?>

<!-- BREADCRUMB -->
<div class="breadcrumb">
    <a href="/front/">Accueil</a>
    <span>›</span>
    <strong><?= $titrePage ?></strong>
</div>

<!-- MAIN CONTENT -->
<div class="container">
    <main>

        <div class="section-header">
            <h1><?= $titrePage ?></h1>
            <span class="live-badge">LIVE</span>
        </div>

        <?php if ($hero): ?>
        <!-- ── HERO ─────────────────────────────── -->
        <a href="?page=article&slug=<?= urlencode($hero['article_slug']) ?>" class="hero-article">

            <?php if (!empty($hero['image_url'])): ?>
                <img
                    class="hero-img"
                    src="/front/assets/<?= htmlspecialchars($hero['image_url']) ?>"
                    alt="<?= htmlspecialchars($hero['alt_text'] ?? $hero['titre']) ?>"
                    loading="eager"
                />
            <?php else: ?>
                <div class="hero-img img-ph img-ph-1"></div>
            <?php endif; ?>

            <div class="hero-content">
                <div>
                    <span class="tag"><?= htmlspecialchars($hero['categorie_nom']) ?></span>
                </div>
                <h2><?= htmlspecialchars($hero['titre']) ?></h2>
                <p><?= truncate($hero['contenu'], 180) ?></p>
                <div class="meta">
                    <span><?= formatDateRelative($hero['date_publication']) ?></span>
                    <span class="sep">|</span>
                    <span><?= htmlspecialchars($hero['categorie_nom']) ?></span>
                </div>
            </div>
        </a>
        <?php endif; ?>

        <!-- ── GRILLE ARTICLES ──────────────────── -->
        <?php if (!empty($articles)): ?>
        <div class="articles-grid">
            <?php foreach ($articles as $index => $art): ?>
            <a href="?page=article&slug=<?= urlencode($art['article_slug']) ?>" class="article-item">

                <?php if (!empty($art['image_url'])): ?>
                    <img
                        class="article-thumb"
                        src="/front/assets/<?= htmlspecialchars($art['image_url']) ?>"
                        alt="<?= htmlspecialchars($art['alt_text'] ?? $art['titre']) ?>"
                        loading="lazy"
                    />
                <?php else: ?>
                    <div class="article-thumb img-ph img-ph-<?= ($index % 8) + 1 ?>"></div>
                <?php endif; ?>

                <div class="article-body">
                    <span class="tag"><?= htmlspecialchars($art['categorie_nom']) ?></span>
                    <h3><?= htmlspecialchars($art['titre']) ?></h3>
                    <p><?= truncate($art['contenu'], 110) ?></p>
                    <div class="meta">
                        <span><?= formatDateRelative($art['date_publication']) ?></span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="empty-state">
            <p>Aucun article disponible pour cette catégorie.</p>
        </div>
        <?php endif; ?>

        <!-- ── PAGINATION ───────────────────────── -->
        <?php if ($totalPages > 1): ?>
        <div class="pagination">

            <?php if ($currentPage > 1): ?>
            <a href="<?= paginationUrl($currentPage - 1, $slugCategorie) ?>" class="pagination-btn">‹</a>
            <?php endif; ?>

            <?php
            // Affiche au max 5 numéros centrés sur la page courante
            $start = max(1, $currentPage - 2);
            $end   = min($totalPages, $currentPage + 2);

            if ($start > 1): ?>
                <a href="<?= paginationUrl(1, $slugCategorie) ?>" class="pagination-btn">1</a>
                <?php if ($start > 2): ?><span class="pagination-ellipsis">…</span><?php endif; ?>
            <?php endif; ?>

            <?php for ($i = $start; $i <= $end; $i++): ?>
            <a
                href="<?= paginationUrl($i, $slugCategorie) ?>"
                class="pagination-btn <?= $i === $currentPage ? 'active' : '' ?>"
            ><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($end < $totalPages): ?>
                <?php if ($end < $totalPages - 1): ?><span class="pagination-ellipsis">…</span><?php endif; ?>
                <a href="<?= paginationUrl($totalPages, $slugCategorie) ?>" class="pagination-btn"><?= $totalPages ?></a>
            <?php endif; ?>

            <?php if ($currentPage < $totalPages): ?>
            <a href="<?= paginationUrl($currentPage + 1, $slugCategorie) ?>" class="pagination-btn">›</a>
            <?php endif; ?>

        </div>
        <?php endif; ?>

    </main>

    <!-- ── SIDEBAR ──────────────────────────── -->
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
                            <a href="?page=article&slug=<?= urlencode($t['article_slug']) ?>">
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
                        <a
                            href="?page=article&slug=<?= urlencode($item['article_slug']) ?>"
                            style="display:flex;gap:10px;align-items:center"
                        >
                            <?php if (!empty($item['image_url'])): ?>
                                <img
                                    src="/front/assets/<?= htmlspecialchars($item['image_url']) ?>"
                                    alt="<?= htmlspecialchars($item['alt_text'] ?? $item['titre']) ?>"
                                    style="width:60px;height:45px;border-radius:4px;flex-shrink:0;object-fit:cover"
                                    loading="lazy"
                                />
                            <?php else: ?>
                                <div style="width:60px;height:45px;border-radius:4px;flex-shrink:0"
                                     class="img-ph img-ph-<?= ($idx % 8) + 1 ?>"></div>
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
