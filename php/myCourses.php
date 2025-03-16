<?php

include 'connect.php';
$connect = dbConnection();

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

if (!isset($_SESSION['uid']) && !isset($_SESSION['login'])) {
    echo "<script>window.location.href='login.php';</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My courses</title>
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
    <link rel="stylesheet" href="../css/user_logs.css">
    <link rel="stylesheet" href="../css/common.css">
</head>

<body>

    <?php
    include 'header.php';
    customHeader();
    ?>

    <div class='logs'>

        <div class="logsLink">
            <a href="./userProfile.php" class="backLink">
                <button class="backButton">
                    Back to Profile
                </button>
            </a>

            <h2 class="logTitle">
                My Courses
            </h2>

            <a href="./enrolled.php" class="backLink">
                <button class="backButton">
                    View My enrolled courses
                </button>
            </a>
        </div>

        <table>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Skill Needed In Exchange</th>
                <th>Skill Teaching</th>
                <th>Price</th>
                <th>Status</th>
                <th>View</th>
                <th>Delete</th>
            </tr>
            <?php
            $sql = "SELECT * FROM courses WHERE UID = " . $_SESSION['uid'];
            $result = mysqli_query($connect, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "
                    <tr>
                        <td>" . htmlspecialchars($row['Title']) . "</td>
                        <td>" . htmlspecialchars($row['Description']) . "</td>
                        <td>" . htmlspecialchars($row['SkillNeeded']) . "</td>
                        <td>" . htmlspecialchars($row['SkillTeaching']) . "</td>
                        <td>" . htmlspecialchars($row['Price']) . "</td>
                        <td>" . htmlspecialchars($row['Status']) . "</td>
                        <td><a href='view_user.php?id=" . urlencode($row['CID']) . "' class='view-btn'>View</a></td>
                        <td><a href='delete_user.php?id=" . urlencode($row['CID']) . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this courses?\")'>Delete</a></td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No courses found under your name. Please enroll in one</td></tr>";
            }
            ?>
        </table>
    </div>

</body>

</html>