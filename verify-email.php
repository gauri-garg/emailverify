<?php
session_start();
include('dbcon.php');

if(isset($_GET['token'])) {
    $token = $_GET['token'];
    $verify_query = "SELECT verify_token, verify_status FROM user WHERE verify_token = '$token' LIMIT 1";
    $verify_query_run = mysqli_query($conn, $verify_query);

    if(mysqli_num_rows($verify_query_run) >= 1) {
        $row = mysqli_fetch_array($verify_query_run);

        if($row['verify_status'] == "0") {
            $update_query = "UPDATE user SET verify_status = '1' WHERE verify_token = '$token' LIMIT 1";
            $update_query_run = mysqli_query($conn, $update_query);

            if($update_query_run) {
                $_SESSION['status'] = "Your Account has been verified successfully!";
                header('Location: login.php');
                exit();
            } else {
                $_SESSION['status'] = "Verification failed!";
                header('Location: login.php');
                exit();
            }
        } else {
            $_SESSION['status'] = "Email already verified. Please login!";
            header('Location: login.php');
            exit();
        }
    } else {
        $_SESSION['status'] = "This token does not exist!";
        header('Location: login.php');
    }
} else {
    $_SESSION['status'] = "Not Allowed!";
    header('Location: login.php');
}
