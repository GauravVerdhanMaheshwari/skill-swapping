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
            <form action="home.php" method="post">
                <h1 class="heading">LOGIN</h1>
                <label for="name">User Name</label><br>
                <input type="text" class="input" name="userName" id="userName" autocomplete="off"
                    placeholder="Enter your username" required minlength="5" maxlength="20"><br><br>
                <label for="password">Password</label><br>
                <input type="password" class="input" name="password" id="password" autocomplete="off"
                    placeholder="Enter your username" required minlength="8" maxlength="20"><br><br>
                <input type="submit" value="Login" class="button"> <br><br>
                <div class="linkDiv">
                    <a href="index.php" class="link"> I don't have an account</a> <br>
                    <a href="forgetPassword.php" class="link"> Forget Password</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>