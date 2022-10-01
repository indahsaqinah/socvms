<?php
session_start();

if (isset($_POST["submit"])) {
    include 'dbconnect.php';
    $username = $_POST["username"];
    $pass = $_POST["password"];
    $email = $_POST["email"];
    $sqlregister = "INSERT INTO `users`(`username`, `password`, `email`, `role`) VALUES('$username', '$pass', '$email', 'visitor')";
    
    try {
        $conn->exec($sqlregister);
        echo "<script>alert('Registration Success');</script>";
        echo "<script> window.location.replace('../index.php#login')</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Registration failed')</script>";
        echo "<script>window.location.replace('../index.php#login')</script>";
    }
}

?>
