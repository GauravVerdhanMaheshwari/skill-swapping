<?php

include 'connect.php';
$connect = dbConnection();

session_start();
if ($_SESSION["login"] == false) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$uid = $_SESSION["uid"];
$noSkill = false; 

$query = "SELECT Name, Email FROM user WHERE UID = '$uid'";
$result = mysqli_query($connect, $query);

if ($result) { 
    $row = mysqli_fetch_assoc($result);
    $name = $row["Name"] ?? "Unknown";
    $email = $row["Email"] ?? "Unknown";

    $query = "SELECT Skill_1, Skill_2, Skill_3 FROM user_skill WHERE UID = '$uid'";
    $skillResult = mysqli_query($connect, $query);

    if ($skillResult && mysqli_num_rows($skillResult) > 0) {
        $skillRow = mysqli_fetch_assoc($skillResult);
        $skill1 = $skillRow["Skill_1"] ?? "N/A";
        $skill2 = $skillRow["Skill_2"] ?? "N/A";
        $skill3 = $skillRow["Skill_3"] ?? "N/A";
    } else {
        $noSkill = true;
        $skill1 = $skill2 = $skill3 = "N/A";
    }
}

function printSkill()
{
    global $skill1, $skill2, $skill3;
    $skills = array_filter([$skill1, $skill2, $skill3], fn($skill) => $skill !== "N/A");

    if (!empty($skills)) {
        echo "Skill: " . implode(", ", $skills);
    } else {
        echo "No skills added yet.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/userProfile.css">
</head>

<body>
    <?php
    include 'header.php';
    customHeader();
    ?>

    <div class="userLink">
        <h1 class="title">User Profile</h1>
        <p class="name">Name: <?php echo htmlspecialchars($name); ?></p>
        <p class="email">Email: <?php echo htmlspecialchars($email); ?></p>
        <p class="skills"><?php echo !$noSkill ? printSkill() : "No skills added yet."; ?></p>
        <br>
        <a href="editProfile.php" class="editProfile">Edit Profile</a>
        <a href="changePassword.php" class="changePassword">Change Password</a>
        <a href="myCourses.php" class="myCourses">My Courses</a>
        <a href="viewLogs.php" class="myLogs">View Logs</a>
        <a href="logout.php" class="logOut">Log Out</a>
    </div>
</body>

</html>
