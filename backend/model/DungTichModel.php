<?php
require_once __DIR__ . "/../config/connection.php";

class DungTichModel{
    public function getAllDungTich (){
        $connection = getConnection();

        $sql = "Select * from dungtich";
        $queryResult = $connection->query($sql);
        $dungtich = [];
        while ($row = $queryResult->fetch_assoc()) {
           $dungtich[] = $row;
        }

        $connection->close();
        return (count($dungtich) > 0 ? $dungtich : null);
    }
}