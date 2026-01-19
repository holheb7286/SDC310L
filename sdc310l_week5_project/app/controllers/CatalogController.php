<?php
declare(strict_types=1);

final class CatalogController
{
    private ProductModel $products;

    public function __construct(mysqli $db)
    {
        $this->products = new ProductModel($db);
    }

    public function index(): void
    {
        $products = $this->products->getAllActive();

        // load view
        require __DIR__ . '/../views/catalog/index.php';
    }
}