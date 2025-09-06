<?php
session_start();
include('dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
function send_password_reset($get_name, $get_email, $token)
{
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'garg.gauri.1020@gmail.com';
    $mail->Password = 'myli dcdr vohv uyhy';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom("garg.gauri.1020@gmail.com", $get_name);
    $mail->addAddress($get_email);
    $mail->isHTML(true);
    $mail->Subject = "Reset password notification";
    $email_template = "
        <h2>Hello</h2>
        <h5>You are recieving the email because we received a password reset request for your account.</h5>
        <a href='http://localhost:8888/emailverify/pass-change.php?token=$token&email=$get_email'>Click here</a>";
    $mail->Body = $email_template;
    $mail->send();
}


if (isset($_POST['pass_reset_link'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $token = md5(rand());

    $check_email = "SELECT email FROM user WHERE email='$email' LIMIT 1";
    $check_email_run = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($check_email_run) >= 1) {
        $row = mysqli_fetch_array($check_email_run);
        $get_name = $row['name'];
        $get_email = $row['email'];

        $update_token = "UPDATE user SET verify_token='$token' WHERE email='$get_email' LIMIT 1";
        $update_token_run = mysqli_query($conn, $update_token);
        if ($update_token_run) {
            send_password_reset($get_name, $get_email, $token);
            $_SESSION['status'] = "We emailed you a password reset link";
            header('Location: pass-reset.php');
        } else {
            $_SESSION['status'] = "Something went wrong!";
            header('Location: pass-reset.php');
        }
    } else {
        $_SESSION['status'] = "No email found";
        header('Location: pass-reset.php');
    }
}

if (isset($_POST['pass_update'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $token = mysqli_real_escape_string($conn, $_POST['password_token']);
    if (!empty($token)) {
        if (!empty($token) && !empty($new_password) && !empty($confirm_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            //check token          
            $check_token = "SELECT verify_token FROM user WHERE verify_token='$token' LIMIT 1";
            $check_token_run = mysqli_query($conn, $check_token);

            if (mysqli_num_rows($check_token_run) >= 1) {

                if ($new_password == $confirm_password) {
                    password_verify($new_password, $hashed_password);
                    $update_password = "UPDATE user SET password='$hashed_password' WHERE verify_token='$token' LIMIT 1";
                    $update_password_run = mysqli_query($conn, $update_password);
                    if ($update_password_run) {
                        $new_token = md5(rand());
                        $update_to_new_token = "UPDATE user SET verify_token='$new_token' WHERE verify_token='$token' LIMIT 1";
                        $update_update_to_new_token_run = mysqli_query($conn, $update_to_new_token);
                        $_SESSION['status'] = "New Password successfully update.";
                        header('Location: login.php');
                    } else {
                        $_SESSION['status'] = "password did not update!something went wrong.";
                        header("Location: pass-change.php?token=$token&email=$email");
                    }
                } else {
                    $_SESSION['status'] = "Password and confirm password does not match";
                    header("Location: pass-change.php?token=$token&email=$email");
                }
            } else {
                $_SESSION['status'] = "Invalid token";
                header("Location: pass-change.php?token=$token&email=$email");
            }
        } else {
            $_SESSION['status'] = "All fields are mandatory";
            header("Location: pass-change.php?token=$token&email=$email");
        }
    } else {
        $_SESSION['status'] = "No token found";
        header('Location: pass-change.php');
    }
}
