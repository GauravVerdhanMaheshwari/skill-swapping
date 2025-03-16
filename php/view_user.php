<?php
session_start();

include 'connect.php';
$connect = dbConnection();
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

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
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admin_logs.css">
    <link rel="stylesheet" href="../css/admin_common.css">
</head>

<body>
    <?php
    include 'header.php';
    adminHeader();
    ?>

    <div class='logs'>
        <table>
            <tr>
                <th>ID</th>
                <th>Log</th>
                <th>Time Date</th>
                <th>Action</th>
                <th>LID</th>
            </tr>
            <?php
            $sql = "SELECT * FROM logs WHERE UID = " . $_GET['id'];
            $result = mysqli_query($connect, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "
                    <tr>
                        <td>" . $_GET['id'] . "</td>
                        <td>" . htmlspecialchars($row['Log']) . "</td>
                        <td>" . htmlspecialchars($row['Time']) . "</td>
                        <td>" . htmlspecialchars($row['What']) . "</td>
                        <td>" . htmlspecialchars($row['LID']) . "</td>
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