<?php
session_start();
include 'connect.php';
$connect = dbConnection();

if (!$connect) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['user']) || !isset($_SESSION['uid']) || !$_SESSION['login']) {
    header("Location: login.php");
    exit();
}

$uid = $_SESSION['uid'];
$query = "SELECT Skill_1, Skill_2, Skill_3 FROM user_skill WHERE UID = '$uid'";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_assoc($result);

if (!$row || empty($row['Skill_1'])) {
    echo "<script>alert('Please add skills first'); window.location.href = 'userProfile.php';</script>";
    exit();
}

$skill1 = $row['Skill_1'];
$skill2 = $row['Skill_2'];
$skill3 = $row['Skill_3'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $courseName = mysqli_real_escape_string($connect, $_POST['courseName']);
    $courseDescription = mysqli_real_escape_string($connect, $_POST['courseDescription']);
    $courseTeaching = strtolower(mysqli_real_escape_string($connect, $_POST['courseTeaching']));
    $courseWant = mysqli_real_escape_string($connect, $_POST['courseWant']);
    $coursePrice = (int)$_POST['coursePrice'];
    $courseStatus = 1;

    if (!in_array($courseTeaching, [$skill1, $skill2, $skill3])) {
        echo "<script>alert('You can only add courses that you can teach'); window.location.href = 'home.php';</script>";
        exit();
    }

    $query = "SELECT COUNT(*) AS course_count FROM courses WHERE UID = '$uid' AND Status = 1";
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_assoc($result);
    if ($row['course_count'] >= 2) {
        echo "<script>alert('You can only add 2 courses'); window.location.href = 'home.php';</script>";
        exit();
    }

    $query = "SELECT * FROM courses WHERE Title = '$courseName' AND UID = '$uid'";
    $result = mysqli_query($connect, $query);
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('You have already added this course'); window.location.href = 'home.php';</script>";
        exit();
    }

    $date = date('Y-m-d H:i:s');
    $log = "ADD COURSE $courseName";
    $query = "INSERT INTO logs (Log, Time, What, UID) VALUES ('$log', '$date', 'ADD COURSE', '$uid')";
    mysqli_query($connect, $query);

    $query = "INSERT INTO courses (Title, Description, SkillTeaching, SkillNeeded, Price, Status, UID) 
              VALUES ('$courseName', '$courseDescription', '$courseTeaching', '$courseWant', '$coursePrice', '$courseStatus', '$uid')";
    
    if (mysqli_query($connect, $query)) {
        echo "<script>alert('Course added successfully'); window.location.href = 'home.php';</script>";
    } else {
        echo "<script>alert('Failed to add course: " . mysqli_error($connect) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Courses</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/addCourses.css">
</head>
<body>
    <?php include 'header.php'; customHeader(); ?>
    <main>
        <h1>Add Courses</h1>
        <form action="" method="post">
            <label for="courseName">Course Name:</label>
            <input type="text" name="courseName" id="courseName" class="input" required>

            <label for="courseDescription">Course Description:</label>
            <textarea name="courseDescription" id="courseDescription" class="input" required></textarea>

            <label for="courseTeaching">Course Teaching:</label>
            <input type="text" name="courseTeaching" id="courseTeaching" class="input" required>

            <label for="courseWant">Course Want In Exchange:</label>
            <input type="text" name="courseWant" id="courseWant" class="input" required>

            <label for="coursePrice">Course Price:</label>
            <input type="number" name="coursePrice" id="coursePrice" class="input" required>

            <input type="submit" value="Add Course">
            <input type="reset" value="Clear">
        </form>
    </main>
</body>
</html>