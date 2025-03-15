<?php

include 'connect.php';
$connect = dbConnection();

session_start();

if ($_SESSION["login"] == false) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/common.css">
</head>

<body>
    <?php
    include 'header.php';
    customHeader();
    ?>
    <div class="title">
        <p class="titleText">Welcome to Skill Swapping Platform</p>
    </div>
    <div class="course">
        <?php
        $query = "SELECT Cid,Title,Description FROM courses";
        $result = mysqli_query($connect, $query);
        if (!$result) {
            echo "Error: <br>" . mysqli_error($connect);
        } elseif (mysqli_num_rows($result) <= 0) {
            echo "<p class = 'noCourses'>No courses available</p>";
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                $courseName = $row["Title"];
                $courseDescription = $row["Description"];
                $courseID = $row["Cid"];
                echo "<div class='courseDiv'>";
                echo "<p class='courseName'>$courseName</p>";
                echo "<p class='courseDescription'>$courseDescription</p>";
                echo "<a href='courseDetails.php?courseID=$courseID' class='courseLink'>View Details</a>";
                echo "</div>";
            }
        }
        ?>
    </div>
</body>

</html>