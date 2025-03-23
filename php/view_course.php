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

// Fetch course details
$sql = "SELECT * FROM courses WHERE Cid = $courseID AND UID = $userID";
$result = mysqli_query($connect, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $course = mysqli_fetch_assoc($result);
} else {
    echo "<script>alert('Course not found!'); window.location.href='my_courses.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course['Title']); ?> - Course Details</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/view_course.css">
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
</head>

<body>

    <?php include 'header.php';
    customHeader(); ?>

    <div class="logs">
        <div class="logsLink">
            <a href="myCourses.php" class="backLink">
                <button class="backButton">Back to My Courses</button>
            </a>
            <h2 class="logTitle"><?php echo htmlspecialchars($course['Title']); ?></h2>
        </div>

        <table>
            <tr>
                <th>Description</th>
                <td><?php echo nl2br(htmlspecialchars($course['Description'])); ?></td>
            </tr>
            <tr>
                <th>Skill Needed in Exchange</th>
                <td><?php echo htmlspecialchars($course['SkillNeeded']); ?></td>
            </tr>
            <tr>
                <th>Skill Teaching</th>
                <td><?php echo htmlspecialchars($course['SkillTeaching']); ?></td>
            </tr>
            <tr>
                <th>Price</th>
                <td><?php echo htmlspecialchars($course['Price']); ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?php echo htmlspecialchars($course['Status']); ?></td>
            </tr>
        </table>
    </div>

</body>

</html>