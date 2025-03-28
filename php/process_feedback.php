<?php
include 'connect.php';
session_start();
$connect = dbConnection();

if (!isset($_SESSION['user']) || !isset($_SESSION['uid']) || !$_SESSION['login']) {
    echo "<script>window.location.href = 'login.php'</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reporterID = $_SESSION['uid'];  // The user submitting the feedback/report
    $targetUserID = mysqli_real_escape_string($connect, $_POST['targetUser']);
    $type = mysqli_real_escape_string($connect, $_POST['type']);
    $message = mysqli_real_escape_string($connect, $_POST['message']);

    if ($type == "report") {
        $query = "INSERT INTO user_report (Report, UID, Reporter) VALUES ('$message', '$targetUserID', '$reporterID')";
    } else {
        $query = "INSERT INTO user_feedback (Feedback, UID, Feedbacker) VALUES ('$message', '$targetUserID', '$reporterID')";
    }

    if (mysqli_query($connect, $query)) {
        echo "<script>alert('Your submission has been recorded!'); window.location.href = 'home.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($connect) . "'); window.location.href = 'home.php';</script>";
    }
} else {
    echo "<script>window.location.href = 'home.php';</script>";
}
?>
