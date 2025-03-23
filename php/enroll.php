<?php

include 'connect.php';
$connect = dbConnection();

session_start();

if (!isset($_SESSION['user']) && !isset($_SESSION['uid']) && !$_SESSION['login']) {
    echo "<script>window.location.href = 'login.php'</script>";
    exit;
}

if (!isset($_GET['courseID'])) {
    die("Course ID is required.");
}

$courseID = intval($_GET['courseID']);
$enrollerID = $_SESSION['uid'];

// Check if the user has already enrolled in more than 3 courses
$query = "SELECT COUNT(*) AS enrolledCount FROM enroll WHERE enroller = $enrollerID";
$result = mysqli_query($connect, $query);

if (!$result) {
    die("Error: " . mysqli_error($connect));
}

$row = mysqli_fetch_assoc($result);
if ($row['enrolledCount'] >= 3) {
    die("You cannot enroll in more than 3 courses.");
}

// Check if the user is already enrolled in this course
$query = "SELECT * FROM enroll WHERE CID = $courseID AND enroller = $enrollerID";
$result = mysqli_query($connect, $query);

if (mysqli_num_rows($result) > 0) {
    die("You are already enrolled in this course.");
}

// Get the course maker (teacher)
$query = "SELECT UID FROM courses WHERE Cid = $courseID";
$result = mysqli_query($connect, $query);

if (!$result || mysqli_num_rows($result) <= 0) {
    die("Course not found.");
}

$row = mysqli_fetch_assoc($result);
$makerID = $row['UID'];

// Insert the enrollment record
$query = "INSERT INTO enroll (CID, Maker, enroller) VALUES ($courseID, $makerID, $enrollerID)";
$result = mysqli_query($connect, $query);

if ($result) {
    // Update the status of the course to 0
    $updateQuery = "UPDATE courses SET status = 0 WHERE Cid = $courseID";
    $updateResult = mysqli_query($connect, $updateQuery);

    if ($updateResult) {
        echo "<script>alert('Successfully enrolled in the course and course status updated.')</script>";
        echo "<script>window.location.href = 'home.php'</script>";
    } else {
        die("Error updating course status: " . mysqli_error($connect));
    }
} else {
    die("Error: " . mysqli_error($connect));
}

?>