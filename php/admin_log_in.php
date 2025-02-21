<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../css/admin_login.css">
</head>
<body>
    <div class="login">
        <div class="innerLogin">
            <center>
                <h1 class="title">Admin Login</h1>
                <form action="admin_panel.php" method="post">
                    <label for="adminName">Name</label><br><br>
                    <input type="text" name="admin" id="admin"><br><br>
                    <label for="email">Email</label><br><br>
                    <input type="email" name="email" id="email"><br><br>
                    <label for="password">Password</label><br><br>
                    <input type="password" name="password" id="password"><br><br>
                    <input type="submit" value="Login">
                </form>
            </center>
        </div>
    </div>
</body>
</html>