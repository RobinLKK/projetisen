<?php
session_start();
require_once '../traitements/db.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header('Location: accueil.php?error=unauthorized');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stock_id = filter_input(INPUT_POST, 'stock_id', FILTER_VALIDATE_INT);
    $quantite = filter_input(INPUT_POST, 'quantite', FILTER_VALIDATE_INT, ["options" => ["min_range" => 0]]);
    if ($stock_id === false || $stock_id <= 0 || $quantite === false) {
        header('Location: admin.php?error=invalid_input#stock');
        exit;
    }

    try {
        $conn->beginTransaction();
        $stmt = $conn->prepare("UPDATE stock_produits SET quantite = :quantite WHERE id = :stock_id");
        $stmt->bindParam(':quantite', $quantite, PDO::PARAM_INT);
        $stmt->bindParam(':stock_id', $stock_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $conn->commit();
            header('Location: admin.php?status=stock_updated#stock');
        } else {
            $conn->rollBack();
            header('Location: admin.php?error=update_failed#stock');
        }
    } catch (\PDOException $e) {
        $conn->rollBack();
        error_log("Stock Update Error: " . $e->getMessage());
        header('Location: admin.php?error=db_error#stock');
    }
    exit;
}

header('Location: admin.php#stock');
exit;
