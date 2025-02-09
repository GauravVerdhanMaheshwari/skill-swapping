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

                <br><label for="name">User Name</label><br>
                <input type="text" name="userName" class="input" id="userName" autocomplete="off"
                    placeholder="Enter your username" required minlength="5" maxlength="20"><br>
                <p id="usernameWarning"
                    style="color: red; font-weight: 500;font-size: 18px; margin:0px,0px,0px,10px; display: none;"></p>

                <br><label for="email">Email</label><br>
                <input type="email" name="email" class="input" id="email" autocomplete="off"
                    placeholder="Enter your email" required><br>

                <br><label for="password">Password</label><br>
                <input type="password" name="password" class="input" id="password" autocomplete="off"
                    placeholder="Enter your password" required minlength="8" maxlength="20"><br>
                <p id="passwordWarning"
                    style="color: red; font-weight: 500;font-size: 18px; margin:0px,0px,0px,10px; display: none;"></p>

                <br><label for="password">Confirm Password</label><br>
                <input type="password" name="confirmPassword" class="input" id="confirmPassword" autocomplete="off"
                    placeholder="Confirm your password" required minlength="8" maxlength="20">
                <p id="confirmPasswordWarning"
                    style="color: red; font-weight: 500;font-size: 18px; margin:0px,0px,0px,10px; display: none;">
                </p>

                <br><br><br><input type="submit" value="Register" class="button"><br><br>

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

    const passwordField = document.getElementById("password");
    const passwordWarning = document.getElementById("passwordWarning");
    let password;

    function validatePassword() {
        const passwordLength = passwordField.value.trim().length;

        if (passwordLength < 5 || passwordLength > 20) {
            passwordWarning.innerText = "Password must be between 5 and 20 characters.";
            passwordWarning.style.display = "block";
            return false;
        } else {
            passwordWarning.style.display = "none";
            password = passwordField.value;
            return true;
        }
    }

    // Validate Password on typing and when leaving the field
    passwordField.addEventListener("keyup", validatePassword);
    passwordField.addEventListener("blur", validatePassword);

    //confirm password 
    const ConfirmPasswordField = document.getElementById("confirmPassword");
    const confirmPasswordWarning = document.getElementById("confirmPasswordWarning");
    let confirmPassword;

    function validateConfirmPassword() {
        const passwordLength = ConfirmPasswordField.value.trim().length;

        if (confirmPassword !== password) {
            confirmPasswordWarning.innerText = "The password is not same as the given password";
            confirmPasswordWarning.style.display = "block";
            return false;
        } else {
            confirmPasswordWarning.style.display = "none";
            password = ConfirmPasswordField.value;
            return true;
        }
    }

    // Validate username on typing and when leaving the field
    ConfirmPasswordField.addEventListener("keyup", validateConfirmPassword);
    ConfirmPasswordField.addEventListener("blur", validateConfirmPassword);

</script>

<?php

?>

</html>