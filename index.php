<?php
include 'controller/login.php';
include 'controller/signup.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>SOCVMS</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script type="text/javascript" src="script.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY&callback=myMap"></script>
</head>

<body>

    <!-- Icon Bar (Sidebar - hidden on small screens) -->
    <nav class="w3-sidebar w3-bar-block w3-small w3-hide-small w3-center w3-gray">
        <!-- Avatar image in top left corner -->
        <img src="res/logo.png" style="width:100%">
        <a href="#home" class="w3-bar-item w3-button w3-padding-32 w3-hover-black">
            <i class="fa fa-university w3-xxlarge"></i>
            <p>HOME</p>
        </a>
        <a href="#about" class="w3-bar-item w3-button w3-padding-32 w3-hover-black">
            <i class="fa fa-info w3-xxlarge"></i>
            <p>ABOUT</p>
        </a>
        <a href="#contact" class="w3-bar-item w3-button w3-padding-32 w3-hover-black">
            <i class="fa fa-envelope w3-xxlarge"></i>
            <p>CONTACT</p>
        </a>
        <a href="#login" class="w3-bar-item w3-button w3-padding-32 w3-hover-black">
            <i class="fa fa-sign-in w3-xxlarge"></i>
            <p>LOG IN</p>
        </a>
    </nav>

    <!-- Navbar on small screens (Hidden on medium and large screens) -->
    <div class="w3-top w3-hide-large w3-hide-medium" id="myNavbar">
        <div class="w3-bar w3-black w3-opacity w3-hover-opacity-off w3-center w3-small">
            <a href="#home" class="w3-bar-item w3-button" style="width:25% !important">HOME</a>
            <a href="#about" class="w3-bar-item w3-button" style="width:25% !important">ABOUT</a>
            <a href="#contact" class="w3-bar-item w3-button" style="width:25% !important">CONTACT</a>
            <a href="#login" class="w3-bar-item w3-button" style="width:25% !important">LOG IN</a>
        </div>
    </div>

    <div style="margin-left:200px;">

        <!--Home-->
        <div class="w3-display-container w3-center" id="home">
            <img src="res/background.jpg" ; style="width:100%">
            <div class="w3-display-middle w3-container w3-text-black w3-padding-32 w3-hide-small">
                <h1 style="font-weight: bold; font-size: 50px; background-color: white">SOC VISITOR MANAGEMENT SYSTEM</h1>
                <hr class="w3-border-black" style="margin:auto;width:100%">
            </div>
        </div>

        <!--About-->
        <div class="w3-content w3-container w3-padding-32" id="about">
            <h2 class="w3-center">ABOUT</h2>
            <div class="w3-card w3-round">
                <div class="w3-white">
                    <button onclick="myFunction('Demo1')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-circle-o-notch fa-fw w3-margin-right"></i> Vision</button>
                    <div id="Demo1" class="w3-hide w3-container">
                        <p>To be acknowledged as a centre of excellence and main reference in Enterprise Computing.</p>
                    </div>
                    <button onclick="myFunction('Demo2')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-circle-o-notch fa-fw w3-margin-right"></i> Mission</button>
                    <div id="Demo2" class="w3-hide w3-container">
                        <p>To actualize the aspiration of SOC as the centre of excellence and main reference in (i) teaching and learning, (ii) research and innovation, (iii) publication and consultation, and (iv) professional training in the Enterprise Computing related areas.</p>
                    </div>
                    <button onclick="myFunction('Demo3')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-circle-o-notch fa-fw w3-margin-right"></i> Objectives</button>
                    <div id="Demo3" class="w3-hide w3-container">
                        <ul>
                            <li>To provide opportunities for undergraduates, masters and doctoral studies in computing and other relevant disciplines;</li>
                            <li>To expand the knowledge of national development and assist it through the research and consultation activities;</li>
                            <li>To produce graduates with sufficient integrated knowledge encompassing the programme offered by the School of Computing.</li>
                            <li>To produce graduates who will become experts in their career choice.</li>
                            <li>To develop a creative, innovative and wider understanding of computing theory and practice, in line with the globalization and modernization of Computing.</li>
                            <li>To achieve an economic excellence and development with the improvement of quality and skills in computing thus providing expertise and knowledge workers for public or private sectors;</li>
                            <li>To contribute towards the enhancement of knowledge and social development by producing intellectuals and professionals.</li>
                            <li>To establish professional relationship and collaboration with the private and public sectors towards developing expertise in the relevant fields of knowledge.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <!-- Container (Contact Section) -->
        <div class="w3-content w3-container w3-padding-32" id="contact">
            <h2 class="w3-center">CONTACT</h2>
            <p class="w3-center"><em>School of Computing</em></p>

            <div class="w3-row w3-padding-32 w3-section">
                <div class="w3-container">
                    <div class="mapouter">
                        <!--<div class="map-responsive"><iframe width="1000" height="350" id="gmap_canvas" src="https://maps.google.com/maps?q=school%20of%20computing%20uum&t=&z=17&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://putlocker-is.org"></a><br>-->
                        <!--    <style>-->
                        <!--        .mapouter {-->
                        <!--            position: relative;-->
                        <!--            text-align: right;-->
                        <!--            height: 350px;-->
                        <!--            width: 1000px;-->
                        <!--        }-->
                        <!--    </style><a href="https://www.embedgooglemap.net">embed google maps without iframe</a>-->
                        <!--    <style>-->
                        <!--        .gmap_canvas {-->
                        <!--            overflow: hidden;-->
                        <!--            background: none !important;-->
                        <!--            height: 350px;-->
                        <!--            width: 1000px;-->
                        <!--        }-->
                        <!--    </style>-->
                        <!--</div>-->
                        
                        <div class="map-responsive">
                            <iframe src="https://maps.google.com/maps?q=school%20of%20computing%20uum&t=&z=17&ie=UTF8&iwloc=&output=embed" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="w3-row-padding w3-large w3-center" style="margin:32px 0">
                        <div class="w3-third"><i class="fa fa-phone fa-fw w3-hover-text-black w3-xlarge"></i> Phone: +604-928 5001</div>
                        <div class="w3-third"><i class="fa fa-fax fa-fw w3-hover-text-black w3-xlarge"></i> Fax: +604-928 5067</div>
                        <div class="w3-third"><i class="fa fa-envelope fa-fw w3-hover-text-black w3-xlarge"></i> Email: soc@uum.edu.my</div>
                    </div>
                    <div class="w3-center w3-large"><i class="fa fa-map-marker fa-fw w3-hover-text-black w3-xlarge"></i><strong>SCHOOL OF COMPUTING</strong> College of Arts and Sciences, Universiti Utara Malaysia, 06010 Sintok Kedah Darul Aman, Malaysia</div><br><br>
                </div>


                <!--Login-->
                <div class="materialContainer w3-padding-32" id="login">
                    <div class="login-wrap">
                        <div class="login-html">
                            <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Log In</label>
                            <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Sign Up</label>

                            <div class="login-form">
                                <form class="sign-in-htm" action="controller/login.php" method="post">
                                    <div class="group">
                                        <label class="label">Username</label>
                                        <input type="text" class="input" id="user_login" name="username" autocomplete="off" placeholder="Username">
                                    </div>
                                    <div class="group">
                                        <label class="label">Password</label>
                                        <input type="password" class="input" id="user_pass" name="password" autocomplete="off" placeholder="Password">
                                    </div>
                                    <div class="group">
                                        <input type="submit" class="button" name="submit" value="Login">
                                    </div>
                                    <div class="hr"></div>
                                </form>

                                <form class="sign-up-htm" action="controller/signup.php" method="post">
                                    <div class="group">
                                        <label for="username" class="label">Username</label>
                                        <input type="text" class="input" id="user_signup" name="username">
                                    </div>
                                    <div class="group">
                                        <label for="password" class="label">Password</label>
                                        <input id="user_passw" type="password" class="input" data-type="password" name="password">
                                    </div>
                                    <div class="group">
                                        <label for="email" class="label">Email Address</label>
                                        <input id="user_email" type="email" class="input" name="email">
                                    </div>
                                    <div class="group">
                                        <input type="submit" class="button" value="Sign Up" name="submit">
                                    </div>
                                    <div class="hr"></div>
                                    <div class="foot-lnk">
                                        <label for="tab-1">Already Member?</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

</body>