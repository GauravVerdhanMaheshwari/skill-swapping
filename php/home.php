<?php

$host = "localhost";
$username = "root";
$password = "";
$db = "skill_swapping";

$connect = mysqli_connect($host, $username, $password, $db);

function printCourse()
{
    
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../css/home.css">
</head>

<body>
    <header class="head">
        <a href="home.php" class="logo"><img src="../image/skillSwapping.png"></a>
        <div class="innerHead">
            <a href="courses.php">Courses</a>
            <a href="aboutUs.php">About Us</a>
            <img src="../image/search.png" class="searchImg"><input type="text" name="courseSearch" id="courseSearch">
        </div>
        <a href="userProfile.php" class="profilePictureLink"><img src="../image/user.png" class="profilePicture"></a>
    </header>
</body>

</html>




<script>
    let search = document.getElementById(courseSearch);
    search.addEventListener("focus", () => {
        if (search.innerText = "") {
            <?php

            ?>
        } else {
            <?php

            ?>
        }
    })
</script>