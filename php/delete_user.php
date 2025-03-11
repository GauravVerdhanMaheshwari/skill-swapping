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

// Validate ID before using in query
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('Invalid User ID');</script>";
    echo "<script>window.location.href='admin_dash.php';</script>";
    exit;
}

$id = intval($_GET['id']); // Ensures it's an integer

$query = "DELETE FROM user WHERE UID = $id";
$result = mysqli_query($connect, $query);

if ($result) {
    echo "<script>alert('User Deleted Successfully');</script>";
} else {
    echo "<script>alert('Error Deleting User');</script>";
}

echo "<script>window.location.href='admin_dash.php';</script>";
?>