<?php
session_start();

$page_title = "change password";
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
                        <h5>Change password</h5>
                    </div>
                    <div class="card-body">
                        <form action="pass-reset-code.php" method="POST">
                            <input type="hidden" name="password_token" value="<?php if(isset($_GET['token'])) {echo $_GET['token'];}?>">
                            <div class="form-group mb-3">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email Address" value="<?php if(isset($_GET['email'])) {echo $_GET['email'];}?>" disabled><br />
                            </div>
                            <input type="checkbox" onclick="togglePasswordVisibility()">
                            <label for="show_password">Show password</label>

                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" placeholder="Enter new Password" class="form-control" name="new_password" id="password"><br />
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Enter confirm password"><br />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success w-100" name="pass_update">Update Password</button>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

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

<?php include('includes/footer.php'); ?>