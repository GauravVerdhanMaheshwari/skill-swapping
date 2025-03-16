<?php

session_start();
if (!isset($_SESSION['user']) && !isset($_SESSION['uid']) && !$_SESSION['login']) {
    echo "<script>window.location.href = 'login.php'</script>";
    exit;
}

include 'connect.php';
$connect = dbConnection();

$uid = $_SESSION["uid"];

$log = date("Y-m-d H:i:s") . " LOGGED OUT ";
$query = "INSERT INTO logs (Log, Time, What, UID) 
          VALUES ('$log', NOW(), 'LOGGED OUT', {$uid})";
$result = mysqli_query($connect, $query);

if (!$result) {
    echo "<script>alert('Error logging activity.');</script>";
} else {
    $_SESSION["login"] = false;
    $_SESSION["uid"] = null;
    echo "<script>alert('Logged Out Successfully');</script>";
}

echo "<script>window.location.href='login.php';</script>";
?>

?>