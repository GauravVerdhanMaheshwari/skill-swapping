<?php
include 'connect.php';
session_start();
$connect = dbConnection();

if (!isset($_SESSION['user']) || !isset($_SESSION['uid']) || !$_SESSION['login']) {
    echo "<script>window.location.href = 'login.php'</script>";
    exit();
}

// Get the target user ID from the URL
if (!isset($_GET['uid']) || empty($_GET['uid'])) {
    echo "<script>alert('Invalid User!'); window.location.href = 'home.php';</script>";
    exit();
}

$targetUserID = $_GET['uid']; // The user being reported/given feedback
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Feedback & Report</title>
    <link rel="stylesheet" href="../css/feedback_report.css">
    <link rel="stylesheet" href="../css/common.css">
</head>

<body>
    <?php include 'header.php'; customHeader(); ?>

    <div class="container">
        <h1>Feedback & Report</h1>

        <form action="process_feedback.php" method="post">
            <input type="hidden" name="targetUser" value="<?php echo htmlspecialchars($targetUserID); ?>">

            <label for="type">Select Type:</label>
            <select name="type" id="type" required>
                <option value="feedback">Feedback</option>
                <option value="report">Report</option>
            </select>

            <label for="message">Your Message:</label>
            <textarea name="message" id="message" rows="5" required></textarea>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>

</html>
