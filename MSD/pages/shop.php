<?php
require("../traitements/init_session.php");
try {
    require("../traitements/db.php");
    $req = "SELECT * FROM produits";
    $stmt = $conn->prepare($req);
    $stmt->execute();
    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>MSD - Boutique</title>
    <link rel="icon" type="image/x-icon" href="../media/favicon.ico">
    <link rel="stylesheet" type="text/css" href="../style/main.css">
    <link rel="stylesheet" type="text/css" href="../style/navbar.css">
    <link rel="stylesheet" type="text/css" href="../style/shop.css">
    <style>
        <?php foreach ($produits as $index => $produit): ?>
        .item:nth-child(<?= $index + 1 ?>):hover img {
            content: url("../media/merch/<?= htmlspecialchars($produit['image_hover']) ?>");
        }
        <?php endforeach; ?>
    </style>
</head>

<body>
    <?php require_once 'navbar.php'; ?>
    <?php if (isset($_SESSION['notification'])): ?>
        <div class="notif">
            <?= htmlspecialchars($_SESSION['notification']) ?>
        </div>
        <?php unset($_SESSION['notification']); ?>
    <?php endif; ?>

    <div class="conteneur-shop">
        <div class="shop-grid">
            <?php foreach ($produits as $index => $produit): ?>
                <div class="item" id="item<?= $index + 1 ?>">
                    <a href="#modal<?= $index + 1 ?>">
                        <img src="../media/merch/<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>">
                        <p><?= htmlspecialchars($produit['nom']) ?> - <?= number_format($produit['prix'], 2) ?>€</p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php foreach ($produits as $index => $produit): ?>
        <div id="modal<?= $index + 1 ?>" class="modal">
            <div class="modal-content">
                <a href="#item<?= $index + 1 ?>" class="close">×</a>
                <div class="modal-layout">
                    <div class="agauche">
                        <img src="../media/merch/<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>" class="modal-image">
                    </div>
                    <div class="modal-info">
                        <h2><?= htmlspecialchars($produit['nom']) ?></h2>
                        <p class="description"><?= htmlspecialchars($produit['description']) ?></p>
                        <p class="price"><?= number_format($produit['prix'], 2) ?>€</p>
                        <form method="POST" action="../traitements/add_to_cart.php">
                            <div class="size-selector">
                                <?php foreach (['XS', 'S', 'M', 'L', 'XL'] as $size): ?>
                                    <input type="radio" id="size-<?= strtolower($size) ?>-<?= $index + 1 ?>" name="size" value="<?= $size ?>" required>
                                    <label for="size-<?= strtolower($size) ?>-<?= $index + 1 ?>" class="size-option"><?= $size ?></label>
                                <?php endforeach; ?>
                            </div>
                            <input type="hidden" name="product_id" value="<?= $produit['id'] ?>">
                            <button type="submit" class="add-to-cart">
                                <span class="button-text">Ajouter au panier</span>
                                <img class="check-icon" src="../media/icon-check.png" alt="Check">
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <?php require_once 'footer.php'; ?>
</body>
</html>
