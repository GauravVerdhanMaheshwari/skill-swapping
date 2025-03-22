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
    <title>Home</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/common.css">
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
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
        $query = "SELECT Cid,Title,Description,Price FROM courses where Status = 1";
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
                $coursePrice = $row["Price"];
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