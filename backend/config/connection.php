<?php 
function getConnection()
{
    $host = "localhost";
    $username = "root";
    $password = "";

    $connection = mysqli_connect($host, $username, $password, "web_nuochoa");

    if (!$connection) {
        echo "Connection failed: " . mysqli_connect_error();
        return null; 
    }

    return $connection;
}
?>