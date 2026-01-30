<?php

namespace app\Models;
use app\core\Database;
class Product {
    private $db;



    public function __construct () {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllProducts() {
        $sql = "SELECT * FROM products ;";
        $data = $sql->query([$data["name"], $data["price"], $data["category"]]);
        $data->fetchAll();
    }

    public function getProductById($productId) {
        $stmt = $db->prepare("SELECT * FROM products WHERE id = ?;");
        $stmt->execute([$productId]);
    }


    public function addProduct($name, $price, $category) {
        $stmt = $db->prepare("INSERT INTO products (name, price, category) VALUES (?, ?, ?);");
        $stmt->execute([$name, $price, $category]);
    }

    public function updateProduct($productId, $name, $price, $category) {
        $stmt = $db->prepare("UPDATE products SET name = ? AND price = ? AND category = ? WHERE id = ?;");
        $stmt->execute([name, $price, $category, $productId]);
    }


    public function deleteProduct($productId) {
        $stmt = $db->prepare("DELETE FROM products WHERE id = ?;");
        $stmt->execute([$productId]);
    }




}

?>
