<?php
require_once __DIR__ . "/../model/NongDoModel.php";

class NongDoController{
    private $nongDoModel ;
    function __construct() {
        $this->nongDoModel = new NongDoModel;
    }

    public function getAllNongDo (){
        return $this->nongDoModel->getAllNongDo();
    }
}