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
            <h1 class="title">Admin Login</h1><br>
            <form action=" " method="post">
                <label for="adminName">Name</label><br>
                <input type="text" name="admin" id="admin" class="input" placeholder="Enter your name" required><br><br>
                <label for="email">Email</label><br>
                <input type="email" name="email" id="email" class="input" placeholder="Enter your email"
                    required><br><br>
                <label for="password">Password</label><br>
                <input type="password" name="password" id="password" class="input" placeholder="Enter your password"
                    required><br><br><br>
                <input type="submit" value="Login" class="button">
            </form>
        </div>
    </div>
</body>

</html>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["password"]) || empty($_POST["password"])) {
        die("Password field is missing or empty.");
    }

    $adminPassword = mysqli_real_escape_string($connect, $_POST["password"]);

    // Fetch admin details
    $checkAdmin = "SELECT * FROM admin WHERE Name='$name' AND email='$email'";
    $result = mysqli_query($connect, $checkAdmin);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row["password"]; // Stored hashed password in DB

        // Verify hashed password
        if (password_verify($adminPassword, $hashedPassword)) {
            session_start();
            $_SESSION["admin_id"] = $row["aid"];
            $_SESSION["admin_name"] = $row["name"];
            $_SESSION["admin_email"] = $row["email"];

            echo "<script>window.location.href='admin_panel.php';</script>";
            exit;
        } else {
            echo "<script>alert('Invalid password.');</script>";
        }
    } else {
        echo "<script>alert('Admin not found.');</script>";
    }
}

?>