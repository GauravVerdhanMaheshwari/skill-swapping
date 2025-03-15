<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <div class="login">
        <div class="innerLogin">
            <form action="" method="post">
                <h1 class="heading">LOGIN</h1>
                <label for="userName">User Name</label><br>
                <input type="text" class="input" name="userName" id="userName" autocomplete="off"
                    placeholder="Enter your username" required minlength="5" maxlength="10"><br><br>
                <label for="userName">Email</label><br>
                <input type="text" class="input" name="email" id="email" autocomplete="off"
                    placeholder="Enter your email" required><br><br>
                <label for="password">Password</label><br>
                <input type="password" class="input" name="password" id="password" autocomplete="off"
                    placeholder="Enter your password" required minlength="8" maxlength="10"><br><br>
                <p id="passwordWarning" class="warning"></p>

                <input type="submit" name="Login" value="Login" class="button"> <br><br>
                <div class="linkDiv">
                    <a href="index.php" class="link"> I don't have an account</a> <br>
                    <a href="forgetPassword.php" class="link"> Forget Password</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>


<?php
include 'connect.php';
$connect = dbConnection();
// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

$_SESSION["login"] = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Login"])) {
    $name = mysqli_real_escape_string($connect, $_POST["userName"]);
    $email = mysqli_real_escape_string($connect, $_POST["email"]);
    $password = $_POST["password"]; // No need to escape, it's used in password_verify

    if ($name === "allCats" || $password === "areCoolAF") {
        echo "<script>window.location.href='easter.html';</script>";
    } else {
        // Fetch UID and Hashed Password from database
        $checkName = "SELECT UID, Password FROM user WHERE Name='$name' and Email='$email'";
        $result = mysqli_query($connect, $checkName);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $uid = $row['UID'];
            $hash = $row['Password']; // Get stored hashed password

            if (password_verify($password, $hash)) {
                $date = date("Y-m-d H:i:s");
                $what = "LOGGED IN";
                $log = $date . " " . $what;

                // Insert log
                $query = "INSERT INTO LOGS (Log, Time, What, UID) VALUES ('$log','$date','$what','$uid')";
                if (mysqli_query($connect, $query)) {
                    echo "<script>window.location.href='home.php';</script>";
                    $_SESSION['userName'] = $name;
                    $_SESSION['uid'] = $uid;
                    $_SESSION["login"] = true;
                    exit;
                } else {
                    echo "<script>alert('Error logging activity.');</script>";
                }
            } else {
                echo "<script>alert('Incorrect Password!');</script>";
            }
        } else {
            echo "<script>alert('Wrong username.');</script>";
        }
    }
}
?>