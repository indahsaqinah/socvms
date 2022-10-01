<?php
include_once("../../controller/dbconnect.php");
session_start();
$user_id = $_SESSION["user"]["id"];
$sqlvisitor = "SELECT * FROM applicationform WHERE `status` = 'Approved' OR `status` = 'Rejected' ORDER BY regdate DESC";

$results_per_page = 6;
if (isset($_GET['pageno'])) {
    $pageno = (int)$_GET['pageno'];

    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
    $pageno = 1;
    $page_first_result = ($pageno - 1) * $results_per_page;
}

$stmt = $conn->prepare($sqlvisitor);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);

$sqlvisitor = $sqlvisitor . " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqlvisitor);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>SOCVMS Completed</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style1.css">
    <script type="text/javascript" src="js/script.js"></script>

</head>

<style>
    @media screen and (min-width: 1000px) {
        .w3-grid-template {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
        }

        .w3-image {
            width: auto;
            height: auto;
            object-fit: fill;
        }

        body {
            width: 98%;
        }
    }

    .button-one {
        background: #f0810f;
    }

    .button-two {
        background: #a2c523;
    }

    .button-one,
    .button-two {
        color: #1d1d1d;
        /* text color */
        display: inline-block;
        border-radius: 0;
        /* square corners */
        padding: 10px 18px;
        /* space around text */
        text-transform: uppercase;
        /* all capital letters */
        font-weight: 700;
        letter-spacing: 1px;
        -moz-transition: all 0.2s;
        -webkit-transition: all 0.2s;
        transition: all 0.2s;
    }

    .button-one:hover,
    .button-two:hover,
    .button-three:hover {
        background: #000;
        color: #fff;
    }

    #rcorners2 {
        border-radius: 25px;
        border: 2px solid #3C4054;
        padding: 20px;
        width: 1160px;
        height: 1355px;
        box-shadow: 5px 5px 5px 0px rgba(0, 0, 0, 0.3);
        filter: drop-shadow(5px 5px 5px rgba(0, 0, 0, 0.3));
    }
</style>

<body style="background-image: url('../../res/bg.png');">

    <nav class="w3-sidebar w3-bar-block w3-animate-left w3-text-black w3-collapse w3-top w3-center" style="background-color: #9DB0E8;z-index:3;width:300px;font-weight:bold; box-shadow: 5px 5px 5px 0px rgba(0,0,0,0.3);
        filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));" id="mySidebar"><br>
        <img src="../../res/logo.png" style="width:90%" class="w3-center"><br>
        <p class="w3-padding-8">SOC VISITOR MANAGEMENT SYSTEM</p><br><br><br><br>
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
            <a href="#../../index.php" class="w3-bar-item w3-button" style="width:25% !important">LOGOUT</a>
        </div>
    </div>

    <!--Main-->
    <div class="w3-main w3-container w3-white" id="rcorners2" style="margin-left:330px; margin-top:20px;">

        <!--Header-->
        <div class="w3-header w3-display-container w3-2019-creme-de-peche w3-padding-48 w3-center">
            <h1 style="text-shadow: 0px 4px 3px rgba(0,0,0,0.4), 0px 8px 13px rgba(0,0,0,0.1), 0px 18px 23px rgba(0,0,0,0.1);"><strong>VISITOR APPLICATION VERIFICATION</strong></h1>
        </div>

        <div class="w3-center">
            <a class="button-one" title="Relevant Title" href="mainpage.php">Pending</a><a class="button-two" title="Relevant Title" href="completedpage.php">Completed</a>
        </div>

        <!--Grid Content-->
        <br>
        <div class="w3-grid-template">
            <?php
            foreach ($rows as $visitor) {

                $status = $visitor['status'];
                if ($status == "Approved") {
                    $color = "color:green";
                } else {
                    $color = "color:red";
                }

                $fullname = $visitor['fullname'];
                $compname = $visitor['compname'];
                $phoneno = $visitor['phoneno'];
                $address = $visitor['address'];
                $person = $visitor['person'];
                $reason = $visitor['reason'];
                $bdate = $visitor['bdate'];
                $status = $visitor['status'];
                $reject_reason = $visitor['reject_reason'];
                $vd = new DateTime($visitor['bdate']);

                echo "<div class='w3-center w3-padding'>";
                echo "<div class='w3-card-4' style='background-color:#E0FFDA;'>";
                echo "<header class='w3-container w3-padding-8 w3-text-white' style='background-color:#1A4D11;'>";
                echo "<h5><strong>$fullname</strong></h5>";
                echo "</header>";
                echo "<br>";
                echo "<img class='w3-image' src='../../res/userpic/$phoneno.jpg'" . " onerror=this.onerror=null;this.src='../../res/profile.jpg'" . " style='width:50%;height:150px'>";
                echo "<div class='w3-container w3-left-align'><hr>";
                echo "<p><i style='font-size:16px'>Phone No</i>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: 0$phoneno<br>
                        <i style='font-size:16px'>Address</i>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: $address<br>
                        <i style='font-size:16px'>Person To Meet</i>&nbsp&nbsp: $person<br>
                        <i style='font-size:16px'>Reason To Visit</i>&nbsp&nbsp: $reason<br>
                        <i style='font-size:16px'>Visit Date</i>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: " . $vd->format('d/m/Y') . "</p><hr>
                        <b style='font-size:16px' style='$color'><center>Status&nbsp&nbsp: $status</center></b>";
            
                            if ( $status == "Rejected" ) {
                                echo "<style='font-size:16px'><center>Reason&nbsp&nbsp: $reject_reason</center>";
                            }

                echo "<div id='rsvp'>";
                echo "<br>";
                echo "</p>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            ?>

        </div>

        <?php
        $num = 1;
        if ($pageno == 1) {
            $num = 1;
        } else if ($pageno == 2) {
            $num = ($num) + 6;
        } else {
            $num = $pageno * 6 - 5;
        }
        echo "<div class='row-pages w3-padding-32'>";
        echo "<center>";
        for ($page = 1; $page <= $number_of_page; $page++) {
            echo '<a href = "completedpage.php?pageno=' . $page . '" style="text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
        }
        echo " ( " . $pageno . " )";
        echo "</center>";
        echo "</div>";
        ?>

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

</body>

</html>