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
    <title>My Enrolled Courses</title>
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
    <link rel="stylesheet" href="../css/my_enrolled.css">
    <link rel="stylesheet" href="../css/common.css">
</head>

<body>

    <?php
    include 'header.php';
    customHeader();
    ?>

    <div class='container'>

        <div class="flex-container">
            <a href="./userProfile.php" class="link-button">
                <button class="button">Back to Profile</button>
            </a>

            <h2 class="title">My Enrolled Courses</h2>
        </div>

        <table class="table-container">
            <tr>
                <th class="table-header">Title</th>
                <th class="table-header">Description</th>
                <th class="table-header">Skill Teaching</th>
                <th class="table-header">Skill Needed</th>
                <th class="table-header">Price</th>
                <th class="table-header">Status</th>
                <th class="table-header">View</th>
            </tr>
            <?php
            $uid = $_SESSION['uid'];

            $sql = "SELECT c.* FROM enroll e 
                    JOIN courses c ON e.CID = c.Cid 
                    WHERE e.Enroller = $uid";
            $result = mysqli_query($connect, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "
                    <tr class='table-row'>
                        <td class='table-data'>" . htmlspecialchars($row['Title']) . "</td>
                        <td class='table-data'>" . htmlspecialchars($row['Description']) . "</td>
                        <td class='table-data'>" . htmlspecialchars($row['SkillTeaching']) . "</td>
                        <td class='table-data'>" . htmlspecialchars($row['SkillNeeded']) . "</td>
                        <td class='table-data'>" . htmlspecialchars($row['Price']) . "</td>
                        <td class='table-data'>" . htmlspecialchars($row['Status']) . "</td>
                        <td class='table-data'><a href='view_course.php?id=" . urlencode($row['Cid']) . "' class='view-link'>View</a></td>
                    </tr>";
                }
            } else {
                echo "<tr><td class='table-data' colspan='7'>You haven't enrolled in any courses yet.</td></tr>";
            }
            ?>
        </table>
    </div>

</body>

</html>