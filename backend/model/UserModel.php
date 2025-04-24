<?php
require_once __DIR__ . "/../config/connection.php";

class UserModel
{

    public function getAllUsers()
    {
        $connection = getConnection();

        $sql = "Select * from khachhang";
        $queryResult = $connection->query($sql);
        $users = [];
        while ($row = $queryResult->fetch_assoc()) {
            $users[] = $row;
        }

        $connection->close();
        return (count($users) > 0 ? $users : null);
    }

    public function isExistUsername($username)
    {
        $connection = getConnection();

        $statement = $connection->prepare("SELECT * FROM khachhang WHERE username = ?");
        $statement->bind_param("s", $username);
        $statement->execute();

        $queryResult = $statement->get_result();    // Return Query Associative Array 
        $isExist = ($queryResult->fetch_assoc() ? true : false);

        $statement->close();
        $connection->close();
        return $isExist;
    }

    public function isCurrentPasswordMatched($username, $currentPassword)
    {
        $connection = getConnection();

        $statement = $connection->prepare("SELECT * FROM khachhang WHERE username = ? AND password = ?");
        $statement->bind_param("ss", $username, $currentPassword);
        $statement->execute();

        $queryResult = $statement->get_result();
        $isExist = ($queryResult->fetch_assoc() ? true : false); // return string 

        $statement->close();
        $connection->close();
        return $isExist;
    }

    public function getAccount($username, $password) {
        $connection = getConnection();

        $statement = $connection->prepare("SELECT * FROM khachhang WHERE username = ? AND password = ?");
        $statement->bind_param("ss", $username, $password);
        $statement->execute();

        $queryResult = $statement->get_result();
        $account = $queryResult->fetch_assoc(); // return associative array 

        $statement->close();
        $connection->close();
        return $account;
    }

    public function addUser($hoten, $email, $username, $password, $status)
    {
        $connection = getConnection();

        $sql = "INSERT INTO khachhang (ten_khach_hang, email, username, khachhang.password, trang_thai_tai_khoan)
                VALUES (?,?,?,?,?)";
        $statement = $connection->prepare($sql);
        $statement->bind_param("ssssi", $hoten, $email, $username, $password, $status);
        $statement->execute();

        return ($statement->affected_rows > 0 ? true : false);
    }

    public function updateUserInfo($hoten, $email, $username) {
        $connection = getConnection();

        $sql = "UPDATE khachhang SET ten_khach_hang = ?, email = ? WHERE username = ?";
        $statement = $connection->prepare($sql);
        $statement->bind_param("sss", $hoten, $email, $username);
        $statement->execute();

        return ($statement->affected_rows > 0 ? true : false);
    }

    
    public function updateUserInfoAndPassword($hoten, $email, $username, $newPassword) {
        $connection = getConnection();
        
        $sql = "UPDATE khachhang SET ten_khach_hang = ?, email = ?, khachhang.password = ? WHERE username = ?";
        $statement = $connection->prepare($sql);
        $statement->bind_param("ssss", $hoten, $email, $newPassword, $username);
        $statement->execute();

        return ($statement->affected_rows > 0 ? true : false);
    }
    
}
