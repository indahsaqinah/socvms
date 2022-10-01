<?php
$servername = "localhost";
$username = "fizqinco_socvms_admin";
$password = "Girin@1998";
$dbname = "fizqinco_socvms_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
