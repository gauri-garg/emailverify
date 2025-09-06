<?php
session_start();
$page_title = "Resend form";
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
                    <div class="alert alert-danger">
                        <h5> <?= $_SESSION['status']; ?> </h5>
                    </div>
                <?php
                    unset($_SESSION['status']);
                } ?>
                <div class="card shadow bg-dark">
                    <div class="card-header">
                        <h5>Resend email verification</h5>
                    </div>
                    <div class="card-body">
                        <form action="resend-code.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" required><br />
                            </div>
                           
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" name="resend_email_verify_btn">Resend Email</button>
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
