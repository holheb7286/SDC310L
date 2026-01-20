<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Product Catalog</title>
<link rel="stylesheet" href="/sdc310l_week5_project_redesign/style.css">
</head>
<body>

<div class="header">
  <div class="nav">
    <div class="brand">
      <h1>Hebert Mercantile</h1>
      <span class="badge">SDC310L Store</span>
    </div>
    <div class="navlinks">
      <a class="pill" href="index.php?page=catalog">Catalog</a>
      <a class="pill" href="index.php?page=cart">View Cart</a>
    </div>
  </div>
</div>

<div class="container">
  <div class="hgroup">
    <div>
      <h2>Product Catalog</h2>
      <p>Choose an item and add it to your cart.</p>
    </div>
  </div>

  <div class="grid">
    <?php foreach ($products as $product): ?>
      <div class="card">
        <div class="card-inner">

          <div class="thumb">
            <?php
              $img = 'images/product-' . (int)$product['product_id'] . '.jpg';
              if (file_exists(__DIR__ . '/../../../' . $img)) {
                echo '<img src="' . htmlspecialchars($img) . '" alt="">';
              } else {
                echo 'No image';
              }
            ?>
          </div>

          <div class="meta">
            <h3><?= htmlspecialchars($product['name']) ?></h3>
            <p class="desc"><?= htmlspecialchars($product['description']) ?></p>

            <div class="kv">
              <span>$<?= number_format((float)$product['cost'], 2) ?></span>
              <span>In stock: <?= (int)$product['quantity_on_hand'] ?></span>
              <span>ID: <?= (int)$product['product_id'] ?></span>
            </div>

            <form class="formrow" method="post" action="index.php?page=cart_action">
              <input type="hidden" name="action" value="add">
              <input type="hidden" name="product_id" value="<?= (int)$product['product_id'] ?>">
              <input type="number" name="quantity" value="1" min="1">
              <button class="btn-primary" type="submit">Add to Cart</button>
            </form>
          </div>

        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="footer">
    Built with PHP + MySQLi • MVC Architecture
  </div>
</div>

</body>
</html>