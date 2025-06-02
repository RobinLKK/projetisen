<?php
session_start();

if (!empty($_POST['product_id']) && !empty($_POST['size'])) {
    $product_id = intval($_POST['product_id']);
    $size = htmlspecialchars($_POST['size']);

    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = [
            'quantity' => 0,
            'size' => $size
        ];
    }

    $_SESSION['cart'][$product_id]['quantity']++;
    $_SESSION['cart'][$product_id]['size'] = $size;

    $_SESSION['notification'] = "Produit ajouté au panier avec succès !";
}

header('Location: ../pages/shop.php');
exit();
