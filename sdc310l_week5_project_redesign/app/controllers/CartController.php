<?php
declare(strict_types=1);

final class CartController
{
    private CartModel $cart;
    private string $base;

    public function __construct(mysqli $db)
    {
        $this->cart = new CartModel($db);

        // Base path to the app (works whether you’re in / or /sdc310l_week4_project/)
        $scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
        $this->base = ($scriptDir === '') ? '/' : $scriptDir . '/';
    }

    private function redirect(string $page): void
    {
        header('Location: ' . $this->base . 'index.php?page=' . $page);
        exit;
    }

    public function index(): void
    {
        $cartItems = $this->cart->getCartItems();
        $totals = $this->cart->calculateTotals($cartItems);

        require __DIR__ . '/../views/cart/index.php';
    }

    public function handlePost(): void
    {
        $action = $_POST['action'] ?? '';
        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;

        switch ($action) {
            case 'add': {
                $qty = max(1, (int)($_POST['quantity'] ?? 1));
                if ($productId > 0) {
                    $this->cart->addToCart($productId, $qty);
                }
                $this->redirect('catalog');
            }

            case 'update': {
                $qty = max(0, (int)($_POST['quantity'] ?? 0));
                if ($productId > 0) {
                    $this->cart->updateCartQuantity($productId, $qty);
                }
                $this->redirect('cart');
            }

            case 'remove': {
                if ($productId > 0) {
                    $this->cart->removeFromCart($productId);
                }
                $this->redirect('cart');
            }

            case 'checkout': {
                $this->cart->clearCart();
                $this->redirect('catalog');
            }

            default:
                $this->redirect('catalog');
        }
    }
}