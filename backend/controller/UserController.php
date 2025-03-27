<?php 
require __DIR__ . "/../model/UserModel.php";

class UserController {
    private $userModel;

    function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function getAllUsers() {
        return $this->userModel->getAllUsers();
    }
}

?>