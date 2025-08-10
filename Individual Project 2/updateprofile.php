<?php
require "session_auth.php";

// CSRF Protection
if (!isset($_POST["nocsrftoken"]) || $_POST["nocsrftoken"] !== $_SESSION["nocsrftoken"]) {
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Security Alert</title>
        <style>
            body {
                background-color: #f8d7da;
                font-family: Arial, sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .alert-box {
                background-color: #f44336;
                color: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0,0,0,0.2);
                width: 400px;
                text-align: center;
                animation: dropDown 0.5s ease-out;
            }
            @keyframes dropDown {
                from { transform: translateY(-50px); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }
        </style>
        <script>
            setTimeout(function() {
                window.location.href = "logout.php";
            }, 5000);
        </script>
    </head>
    <body>
        <div class="alert-box">
            <h2>CSRF Attack Detected!</h2>
            <p>Logging out for security...</p>
        </div>
    </body>
    </html>';
    exit();
}

// Database Connection
$mysqli = new mysqli("localhost", "muddamn1", "Navatej@123", "project2");

// Input Sanitization Function
function sanitize_input($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

$fullname = sanitize_input($_POST["fullname"]);
$email = sanitize_input($_POST["email"]);
$username = sanitize_input($_POST["username"]);
$cur_username = $_SESSION["username"];

// Fetch Current Values
$stmt = $mysqli->prepare("SELECT fullname, email, username FROM users WHERE username=?");
$stmt->bind_param("s", $cur_username);
$stmt->execute();
$stmt->bind_result($curname, $curmail, $curuser);
$stmt->fetch();
$stmt->close();

// Compare & Update
if ($fullname == $curname && $email == $curmail && $username == $curuser) {
    $message = "No changes made.";
} else {
    $stmt = $mysqli->prepare("UPDATE users SET fullname=?, email=?, username=? WHERE username=?");
    $stmt->bind_param("ssss", $fullname, $email, $username, $cur_username);
    if ($stmt->execute()) {
        $message = "Profile updated successfully.";
        $_SESSION["username"] = $username;
    } else {
        $message = "Failed to update profile.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Update Profile</title>
    <style>
        body {
            background: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .message-box {
            width: 500px;
            margin: 100px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        .message-box h2 {
            margin-bottom: 10px;
        }
        .message-box a {
            margin: 0 10px;
            color: #007bff;
            text-decoration: none;
        }
        .message-box p {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="message-box">
        <h2>Welcome <?php echo htmlentities($username); ?>!</h2>
        <p><?php echo $message; ?></p>
        <a href="profile.php">Back to profile</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
