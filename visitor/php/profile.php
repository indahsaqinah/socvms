<?php
include_once("../../controller/dbconnect.php");
session_start();
$user_id = $_SESSION["user"]["id"];

if (isset($_POST["submit"])) {
    $fullname = $_POST["fullname"];
    $compname = $_POST["compname"];
    $address = $_POST["address"];
    $phoneno = $_POST["phoneno"];
    $email = $_POST["email"];
    $sqlprofile = "UPDATE `users` SET `fullname` = '$fullname', `email` = '$email', `compname` = '$compname', `address` = '$address', `phoneno` = '$phoneno' WHERE `id` = '$user_id' ";

    try {
        $conn->exec($sqlprofile);
        if (file_exists($_FILES["fileToUpload"]["tmp_name"]) || is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])) {
            uploadImage($phoneno);
        }
        echo "<script>window.location.replace('mainpage.php')</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Edit failed')</script>";
    }
}

$sqlprofile = "SELECT * FROM users WHERE `id` = '$user_id' LIMIT 1";

$stmt = $conn->prepare($sqlprofile);
$stmt->execute();
$rows = $stmt->fetchAll();
$user = $rows[0];

function uploadImage($id)
{
    $target_dir = "../../res/userpic/";
    $target_file = $target_dir . $id . ".jpg";
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>SOCVMS Visitor Profile</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/profilestyle.css">
    <script type="text/javascript" src="../js/script.js"></script>
</head>

<style>

    #rcorners2 {
        border-radius: 25px;
        border: 2px solid #3C4054;
        padding: 20px;
        width: 1100px;
        height: 520px;
        box-shadow: 5px 5px 5px 0px rgba(0, 0, 0, 0.3);
        filter: drop-shadow(5px 5px 5px rgba(0, 0, 0, 0.3));
    }
</style>

<body style="background-image: url('../../res/bg.png');">

    <nav class="w3-sidebar w3-bar-block w3-animate-left w3-text-black w3-collapse w3-top w3-center" style="background-color: #9DB0E8;z-index:3;width:300px;font-weight:bold; box-shadow: 5px 5px 5px 0px rgba(0,0,0,0.3);
        filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));" id="mySidebar"><br>
        <img src="../../res/logo.png" style="width:90%" class="w3-center">
        <p class="w3-padding-16 w3-text-black">SOC VISITOR MANAGEMENT SYSTEM</p><br><br><br><br><br>
        <a href="mainpage.php" onclick="w3_close()" class="w3-button w3-bar-item">APPLICATION STATUS</a>
        <a href="applicationform.php" onclick="w3_close()" class="w3-bar-item w3-button">APPLICATION FORM</a><br><br>
        <a href="profile.php" onclick="w3_close()" class="w3-bar-item w3-button">PROFILE</a>
        <a href="../../index.php" onclick="w3_close()" class="w3-bar-item w3-button">LOGOUT</a>
        <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button w3-padding w3-hide-large">CLOSE</a>
    </nav>

    <!-- Top menu on small screens -->
    <header class="w3-container w3-top w3-hide-large w3-white w3-xlarge w3-padding-16">
        <span class="w3-left w3-padding">SOC VISITOR MANAGEMENT SYSTEM</span>
        <a href="javascript:void(0)" class="w3-right w3-button w3-white" onclick="w3_open()">☰</a>
    </header>

    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

    <!-- Navbar on small screens (Hidden on medium and large screens) -->
    <div class="w3-top w3-hide-large w3-hide-medium" id="myNavbar">
        <div class="w3-bar w3-black w3-opacity w3-hover-opacity-off w3-center w3-small">
            <a href="mainpage.php" class="w3-bar-item w3-button" style="width:25% !important">APPLICATION STATUS</a>
            <a href="applicationform.php" class="w3-bar-item w3-button" style="width:25% !important">APPLICATION FORM</a>
            <a href="#../../index.php" class="w3-bar-item w3-button" style="width:25% !important">LOGOUT</a>
        </div>
    </div>

    <div class="w3-main w3-container w3-white" id="rcorners2" style="margin-left:350px; margin-top:100px;">

        <div class="container bootstrap snippets bootdey">
            <h1 class="text-primary" style="text-shadow: 0px 4px 3px rgba(0,0,0,0.3), 0px 8px 13px rgba(0,0,0,0.1), 0px 18px 23px rgba(0,0,0,0.1);">Edit Profile</h1>
            <hr>
            <form class="form-horizontal" role="form" action="profile.php" name="registerForm" method="post" enctype="multipart/form-data">

                <div class="row">
                    <!-- left column -->
                    <div class="col-md-3 form-group">
                        <div class="text-center">
                            <?php

                            foreach ($rows as $pic) {
                                $phoneno = $pic['phoneno'];

                                echo "<div class='w3-padding-small'><img class='w3-container w3-image' src='../../res/userpic/$phoneno.jpg'></a></div>";
                            }
                            ?>
                            <input class="w3-margin" type="file" onchange="previewFile();" name="fileToUpload" id="fileToUpload">
                        </div><p class="w3-center">Profile Picture</p>
                    </div>

                    <!-- edit form column -->
                    <div class=" col-md-9 personal-info">
                        <h3>Personal info</h3>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Full Name:</label>
                            <div class="col-lg-8">
                                <input class="form-control" id="fullname" type="name" name="fullname" value="<?php echo $user['fullname']; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Company Name:</label>
                            <div class="col-lg-8">
                                <input class="form-control" id="compname" type="compname" name="compname" value="<?php echo $user['compname']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Address:</label>
                            <div class="col-lg-8">
                                <textarea class="form-control" id="address" name="address" rows="2" required><?php echo $user['address']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Phone:</label>
                            <div class="col-lg-8">
                                <p>+60<input class="form-control" id="phone" type="number" placeholder="123456789" name="phoneno" value="<?php echo $user['phoneno']; ?>" required></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Email:</label>
                            <div class="col-lg-8">
                                <input class="form-control" id="email" type="email" name="email" value="<?php echo $user['email']; ?>">
                            </div>
                        </div>
                        <div class="row gutters">
                            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-11 col-11">
                                <div class="text-right">
                                    <input type="submit" id="submit" name="submit" class="btn btn-primary" value="Update">
                                </div>
                            </div>
                        </div>
            </form>
        </div>
    </div>
    </div>


    <hr>