<?php
$conn = mysqli_connect("localhost" , "root" , "root","validation");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>