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

<script>

    document.getElementById("password").addEventListener("input", function () {
        let passwordWarning = document.getElementById("passwordWarning");
        if (this.value.length > 8) {
            passwordWarning.innerText = "Password must be 8 characters long.";
            passwordWarning.style.display = "block";
        } else {
            passwordWarning.style.display = "none";
        }
    });

</script>

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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Login"])) {
    $name = mysqli_real_escape_string($connect, $_POST["userName"]);
    $password = $_POST["password"]; // No need to escape, it's used in password_verify

    // Query to fetch the hashed password from database
    $checkName = "SELECT Password FROM user WHERE Name='$name'";
    $result = mysqli_query($connect, $checkName);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hash = $row['Password']; // Get stored hashed password

        if (password_verify($password, $hash)) {
            echo "<script>window.location.href='home.php';</script>";
            exit;
        } else {
            echo "<script>alert('Incorrect Password!');</script>";
        }
    } else {
        echo "<script>alert('Wrong username.');</script>";
    }
}
?>