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

    public function getTotalUsers()
    {
        return $this->userModel->getTotalUsers();
    }

    public function getAllUsers($limit, $offset)
    {
        return $this->userModel->getAllUsers($limit, $offset);
    }

    public function isExistUsername($username)
    {
        return $this->userModel->isExistUsername($username);
    }

    public function getAccount($username, $password)
    {
        return $this->userModel->getAccount($username, $password);
    }

    public function registerUser($hoten, $email, $username, $password, $status, $quyenhan)
    {
        // If username existed 
        if ($this->userModel->isExistUsername($username)) {
            return -1; // Username existed
        }

        if ($this->userModel->addUser($hoten, $email, $username, $password, $status , $quyenhan)) {
            return 1;
        }
        return 0;
    }

    public function addUser($hoten, $email, $username, $password, $status , $quyenhan)
    {
        if ($this->userModel->isExistUsername($username)) {
            return -1; 
        }
        if ($this->userModel->isExistEmail($email)) {
            return -2;
        }

        $isSuccess = $this->userModel->addUser($hoten, $email, $username, $password, $status , $quyenhan);
        if ($isSuccess) {
            return 1; 
        }

        return 0; // Thêm thất bại
    }
    
    public function getAdminCount() {
        return $this->userModel->countAdmins();
    }

    public function getUserRoleByUsername($username) {
        return $this->userModel->getUserRoleByUsername($username);
    }

    public function updateUser($hoten, $email, $username, $currentPassword, $newPassword , $quyenhan , $trangthai)
    {
        // If password null call updateUserInfo else call updateUserInfoAndPassword 
        if (!$currentPassword) {
            $isSuccess = $this->userModel->updateUserInfo($hoten, $email, $username , $quyenhan , $trangthai);
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

    public function updateUserFromClient($hoten, $email, $username, $currentPassword, $newPassword)
    {
        // If password null call updateUserInfo else call updateUserInfoAndPassword 
        if (!$currentPassword) {
            $isSuccess = $this->userModel->updateUserInfo($hoten, $email, $username);
            if ($isSuccess) {
                return 1;
            }
            return -3; // Update user info failed (data not change) 
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


    public function updateUserInfoFromAdmin($hoten, $email, $username, $password, $quyenhan, $trangthai)
    {
        $isSuccess = $this->userModel->updateUserInfoAndPasswordFromAdmin(
            $hoten, $email, $username, $password, $quyenhan, $trangthai
        );
        return $isSuccess ? 1 : -1;
    }

    public function searchUsers($keyword, $limit, $offset) {
        return $this->userModel->searchUsers($keyword, $limit, $offset);
    }
    public function getTotalSearchUsers($keyword) {
        return $this->userModel->getTotalSearchUsers($keyword);
    }

}
