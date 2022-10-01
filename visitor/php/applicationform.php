<?php
include_once("../../controller/dbconnect.php");
session_start();
$user_id = $_SESSION["user"]["id"];
// $user_fullname = $_SESSION["user"]["fullname"];
// $user_compname = $_SESSION["user"]["compname"];
// $user_address = $_SESSION["user"]["address"];
// $user_phoneno = $_SESSION["user"]["phoneno"];

// checking profile
$sqlc = "SELECT * FROM users WHERE id= " . $_SESSION["user"]["id"];
$stmt2 = $conn->prepare($sqlc);
$stmt2->execute();
$result2 = $stmt2->setFetchMode(PDO::FETCH_ASSOC);
$rows2 = $stmt2->fetch();

if($rows2["fullname"]=="" || $rows2["address"]=="" || $rows2["phoneno"]==""){
    echo '<script> alert("Please fill all profile data before proceed!"); window.location= "profile.php"; </script>';
}
// end checking

$user_fullname = $rows2["fullname"];
$user_compname = $rows2["compname"];
$user_address = $rows2["address"];
$user_phoneno = $rows2["phoneno"];

$sqlprofile = "SELECT `fullname`, `compname`, `address`, `phoneno` FROM `users`";

$stmt = $conn->prepare($sqlprofile);
$stmt->execute();

if (isset($_POST["submit"])) {
    $person = $_POST["person"];
    $bdate = $_POST["bdate"];
    $time = $_POST["time"];
    $reason = $_POST["reason"];
    $sqlapply = "INSERT INTO `applicationform`(`fullname`, `compname`, `address`, `phoneno`,`person`, `bdate`, `time`, `reason`, `user_id`, `status`) VALUES('$user_fullname', '$user_compname', '$user_address', '$user_phoneno','$person', '$bdate', '$time', '$reason', '$user_id', 'Pending')";

    try {
        $conn->exec($sqlapply);
        echo "<script>alert('Your application has been submitted.')</script>";
        echo "<script> window.location.replace('mainpage.php')</script>";
    } catch (\PDOException $e) {
        echo "<script>alert('Failed! Try again.')</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>SOCVMS Visitor Application Form</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/script.js"></script>
</head>

<style>
    .test {
        text-shadow: 0 0 6px #000000, 0 0 5px #000000;
    }
    #rcorners2 {
            border-radius: 25px;
            border: 2px solid #3C4054;
            padding: 20px;
            width: 1150px;
            height: 500px;
            box-shadow: 5px 5px 5px 0px rgba(0,0,0,0.3);
        filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));
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
            <h1 class="text-primary" style="text-shadow: 0px 4px 3px rgba(0,0,0,0.3), 0px 8px 13px rgba(0,0,0,0.1), 0px 18px 23px rgba(0,0,0,0.1);">SOC Application Form</h1>
            <hr>
            <div class="row">
                <!-- left column -->
                <div class="col-md-3">
                    <div class="text-center">
                        <img src="../../res/background.jpg" class="avatar img-rounded" style="width: 280px; height: 180px;">

                    </div>
                </div>

                <!-- edit form column -->
                <div class="col-md-9 personal-info">
                    <form class="form-horizontal" action="applicationform.php" name="registerForm" method="post" enctype="multipart/form-data" onsubmit="return confirmDialog()">
                        <div class="form-group">
                            <label for="person" class="col-lg-3 control-label">Person to Meet:</label>
                            <div class="col-lg-8">
                                <input class="form-control" id="person" type="person" name="person" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bdate" class="col-lg-3 control-label">Date to Visit:</label>
                            <div class="col-lg-8">
                                <input class="form-control" id="bdate" type="date" name="bdate" required>
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Time:</label>
                            <div class="col-lg-8">
                                <input class="time" type="time" id="time" name="time" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="reason" class="col-lg-3 control-label">Reason to Visit:</label>
                            <div class="col-lg-8">
                                <textarea id="reason" name="reason" rows="2" cols="75" required></textarea>
                            </div>
                        </div>

                        <div class="row gutters">
                            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-11 col-11">
                                <div class="text-right">
                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</body>

</html>