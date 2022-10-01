<?php

include_once("../../controller/dbconnect.php");

$sqlvisitor = "SELECT * FROM applicationform ORDER BY regdate ASC";
$stmt = $conn->prepare($sqlvisitor);
$stmt->execute();

if (isset($_GET['submit']) && $_GET['submit'] == "search") {
    $search = $_GET['search'];
    $sqlvisitor = "SELECT * FROM applicationform WHERE fullname LIKE '%$search%'";
} else {
    $sqlvisitor = "SELECT * FROM applicationform";
}

if (isset($_GET['op'])) {
    $op = $_GET['op'];
    if ($op == 'delete') {
        $id = $_GET['id'];
        $sqldelete = "DELETE FROM applicationform WHERE id = '$id'";

        $stmtw = $conn->prepare($sqldelete);
        if ($stmtw->execute()) {
            echo "<script> alert('Delete Success')</script>";
            echo "<script> window.location.replace('visitor.php')</script>";
        } else {
            echo "<script> alert('Delete Failed')</script>";
            echo "<script> window.location.replace('visitor.php')</script>";
        }
    }
}

if (isset($_POST["submit"])) {

    $fullname = $_POST["fullname"];
    $compname = $_POST["compname"];
    $address = $_POST["address"];
    $phoneno = $_POST["phoneno"];
    $bdate = $_POST["bdate"];
    $time = $_POST["time"];
    $person = $_POST["person"];
    $reason = $_POST["reason"];
    $sqlapply = "INSERT INTO `applicationform` (`fullname`, `compname`, `address`, `phoneno`, `bdate`, `time`, `person`, `reason`, `status`) VALUES ('$fullname', '$compname', '$address', '$phoneno', '$bdate', '$time', '$person', '$reason', 'Approved')";

    $conn->exec($sqlapply);
}


$results_per_page = 5;
if (isset($_GET['pageno'])) {
    $pageno = (int)$_GET['pageno'];

    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
    $pageno = 1;
    $page_first_result = ($pageno - 1) * $results_per_page;
}

$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sqlvisitor = $sqlvisitor . " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqlvisitor);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html>

<head>
    <title>SOCVMS Admin Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-2020.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script type="text/javascript" src="js/script.js"></script>
</head>

<style>
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 80%;
    }

    #customers td,
    #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #customers tr:hover {
        background-color: #ddd;
    }

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #38456B;
        color: white;
    }
    .modal {
        display: none;
        position: fixed;
        z-index: 8;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        margin: 50px auto;
        border: 1px solid #999;
        width: 60%;
    }

    span {
        color: #666;
        display: block;
        padding: 0 0 5px;
    }

    form {
        padding: 25px;
        margin: 25px;
        box-shadow: 0 2px 5px #f5f5f5;
        background: #eee;
    }

    .input1,
    .textarea1 {
        width: 90%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #1c87c9;
        outline: none;
    }

    .contact-form button {
        width: 100%;
        padding: 10px;
        border: none;
        background: #1c87c9;
        font-size: 16px;
        font-weight: 400;
        color: #fff;
    }

    button:hover {
        background: #2371a0;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
    #rcorners2 {
        border-radius: 25px;
        border: 2px solid #3C4054;
        padding: 20px;
        width: 1150px;
        height: 840px;
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
        <div class="w3-header w3-display-container w3-padding-32 w3-center">
            <h1 style="text-shadow: 0px 4px 3px rgba(0,0,0,0.4), 0px 8px 13px rgba(0,0,0,0.1), 0px 18px 23px rgba(0,0,0,0.1);"><strong>SOCVMS VISITOR LIST</strong></h1>
        </div>

        <div>
            <div style="margin:auto;max-width:300px; margin-left: 120px;">
                <button style="box-shadow: 5px 5px 5px 0px rgba(0,0,0,0.3);
        filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));"><a href="excel.php" class="fa fa-download button"></a></button>
                <button class="button" data-modal="modalOne" style="box-shadow: 5px 5px 5px 0px rgba(0,0,0,0.3);
        filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));"><i class="fa fa-user"></i></button>
            </div>

            <div id="modalOne" class="modal">
                <div class="modal-content">
                    <div class="contact-form">
                        <a class="close">&times;</a>
                        <form action="visitor.php" name="registerForm" method="post" enctype="multipart/form-data">
                            <h2>Add Visitor</h2>
                            <div>
                                <input class="input1" id="fullname" type="text" name="fullname" placeholder="Full name" />
                                <input class="input1" type="text" id="compname" name="compname" placeholder="Company Name" />
                                <textarea class="textarea1" id="address" name="address" rows="2" placeholder="Address" required></textarea>
                                <input class="input1" id="phone" type="number" placeholder="(XXX) XXX-XXXX" name="phoneno" placeholder="Phone no." required />
                                <input class="input1" id="person" type="person" name="person" placeholder="Person To Meet" required />
                                <input class="input1" id="bdate" type="date" name="bdate" placeholder="Date" required />
                                <input class="input1" type="time" id="time" name="time" placeholder="Time" required />
                                <textarea class="textarea1" id="reason" name="reason" rows="2" placeholder="Reason To Visit" required></textarea>
                            </div>
                            <input type="submit" name="submit" class="button" value="Submit">
                        </form>
                    </div>
                </div>
            </div>

            <form class="example" action="visitor.php" method="get" style="margin:auto;max-width:300px; margin-right: 40px; ">
                <input type="text" placeholder="Search Visitor Name" name="search">
                <button type="submit" name="submit" value="search"><i class="fa fa-search"></i></button>
            </form>

            <br><br>
        </div>

        <?php
        echo "<table id='customers' style='margin-left: 120px; margin-top:5px'>";
        echo "<tr'>";
        echo "<th class='w3-center' style='box-shadow: 5px 5px 5px 0px rgba(0,0,0,0.3);
        filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));'>Visitor Name</th>
        <th class='w3-center' style='box-shadow: 5px 5px 5px 0px rgba(0,0,0,0.3);
        filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));'>Person Too Meet</th>
        <th class='w3-center' style='box-shadow: 5px 5px 5px 0px rgba(0,0,0,0.3);
        filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));'>Apply Date</th>
        <th class='w3-center' style='box-shadow: 5px 5px 5px 0px rgba(0,0,0,0.3);
        filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));'>Visit Date</th>
        <th class='w3-center' style='box-shadow: 5px 5px 5px 0px rgba(0,0,0,0.3);
        filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));'>Time</th>
        <th class='w3-center' style='box-shadow: 5px 5px 5px 0px rgba(0,0,0,0.3);
        filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));'>Status</th>
        <th class='w3-center' style='box-shadow: 5px 5px 5px 0px rgba(0,0,0,0.3);
        filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));'>Reject Reason</th>
        <th class='w3-center' style='box-shadow: 5px 5px 5px 0px rgba(0,0,0,0.3);
        filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));'>Action</th>
        </tr>";

        foreach ($rows as $visitor) {
            $fullname = $visitor['fullname'];
            $person = $visitor['person'];
            $vdate = $visitor['regdate'];
            $bdate = $visitor['bdate'];
            $time = $visitor['time'];
            $status = $visitor['status'];
            $reject_reason = $visitor['reject_reason'];


            echo "<tr>";
            echo "<td>" . $visitor['fullname'] . "</td>";
            echo "<td>" . $visitor['person'] . "</td>";
            echo "<td>" . date("jS M Y",strtotime($vdate)) . "</td>";
            echo "<td>" . date("jS M Y",strtotime($bdate)) . "</td>";
            echo "<td>" . date("g:i A",strtotime($visitor['time'])). "</td>";
            echo "<td>" . $visitor['status'] . "</td>";
                if ( $status == "Rejected" ) {
                    echo "<td>". $visitor['reject_reason'] . "</td>";
                } else {
                    echo "<td>". $visitor['reject_reason'] . "</td>";
                }
            echo "<td class='w3-center'><a href='visitor.php?op=delete&id= " . $visitor['id'] . "'><i class='fa fa-trash-o' style='text-decoration:none'></i></a></td>";
            echo "</tr>";
        }
        ?>

        </table>

        <div style="margin-left: 90px">
            <?php
            $num = 1;
            if ($pageno == 1) {
                $num = 1;
            } else if ($pageno == 2) {
                $num = ($num) + 5;
            } else {
                $num = $pageno * 5 - 4;
            }
            echo "<div class='row-pages w3-padding-32'>";
            echo "<center>";
            for ($page = 1; $page <= $number_of_page; $page++) {
                echo '<a href = "visitor.php?pageno=' . $page . '" style="text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
            }
            echo " ( " . $pageno . " )";
            echo "</center>";
            echo "</div>";
            ?>
        </div>

    </div>

    <script>
        let modalBtns = [...document.querySelectorAll(".button")];
        modalBtns.forEach(function(btn) {
            btn.onclick = function() {
                let modal = btn.getAttribute("data-modal");
                document.getElementById(modal).style.display = "block";
            };
        });
        let closeBtns = [...document.querySelectorAll(".close")];
        closeBtns.forEach(function(btn) {
            btn.onclick = function() {
                let modal = btn.closest(".modal");
                modal.style.display = "none";
            };
        });
        window.onclick = function(event) {
            if (event.target.className === "modal") {
                event.target.style.display = "none";
            }
        };
    </script>
</body>

</html>