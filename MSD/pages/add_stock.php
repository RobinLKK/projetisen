<?php
session_start();
require_once '../traitements/db.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header('Location: accueil.php?error=unauthorized');
    exit;
}

$error_message = '';
$success_message = '';
$products = [];
$sizes = [];

try {
    $stmt_products = $conn->query("SELECT id, nom FROM produits ORDER BY nom");
    $products = $stmt_products->fetchAll(PDO::FETCH_ASSOC);

    $stmt_sizes = $conn->query("SELECT id, nom FROM tailles ORDER BY nom");
    $sizes = $stmt_sizes->fetchAll(PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    $error_message = "Erreur lors de la récupération des données. Impossible d'afficher le formulaire.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produit_id = filter_input(INPUT_POST, 'produit_id', FILTER_VALIDATE_INT);
    $taille_id = filter_input(INPUT_POST, 'taille_id', FILTER_VALIDATE_INT);
    $quantite = filter_input(INPUT_POST, 'quantite', FILTER_VALIDATE_INT, ["options" => ["min_range" => 0]]);

    if (!$produit_id || !$taille_id || $quantite === false) {
        $error_message = "Veuillez sélectionner un produit, une taille et entrer une quantité valide (0 ou plus).";
    } else {
        try {
            $check_sql = "SELECT id FROM stock_produits WHERE produit_id = :produit_id AND taille_id = :taille_id";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bindParam(':produit_id', $produit_id, PDO::PARAM_INT);
            $check_stmt->bindParam(':taille_id', $taille_id, PDO::PARAM_INT);
            $check_stmt->execute();
            $existing_stock = $check_stmt->fetch(PDO::FETCH_ASSOC);

            if ($existing_stock) {
                $error_message = "Cette combinaison produit/taille existe déjà dans le stock. Utilisez 'Gérer Stock' sur la page admin pour mettre à jour la quantité.";
            } else {
                $insert_sql = "INSERT INTO stock_produits (produit_id, taille_id, quantite) VALUES (:produit_id, :taille_id, :quantite)";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bindParam(':produit_id', $produit_id, PDO::PARAM_INT);
                $insert_stmt->bindParam(':taille_id', $taille_id, PDO::PARAM_INT);
                $insert_stmt->bindParam(':quantite', $quantite, PDO::PARAM_INT);

                if ($insert_stmt->execute()) {
                    $success_message = "Nouvelle entrée de stock ajoutée avec succès !";
                } else {
                    $error_message = "Erreur lors de l'ajout de l'entrée de stock.";
                }
            }
        } catch (\PDOException $e) {
            error_log("Add Stock Error: " . $e->getMessage());
            $error_message = $e->getCode() == '23000' ? "Erreur : Cette combinaison produit/taille existe déjà." : "Erreur base de données lors de l'ajout du stock.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/admin.css">
    <link rel="stylesheet" href="../style/forms.css">
    <title>Ajouter une Entrée de Stock - Admin</title>
</head>
<body>
    <div class="form-container">
        <h1>Ajouter une Entrée de Stock</h1>
        <a href="admin.php#stock" class="link-back">« Retour au Panneau Admin</a>

        <?php if ($error_message): ?>
            <p class="message error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <p class="message success"><?php echo htmlspecialchars($success_message); ?></p>
        <?php endif; ?>

        <?php if (!empty($products) && !empty($sizes)): ?>
            <form action="add_stock.php" method="POST">
                <div class="form-group">
                    <label for="produit_id">Produit :</label>
                    <select name="produit_id" id="produit_id" required>
                        <option value="">-- Sélectionner un produit --</option>
                        <?php foreach ($products as $product): ?>
                            <option value="<?php echo htmlspecialchars($product['id']); ?>">
                                <?php echo htmlspecialchars($product['nom']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="taille_id">Taille :</label>
                    <select name="taille_id" id="taille_id" required>
                        <option value="">-- Sélectionner une taille --</option>
                        <?php foreach ($sizes as $size): ?>
                            <option value="<?php echo htmlspecialchars($size['id']); ?>">
                                <?php echo htmlspecialchars($size['nom']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantite">Quantité :</label>
                    <input type="number" name="quantite" id="quantite" value="0" min="0" required>
                </div>

                <div class="form-actions">
                    <button type="submit">Ajouter au Stock</button>
                </div>
            </form>
        <?php elseif (empty($error_message)) : ?>
            <p class="message error">Impossible d'ajouter du stock : Aucun produit ou taille n'a été trouvé dans la base de données.</p>
        <?php endif; ?>
        <a href="admin.php#stock" class="link-back" style="display: block; text-align: center; margin-top: 20px;">« Retour au Panneau Admin</a>
    </div>
</body>
</html>
