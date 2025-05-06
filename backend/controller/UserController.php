<?php
require_once __DIR__ . "/../model/UserModel.php";

class UserController
{
    private $userModel;

    function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function getUserById($id)
    {
        return $this->userModel->getUserById($id);
    }

    public function getAllUsers()
    {
        return $this->userModel->getAllUsers();
    }

    public function isExistUsername($username)
    {
        return $this->userModel->isExistUsername($username);
    }

    public function getAccount($username, $password)
    {
        return $this->userModel->getAccount($username, $password);
    }

    public function registerUser($hoten, $email, $username, $password, $status)
    {
        // If username existed 
        if ($this->userModel->isExistUsername($username)) {
            return -1; // Username existed
        }

        if ($this->userModel->addUser($hoten, $email, $username, $password, $status)) {
            return 1;
        }
        return 0;
    }

    public function updateUser($hoten, $email, $username, $currentPassword, $newPassword)
    {
        // If password null call updateUserInfo else call updateUserInfoAndPassword 
        if (!$currentPassword) {
            $isSuccess = $this->userModel->updateUserInfo($hoten, $email, $username);
            if ($isSuccess) {
                return 1;
            }
            return -1; // Update user info failed, db error 
        } else {
            if (!$this->userModel->isCurrentPasswordMatched($username, $currentPassword)) {
                return -2; // Current password not correct 
            }
            if (!$this->userModel->updateUserInfoAndPassword($hoten, $email, $username, $newPassword)) {
                return -1; // Update user info and password failed, db error 
            }
            return 1;
        }
    }
}
