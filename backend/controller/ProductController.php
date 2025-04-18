<?php
require __DIR__ . "/../model/ProductModel.php";

class ProductController {
    private $productModel;

    function __construct() {
        $this->productModel = new ProductModel();
    }

    public function getAllProducts($limit = null, $offset = null) {
        return $this->productModel->getAllProducts($limit, $offset);
    }

    public function getTotalProducts() {
        return $this->productModel->getTotalProducts();
    }

    public function filterProducts($gender, $minPrice, $maxPrice, $productNameSearch, $limit = null, $offset = null) { // Đổi từ $brandSearch
        return $this->productModel->filterProducts($gender, $minPrice, $maxPrice, $productNameSearch, $limit, $offset);
    }
}
?>