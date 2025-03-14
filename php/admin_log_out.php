<?php
include 'connect.php';
$connect = dbConnection();
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();
if (!isset($_SESSION["Admin Login"]) || $_SESSION["Admin Login"] == false) {
    echo "<script>window.location.href='admin_log_in.php';</script>";
    exit;
}

// Ensure Admin ID is set
if (!isset($_SESSION['Admin ID'])) {
    echo "<script>alert('Session error. Please log in again.');</script>";
    echo "<script>window.location.href='admin_log_in.php';</script>";
    exit;
}

$log = date("Y-m-d H:i:s") . " LOGGED OUT ";
$query = "INSERT INTO admin_logs (Log, Time, What, AID) 
          VALUES ('$log', NOW(), 'LOGGED OUT', {$_SESSION['Admin ID']})";
$result = mysqli_query($connect, $query);

if (!$result) {
    echo "<script>alert('Error logging activity.');</script>";
} else {
    $_SESSION["Admin Login"] = false;
    $_SESSION["Admin ID"] = null;
    echo "<script>alert('Logged Out Successfully');</script>";
}

echo "<script>window.location.href='admin_log_in.php';</script>";
?>