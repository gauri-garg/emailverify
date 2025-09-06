<?php
session_start();
include('dbcon.php');
if (isset($_POST['login'])) {
    if (!empty(trim($_POST['email'])) && !empty(trim($_POST['password']))) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Prepare query to fetch user data by email (no need for name and phone)
        $stmt = $conn->prepare("SELECT id, name, email, phone, password,api_key, verify_status FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);  // Only bind email
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows >= 1) {
            $stmt->bind_result($id ,$name, $email, $phone, $hashed_password,$api_key, $verify_status);
            $stmt->fetch();

            // Check password verification
            if (password_verify($password, $hashed_password)) {
                // Check if user has verified their email
                if ($verify_status == "1") {
                    if (empty($api_key)) {
                        $api_key = bin2hex(random_bytes(32));  // Generate 64-character hexadecimal key
                        // Update the database with the generated API key
                        $update_stmt = $conn->prepare("UPDATE user SET api_key = ? WHERE id = ?");
                        $update_stmt->bind_param("si", $api_key, $id);
                        $update_stmt->execute();
                    }
                    $_SESSION['authenticated'] = TRUE;
                    $_SESSION['auth_user'] = [
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone,
                        'api_key' => $api_key
                        // Add more user details here if needed
                    ];
                    $_SESSION['status'] = "You are logged in!";
                    header('Location: dashboard.php');
                    exit(0);
                } else {
                    $_SESSION['status'] = "Please verify your email address to login!";
                    header('Location: login.php');
                    exit(0);
                }
            } else {
                $_SESSION['status'] = "Invalid Email or Password!";
                header('Location: login.php');
                exit(0);
            }
        } else {
            $_SESSION['status'] = "Invalid Email or Password!";
            header('Location: login.php');
            exit(0);
        }
    } else {
        $_SESSION['status'] = "All fields are mandatory";
        header('Location: login.php');
        exit(0);
    }
}
?>
