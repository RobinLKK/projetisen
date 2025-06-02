<!-- CETTE PAGE EST UNE PAGE DEV POUR OBSERVER LES PB ETC DONC JE LA SUPPRIME APRES -->
<!-- CETTE PAGE EST UNE PAGE DEV POUR OBSERVER LES PB ETC DONC JE LA SUPPRIME APRES -->
<!-- CETTE PAGE EST UNE PAGE DEV POUR OBSERVER LES PB ETC DONC JE LA SUPPRIME APRES -->
<!-- CETTE PAGE EST UNE PAGE DEV POUR OBSERVER LES PB ETC DONC JE LA SUPPRIME APRES -->
<!-- CETTE PAGE EST UNE PAGE DEV POUR OBSERVER LES PB ETC DONC JE LA SUPPRIME APRES -->
<!-- CETTE PAGE EST UNE PAGE DEV POUR OBSERVER LES PB ETC DONC JE LA SUPPRIME APRES -->
<!-- CETTE PAGE EST UNE PAGE DEV POUR OBSERVER LES PB ETC DONC JE LA SUPPRIME APRES -->



<?php
session_start();
require_once '../traitements/db.php';

echo "<h1>Votre Panier</h1>";

if (!empty($_SESSION['cart'])) {
    $total = 0;

    foreach ($_SESSION['cart'] as $product_id => $details) {
        $stmt = $conn->prepare("SELECT * FROM produits WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();

        if ($product) {
            $subtotal = $product['prix'] * $details['quantity'];
            $total += $subtotal;
            echo "<div class='cart-item'>";
            echo "<p><strong>{$product['nom']}</strong></p>";
            echo "<p>Prix: " . number_format($product['prix'], 2) . " €</p>";
            echo "<p>Quantité: {$details['quantity']}</p>";
            echo "<p>Taille: " . htmlspecialchars($details['size']) . "</p>"; // Affiche la taille
            echo "<p>Total de ce produit: " . number_format($subtotal, 2) . " €</p>";
            echo "<hr>";
            echo "</div>";
        }
    }

    echo "<h2>Total du panier : " . number_format($total, 2) . " €</h2>";
} else {
    echo "<p>Votre panier est vide.</p>";
}
?>
