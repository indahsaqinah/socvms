<?php
include_once("../../controller/dbconnect.php");
require_once('../../library/Mailer.php');
session_start();

function send_email($data){

    if(!isset($data)){
        die('Email no data');
    }

    $mailer = new Mailer();
	
    // Set Recipient Details
    $xRecipientList = $data['email'];
    $xRecipientName = $data['fullname'];
    
    // Set Subject
    $xSubject = 'Application Status - '.$data['status'].' - Ref No: '.rand(1000,9999);
    
    // Set Message
    $xMsg = 'Your application is '.$data['status'].'.';

    if(strtoupper($data['status']) === 'REJECTED'){
        $xMsg.= '<br />Reason: '.$data['reject_reason'];
    }
    
    // Don't worry, I will do the rest.
    $xPriceListEmailList = explode(',',$xRecipientList);
    $xRecipient = array();
    foreach ($xPriceListEmailList as $val):
        array_push($xRecipient,trim($val));
    endforeach;
    $mailer->sendmail($xRecipient,$xRecipientName,$xSubject,$xMsg,TRUE);
    
}

$user_id = $_SESSION["user"]["id"];
$sqlvisitor = "SELECT * FROM applicationform WHERE `status` = 'Pending' ORDER BY regdate DESC";

if (isset($_GET["status"])) {

    $status = $_GET["status"];
    $id = $_GET["id"];

    if(isset($_POST['reject_reason'])){
        $reject_reason = $_POST['reject_reason'];
    }else{
        $reject_reason = "";
    }

    // Get Application User Details
    $sqlGetEmail = "SELECT u.email,u.fullname FROM applicationform a LEFT JOIN users u ON a.user_id = u.id WHERE a.id = '$id' LIMIT 1";
    $stmt = $conn->prepare($sqlGetEmail);
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $data = $stmt->fetchAll()[0];
    $data += ['status'=>$status, 'reject_reason'=>$reject_reason];
        
    $sqltest = "UPDATE `applicationform` SET `status` = '$status', reject_reason = '$reject_reason' WHERE `id` = '$id'";

    try {
        $conn->exec($sqltest);
        send_email($data);
        echo "<script>alert('Successful')</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Please fill again')</script>";
    }
}

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
    <title>SOCVMS Top Mngmt Main Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/style1.css">
    <script type="text/javascript" src="js/script.js"></script>

</head>

<style>

       /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: absolute;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            padding-top: 200px;
            /* Location of the box */
            left: 200px;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
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
    
    .button-three {
    background: #f0810f;
    }
    .button-four {
    background: #a2c523;
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
    
    * {
        box-sizing: border-box;
      }
      .loginPopup {
        position: relative;
        text-align: center;
        width: 100%;
      }
      .formPopup {
        display: none;
        position: fixed;
        left: 45%;
        top: 15%;
        transform: translate(-50%, 5%);
        border: 3px solid #999999;
        z-index: 9;
      }
      .formContainer {
        max-width: 300px;
        padding: 20px;
        background-color: #fff;
      }
      .formContainer input[type=text],
      .formContainer input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 20px 0;
        border: none;
        background: #eee;
      }
      .formContainer input[type=text]:focus,
      .formContainer input[type=password]:focus {
        background-color: #ddd;
        outline: none;
      }
      .formContainer .btn {
        padding: 12px 20px;
        border: none;
        background-color: #8ebf42;
        color: #fff;
        cursor: pointer;
        width: 100%;
        margin-bottom: 15px;
        opacity: 0.8;
      }
      .formContainer .cancel {
        background-color: #cc0000;
      }
      .formContainer .btn:hover,
      .openButton:hover {
        opacity: 1;
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
                $fullname = $visitor['fullname'];
                $compname = $visitor['compname'];
                $phoneno = $visitor['phoneno'];
                $address = $visitor['address'];
                $person = $visitor['person'];
                $reason = $visitor['reason'];
                $bdate = $visitor['bdate'];
                $vd = new DateTime($visitor['bdate']);

                echo "<div class='w3-center w3-padding'>";
                echo "<div class='w3-card-4' style='background-color:#E7E7E7;'>";
                echo "<header class='w3-container w3-padding-8 w3-text-white' style='background-color:#373636;'>";
                echo "<h5><strong>$fullname</strong></h5>";
                echo "</header>";
                echo "<br>";
                echo "<img class='w3-image' src='../../res/userpic/$phoneno.jpg'" . " onerror=this.onerror=null;this.src='../../res/profile.jpg'" . " style='width:50%;height:150px'>";
                echo "<div class='w3-container w3-left-align'><hr>";
                echo "<p><i style='font-size:16px'>Phone No</i>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: 0$phoneno<br>
                        <i style='font-size:16px'>Address</i>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: $address<br>
                        <i style='font-size:16px'>Person To Meet</i>&nbsp&nbsp: $person<br>
                        <i style='font-size:16px'>Reason To Visit</i>&nbsp&nbsp: $reason<br>
                        <i style='font-size:16px'>Visit Date</i>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: " . $vd->format('d/m/Y') . "</p><hr>";
                echo "<div id='rsvp'>";
                echo "<p class='w3-xlarge w3-center'>";
                echo "<center><a href='mainpage.php?id=" . $visitor['id'] . "&status=Approved' class='accept'>ACCEPT <span class='fa fa-close'></span></a>";
                echo "<a onclick='openForm()' class='openButton deny'>DENY <span class='fa fa-close'></span></button></a>";
                echo "<div class='openBtn'>";
                echo "<div class='loginPopup'>";
                echo "<div class='formPopup' id='popupForm'>";
                echo "<form action='mainpage.php?id=" . $visitor['id'] . "&status=Rejected' method='post' class='formContainer'>";
                echo "<label for='reason'>";
                echo "<strong>Reason</strong>";
                echo "</label>";
                echo "<input type='text' id='reject_reason' name='reject_reason' required>";
                echo "<input class='deny' type='submit' name='submit' value='Submit'>";
                // echo "<button type='submit' class='btn'>Submit</button>";
                echo "<button type='button' class='btn cancel' onclick='closeForm()'>Close</button>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
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
            echo '<a href = "mainpage.php?pageno=' . $page . '" style="text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
        }
        echo " ( " . $pageno . " )";
        echo "</center>";
        echo "</div>";
        ?>

    <script>
    
                // Get the modal
            var modal = document.getElementById("myModal");

            // Get the button that opens the modal
            var btn = document.getElementById("myBtn");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks the button, open the modal 
            btn.onclick = function() {
                modal.style.display = "block";
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

        // Script to open and close sidebar
        function w3_open() {
            document.getElementById("mySidebar").style.display = "block";
            document.getElementById("myOverlay").style.display = "block";
        }

        function w3_close() {
            document.getElementById("mySidebar").style.display = "none";
            document.getElementById("myOverlay").style.display = "none";
        }
              function openForm() {
        document.getElementById("popupForm").style.display = "block";
      }
      function closeForm() {
        document.getElementById("popupForm").style.display = "none";
      }
    </script>



</body>

</html>