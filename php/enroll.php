<?php

include 'connect.php';
$connect = dbConnection();

session_start();

// Redirect if user is not logged in
if (!isset($_SESSION['user']) || !isset($_SESSION['uid']) || !$_SESSION['login']) {
    echo "<script>window.location.href = 'login.php'</script>";
    exit;
}

// Check if course ID is provided
if (!isset($_GET['courseID'])) {
    die("Course ID is required.");
}

$courseID = intval($_GET['courseID']);  // Sanitize input
$enrollerID = intval($_SESSION['uid']); // Logged-in user's ID

// Check if the user has already enrolled in more than 3 courses
$query = "SELECT COUNT(*) AS enrolledCount FROM enroll WHERE enroller = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "i", $enrollerID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    if ($row['enrolledCount'] >= 3) {
        die("You cannot enroll in more than 3 courses.");
    }
}

// Check if the user is already enrolled in this course
$query = "SELECT * FROM enroll WHERE CID = ? AND enroller = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "ii", $courseID, $enrollerID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    die("You are already enrolled in this course.");
}

// Get course details
$query = "SELECT UID, SkillNeeded FROM courses WHERE Cid = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "i", $courseID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$row = mysqli_fetch_assoc($result)) {
    die("Course not found.");
}

$makerID = $row['UID'];
$requiredSkill = $row['SkillNeeded'];

// Fetch user's skills
$query = "SELECT Skill_1, Skill_2, Skill_3 FROM user_skill WHERE UID = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "i", $enrollerID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$userHasSkill = false;
if ($row = mysqli_fetch_assoc($result)) {
    $userSkills = array_filter([$row['Skill_1'], $row['Skill_2'], $row['Skill_3']]); // Remove null values
    if (in_array($requiredSkill, $userSkills)) {
        $userHasSkill = true;
    }
}

// If user does not have the required skill, deny enrollment
if (!$userHasSkill) {
    echo "<script>alert('You do not have the required skill for this course.')</script>";
    echo "<script>window.location.href = 'home.php'</script>";
    exit;
}

// Insert the enrollment record
$query = "INSERT INTO enroll (CID, Maker, enroller) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "iii", $courseID, $makerID, $enrollerID);
$insertSuccess = mysqli_stmt_execute($stmt);

if ($insertSuccess) {
    // Update course status to 0
    $updateQuery = "UPDATE courses SET status = 0 WHERE Cid = ?";
    $stmt = mysqli_prepare($connect, $updateQuery);
    mysqli_stmt_bind_param($stmt, "i", $courseID);
    $updateSuccess = mysqli_stmt_execute($stmt);

    echo "<script>alert('Successfully enrolled in the course.')</script>";
    echo "<script>window.location.href = 'home.php'</script>";
} else {
    die("Error: " . mysqli_error($connect));
}

?>
