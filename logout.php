<?php
$page_title = "Logout";
session_start();
unset($_SESSION['authenticated']);
unset($_SESSION['auth_user']);
$_SESSION['status'] = "you logged out successfully!";
header('Location: login.php');


?>