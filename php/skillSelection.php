<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../image/logo.png">
    <title>Skill Selection</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/skillSelection.css">
</head>

<body>

    <section>
        <form action="" method="post">
            <h1 class="title">Select Your Skill(s)</h1>
            <h2 class="subTitle">Tell us your skills</h2>

            <div id="skills-container">
                <input type="text" name="Skill_1" placeholder="Enter your skill">
            </div>

            <button type="button" id="add-skill">Add Skill</button>

            <p class="para">If you don't have any skills, just skip this form.</p>

            <input type="submit" value="Submit" class="submit-btn">
            <a href="login.php" class="skip-btn">Skip</a>
        </form>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const container = document.getElementById("skills-container");
            const addButton = document.getElementById("add-skill");
            let skillCount = 1;

            addButton.addEventListener("click", function () {
                const inputs = container.getElementsByTagName("input");
                const lastInput = inputs[inputs.length - 1];

                // Check if the last input field has text
                if (lastInput.value.trim() === "") {
                    alert("Please fill in the current skill field before adding a new one.");
                    return;
                }

                if (skillCount < 3) {
                    skillCount++;
                    const input = document.createElement("input");
                    input.type = "text";
                    input.name = `Skill_${skillCount}`;
                    input.placeholder = `Enter your skill ${skillCount}`;
                    container.appendChild(input);
                }

                if (skillCount === 3) {
                    addButton.disabled = true; // Disable button after 3 skills
                }
            });
        });
    </script>

</body>

</html>

<?php
session_start();
include 'connect.php';
$connect = dbConnection();

// Ensure session variable exists
if (!isset($_SESSION["UID"]) && $_SESSION["Register"] == false) {
    echo "<script> window.location.href='index.php';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $UID = $_SESSION["UID"];
    $skill1 = $_POST["Skill_1"] ?? NULL;
    $skill2 = $_POST["Skill_2"] ?? NULL;
    $skill3 = $_POST["Skill_3"] ?? NULL;

    $sql = "SELECT * FROM user_skill WHERE UID='$UID'";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "<script> window.location.href='login.php';</script>";
        exit;
    }

    // Ensure table exists before inserting
    $sql = "INSERT INTO user_skill (Skill_1, Skill_2, Skill_3, UID) VALUES ('$skill1', '$skill2', '$skill3','$UID')";
    $result = mysqli_query($connect, $sql);

    if ($result) {
        echo "<script>window.location.href='login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>