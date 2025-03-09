<?php

function customHeader()
{
    echo
        '<header class="head">
            <a href="home.php" class="logo"><img src="../image/skillSwapping.png"></a>
            <div class="innerHead">
                <a href="home.php">Home</a>
                <a href="courses.php">Courses</a>
                <a href="aboutUs.php">About Us</a>
                <img src="../image/search.png" class="searchImg"><input type="text" name="courseSearch" id="courseSearch">
            </div>
            <a href="userProfile.php" class="profilePictureLink"><img src="../image/user.png" class="profilePicture"></a>
        </header>';
}

?>