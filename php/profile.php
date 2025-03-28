<?php
include 'connect.php';
$connect = dbConnection();

session_start();

// Redirect if not logged in
if (!isset($_SESSION['user']) || !isset($_SESSION['uid']) || !$_SESSION['login']) {
    echo "<script>window.location.href = 'login.php'</script>";
    exit;
}

// Check if UID is provided
if (!isset($_GET['uid'])) {
    echo "<p>User not found.</p>";
    exit;
}

$teacherID = mysqli_real_escape_string($connect, $_GET['uid']); // Prevent SQL injection

// Fetch user details
$query = "SELECT Name FROM user WHERE UID = '$teacherID'";
$result = mysqli_query($connect, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<p>User not found.</p>";
    exit;
}

$query = "SELECT bio FROM bio WHERE UID = '$teacherID'";
$bio = mysqli_query($connect, $query);

$row = mysqli_fetch_assoc($result);
$rowBio = mysqli_fetch_assoc($bio);
$teacherName = $row['Name'];
$teacherBio = $rowBio['Bio'] ?? "No bio available.";

// Fetch user skills
$query = "SELECT Skill_1, Skill_2, Skill_3 FROM user_skill WHERE UID = '$teacherID'";
$result = mysqli_query($connect, $query);

$teacherSkills = "No skills listed.";
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $skills = array_filter([$row['Skill_1'] ?? null, $row['Skill_2'] ?? null, $row['Skill_3'] ?? null]); // Remove null values
    if (!empty($skills)) {
        $teacherSkills = implode(", ", $skills);
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($teacherName); ?>'s Profile</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
</head>

<body>
    <?php
    include 'header.php';
    customHeader();
    ?>
    
    <div class="profileDetails">
        <h1><?php echo htmlspecialchars($teacherName); ?>'s Profile</h1>
        <p><strong>Bio:</strong> <?php echo htmlspecialchars($teacherBio); ?></p>
        <p><strong>Skills:</strong> <?php echo htmlspecialchars($teacherSkills); ?></p>

        <!-- Feedback & Report Button -->
        <a href="feedback_report.php?uid=<?php echo urlencode($teacherID); ?>" class="feedbackButton">
            Give Feedback / Report User
        </a>
    </div>
</body>

</html>
