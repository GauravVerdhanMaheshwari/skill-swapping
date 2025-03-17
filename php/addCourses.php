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
if (!isset($_SESSION['user']) || !isset($_SESSION['uid']) || !$_SESSION['login']) {
    echo "<script>window.location.href = 'login.php'</script>";
    exit();
}

include 'connect.php';
$connect = dbConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Prevent SQL Injection
    $courseName = mysqli_real_escape_string($connect, $_POST['courseName']);
    $courseDescription = mysqli_real_escape_string($connect, $_POST['courseDescription']);
    $courseCategory = mysqli_real_escape_string($connect, $_POST['courseTeaching']);
    $courseWantInExchange = mysqli_real_escape_string($connect, $_POST['courseWant']);
    $coursePrice = mysqli_real_escape_string($connect, $_POST['coursePrice']);
    $courseStatus = true;
    $uid = $_SESSION['uid'];

    // Check if the user has skills
    $query = "SELECT Skill_1, Skill_2, Skill_3 FROM user_skills WHERE UID = '$uid'";
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_assoc($result);
    $skill1 = $row['Skill_1'];
    $skill2 = $row['Skill_2'];
    $skill3 = $row['Skill_3'];
    if ($skill1 == "" || $skill2 == "" || $skill3 == "") {
        echo "<script>alert('Please add skills first')</script>";
        echo "<script>window.location.href = 'userProfile.php'</script>";
        exit();
    }

    // Check if the user is teaching a valid skill
    if (!in_array($courseCategory, [$skill1, $skill2, $skill3])) {
        echo "<script>alert('You can only add courses that you can teach')</script>";
        echo "<script>window.location.href = 'home.php'</script>";
        exit();
    }

    // Check if user has already added 2 courses
    $query = "SELECT COUNT(*) AS course_count FROM courses WHERE UID = '$uid' AND Status = 1";
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_assoc($result);
    if ($row['course_count'] >= 2) {
        echo "<script>alert('You can only add 2 courses')</script>";
        echo "<script>window.location.href = 'home.php'</script>";
        exit();
    }

    // Check for duplicate course
    $query = "SELECT * FROM courses WHERE Title = '$courseName' AND UID = '$uid'";
    $result = mysqli_query($connect, $query);
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('You have already added this course')</script>";
        echo "<script>window.location.href = 'home.php'</script>";
        exit();
    }

    // Insert log
    $date = date('Y-m-d H:i:s');
    $what = "ADD COURSE";
    $log = "$what $courseName";
    $query = "INSERT INTO LOGS (Log, Time, What, UID) VALUES ('$log','$date','$what','$uid')";
    mysqli_query($connect, $query);

    // Insert course
    $query = "INSERT INTO courses (Title, Description, SkillTeaching, SkillNeeded, Price, Status, UID) 
              VALUES ('$courseName', '$courseDescription', '$courseCategory', '$courseWantInExchange', '$coursePrice', '$courseStatus', '$uid')";
    if (mysqli_query($connect, $query)) {
        echo "<script>alert('Course added successfully')</script>";
        echo "<script>window.location.href = 'home.php'</script>";
    } else {
        echo "<script>alert('Failed to add course')</script>";
    }
}
?>