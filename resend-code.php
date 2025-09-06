<?php
session_start();
include('dbcon.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function resend_email_verify($name, $email, $verify_token) {
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
    $mail->Subject = "Resend Email verification from Web IT";
    $email_template = "
        <h2>You have registered with Web IT</h2>
        <h5>Verify your email address to login with the link below:</h5>
        <a href='http://localhost:8888/emailverify/verify-email.php?token=$verify_token'>Click here</a>";
    $mail->Body = $email_template;
    $mail->send();
}

if (isset($_POST['resend_email_verify_btn'])) {
    if (!empty(trim($_POST['email']))) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);


        $stmt = $conn->prepare("SELECT name, email,verify_token, verify_status FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);  // Only bind email
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows >= 1) {
            $stmt->bind_result($name, $email,$verify_token, $verify_status);
            $stmt->fetch();

                if ($verify_status == "0") {
                  resend_email_verify($name , $email , $verify_token);
                    $_SESSION['status'] = "Your email link has been sent to your email account!";
                    header('Location: dashboard.php');
                    exit(0);
                }
                 else {
                    $_SESSION['status'] = "Email already verified!";
                    header('Location: resend-email-verify.php');
                    exit(0);
                }
            }
             else {
                $_SESSION['status'] = "Email not registered please register first!";
                header('Location: register.php');
                exit(0);
            }
        } else {
            $_SESSION['status'] = "Invalid Email!";
            header('Location: login.php');
            exit(0);
        }
    } else {
        $_SESSION['status'] = "Email field is mandatory";
        header('Location: resend_email_verify_btn.php');
        exit(0);
    }









?>