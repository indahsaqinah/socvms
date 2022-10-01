<?php
    $email=$_POST['email'];
    $subject = 'Your application have been verified!';
    $message = 'Please check your application';

    mail($email, $subject, $message);
?>