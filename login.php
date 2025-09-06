<?php
session_start();
if(isset($_SESSION['authenticated']))
{
    $_SESSION['status'] = "You are already logged in";
    header('Location: dashboard.php');
    exit(0);
}
$page_title = "Login form";
include('includes/header.php');
include('includes/navbar.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php if (isset($_SESSION['status'])) { ?>
                    <div class="alert alert-success">
                        <h5> <?= $_SESSION['status']; ?> </h5>
                    </div>
                <?php
                    unset($_SESSION['status']);
                } ?>
                <div class="card shadow bg-dark">
                    <div class="card-header">
                        <h5>Login Form</h5>
                    </div>
                    <div class="card-body">
                        <form action="logincode.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" required><br />
                            </div>
                            <input type="checkbox" onclick="showPassword()">
                            <label for="password">Show password</label> 
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" placeholder="Password" class="form-control" name="password" id="password" required><br />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" name="login">Login Now</button>

                                <a href="pass-reset.php" class="float-end">Forgot your password</a>
                            </div>
                        </form>
                        <hr>
                        <h5>
                            Did not receive your email verification?
                            <a href="resend-email-verify.php">Resend</a>
        
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
</body>
</html>


