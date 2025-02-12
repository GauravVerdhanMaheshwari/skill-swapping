<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>
    <div class="register">
        <div class="innerRegister">
            <form action="" method="post">
                <h1 class="heading">REGISTER</h1>

                <label for="userName">User Name</label><br>
                <input type="text" name="userName" class="input" id="userName" autocomplete="off"
                    placeholder="Enter your username" required minlength="5" maxlength="10"><br>
                <p id="usernameWarning" class="warning"></p>

                <label for="email">Email</label><br>
                <input type="email" name="email" class="input" id="email" autocomplete="off"
                    placeholder="Enter your email" required maxlength="50"><br>

                <label for="password">Password</label><br>
                <input type="password" name="password" class="input" id="password" autocomplete="off"
                    placeholder="Enter your password" required minlength="8" maxlength="10"><br>
                <p id="passwordWarning" class="warning"></p>

                <label for="confirmPassword">Confirm Password</label><br>
                <input type="password" name="confirmPassword" class="input" id="confirmPassword" autocomplete="off"
                    placeholder="Confirm your password" required minlength="8" maxlength="10"><br>
                <p id="confirmPasswordWarning" class="warning"></p>

                <br><input type="submit" value="Register" name="register" class="button"><br><br>
                <a href="login.php" class="link">Already have an account?</a>
            </form>
        </div>
    </div>
</body>

<script>
    // Username Validation
    document.getElementById("userName").addEventListener("input", function () {
        let usernameWarning = document.getElementById("usernameWarning");
        if (this.value.length < 5 || this.value.length > 10) {
            usernameWarning.innerText = "Username must be between 5 and 10 characters.";
            usernameWarning.style.display = "block";
        } else {
            usernameWarning.style.display = "none";
        }
    });

    // Password Validation
    document.getElementById("password").addEventListener("input", function () {
        let passwordWarning = document.getElementById("passwordWarning");
        if (this.value.length < 8 || this.value.length > 10) {
            passwordWarning.innerText = "Password must be between 8 and 10 characters.";
            passwordWarning.style.display = "block";
        } else {
            passwordWarning.style.display = "none";
        }
    });

    // Confirm Password Validation
    document.getElementById("confirmPassword").addEventListener("input", function () {
        let confirmPasswordWarning = document.getElementById("confirmPasswordWarning");
        if (this.value !== document.getElementById("password").value) {
            confirmPasswordWarning.innerText = "Passwords do not match.";
            confirmPasswordWarning.style.display = "block";
        } else {
            confirmPasswordWarning.style.display = "none";
        }
    });
</script>

<style>
    .warning {
        color: red;
        font-weight: 500;
        font-size: 14px;
        display: none;
    }
</style>

<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$db = "skill_swapping";

$connect = mysqli_connect($host, $username, $password, $db);

// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $name = mysqli_real_escape_string($connect, $_POST["userName"]);
    $email = mysqli_real_escape_string($connect, $_POST["email"]);
    $password = mysqli_real_escape_string($connect, $_POST["password"]);
    $confirmPassword = mysqli_real_escape_string($connect, $_POST["confirmPassword"]);
    $logs = date("Y-m-d H:i:s"); // Store timestamp

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match.');</script>";
    } else {
        // Check if email already exists
        $checkEmail = "SELECT * FROM user WHERE email='$email'";
        $result = mysqli_query($connect, $checkEmail);

        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('Email already exists. Please use another email.');</script>";
        } else {
            // Insert data into the database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO user (Name, Email, Password, Logs) VALUES ('$name', '$email', '$hashedPassword', '$logs')";
            if (mysqli_query($connect, $query)) {
                echo "<script>alert('Registration successful! Redirecting to login page.'); window.location.href='login.php';</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($connect) . "');</script>";
            }
        }
    }
}
?>

</html>