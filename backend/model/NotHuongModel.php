<?php
require_once __DIR__ . "/../config/connection.php";

class NotHuongModel{
    public function getAllNotHuong (){
        $connection = getConnection();

        $sql = "Select * from nothuong";
        $queryResult = $connection->query($sql);
        $users = [];
        while ($row = $queryResult->fetch_assoc()) {
            $users[] = $row;
        }

        $connection->close();
        return (count($users) > 0 ? $users : null);
    }
}