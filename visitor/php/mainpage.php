<?php
session_start();

include_once("../../controller/dbconnect.php");

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

$sqldisplay = "SELECT * FROM applicationform WHERE user_id= " . $_SESSION["user"]["id"] . " ORDER BY regdate DESC";

$results_per_page = 3;
if (isset($_GET['pageno'])) {
    $pageno = (int)$_GET['pageno'];

    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
    $pageno = 1;
    $page_first_result = ($pageno - 1) * $results_per_page;
}

$stmt = $conn->prepare($sqldisplay);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);

$sqldisplay = $sqldisplay . " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqldisplay);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html>

<head>

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

        #rcorners2 {
            border-radius: 25px;
            border: 2px solid #3C4054;
            padding: 20px;
            width: 850px;
            height: 600px;
            box-shadow: 5px 5px 5px 0px rgba(0, 0, 0, 0.3);
            filter: drop-shadow(5px 5px 5px rgba(0, 0, 0, 0.3));
        }
    </style>

    <title>SOCVMS Visitor Main Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script type="text/javascript" src="../js/script.js"></script>
</head>

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

    <div class="w3-content w3-main w3-container w3-white" id="rcorners2" style="margin-left:550px; margin-top:80px;">

        <div class="welcome">
            <h3 style="font-size: 50px; font-family: Times New Roman;">Welcome, <strong>
                    <?php
                    $_SESSION['user']['username'];
                    print_r($_SESSION['user']['username']);
                    echo ".";
                    ?>
                </strong></h3>
        </div><br>

        <div class="container bootstrap snippets bootdey">
            <h1 class="text-primary" style="text-shadow: 0px 4px 3px rgba(0,0,0,0.3), 0px 8px 13px rgba(0,0,0,0.1), 0px 18px 23px rgba(0,0,0,0.1);">SOC Application Status</h1>
            <hr>


            <div>
                <p class="w3-justify">You should wait for SOC to notify you whether your application is <span style="color:green;"><b>Approved</b></span>,
                    <span style="color:red"><b>Rejected</b></span>, or <span style="color:orange"><b>Pending</b></span>.
                </p>
            </div>

            <div id="tablevisitor" style="margin-left:30px;">

                <table style="margin-left:60px;">
                    <tr style="box-shadow: 5px 5px 5px 0px rgba(0,0,0,0.3);
                    filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));">
                        <th>Ref No.</th>
                        <th>Apply Date</th>
                        <th>Visit Date</th>
                        <th>Status</th>
                        <th>Details</th>
                    </tr>

                    <?php

                    foreach ($rows as $row) {

                        $status = $row['status'];
                        if ($status == "Approved") {
                            $color = "color:green";
                        } else if ($status == "Pending") {
                            $color = "color:orange";
                        } else {
                            $color = "color:red";
                        }

                        echo "<tr class='w3-center'>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . date("jS M Y", strtotime($row['regdate'])) . "</td>";
                        echo "<td>" . date("jS M Y", strtotime($row['bdate'])) . "</td>";
                        echo "<td style='$color'><b>".$status ."</b></td>";  
                            if ( $status == "Rejected" ) {
                                echo "<td>" . $row[reject_reason] ."</td>";
                            } elseif ( $status == "Approved" ) {
                                echo "<td>✔</td>";
                            } else {
                                echo "<td></td>";
                            }
                        // echo "<td><button id='myBtn'>View</button>";
                        // echo "<div id='myModal' class='modal'>";
                        // echo "<div class='modal-content w3-container w3-padding w3-card w3-round w3-border;'>";
                        // echo "<table>";
                        // echo "<tr><td style='width: 40%'>Person To Meet: </td><td style='width: 60%'>$row[person]</td></tr>";
                        // echo "<tr><td style='width: 40%'>Reason To Visit: </td><td style='width: 60%'>$row[reason]</td></tr>";
                        // echo "<tr><td tyle='width: 40%'>Reject reason: </td><td style='width: 60%'>$row[$reject_reason]</td></tr>";

                        
                        // if ( $row[status] == "Rejected" ) {
                        //     echo "<tr><td tyle='width: 40%>Reject reason: </td><td style='width: 60%'>$row[$reject_reason]</td></tr>";
                        // }
                        
                        // echo "<span class='close'>&times;</span>";
                        // echo "</table>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div></td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
                <div style="margin-left: -400px">
                    <?php
                    $num = 1;
                    if ($pageno == 1) {
                        $num = 1;
                    } else if ($pageno == 2) {
                        $num = ($num) + 3;
                    } else {
                        $num = $pageno * 3 - 2;
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
                </div>
            </div>

        </div>


        <script>
            // // Get the modal
            // var modal = document.getElementById("myModal");

            // // Get the button that opens the modal
            // var btn = document.getElementById("myBtn");

            // // Get the <span> element that closes the modal
            // var span = document.getElementsByClassName("close")[0];

            // // When the user clicks the button, open the modal 
            // btn.onclick = function() {
            //     modal.style.display = "block";
            // }

            // // When the user clicks on <span> (x), close the modal
            // span.onclick = function() {
            //     modal.style.display = "none";
            // }

            // // When the user clicks anywhere outside of the modal, close it
            // window.onclick = function(event) {
            //     if (event.target == modal) {
            //         modal.style.display = "none";
            //     }
            // }

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