<?php
if (isset($_POST["submit"])) {
    include 'dbconnect.php';
    $username = $_POST["username"];
    $pass = $_POST["password"];
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = '$username' AND password = '$pass'");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll();
    
    if (count($rows)) {
        session_start();
        $_SESSION["user"] = $rows[0];
        if ($_SESSION["user"]["role"] == "visitor") {
            echo "<script>alert('Login Success');</script>";
            echo "<script> window.location.replace('../visitor/php/mainpage.php')</script>";
        } else if ($_SESSION["user"]["role"] == "top_management") {
            echo "<script>alert('Login Success');</script>";
            echo "<script> window.location.replace('../topmanagement/php/mainpage.php')</script>";
        } else if ($_SESSION["user"]["role"] == "admin") {
            echo "<script>alert('Login Success');</script>";
            echo "<script> window.location.replace('../admin/php/dashboard.php')</script>";
        }
    } else {
        echo "<script>alert('Login Failed');</script>";
        echo "<script> window.location.replace('../index.php')</script>";
    }
}
