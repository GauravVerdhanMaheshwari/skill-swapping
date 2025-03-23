<?php
include 'connect.php';
$connect = dbConnection();
session_start();

if (!isset($_SESSION['uid']) && !isset($_SESSION['login'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$courseID = isset($_GET['id']) ? intval($_GET['id']) : 0;
$userID = $_SESSION['uid'];

// Check if course exists and belongs to the user
$checkQuery = "SELECT * FROM courses WHERE Cid = $courseID AND UID = $userID";
$checkResult = mysqli_query($connect, $checkQuery);

if (!$checkResult || mysqli_num_rows($checkResult) == 0) {
    echo "<script>alert('Course not found or you do not have permission to delete this course.'); window.location.href='my_courses.php';</script>";
    exit;
}

// Move course to deleted_courses before deleting
$moveQuery = "INSERT INTO deleted_courses (Cid, UID, Title, Description, SkillNeeded, SkillTeaching, Price, Status) 
              SELECT Cid, UID, Title, Description, SkillNeeded, SkillTeaching, Price, Status FROM courses WHERE Cid = $courseID";
mysqli_query($connect, $moveQuery);

// Delete enrollments first (to resolve foreign key dependency)
$deleteEnrollmentsQuery = "DELETE FROM enroll WHERE CID = $courseID";
mysqli_query($connect, $deleteEnrollmentsQuery);

// Delete course from courses table
$deleteQuery = "DELETE FROM courses WHERE Cid = $courseID";
mysqli_query($connect, $deleteQuery);

$uid = $_SESSION["uid"];

$log = date("Y-m-d H:i:s") . " DELETED COURSE ";
$query = "INSERT INTO logs (Log, Time, What, UID) 
          VALUES ('$log', NOW(), 'DELETED COURSE', {$uid})";
$result = mysqli_query($connect, $query);

echo "<script>alert('Course deleted successfully!'); window.location.href='myCourses.php';</script>";
?>