<?php
require "session_auth.php";
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];
date_default_timezone_set("America/New_York");
$current_time = date("Y-m-d h:i:sa");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }
        .welcome {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 15px;
        }
        .box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            width: 350px;
            text-align: center;
        }
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 12px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        .btn {
            width: 100%;
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-bottom: 15px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        h2 {
            margin-bottom: 10px;
        }
        small {
            color: #666;
            display: block;
            margin-bottom: 20px;
        }
        a {
            display: block;
            text-decoration: none;
            color: #007bff;
            margin-top: 10px;
        }
    </style>
     <script type="text/javascript">
    function displayTime() {
      const options = {
        month: 'short',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true
      };
      const formattedTime = new Date().toLocaleString('en-US', options).replace(/,/g, '');
      document.getElementById('digit-clock').innerHTML = "Current time: " + formattedTime;
    }
    setInterval(displayTime, 500);
</script>
</head>
<body>
    <div class="box">   
    <div class="welcome">Welcome <?= htmlspecialchars($username) ?>!</div>
        <h2>Change Password</h2>
        <small>By Navatej Reddy <br>
    <div id="digit-clock"></div>
        <form action="changepassword.php" method="POST">
            <input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
            <label for="newpassword">New password:</label>
            <input type="password" name="newpassword" id="newpassword" required
                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$"
                placeholder="Your password"
                title="Password must have at least 8 characters with 1 special symbol !@#$%^& 1 number, 1 lowercase, and 1 UPPERCASE"
                onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); form.repassword.pattern = this.value;" />
            <button type="submit" class="btn">Change password</button>
        </form>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>


       
   
