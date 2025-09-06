<?php
session_start();
$page_title = "Registration form";
include('includes/header.php');
include('includes/navbar.php');

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$name = $email = $phone = $password = $confirm_password = "";
$name_err = $email_err = $phone_err = $password_err = $confirm_password_err = "";
$message = $status = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // CSRF Token Validation
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed.");
    }

    // Form Validation
    if (empty(trim($_POST["name"]))) {
        $name_err = "Name is required.";
    } else {
        $name = htmlspecialchars(trim($_POST["name"]));
        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            $name_err = "Name can only contain letters and spaces.";
        }
    }

    if (empty(trim($_POST["email"]))) {
        $email_err = "Email is required.";
    } else {
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format.";
        }
    }

    if (empty(trim($_POST["phone"]))) {
        $phone_err = "Phone number is required.";
    } else {
        $phone = filter_var(trim($_POST["phone"]), FILTER_SANITIZE_NUMBER_INT);
        if (!filter_var($phone, FILTER_VALIDATE_INT)) {
            $phone_err = "Invalid phone number.";
        }
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Password is required.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must be at least 6 characters.";
    } elseif (!preg_match("/[A-Z]/", $_POST["password"])) {
        $password_err = "Password must include at least one uppercase letter.";
    } elseif (!preg_match("/[a-z]/", $_POST["password"])) {
        $password_err = "Password must include at least one lowercase letter.";
    } elseif (!preg_match("/[0-9]/", $_POST["password"])) {
        $password_err = "Password must include at least one number.";
    } elseif (!preg_match("/[\W_]/", $_POST["password"])) {
        $password_err = "Password must include at least one special character.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm your password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if ($password != $confirm_password) {
            $confirm_password_err = "Password and confirm password do not match.";
        }
    }

    // reCAPTCHA Validation
    $recaptchaResponse = $_POST['g-recaptcha-response'] ?? null;
    if (empty($recaptchaResponse)) {
        $message = 'reCAPTCHA response is missing';
        $status = false;
    } else {
        $secretKey = '6LcCewMrAAAAAH3kfOBaC8DvNgyGeY28UXV682at';
        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
        $response = file_get_contents($verifyUrl . '?secret=' . $secretKey . '&response=' . $recaptchaResponse);
        $responseKeys = json_decode($response, true);

        if ($responseKeys['success']){
            $status = true;
        } else {
            $message = 'reCAPTCHA verification failed. Please try again.';
            $status = false;
        }
    }

    if (empty($name_err) && empty($email_err) && empty($phone_err) && empty($password_err) && empty($confirm_password_err) && $status) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['phone'] = $phone;
        $_SESSION['password'] = $hashed_password;

        header("Location: code.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <div class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <?php if (!empty($message)) { ?>
                        <div class="alert alert-danger">
                            <h5> <?= $message; ?> </h5>
                        </div>
                    <?php } ?>
                    <div class="card shadow bg-dark">
                        <div class="card-header">
                            <h5>Registration Form with reCAPTCHA</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                                    <span style="color: red;"><?php echo $name_err; ?></span><br><br>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
                                    <span style="color: red;"><?php echo $email_err; ?></span><br><br>
                                </div>

                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="tel" class="form-control" name="phone" value="<?php echo $phone; ?>">
                                    <span style="color: red;"><?php echo $phone_err; ?></span><br><br>
                                </div>
                                <input type="checkbox" onclick="togglePasswordVisibility()">
                                 <label for="password">Show password</label> 
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password">
                                    <span style="color: red;"><?php echo $password_err; ?></span><br><br>
                                </div>

                                <div class="form-group">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password">
                                    <span style="color: red;"><?php echo $confirm_password_err; ?></span><br><br>
                                </div>

                                <div class="form-group">
                                    <div class="g-recaptcha" data-sitekey="6LcCewMrAAAAAMZ7_ISbdusk4Rjk2iFLu0O0uctr"></div>
                                </div><br>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Register Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function togglePasswordVisibility() {
        var passField = document.getElementById("password");
        var confirmPassField = document.getElementById("confirm_password");
        if (passField.type === "password") {
            passField.type = "text";
            confirmPassField.type = "text";
        } else {
            passField.type = "password";
            confirmPassField.type = "password";
        }
    }
</script>

</html>

<?php include('includes/footer.php'); ?>