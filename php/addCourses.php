<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Courses</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/addCourses.css">
</head>

<body>

    <?php
    include 'header.php';
    customHeader();
    ?>

    <main>
        <h1>Add Courses</h1>
        <form action="addCourses.php" method="post">
            <label for="courseName">Course Name:</label>
            <input type="text" name="courseName" id="courseName" class="input" required>

            <label for="courseDescription">Course Description:</label>
            <textarea name="courseDescription" id="courseDescription" class="input" required></textarea>

            <label for="courseCategory">Course Teaching:</label>
            <input type="text" name="courseTeaching" id="courseTeaching" class="input" required>

            <label for="courseCategory">Course Want In Exchange:</label>
            <input type="text" name="courseWant" id="courseWant" class="input" required>

            <label for="coursePrice">Course Price:</label>
            <input type="number" name="coursePrice" id="coursePrice" class="input" required>

            <input type="submit" value="Add Course">
            <input type="reset" value="Clear">
        </form>
    </main>

</body>

</html>

<?php

session_start();
if (!isset($_SESSION['user']) && !isset($_SESSION['uid']) && !$_SESSION['login']) {
    echo "<script>window.location.href = 'login.php'</script>";
}

include 'connect.php';
$connect = dbConnection();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $courseName = $_POST['courseName'];
    $courseDescription = $_POST['courseDescription'];
    $courseCategory = $_POST['courseTeaching'];
    $courseWantInExchange = $_POST['courseWant'];
    $coursePrice = $_POST['coursePrice'];
    $courseStatus = true;

    $date = date('Y-m-d H:i:s');
    $what = "ADD COURSE";
    $log = $what . " " . $courseName;
    $uid = $_SESSION['uid'];
    $query = "INSERT INTO LOGS (Log, Time, What, UID) VALUES ('$log','$date','$what','$uid')";
    $result = mysqli_query($connect, $query);

    if ($result) {
        $query = "INSERT INTO courses (Title, Description, SkillTeaching, SkillNeeded, Price, Status ,UID) VALUES ('$courseName', '$courseDescription', '$courseCategory', '$courseWantInExchange', '$coursePrice','$courseStatus','{$_SESSION['uid']}')";
        $result = mysqli_query($connect, $query);
        if ($result) {
            echo "<script>alert('Course added successfully')</script>";
            echo "<script>window.location.href = 'home.php'</script>";
        } else {
            echo "<script>alert('Failed to add course')</script>";
        }
    } else {
        echo "<script>alert('Failed to add course')</script>";
    }
}

?>