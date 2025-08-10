<?php
session_start();

// Connect to database
$mysqli = new mysqli('localhost', 'muddamn1', 'Navatej@123', 'project2');
if ($mysqli->connect_errno) {
    printf("Database connection failed: %s\n", $mysqli->connect_error);
    exit();
}

// Get input from form

$username = $_POST["username"];
$fullname = $_POST["fullname"];
$email = $_POST["email"];
$password = $_POST["password"];
$respassword = $_POST["repassword"];


// Prepare SQL to insert new user
$prepared_sql = "INSERT INTO users (username, password, fullname, email) VALUES (?, md5(?), ?, ?)";
if (!$stmt = $mysqli->prepare($prepared_sql)) {
    echo "Prepare failed.";
    exit();
}

// Bind the parameters
$stmt->bind_param("ssss", $username, $password, $fullname, $email);

// Execute the statement
if (!$stmt->execute()) {
    echo "Execute failed: " . $stmt->error;
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration Success</title>
  <style>
    body {
      background-color: #f0f2f5;
      font-family: "Segoe UI", sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .message-box {
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      text-align: center;
    }
    .message-box h2 {
      color: green;
      margin-bottom: 20px;
    }
    .message-box a {
      display: inline-block;
      padding: 12px 24px;
      background-color: #007bff;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
    }
    .message-box a:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="message-box">
    <h2>Registration succeeded. You can now login.</h2>
    <a href="login.php">Login Now</a>
  </div>
</body>
</html>
