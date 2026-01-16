<?php
declare(strict_types=1);

final class CartModel
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    private function getSessionId(): string
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        return session_id();
    }

    public function getCartItems(): array
    {
        $sid = $this->getSessionId();

        $sql = "SELECT p.product_id, p.name, p.cost, c.quantity,
                       (p.cost * c.quantity) AS line_total
                FROM cart_items c
                JOIN products p ON p.product_id = c.product_id
                WHERE c.session_id = ? AND c.quantity > 0
                ORDER BY p.product_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $sid);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function addToCart(int $productId, int $qtyToAdd): void
    {
        $sid = $this->getSessionId();
        $qtyToAdd = max(1, $qtyToAdd);

        $sql = "INSERT INTO cart_items (session_id, product_id, quantity)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sii", $sid, $productId, $qtyToAdd);
        $stmt->execute();
    }

    public function updateCartQuantity(int $productId, int $newQty): void
    {
        $sid = $this->getSessionId();
        $newQty = max(0, $newQty);

        if ($newQty === 0) {
            $this->removeFromCart($productId);
            return;
        }

        $sql = "UPDATE cart_items
                SET quantity = ?
                WHERE session_id = ? AND product_id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("isi", $newQty, $sid, $productId);
        $stmt->execute();
    }

    public function removeFromCart(int $productId): void
    {
        $sid = $this->getSessionId();

        $sql = "DELETE FROM cart_items
                WHERE session_id = ? AND product_id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("si", $sid, $productId);
        $stmt->execute();
    }

    public function clearCart(): void
    {
        $sid = $this->getSessionId();

        $sql = "DELETE FROM cart_items WHERE session_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $sid);
        $stmt->execute();
    }

    public function calculateTotals(array $cartItems): array
    {
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
}