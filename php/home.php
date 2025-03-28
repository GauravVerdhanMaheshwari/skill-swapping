<?php
include 'connect.php';
$connect = dbConnection();
session_start();

if (!isset($_SESSION['user']) && !isset($_SESSION['uid']) && !$_SESSION['login']) {
    echo "<script>window.location.href = 'login.php'</script>";
    exit;
}

$userID = $_SESSION['uid']; // Logged-in user's ID
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/common.css">
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
</head>

<body>

    <?php include 'header.php';
    customHeader(); ?>

    <div class="title">
        <p class="titleText">Welcome to Skill Swapping Platform</p>
    </div>

    <!-- Enrolled Courses Section -->

    <div class="course" style="margin:30px 0px;">
        <h2 style="margin: 20px;">Your Enrolled Courses</h2>
        <?php
        $enrolledQuery = "SELECT courses.Cid, courses.Title, courses.Description, courses.Price 
                      FROM enroll 
                      JOIN courses ON enroll.CID = courses.Cid 
                      WHERE enroll.Enroller = '$userID'";

        $enrolledResult = mysqli_query($connect, $enrolledQuery);

        if (!$enrolledResult) {
            echo "<p class='error'>Error fetching enrolled courses: " . mysqli_error($connect) . "</p>";
        } elseif (mysqli_num_rows($enrolledResult) == 0) {
            echo "<p class='noCourses' style='font-size:30px; margin:0px ; color:white; text-shadow:1px 1px 10px black'>You have not enrolled in any courses.</p>";
        } else {
            while ($row = mysqli_fetch_assoc($enrolledResult)) {
                $courseID = htmlspecialchars($row["Cid"]);
                $courseName = htmlspecialchars($row["Title"]);
                $courseDescription = htmlspecialchars($row["Description"]);
                $coursePrice = htmlspecialchars($row["Price"]);

                echo "<div class='courseDiv enrolled'>";
                echo "<p class='courseName'>$courseName</p>";
                echo "<p class='courseDescription'>$courseDescription</p>";
                echo "<p class='coursePrice'>Price: ₹$coursePrice</p>";
                echo "<a href='courseContent.php?courseID=$courseID' class='courseLink continueLink'>Continue Course</a>";
                echo "</div>";
            }
        }
        ?>
    </div>

    <!-- Available Courses Section -->

    <div class="course" style="margin-top:30px;">
        <h2 style="margin: 20px;">Available Courses</h2>
        <?php
        $query = "SELECT Cid, Title, Description, Price FROM courses 
                  WHERE Status = 1 AND UID != '$userID' 
                  AND Cid NOT IN 
                  (SELECT CID FROM enroll WHERE Maker = '$userID')";  // Exclude courses created by the logged-in user
        
        $result = mysqli_query($connect, $query);

        if (!$result) {
            echo "<p class='error'>Error fetching courses: " . mysqli_error($connect) . "</p>";
        } elseif (mysqli_num_rows($result) == 0) {
            echo "<p class='noCourses'>No courses available</p>";
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                $courseID = htmlspecialchars($row["Cid"]);
                $courseName = htmlspecialchars($row["Title"]);
                $courseDescription = htmlspecialchars($row["Description"]);
                $coursePrice = htmlspecialchars($row["Price"]);

                echo "<div class='courseDiv'>";
                echo "<p class='courseName'>$courseName</p>";
                echo "<p class='courseDescription'>$courseDescription</p>";
                echo "<p class='coursePrice'>Price: ₹$coursePrice</p>";
                echo "<a href='courseDetails.php?courseID=$courseID' class='courseLink'>View Details</a>";
                echo "</div>";
            }
        }
        ?>
    </div>

</body>

</html>