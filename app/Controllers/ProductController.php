<?php





namespace app\Controllers;
use app\Models\Product;

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }


    public function showProducts () {
        $products = productModel->getAllProducts();
        return $products;
    }

    public function addProduct () {
        if (isset($_SESSION['name'] && isset($_SESSION['price'] && isset($_SESSION['category'])) {
            productModel->addProduct($_SESSION['name'], $_SESSION['price'], $_SESSION['category']);
        }
    }
    public function updateProduct () {
        if (isset($_SESSION['id']), isset($_SESSION['name']) && isset($_SESSION['price']) && isset($_SESSION['category'])) {
            productModel->updateProduct($_SESSION['id'], $_SESSION['name'], $_SESSION['price'], $_SESSION['category']);
        }
    }

}
