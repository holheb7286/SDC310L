<?php
declare(strict_types=1);

final class ProductModel
{
    private mysqli $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    /**
     * Get all active products for the catalog
     */
    public function getAllActive(): array
    {
        $sql = "SELECT product_id, name, description, cost, quantity_on_hand
                FROM products
                WHERE active = 1
                ORDER BY product_id";

        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get one product by id (only if active). Returns null if not found.
     */
    public function getById(int $productId): ?array
    {
        $sql = "SELECT product_id, name, description, cost, quantity_on_hand
                FROM products
                WHERE product_id = ? AND active = 1
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();

        $row = $stmt->get_result()->fetch_assoc();
        return $row ?: null;
    }
}