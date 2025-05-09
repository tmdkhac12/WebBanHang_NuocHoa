<?php
require_once __DIR__ . "/../model/ThuongHieuModel.php";

class ThuongHieuController{
    private $thuongHieuModel ;
    function __construct() {
        $this->thuongHieuModel = new ThuongHieuModel();
    }

    public function getAllBrand (){
        return $this->thuongHieuModel->getAllThuongHieu();
    }
}