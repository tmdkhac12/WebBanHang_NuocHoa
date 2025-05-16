<?php
require_once __DIR__ . "/../model/DungTichModel.php";

class DungTichController{
    private $dungTichModel ;
    function __construct() {
        $this->dungTichModel = new DungTichModel();
    }

    public function getAllDungTich (){
        return $this->dungTichModel->getAllDungTich();
    }
}