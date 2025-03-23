<?php
include 'connect.php';
$connect = dbConnection();

session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] == false) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$uid = $_SESSION["uid"];

// Fetch user details
$query = "SELECT Name, Email FROM user WHERE UID = '$uid'";
$result = mysqli_query($connect, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row["Name"];
    $email = $row["Email"];
} else {
    $name = "";
    $email = "";
}

// Fetch user skills
$skillQuery = "SELECT Skill_1, Skill_2, Skill_3 FROM user_skill WHERE UID = '$uid'";
$skillResult = mysqli_query($connect, $skillQuery);

if ($skillResult && mysqli_num_rows($skillResult) > 0) {
    $skillRow = mysqli_fetch_assoc($skillResult);
    $skill1 = $skillRow["Skill_1"] ?? "";
    $skill2 = $skillRow["Skill_2"] ?? "";
    $skill3 = $skillRow["Skill_3"] ?? "";
} else {
    $skill1 = $skill2 = $skill3 = "";
}

// Fetch user bio
$bioQuery = "SELECT Bio FROM bio WHERE UID = '$uid'";
$bioResult = mysqli_query($connect, $bioQuery);
if ($bioResult && mysqli_num_rows($bioResult) > 0) {
    $bioRow = mysqli_fetch_assoc($bioResult);
    $bio = $bioRow["Bio"];
} else {
    $bio = "";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newName = mysqli_real_escape_string($connect, $_POST['name']);
    $newEmail = mysqli_real_escape_string($connect, $_POST['email']);
    $newSkill1 = mysqli_real_escape_string($connect, $_POST['skill1']);
    $newSkill2 = mysqli_real_escape_string($connect, $_POST['skill2']);
    $newSkill3 = mysqli_real_escape_string($connect, $_POST['skill3']);
    $newBio = mysqli_real_escape_string($connect, $_POST['bio']);

    // Update user details
    $updateQuery = "UPDATE user SET Name = '$newName', Email = '$newEmail' WHERE UID = '$uid'";
    mysqli_query($connect, $updateQuery);

    // Update skills (Insert if not exists, otherwise update)
    $updateSkillsQuery = "INSERT INTO user_skill (UID, Skill_1, Skill_2, Skill_3) 
                          VALUES ('$uid', '$newSkill1', '$newSkill2', '$newSkill3') 
                          ON DUPLICATE KEY UPDATE Skill_1='$newSkill1', Skill_2='$newSkill2', Skill_3='$newSkill3'";
    mysqli_query($connect, $updateSkillsQuery);

    // Update bio (Insert if not exists, otherwise update)
    $updateBioQuery = "INSERT INTO bio (UID, Bio) 
                       VALUES ('$uid', '$newBio') 
                       ON DUPLICATE KEY UPDATE Bio = '$newBio'";
    mysqli_query($connect, $updateBioQuery);

    echo "<script>alert('Profile updated successfully!'); window.location.href='userProfile.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/editProfile.css">
</head>

<body>
    <?php include 'header.php';
    customHeader(); ?>

    <div class="userLink">
        <h1 class="title">Edit Profile</h1>
        <form method="POST">
            <p class="name">Name
                <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            </p>
            <p class="email">Email
                <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </p>
            <p class="skill">Skill 1
                <input type="text" name="skill1" value="<?php echo htmlspecialchars($skill1); ?>">
            </p>
            <p class="skill">Skill 2
                <input type="text" name="skill2" value="<?php echo htmlspecialchars($skill2); ?>">
            </p>
            <p class="skill">Skill 3
                <input type="text" name="skill3" value="<?php echo htmlspecialchars($skill3); ?>">
            </p>
            <p class="bio">Bio
                <textarea name="bio"><?php echo htmlspecialchars($bio); ?></textarea>
            </p>
            <br>
            <input type="submit" value="Save" class="editProfile">
        </form>
        <a href="deleteProfile.php" onclick="return confirm('Are you sure you want to delete your profile?')">Delete
            Profile</a>
    </div>
</body>

</html>