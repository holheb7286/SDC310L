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

<?php foreach ($products as $product): ?>
    <p>
        <strong><?= htmlspecialchars($product['name']) ?></strong><br>
        <?= htmlspecialchars($product['description']) ?><br>
        $<?= number_format($product['cost'], 2) ?><br>
        In stock: <?= $product['quantity_on_hand'] ?>
    </p>
<?php endforeach; ?>

</body>
</html>