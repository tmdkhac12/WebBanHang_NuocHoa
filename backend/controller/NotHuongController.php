<?php
require_once __DIR__ . "/../model/NotHuongModel.php";

class NotHuongController{
    private $notHuongModel ;
    function __construct() {
        $this->notHuongModel = new NotHuongModel();
    }

    public function getAllNotHuong (){
        return $this->notHuongModel->getAllNotHuong();
    }
}