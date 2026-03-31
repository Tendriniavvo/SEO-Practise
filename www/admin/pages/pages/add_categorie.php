<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $slug = $_POST['slug'] ?? '';

    try {
        $result = createAdminCategory($pdo, $nom, $slug);
        $success = "Catégorie ajoutée avec succès (slug: " . htmlspecialchars($result['slug']) . ").";
    } catch (Exception $e) {
        $error = "Erreur lors de l'ajout : " . $e->getMessage();
    }
}

$categories = getAdminCategories($pdo);
?>

<div class="admin-form-container">
    <h1>Ajouter une catégorie</h1>

    <?php if (isset($error)): ?>
        <div style="background: #fff0f2; color: #d32f2f; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #ffccd2;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div style="background: #edf7ed; color: #1e7e34; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            <?= $success ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="nom">Nom de la catégorie :</label>
            <input type="text" id="nom" name="nom" required placeholder="Ex: Géopolitique" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="slug">Slug (optionnel) :</label>
            <input type="text" id="slug" name="slug" placeholder="Ex: geopolitique" value="<?= htmlspecialchars($_POST['slug'] ?? '') ?>">
            <small style="color:#777; margin-top:5px; display:block;">Si vide, le slug est généré automatiquement à partir du nom.</small>
        </div>

        <div style="margin-top: 30px; display: flex; align-items: center; gap: 20px;">
            <button type="submit" class="btn-admin">💾 Enregistrer la catégorie</button>
            <a href="index.php?page=dashboard" style="color: #666; font-size: 14px; text-decoration: none; font-weight: 600;">⬅️ Annuler et retour</a>
        </div>
    </form>

    <div style="margin-top: 40px;">
        <h2 style="font-size: 20px; margin-bottom: 15px;">Catégories existantes</h2>

        <?php if (!empty($categories)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Slug</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $cat): ?>
                        <tr>
                            <td><?= (int) $cat['id_categorie'] ?></td>
                            <td><?= htmlspecialchars($cat['nom']) ?></td>
                            <td><?= htmlspecialchars($cat['slug']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="color:#666;">Aucune catégorie disponible.</p>
        <?php endif; ?>
    </div>
</div>
