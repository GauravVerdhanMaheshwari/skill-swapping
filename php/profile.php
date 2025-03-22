<?php

include 'connect.php';
$connect = dbConnection();

session_start();

if (!isset($_SESSION['user']) && !isset($_SESSION['uid']) && !$_SESSION['login']) {
    echo "<script>window.location.href = 'login.php'</script>";
    exit;
}

if (!isset($_GET['uid'])) {
    echo "<p>User not found.</p>";
    exit;
}

$teacherID = $_GET['uid'];

$query = "SELECT Name FROM user WHERE UID = $teacherID";
$result = mysqli_query($connect, $query);

if (!$result) {
    echo "Error: <br>" . mysqli_error($connect);
    exit;
} elseif (mysqli_num_rows($result) <= 0) {
    echo "<p>User not found.</p>";
    exit;
} else {
    $row = mysqli_fetch_assoc($result);
    $query = "SELECT Skill_1,Skill_2,Skill_3 FROM user_skill WHERE UID = $teacherID";
    $result = mysqli_query($connect, $query);
    $teacherName = $row['Name'];
    $row = mysqli_fetch_assoc($result);
    if ($row['Skill_2'] != NULL) {
        $skill_1 = $row['Skill_1'];
    } elseif ($row['Skill_3'] != NULL) {
        $skill_1 = $row['Skill_1'];
        $skill_2 = $row['Skill_2'];
    } else {
        $skill_1 = $row['Skill_1'];
        $skill_2 = $row['Skill_2'];
        $skill_3 = $row['Skill_3'];
    }
    $teacherSkills = $skill_1 . ", " . $skill_2 . ", " . $skill_3;
    echo $teacherSkills;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $teacherName; ?>'s Profile</title>
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
        <h1><?php echo $teacherName; ?>'s Profile</h1>
        <p><strong>Bio:</strong> <?php echo $teacherBio; ?></p>
        <p><strong>Skills:</strong> <?php echo $teacherSkills; ?></p>
    </div>
</body>

</html>