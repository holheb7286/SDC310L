<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Your Cart</title>
</head>
<body>

  <h1>Your Cart</h1>

  <p><a href="index.php?page=catalog">← Continue Shopping</a></p>

  <?php if (count($cartItems) === 0): ?>
    <p>Your cart is empty.</p>
  <?php else: ?>

    <table border="1" cellpadding="8" cellspacing="0">
      <thead>
        <tr>
          <th>Product ID</th>
          <th>Product Name</th>
          <th>Quantity</th>
          <th>Cost (each)</th>
          <th>Line Total</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>

      <?php foreach ($cartItems as $item): ?>
        <tr>
          <td><?= (int)$item['product_id'] ?></td>
          <td><?= htmlspecialchars($item['name']) ?></td>
          <td>
            <form method="post" action="index.php?page=cart_action" style="display:inline;">
              <input type="hidden" name="action" value="update">
              <input type="hidden" name="product_id" value="<?= (int)$item['product_id'] ?>">
              <input type="number" name="quantity" min="0" value="<?= (int)$item['quantity'] ?>">
              <button type="submit">Update</button>
            </form>
          </td>
          <td>$<?= number_format((float)$item['cost'], 2) ?></td>
          <td>$<?= number_format((float)$item['line_total'], 2) ?></td>
          <td>
            <form method="post" action="index.php?page=cart_action" style="display:inline;">
              <input type="hidden" name="action" value="remove">
              <input type="hidden" name="product_id" value="<?= (int)$item['product_id'] ?>">
              <button type="submit">Remove</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>

      </tbody>
    </table>

    <h2>Order Summary</h2>
    <ul>
      <li>Total of items ordered (subtotal): $<?= number_format((float)$totals['subtotal'], 2) ?></li>
      <li>Tax (5%): $<?= number_format((float)$totals['tax'], 2) ?></li>
      <li>Shipping &amp; Handling (10%): $<?= number_format((float)$totals['shipping'], 2) ?></li>
      <li><strong>Order Total:</strong> $<?= number_format((float)$totals['order_total'], 2) ?></li>
    </ul>

    <form method="post" action="index.php?page=cart_action">
      <input type="hidden" name="action" value="checkout">
      <button type="submit">Check Out</button>
    </form>

  <?php endif; ?>

</body>
</html>