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
    <title>Search Results</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/common.css">
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
</head>

<body>

    <?php include 'header.php';
    customHeader(); ?>

    <div class="title">
        <p class="titleText">Search Results</p>
    </div>

    <div class="course" style="margin-top: 30px;">
        <h2 style="margin: 20px;">Search Results</h2>
        <?php
        if (isset($_GET['courseSearch'])) {
            $searchTerm = mysqli_real_escape_string($connect, $_GET['courseSearch']);

            $query = "SELECT Cid, Title, Description, Price FROM courses 
                      WHERE Status = 1 AND Title LIKE '%$searchTerm%'";
            $result = mysqli_query($connect, $query);

            if (!$result) {
                echo "<p class='error'>Error fetching courses: " . mysqli_error($connect) . "</p>";
            } elseif (mysqli_num_rows($result) == 0) {
                echo "<p class='noCourses' style='font-size:30px; margin:0px; color:white; text-shadow:1px 1px 10px black'>No matching courses found.</p>";
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
        }
        ?>
    </div>

</body>

</html>