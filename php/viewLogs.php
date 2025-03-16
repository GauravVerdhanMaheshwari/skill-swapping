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
    <title>My Logs</title>
    <link rel="stylesheet" href="../css/user_logs.css">
    <link rel="stylesheet" href="../css/common.css">
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
</head>

<body>
    <?php
    include 'header.php';
    customHeader();
    ?>

    <div class='logs'>
        <a href="./userProfile.php" class="backLink">
            <button class="backButton">
                Back to Profile
            </button>
        </a>

        <table>
            <tr>
                <th>Log</th>
                <th>Time Date</th>
                <th>Action</th>
            </tr>
            <?php
            $sql = "SELECT * FROM logs WHERE UID = " . $_SESSION['uid'];
            $result = mysqli_query($connect, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "
                    <tr>
                        <td>" . htmlspecialchars($row['Log']) . "</td>
                        <td>" . htmlspecialchars($row['Time']) . "</td>
                        <td>" . htmlspecialchars($row['What']) . "</td>
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