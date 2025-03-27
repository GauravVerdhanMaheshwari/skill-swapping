<?php
include 'connect.php';
$connect = dbConnection();
session_start();

if (!isset($_SESSION['user']) && !isset($_SESSION['uid']) && !$_SESSION['login']) {
    echo "<script>window.location.href = 'login.php'</script>";
    exit;
}

$userID = $_SESSION['uid'];
$courseID = isset($_GET['courseID']) ? intval($_GET['courseID']) : 0;

// Check if the user is enrolled in this course
$checkEnrollmentQuery = "SELECT progress FROM enroll WHERE Enroller = '$userID' AND CID = '$courseID'";
$enrollmentResult = mysqli_query($connect, $checkEnrollmentQuery);

if (!$enrollmentResult || mysqli_num_rows($enrollmentResult) == 0) {
    echo "<script>alert('You are not enrolled in this course.'); window.location.href = 'home.php';</script>";
    exit;
}

$enrollmentData = mysqli_fetch_assoc($enrollmentResult);
$progress = intval($enrollmentData['progress']);

// Fetch course details
$courseQuery = "SELECT Title, Description FROM courses WHERE Cid = '$courseID'";
$courseResult = mysqli_query($connect, $courseQuery);

if ($courseResult && mysqli_num_rows($courseResult) > 0) {
    $courseData = mysqli_fetch_assoc($courseResult);
    $courseTitle = htmlspecialchars($courseData['Title']);
    $courseDescription = htmlspecialchars($courseData['Description']);
} else {
    echo "<script>alert('Course not found.'); window.location.href = 'home.php';</script>";
    exit;
}

// Handle progress update
if (isset($_POST['increaseProgress'])) {
    $newProgress = min(100, $progress + 10); // Increase by 10%

    // Update progress in the database
    $updateQuery = "UPDATE enroll SET progress = $newProgress WHERE CID = $courseID AND Enroller = $userID";
    mysqli_query($connect, $updateQuery);

    // If progress reaches 100%, move to completed_courses
    if ($newProgress >= 100) {
        $moveQuery = "INSERT INTO completed_courses ( Cid, Title, Description, Price,UID) 
                      SELECT  Cid, Title, Description, Price,$userID FROM courses WHERE Cid = $courseID";
        mysqli_query($connect, $moveQuery);

        // Remove from enroll table
        $deleteQuery = "DELETE FROM enroll WHERE CID = $courseID AND Enroller = $userID";
        mysqli_query($connect, $deleteQuery);
        echo "<script>alert('You have completed this course.'); window.location.href = 'home.php';</script>";
    }

    // Refresh page to reflect changes
    echo "<script>window.location.href='courseContent.php?courseID=$courseID'</script>";
    exit;
}

// Generate fake "Next Course Time" (random within the next 24 hours)
$nextCourseTime = date("h:i A", strtotime("+" . rand(1, 24) . " hours"));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $courseTitle; ?> - Course Content</title>
    <link rel="stylesheet" href="../css/courseContent.css">
    <link rel="stylesheet" href="../css/common.css">
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
</head>

<body>

    <?php include 'header.php';
    customHeader(); ?>

    <div class="courseContent">
        <h2 style="text-align: center;" class="titleText"><?php echo $courseTitle; ?></h2>
        <h2>Course Description</h2>
        <p><?php echo nl2br($courseDescription); ?></p>

        <h2>Next Course Time</h2>
        <p class="next-course-time"><?php echo $nextCourseTime; ?></p>

        <h2>Progress</h2>
        <div class="progress-container">
            <div class="progress-bar" id="progressBar" style="width: <?php echo $progress; ?>%;">
                <?php echo $progress; ?>%
            </div>
        </div>

        <?php if ($progress < 100) { ?>
            <form method="post">
                <button type="submit" name="increaseProgress" class="continue-btn">Continue Course</button>
            </form>
        <?php } else {

            $uid = $_SESSION["uid"];

            $log = date("Y-m-d H:i:s") . " COURSE COMPLETED: {$courseTitle}";
            $query = "INSERT INTO logs (Log, Time, What, UID) 
            VALUES ('$log', NOW(), 'COURSE COMPLETED: {$courseTitle}', {$uid})";
            $result = mysqli_query($connect, $query);
            ?>
            <p class="completed-msg">Course Completed! 🎉</p>
        <?php } ?>

        <h2>Course Materials</h2>
        <p></p>

        <a href="home.php" class="backButton">Back to Home</a>
    </div>

</body>

</html>