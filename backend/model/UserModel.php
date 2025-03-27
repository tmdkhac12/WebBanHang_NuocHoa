<?php 
require __DIR__ . "/../config/connection.php";

class UserModel {
    
    public function getAllUsers() {
        $connection = getConnection();

        $sql = "Select * from khachhang";
        $queryResult = $connection->query($sql);
        $users = [];
        while ($row = $queryResult->fetch_assoc()) {
            $users[] = $row;
        }

        $connection->close();
        return $users;
    }
}

?>