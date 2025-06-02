<?php
require_once '../traitements/db.php';

session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header('Location: accueil.php');
    exit;
}

try {
    $stmt_users = $conn->query("SELECT id, nom, prenom, email, admin, date_creation FROM utilisateurs ORDER BY nom, prenom");
    $users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    $error_users = "Erreur lors de la récupération des utilisateurs: " . $e->getMessage();
    $users = [];
}

try {
    $stmt_orders = $conn->query("
        SELECT c.id, c.date_commande, c.prix_total, c.statut, u.nom AS user_nom, u.prenom AS user_prenom
        FROM commandes c
        JOIN utilisateurs u ON c.utilisateur_id = u.id
        ORDER BY c.date_commande DESC
    ");
    $orders = $stmt_orders->fetchAll(PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    $error_orders = "Erreur lors de la récupération des commandes: " . $e->getMessage();
    $orders = [];
}

try {
    $stmt_stock = $conn->query("
        SELECT sp.id, p.nom AS produit_nom, t.nom AS taille_nom, sp.quantite, p.id as produit_id, t.id as taille_id
        FROM stock_produits sp
        JOIN produits p ON sp.produit_id = p.id
        JOIN tailles t ON sp.taille_id = t.id
        ORDER BY p.nom, t.id
    ");
    $stock = $stmt_stock->fetchAll(PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    $error_stock = "Erreur lors de la récupération des stocks: " . $e->getMessage();
    $stock = [];
}

$products_with_stock = [];
if (isset($stock) && is_array($stock)) {
    foreach ($stock as $item) {
        $product_id = $item['produit_id'];
        if (!isset($products_with_stock[$product_id])) {
            $products_with_stock[$product_id] = [
                'produit_nom' => $item['produit_nom'],
                'produit_id' => $item['produit_id'],
                'stock_details' => []
            ];
        }
        $products_with_stock[$product_id]['stock_details'][] = [
            'stock_id' => $item['id'],
            'taille_id' => $item['taille_id'],
            'taille_nom' => $item['taille_nom'],
            'quantite' => $item['quantite']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/admin.css">
    <title>Panneau d'Administration - Miaou3</title>
</head>
<body>
    <h1>PANNEL ADMIN</h1>
    <a href="./accueil.php" style="text-decoration:none; color: #FFF; margin: 0; padding: 10px 20px; background-color:rgba(117, 117, 117, 0.87); border-radius: 5px; font-size: 1.2em; display: inline-block; margin-bottom: 20px;">Retour à l'accueil</a>
    <section id="users">
        <h2>Gestion des Utilisateurs</h2>
        <?php if (isset($error_users)): ?>
            <p class="error"><?php echo htmlspecialchars($error_users); ?></p>
        <?php endif; ?>
        <div class="scrollable-table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Admin</th>
                        <th>Date Création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['nom']); ?></td>
                        <td><?php echo htmlspecialchars($user['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td>
                            <?php if ($user['admin']): ?>
                                <span class="status-admin" title="Administrateur">✔ Oui</span>
                            <?php else: ?>
                                <span class="status-not-admin" title="Utilisateur standard">✘ Non</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($user['date_creation']))); ?></td>
                        <td class="actions">
                            <a href="../traitements/mod_utilisateur.php?id=<?php echo $user['id']; ?>" class="edit">Modifier</a>
                            <a href="../traitements/supr_utilisateur.php?id=<?php echo $user['id']; ?>" class="delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?\nNom: <?php echo htmlspecialchars(addslashes($user['prenom'] . ' ' . $user['nom'])); ?>');">Supprimer</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($users) && !isset($error_users)): ?>
                    <tr><td colspan="7">Aucun utilisateur trouvé.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
    <section id="orders">
        <h2>Gestion des Commandes</h2>
        <?php if (isset($error_orders)): ?>
            <p class="error"><?php echo htmlspecialchars($error_orders); ?></p>
        <?php endif; ?>
        <div class="scrollable-table-container">
            <table>
                <thead>
                    <tr>
                        <th>N° Commande</th>
                        <th>Date</th>
                        <th>Client</th>
                        <th>Total</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?php echo htmlspecialchars($order['id']); ?></td>
                        <td><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($order['date_commande']))); ?></td>
                        <td><?php echo htmlspecialchars($order['user_prenom'] . ' ' . $order['user_nom']); ?></td>
                        <td><?php echo htmlspecialchars(number_format($order['prix_total'], 2, ',', ' ')); ?> €</td>
                        <td><?php echo htmlspecialchars($order['statut']); ?></td>
                        <td class="actions">
                            <a href="view_order.php?id=<?php echo $order['id']; ?>" class="view">Détails</a>
                            <a href="edit_order.php?id=<?php echo $order['id']; ?>" class="edit">Statut</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($orders) && !isset($error_orders)): ?>
                    <tr><td colspan="6">Aucune commande trouvée.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
    <section id="stock">
        <h2>Gestion des Stocks</h2>
        <?php if (isset($error_stock)): ?>
            <p class="error"><?php echo htmlspecialchars($error_stock); ?></p>
        <?php endif; ?>
        <div class="scrollable-table-container">
            <table>
                <thead>
                    <tr>
                        <th>Produit (ID)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products_with_stock as $product_id => $product_info): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product_info['produit_nom']); ?> (<?php echo htmlspecialchars($product_id); ?>)</td>
                        <td class="actions">
                            <label for="modal-toggle-<?php echo $product_id; ?>" class="actions view">Gérer Stock</label>
                            <a href="edit_product.php?id=<?php echo $product_id; ?>" class="actions edit">Modifier Produit</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($products_with_stock) && !isset($error_stock)): ?>
                    <tr><td colspan="2">Aucun produit avec stock trouvé</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php foreach ($products_with_stock as $product_id => $product_info): ?>
            <input type="checkbox" id="modal-toggle-<?php echo $product_id; ?>" class="modal-toggle">
            <div class="modal">
                <label for="modal-toggle-<?php echo $product_id; ?>" class="modal-overlay"></label>
                <div class="modal-content">
                    <label for="modal-toggle-<?php echo $product_id; ?>" class="modal-close-btn">×</label>
                    <h3>Stock pour : <?php echo htmlspecialchars($product_info['produit_nom']); ?></h3>
                    <div class="modal-table-container">
                         <table>
                            <thead>
                                <tr>
                                    <th>Taille (ID)</th>
                                    <th>Quantité Actuelle</th>
                                    <th>Mettre à Jour</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($product_info['stock_details'] as $detail): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($detail['taille_nom']); ?> (<?php echo htmlspecialchars($detail['taille_id']); ?>)</td>
                                    <td><?php echo htmlspecialchars($detail['quantite']); ?></td>
                                    <td>
                                        <form action="update_stock.php" method="POST" class="stock-form-modal">
                                            <input type="hidden" name="stock_id" value="<?php echo htmlspecialchars($detail['stock_id']); ?>">
                                            <input type="number" name="quantite" value="<?php echo htmlspecialchars($detail['quantite']); ?>" min="0" required>
                                            <button type="submit" class="actions edit">MàJ</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($product_info['stock_details'])): ?>
                                    <tr><td colspan="3">Aucune taille définie pour ce produit en stock</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
    <section id="ajouter_item">
        <h1>Ajouter un nouvel item au shop</h1>
        <form action="../traitements/traitement_ajouter_item.php" method="POST" enctype="multipart/form-data">
            <label for="nom">Nom :</label><br>
            <input type="text" id="nom" name="nom" required><br><br>
            <label for="description">Description :</label><br>
            <textarea id="description" name="description" required></textarea><br><br>
            <label for="prix">Prix (€) :</label><br>
            <input type="number" step="0.01" id="prix" name="prix" required><br><br>
            <label for="image">Image :</label><br>
            <input type="file" id="image" name="image" accept="image/*"><br><br>
            <label for="image_hover">Image Hover :</label><br>
            <input type="file" id="image_hover" name="image_hover" accept="image/*"><br><br>
            <label for="categorie_id">Catégorie :</label><br>
            <select id="categorie_id" name="categorie_id" required>
                <option value="1">Vêtements</option>
                <option value="2">CD</option>
                <option value="3">Vinyles</option>
                <option value="4">Accessoires</option>
            </select><br><br>
            <label for="a_des_tailles">A des tailles ?</label><br>
            <select id="a_des_tailles" name="a_des_tailles" required>
                <option value="1">Oui</option>
                <option value="0">Non</option>
            </select><br><br>
            <button type="submit" name="Envoyer">Ajouter l'item</button>
        </form>
        <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
            <div class="success-message">Item ajouté avec succès !</div>
        <?php endif; ?>
    </section>
</body>
</html>
