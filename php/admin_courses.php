<?php
session_start();

include 'connect.php';
$connect = dbConnection();

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ensure Admin is Logged In
if (!isset($_SESSION["Admin Login"]) || $_SESSION["Admin Login"] == false) {
    echo "<script>window.location.href='admin_log_in.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
    <link rel="stylesheet" href="../css/admin_dash.css">
    <link rel="stylesheet" href="../css/admin_common.css">
</head>

<body>
    <?php
    include 'header.php';
    adminHeader();
    ?>
    <div class='user'>
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Skill needed</th>
                <th>Skill Teaching</th>
                <th>Price</th>
                <th>Status</th>
                <th>Creator ID</th>
                <th>View</th>
                <th>Delete</th>
            </tr>

            <?php
            $sql = "SELECT * FROM courses";
            $result = mysqli_query($connect, $sql);

            if (mysqli_num_rows($result) > 0) {
                $sql = "SELECT * FROM courses";
                $result = mysqli_query($connect, $sql);
                if (!$result) {
                    die("Query failed: " . mysqli_error($connect));
                } else {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "
                        <tr>
                        <td>" . htmlspecialchars($row['Cid']) . "</td>
                        <td>" . htmlspecialchars($row['Title']) . "</td>
                        <td>" . htmlspecialchars($row['Description']) . "</td>
                        <td>" . htmlspecialchars($row['SkillNeeded']) . "</td>
                        <td>" . htmlspecialchars($row['SkillTeaching']) . "</td>
                        <td>" . htmlspecialchars($row['Price']) . "</td>
                        <td>" . htmlspecialchars($row['Status']) . "</td>
                        <td>" . htmlspecialchars($row['UID']) . "</td>
                        <td><a href='view_user.php?id=" . urlencode($row['UID']) . "' class='view-btn'>View</a></td>
                        <td><a href='delete_user.php?id=" . urlencode($row['UID']) . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a></td>
                        </tr>";
                    }
                }
            } else {
                echo "<tr><td colspan='8'>No users found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>