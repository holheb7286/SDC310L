<?php
declare(strict_types=1);

require_once 'database.php';
require_once __DIR__ . '/lib/cart.php';

$action = $_POST['action'] ?? '';
$productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;

switch ($action) {

    case 'add':
        $qty = max(1, (int)($_POST['quantity'] ?? 1));
        if ($productId > 0) {
            addToCart($pdo, $productId, $qty);
        }
        header('Location: index.php');
        exit;

    case 'update':
        $qty = max(0, (int)($_POST['quantity'] ?? 0));
        if ($productId > 0) {
            updateCartQuantity($pdo, $productId, $qty);
        }
        header('Location: cart.php');
        exit;

    case 'remove':
        if ($productId > 0) {
            removeFromCart($pdo, $productId);
        }
        header('Location: cart.php');
        exit;

    case 'checkout':
        clearCart($pdo);
        header('Location: index.php');
        exit;

    default:
        header('Location: index.php');
        exit;
}