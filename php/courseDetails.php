<?php

include 'connect.php';
$connect = dbConnection();

session_start();

if (!isset($_SESSION['user']) && !isset($_SESSION['uid']) && !$_SESSION['login']) {
    echo "<script>window.location.href = 'login.php'</script>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        $courseID = $_GET['courseID'];
        $query = "SELECT Title FROM courses where Cid = $courseID";
        $result = mysqli_query($connect, $query);
        if (!$result) {
            echo "Error: <br>" . mysqli_error($connect);
        } elseif (mysqli_num_rows($result) <= 0) {
            echo "Course not found";
        } else {
            $row = mysqli_fetch_assoc($result);
            echo $row["Title"];
        }
        ?>
    </title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/course.css">
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
</head>

<body>
    <?php
    include 'header.php';
    customHeader();
    ?>
    <div class="courseDetails">
        <?php
        $query = "SELECT Title,Description,Price,SkillNeeded,SkillTeaching,UID FROM courses where Cid = $courseID";
        $result = mysqli_query($connect, $query);
        if (!$result) {
            echo "Error: <br>" . mysqli_error($connect);
        } elseif (mysqli_num_rows($result) <= 0) {
            echo "<p class = 'noCourses'>Course not found</p>";
        } else {
            $row = mysqli_fetch_assoc($result);
            $courseName = $row["Title"];
            $courseDescription = $row["Description"];
            $coursePrice = $row["Price"];
            $skillNeeded = $row["SkillNeeded"];
            $skillTeaching = $row["SkillTeaching"];
            $teacherID = $row["UID"];
            $query = "SELECT Name FROM user where UID = $teacherID";
            $result = mysqli_query($connect, $query);
            $row = mysqli_fetch_assoc($result);
            $teacherName = $row["Name"];
            echo "<div class='courseDiv'>";
            echo "<p class='courseName'>$courseName</p>";
            echo "<p class='courseDescription'>$courseDescription</p>";
            echo "<p class='coursePrice'>Price: ₹$coursePrice</p>";
            echo "<p class='courseSkill'>Skill Needed: $skillNeeded</p>";
            echo "<p class='courseSkill'>Skill Teaching: $skillTeaching</p>";
            echo "<p class='courseTeacher'>Teacher: <a href='profile.php?uid=$teacherID'>$teacherName</a></p>";
            echo "<a href='enroll.php?courseID=$courseID' class='courseLink'>Enroll</a>";
            echo "</div>";
        }
        ?>
    </div>
</body>

</html>