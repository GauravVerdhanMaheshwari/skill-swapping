<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../css/password.css">
</head>

<body>

    <div class="password">

        <div class="innerPassword">
            <form method="POST" action="./passwordRecover.php">
                <h1 class="title">Recover Account</h1><br><br>
                <label for="email">Email</label><br>
                <input type="email" name="email" id="email" class="input" placeholder="Enter your register email"
                    autocomplete="off" required><br><br><br>
                <input type="submit" value="Recover password" class="button">
            </form>
            <a href="./login.php" class="link">I know my password</a>
        </div>

    </div>

</body>

</html>

<?php

$host = "localhost";
$username = "root";
$password = "";
$db = "skill_swapping";

// Create connection
$connect = mysqli_connect($host, $username, $password, $db);

// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"])) {
    $email = mysqli_real_escape_string($connect, $_POST["email"]);
    $checkEmail = "SELECT Email FROM user WHERE Email='$email'";
    $result = mysqli_query($connect, $checkEmail);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $email = $row['Email'];

        if ($email) {
            /* send Recover Account
             USER DATABASE 
             1	UID Primary	int(10)
             2	Name	char(10)
             3	Email Index	varchar(20)
             4	Password	varchar(255)
             5	Logs	varchar(100)	
             */

        }
    }
}

?>