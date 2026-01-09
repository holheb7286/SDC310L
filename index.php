<?php
require_once 'database.php';

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Catalog</title>
</head>
<body>

<h1>Product Catalog</h1>

<p><a href="cart.php">View Cart</a></p>

<?php foreach ($products as $product): ?>
    <p>
        <strong><?= htmlspecialchars($product['name']) ?></strong><br>
        <?= htmlspecialchars($product['description']) ?><br>
        $<?= number_format($product['cost'], 2) ?><br>
        In stock: <?= $product['quantity_on_hand'] ?>
    </p>

<form method="post" action="cart_actions.php">
    <input type="hidden" name="action" value="add">
    <input type="hidden" name="product_id" value="<?= (int)$product['product_id'] ?>">

    <label>
        Qty:
        <input type="number" name="quantity" value="1" min="1">
    </label>

    <button type="submit">Add to Cart</button>
</form>

<?php endforeach; ?>

</body>
</html>