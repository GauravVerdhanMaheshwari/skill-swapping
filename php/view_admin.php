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
    <link rel="stylesheet" href="../css/admin_common.css">
    <link rel="stylesheet" href="../css/admin_user_logs.css">
</head>

<body>

    <?php
    include 'header.php';
    adminHeader();
    ?>

    <div class="profileDetail">
        <table>
            <tr>
                <th>ID</th>
                <th>Log</th>
                <th>Time Date</th>
                <th>Action</th>
            </tr>

            <?php
            $sql = "SELECT * FROM admin_logs where AID = " . $_SESSION['Admin ID'];
            $result = mysqli_query($connect, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "
                <tr>
                <td>" . htmlspecialchars($row['LID']) . "</td>
                <td>" . htmlspecialchars($row['Log']) . "</td>
                <td>" . htmlspecialchars($row['Time']) . "</td>
                <td id='Action'>" . htmlspecialchars($row['What']) . "</td>
                </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No users found.</td></tr>";
            }
            ?>

        </table>
    </div>

</body>

</html>