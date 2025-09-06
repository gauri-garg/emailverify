<?php
session_start();
include('dbcon.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendemail_verify($name, $email, $verify_token) {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'garg.gauri.1020@gmail.com';
    $mail->Password = 'myli dcdr vohv uyhy';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom("garg.gauri.1020@gmail.com", $name);
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = "Email verification from Web IT";
    $email_template = "
        <h2>You have registered with Web IT</h2>
        <h5>Verify your email address to login with the link below:</h5>
        <a href='http://localhost:8888/emailverify/verify-email.php?token=$verify_token'>Click here</a>";
    $mail->Body = $email_template;
    $mail->send();
}

if (isset($_SESSION['name']) && isset($_SESSION['email']) && isset($_SESSION['phone']) && isset($_SESSION['password'])) {
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $phone = $_SESSION['phone'];
    $hashed_password = $_SESSION['password'];
    $verify_token = md5(rand());

    // Check if email exists
    $check_email_query = "SELECT email FROM user WHERE email = '$email' LIMIT 1";
    $check_email_query_run = mysqli_query($conn, $check_email_query);
    if (mysqli_num_rows($check_email_query_run) >= 1) {
        $_SESSION['status'] = "Email ID already exists";
        header('Location: register.php');
        exit();
    } else {
        $query = "INSERT INTO user (name, phone, email, password, verify_token) 
                  VALUES ('$name', '$phone', '$email', '$hashed_password', '$verify_token')";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            sendemail_verify($name, $email, $verify_token);
            $_SESSION['status'] = "Registration successful! Please verify your email.";
            header('Location: register.php');
        } else {
            $_SESSION['status'] = "Registration failed";
            header('Location: register.php');
        }
    }
}
