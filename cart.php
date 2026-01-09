<?php
declare(strict_types=1);

function getSessionId(): string {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    return session_id();
}

function getCartItems(PDO $pdo): array {
    $sid = getSessionId();
    $sql = "SELECT p.product_id, p.name, p.cost, c.quantity,
                   (p.cost * c.quantity) AS line_total
            FROM cart_items c
            JOIN products p ON p.product_id = c.product_id
            WHERE c.session_id = :sid AND c.quantity > 0
            ORDER BY p.product_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['sid' => $sid]);
    return $stmt->fetchAll();
}

function addToCart(PDO $pdo, int $productId, int $qtyToAdd): void {
    $sid = getSessionId();
    $qtyToAdd = max(1, $qtyToAdd);

    // If row exists, update; else insert
    $sql = "INSERT INTO cart_items (session_id, product_id, quantity)
            VALUES (:sid, :pid, :qty)
            ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['sid' => $sid, 'pid' => $productId, 'qty' => $qtyToAdd]);
}

function updateCartQuantity(PDO $pdo, int $productId, int $newQty): void {
    $sid = getSessionId();
    $newQty = max(0, $newQty);

    if ($newQty === 0) {
        removeFromCart($pdo, $productId);
        return;
    }

    $sql = "UPDATE cart_items
            SET quantity = :qty
            WHERE session_id = :sid AND product_id = :pid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['qty' => $newQty, 'sid' => $sid, 'pid' => $productId]);
}

function removeFromCart(PDO $pdo, int $productId): void {
    $sid = getSessionId();
    $sql = "DELETE FROM cart_items
            WHERE session_id = :sid AND product_id = :pid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['sid' => $sid, 'pid' => $productId]);
}

function clearCart(PDO $pdo): void {
    $sid = getSessionId();
    $sql = "DELETE FROM cart_items WHERE session_id = :sid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['sid' => $sid]);
}

function calculateTotals(array $cartItems): array {
    $subtotal = 0.0;
    foreach ($cartItems as $item) {
        $subtotal += (float)$item['line_total'];
    }
    $tax = $subtotal * 0.05;
    $shipping = $subtotal * 0.10;
    $orderTotal = $subtotal + $tax + $shipping;

    return [
        'subtotal' => $subtotal,
        'tax' => $tax,
        'shipping' => $shipping,
        'order_total' => $orderTotal,
    ];
}