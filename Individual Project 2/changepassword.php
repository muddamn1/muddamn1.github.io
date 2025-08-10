<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}


$mysqli = new mysqli("localhost", "muddamn1", "Navatej@123", "project2");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION["username"];
    $newpassword = htmlspecialchars(trim($_POST["newpassword"]));

    if (!empty($newpassword)) {
        $stmt = $mysqli->prepare("UPDATE users SET password=md5(?) WHERE username=?");
        $stmt->bind_param("ss", $newpassword, $username);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $message = "Password updated successfully.";
        } else {
            $message = "Password update failed.";
        }
        $stmt->close();
    } else {
        $message = "Password cannot be empty.";
    }
} else {
    $message = "Invalid request.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            width: 350px;
            text-align: center;
        }
        a {
            display: block;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="box">
    <h3>Welcome <?= htmlspecialchars($_SESSION["username"]) ?>!</h3>
    <p><?= $message ?></p>
    <a href="profile.php">Back to profile</a>
    <a href="logout.php">Logout</a>
</div>
</body>
</html>
