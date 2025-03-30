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

    public function isExistUsername($username) {
        return $this->userModel->isExistUsername($username);
    }

    public function isExistUsernameAndPassword($username, $password) {
        return $this->userModel->isExistUsernameAndPassword($username, $password);
    }

    public function addUser($hoten, $email, $username, $password, $status) {
        return $this->userModel->addUser($hoten, $email, $username, $password, $status);
    }
}

?>