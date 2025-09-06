<?php
session_start();
$page_title = "Reset password";
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
                        <h5>Reset password</h5>
                    </div>
                    <div class="card-body">
                        <form action="pass-reset-code.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" name="email" id="email" required><br />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" name="pass_reset_link">Send password reset link</button>
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


<?php include('includes/footer.php'); ?>