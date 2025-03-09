<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="../css/aboutUs.css">
    <link rel="stylesheet" href="../css/common.css">
</head>

<?php
session_start();

if ($_SESSION["login"] == false) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}
function person($name, $Fullname, $imageURL, $width, $URL, $hobby1, $hobby2, $hobby3, $quote)
{
    echo
        "<div class='person' id='$name'>
            <div class='imageDiv'>
                <a href='$URL' id='$name'>
                <img width='$width'% src='$imageURL' alt='$name' class='image'>
            </a>
            </div>
            <div class='details'>
                <h2 class='name'>$Fullname</h2>
                <h3 class='hobbies'>Hobbies:</h3>
                <ul class='hobbiesList'>
                    <li class='hobby'>$hobby1</li>
                    <li class='hobby'>$hobby2</li>
                    <li class='hobby'>$hobby3</li>
                </ul>
                <h3 class='favoriteQuote'>Favorite Quote:</h3>
                <p class='quote'>$quote</p>
            </div>
        </div>";
}

?>

<body>
    <?php
    include 'header.php';
    customHeader();
    ?>

    <main>
        <h1 class="title">Meet Our Team</h1>
        <div class="team">
            <?php
            person("Gaurav", "Gaurav Verdhan Maheshwari", "../image/Gaurav.jpeg", 250, "https://www.linkedin.com/in/gauravverdhanmaheshwari/", "Coding", "3d Modelling", "Drawing", "'If you know the enemy and know yourself, you need not fear the result of a hundred battles. If you know yourself but not the enemy, for every victory gained you will also suffer a defeat. If you know neither the enemy nor yourself, you will succumb in every battle.'<br>~Sun Tzu, The Art of War");

            person("Arya", "Makadia Arya", "../image/Arya.jpeg", 250, "https://www.instagram.com/arya_makadia", "Sports", "Traveling", "Video Game", "'Character is power.'<br>~Booker T. Washington");

            person("Chintan", "Malodiya Chintan Sanjaybhai", "../image/Chintan.jpeg", 200, "https://www.instagram.com/c._h._i._n._t._a._n/", "volleyball", "cricket", "traveling", "'The love of money is the root of all evil.'<br>~Timothy 6:10");
            ?>
        </div>
    </main>
</body>

</html>