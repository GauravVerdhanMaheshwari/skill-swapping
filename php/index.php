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
            <form action="./skillSelection.php" method="post">
                <h1 class="heading">REGISTER</h1>

                <label for="name">User Name</label><br>
                <input type="text" name="userName" class="input" id="userName" autocomplete="off"
                    placeholder="Enter your username" required minlength="5" maxlength="20"><br><br>
                <p id="usernameWarning" style="color: red; display: none;"></p><br>

                <label for="email">Email</label><br>
                <input type="email" name="email" class="input" id="email" autocomplete="off"
                    placeholder="Enter your email" required><br><br>

                <label for="password">Password</label><br>
                <input type="password" name="password" class="input" id="password" autocomplete="off"
                    placeholder="Enter your password" required minlength="8" maxlength="20"><br><br>
                <p id="passwordWarning" style="color: red; display: none;"></p><br>

                <label for="password">Confirm Password</label><br>
                <input type="password" name="conformPassword" class="input" id="conformPassword" autocomplete="off"
                    placeholder="Conform your password" required minlength="8" maxlength="20"><br><br>
                <input type="submit" value="Register" class="button"><br><br>

                <a href="login.php" class="link"> Already have an account</a>
            </form>
        </div>
    </div>
</body>

<script>

    //username 
    {
        const usernameField = document.getElementById("userName");
        const usernameWarning = document.getElementById("usernameWarning");
        const registerForm = document.getElementById("registerForm");

        function validateUsername() {
            const usernameLength = usernameField.value.trim().length;

            if (usernameLength < 5 || usernameLength > 20) {
                usernameWarning.innerText = "Username must be between 5 and 20 characters.";
                usernameWarning.style.display = "block";
                return false;
            } else {
                usernameWarning.style.display = "none";
                return true;
            }
        }

        // Validate username on typing and when leaving the field
        usernameField.addEventListener("keyup", validateUsername);
        usernameField.addEventListener("blur", validateUsername);
    }

    //password
    {
        const passwordField = document.getElementById("password");
        const passwordWarning = document.getElementById("passwordWarning");
        const registerForm = document.getElementById("registerForm");

        function validateUsername() {
            const usernameLength = usernameField.value.trim().length;

            if (usernameLength < 5 || usernameLength > 20) {
                usernameWarning.innerText = "Username must be between 5 and 20 characters.";
                usernameWarning.style.display = "block";
                return false;
            } else {
                usernameWarning.style.display = "none";
                return true;
            }
        }

        // Validate username on typing and when leaving the field
        usernameField.addEventListener("keyup", validateUsername);
        usernameField.addEventListener("blur", validateUsername);
    }

</script>

<?php

?>

</html>