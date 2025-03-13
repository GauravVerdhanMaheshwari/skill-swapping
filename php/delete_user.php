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

// Validate ID before using in query
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('Invalid User ID');</script>";
    echo "<script>window.location.href='admin_dash.php';</script>";
    exit;
}

$id = intval($_GET['id']); // Ensures it's an integer

$log = date("Y-m-d H:i:s") . " User Deleted ";
$query = "INSERT INTO admin_logs (Log, Time, What, AID) 
          VALUES ('$log', NOW(), 'DELETED USER', {$_SESSION['Admin ID']})";
$result = mysqli_query($connect, $query);

if (!$result) {
    echo "<script>alert('Error logging activity.');</script>";
} else {
    $query = "DELETE FROM user WHERE UID = $id";
    $result = mysqli_query($connect, $query);

    if ($result) {
        echo "<script>alert('User Deleted Successfully');</script>";
    } else {
        echo "<script>alert('Error Deleting User');</script>";
    }
}

echo "<script>window.location.href='admin_dash.php';</script>";
?>