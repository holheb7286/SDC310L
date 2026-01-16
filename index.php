<?php
declare(strict_types=1);

require_once __DIR__ . '/database.php';

// models
require_once __DIR__ . '/app/models/ProductModel.php';
require_once __DIR__ . '/app/models/CartModel.php';

// controllers
require_once __DIR__ . '/app/controllers/CatalogController.php';
require_once __DIR__ . '/app/controllers/CartController.php';

$page = $_GET['page'] ?? 'catalog';

switch ($page) {
    case 'cart':
        (new CartController($mysqli))->index();
        break;

    case 'cart_action':
        (new CartController($mysqli))->handlePost();
        break;

    case 'catalog':
    default:
        (new CatalogController($mysqli))->index();
        break;
}