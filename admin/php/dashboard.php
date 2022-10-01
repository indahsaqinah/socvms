<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
include_once("../../controller/dbconnect.php");
session_start();

$todaydate = date('Y-m-d');
$sqltoday = "SELECT count(*) AS todaycount FROM applicationform WHERE bdate LIKE '$todaydate%' ";
$stmt = $conn->prepare($sqltoday);
$stmt->execute();
$resulttoday = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rowss = $stmt->fetchAll();
$todaycount = $rowss[0]['todaycount'];

$yesterdaydate = date('Y-m-d', strtotime("-1 days"));
$sql = "SELECT count(*) AS yesterdaycount FROM applicationform WHERE bdate LIKE '$yesterdaydate%' ";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();
$yesterdaycount = $rows[0]['yesterdaycount'];

$sqlprevious = "SELECT count(*) AS previouscount FROM applicationform WHERE bdate < '$yesterdaydate' ";
$stmt = $conn->prepare($sqlprevious);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rowsss = $stmt->fetchAll();
$previouscount = $rowsss[0]['previouscount'];

$totalcount = $yesterdaycount + $todaycount + $previouscount;
?>

<!DOCTYPE html>
<html>

<head>
    <title>SOCVMS Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-2020.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
</head>

<style>
    #rcorners2 {
        border-radius: 25px;
        border: 2px solid #3C4054;
        padding: 20px;
        width: 1150px;
        height: 680px;
        box-shadow: 5px 5px 5px 0px rgba(0, 0, 0, 0.3);
        filter: drop-shadow(5px 5px 5px rgba(0, 0, 0, 0.3));
    }
</style>

<body style="background-image: url('../../res/bg.png');">

    <nav class="w3-sidebar w3-bar-block w3-animate-left w3-text-black w3-collapse w3-top w3-center" style="background-color: #9DB0E8;z-index:3;width:300px;font-weight:bold; box-shadow: 5px 5px 5px 0px rgba(0,0,0,0.3);
        filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));" id="mySidebar"><br>
        <img src="../../res/logo.png" style="width:90%" class="w3-center"><br><br>
        <p class="w3-padding-8">SOC VISITOR MANAGEMENT SYSTEM</p><br><br><br><br>
        <a href="dashboard.php" onclick="w3_close()" class="w3-bar-item w3-button">DASHBOARD</a>
        <a href="visitor.php" onclick="w3_close()" class="w3-bar-item w3-button">VISITOR</a>
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
            <a href="dashboard.php" class="w3-bar-item w3-button" style="width:25% !important">LOGOUT</a>
            <a href="visitor.php" class="w3-bar-item w3-button" style="width:25% !important">LOGOUT</a>
            <a href="../../index.php" class="w3-bar-item w3-button" style="width:25% !important">LOGOUT</a>
        </div>
    </div>

    <!--Main-->
    <div class="w3-main w3-container w3-white" id="rcorners2" style="margin-left:350px; margin-top:20px;">

        <!--Header-->
        <div class="w3-header w3-display-container w3-2019-creme-de-peche w3-padding-32 w3-center">
            <h1 style="text-shadow: 0px 4px 3px rgba(0,0,0,0.4), 0px 8px 13px rgba(0,0,0,0.1), 0px 18px 23px rgba(0,0,0,0.1);"><strong>SOCVMS DASHBOARD</strong></h1><br><br><br><br><br>
        </div>

        <div class="w3-row-padding w3-margin-bottom">
            <div class="w3-half">
                <div class="w3-container w3-padding-32" style="background-color:#217CA3; color:#fff; box-shadow: 5px 5px 5px 0px rgba(0,0,0,0.3);
                filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));">
                    <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
                    <div class="w3-right">
                        <h1><?php echo $todaycount; ?></h1>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Total Today Visitor</h4>
                </div>
            </div>
            <div class="w3-half">
                <div class="w3-container w3-padding-32" style="background-color:#E29930; color:#fff; box-shadow: 5px 5px 5px 0px rgba(0,0,0,0.3);
                filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));">
                    <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
                    <div class="w3-right">
                        <h1><?php echo $yesterdaycount; ?></h1>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Total Yesterday Visitor</h4>
                </div>
            </div>
            <div class="w3-half">
                <br>
                <div class="w3-container w3-padding-32" style="background-color:#32384D; color:#fff; box-shadow: 5px 5px 5px 0px rgba(0,0,0,0.3);
                    filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));">
                    <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
                    <div class="w3-right">
                        <h1><?php echo $previouscount; ?></h1>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Previous Visitor</h4>
                </div>
            </div>
            <div class="w3-half">
                <br>
                <div class="w3-container w3-padding-32" style="background-color:#211F30; color:#fff; box-shadow: 5px 5px 5px 0px rgba(0,0,0,0.3);
                filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));">
                    <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
                    <div class="w3-right">
                        <h1><?php echo $totalcount; ?></h1>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Total Visitor Till Day</h4>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Script to open and close sidebar
        function w3_open() {
            document.getElementById("mySidebar").style.display = "block";
            document.getElementById("myOverlay").style.display = "block";
        }

        function w3_close() {
            document.getElementById("mySidebar").style.display = "none";
            document.getElementById("myOverlay").style.display = "none";
        }
    </script>
    </script>
</body>