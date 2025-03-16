<?php

function customHeader()
{
    echo
        '<header class="head">
            <a href="home.php" class="logoDiv"><img src="../image/logo.png" width="80px" class="logo"></a>
            <div class="innerHead">
                <a href="home.php">Home</a>
                <a href="addCourses.php">Add Courses</a>
                <a href="aboutUs.php">About Us</a>
                <img src="../image/search.png" class="searchImg"><input type="text" name="courseSearch" id="courseSearch">
            </div>
            <a href="userProfile.php" class="profilePictureLink"><img src="../image/user.png" class="profilePicture"></a>
        </header>';
}

function adminHeader()
{
    echo '<header class="outerHeader">
        <h1 class="title">Welcome Admin</h1>
        <nav class="header">
            <a href="./admin_dash.php">Users</a>
            <a href="./admin_courses.php">Courses</a>
            <a href="./admin_user.php">Profile</a>
            <a href="./admin_log_out.php" id="logOut">Log Out</a>
        </nav>
    </header>';
}

?>