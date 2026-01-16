<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Product Catalog</title>
</head>
<body>

<h1>Product Catalog</h1>

<p><a href="index.php?page=cart">View Cart</a></p>

<?php foreach ($products as $product): ?>
    <p>
        <strong><?= htmlspecialchars($product['name']) ?></strong><br>
        <?= htmlspecialchars($product['description']) ?><br>
        $<?= number_format((float)$product['cost'], 2) ?><br>
        In stock: <?= (int)$product['quantity_on_hand'] ?>
    </p>

    <form method="post" action="index.php?page=cart_action">
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