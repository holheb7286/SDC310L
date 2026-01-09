<?php
declare(strict_types=1);

function getAllProducts(PDO $pdo): array {
    $sql = "SELECT product_id, name, description, cost, quantity_on_hand
            FROM products
            WHERE active = 1
            ORDER BY product_id";
    return $pdo->query($sql)->fetchAll();
}

function getProductById(PDO $pdo, int $productId): ?array {
    $sql = "SELECT product_id, name, description, cost, quantity_on_hand
            FROM products
            WHERE product_id = :id AND active = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $productId]);
    $row = $stmt->fetch();
    return $row ?: null;
}