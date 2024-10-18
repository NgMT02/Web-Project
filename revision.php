<?php
$servername = "localhost";
$username = "username";
$password = "";
$dbname = "sse3308";

try{
    $conn = new PDO("mysql:host = $servername;dbname = $dbname",$username,$password);
    $conn -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE TABLE revision(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL)";

    $conn -> exec($sql);
    echo "Table created";
}catch(PDOEXception $e){
    echo $sql."<br>".$e->getMessage();
}

$conn = null;
?>