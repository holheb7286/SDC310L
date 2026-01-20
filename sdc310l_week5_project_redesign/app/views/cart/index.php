<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart</title>
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
      <h2>Your Cart</h2>
      <p>Review your items, update quantities, or check out.</p>
    </div>
    <div>
      <a class="pill" href="index.php?page=catalog">← Continue Shopping</a>
    </div>
  </div>

  <?php if (count($cartItems) === 0): ?>

    <div class="card">
      <div class="card-inner" style="display:block;">
        <h3 style="margin:0 0 8px;">Your cart is empty.</h3>
        <p class="desc" style="margin:0;">Add something from the catalog to see it here.</p>
      </div>
    </div>

  <?php else: ?>

    <div class="cart-layout">

      <!-- CART ITEMS -->
      <div class="card">
        <div class="card-inner" style="display:block;">
          <h3 style="margin:0 0 12px;">Items</h3>

          <div class="cart-table">

            <div class="cart-head">
              <div>Product</div>
              <div class="right">Cost</div>
              <div class="center">Qty</div>
              <div class="right">Line Total</div>
              <div class="right">Actions</div>
            </div>

            <?php foreach ($cartItems as $item): ?>
              <div class="cart-row">

                <!-- PRODUCT CELL -->
                <div class="product-cell">
                  <div class="thumb small">
                    <?php
                      $pid = (int)$item['product_id'];
                      $imgUrl  = "/sdc310l_week5_project_redesign/images/product-$pid.jpg";
                      $imgFile = __DIR__ . "/../../../images/product-$pid.jpg";

                      if (file_exists($imgFile)) {
                        echo '<img src="' . htmlspecialchars($imgUrl) . '" alt="">';
                      } else {
                        echo '<span class="noimg">No image</span>';
                      }
                    ?>
                  </div>

                  <div>
                    <div class="pname"><?= htmlspecialchars($item['name']) ?></div>
                    <div class="muted">ID: <?= $pid ?></div>
                  </div>
                </div>

                <!-- COST -->
                <div class="right">
                  $<?= number_format((float)$item['cost'], 2) ?>
                </div>

                <!-- QTY -->
                <div class="center">
                  <form method="post" action="index.php?page=cart_action" class="qty-form">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="product_id" value="<?= $pid ?>">
                    <input class="qty" type="number" name="quantity" min="0" value="<?= (int)$item['quantity'] ?>">
                    <button class="btn-secondary" type="submit">Update</button>
                  </form>
                </div>

                <!-- LINE TOTAL -->
                <div class="right">
                  $<?= number_format((float)$item['line_total'], 2) ?>
                </div>

                <!-- REMOVE -->
                <div class="right">
                  <form method="post" action="index.php?page=cart_action">
                    <input type="hidden" name="action" value="remove">
                    <input type="hidden" name="product_id" value="<?= $pid ?>">
                    <button class="btn-danger" type="submit">Remove</button>
                  </form>
                </div>

              </div>
            <?php endforeach; ?>

          </div>
        </div>
      </div>

      <!-- SUMMARY -->
      <div class="card">
        <div class="card-inner" style="display:block;">
          <h3 style="margin:0 0 12px;">Order Summary</h3>

          <div class="summary">
            <div class="sumrow">
              <span>Subtotal</span>
              <span>$<?= number_format((float)$totals['subtotal'], 2) ?></span>
            </div>
            <div class="sumrow">
              <span>Tax (5%)</span>
              <span>$<?= number_format((float)$totals['tax'], 2) ?></span>
            </div>
            <div class="sumrow">
              <span>Shipping (10%)</span>
              <span>$<?= number_format((float)$totals['shipping'], 2) ?></span>
            </div>

            <div class="divider"></div>

            <div class="sumrow total">
              <span>Order Total</span>
              <span>$<?= number_format((float)$totals['order_total'], 2) ?></span>
            </div>

            <form method="post" action="index.php?page=cart_action" style="margin-top:14px;">
              <input type="hidden" name="action" value="checkout">
              <button class="btn-primary wide" type="submit">Check Out</button>
            </form>

            <p class="muted" style="margin-top:10px;">
              Tip: Set quantity to 0 to remove an item.
            </p>
          </div>
        </div>
      </div>

    </div>

  <?php endif; ?>

  <div class="footer">
    Built with PHP + MySQLi • MVC architecture
  </div>

</div>

</body>
</html>