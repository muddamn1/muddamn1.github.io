<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>WAPH - Registration Page</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", sans-serif;
      background: #f0f2f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background: #fff;
      padding: 40px 30px;
      border-radius: 12px;
      width: 400px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    h1, h2 {
      text-align: center;
      color: #333;
      margin-bottom: 10px;
    }

    #digit-clock {
      text-align: center;
      margin-bottom: 10px;
      font-weight: bold;
      color: #666;
    }

    p {
      text-align: center;
      font-size: 14px;
      color: #888;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      margin-bottom: 6px;
      font-weight: 500;
      color: #555;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      margin-bottom: 18px;
      font-size: 14px;
    }

    button {
      padding: 12px;
      background-color: #007bff;
      color: #fff;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover {
      background-color: #0056b3;
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
  <div class="container">
    <h1>A Simple login form, WAPH</h1>
    <h2>Navatej Reddy</h2>
    <div id="digit-clock"></div>
    <?php
      echo "<p>Visited time: " . date("M-d h:i:sa") . "</p>";
    ?>
    <form action="addnewuser.php" method="POST">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>

      <label for="fullname">Full Name:</label>
      <input type="text" id="fullname" name="fullname" required>

      <label for="email">Email:</label>
      <input type="text" class="text_field" name="email"
               pattern="^[\w.-]+@[\w-]+(\.[\w-]+)*$"
               title="Please enter a valid email"
               placeholder="Your email address"
               onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');"
               required>
     <label for="password">Password:</label>
   <input type="password" name="password"  required
 pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$"
 placeholder="Your password"
 title="Password must have at least 8 characters with 1 special symbol !@#$%^& 1 number, 1 
lowercase, and 1 UPPERCASE"
 onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: 
''); form.repassword.pattern = this.value;"/>
  <label for="repassword">Confirm Password:</label>
<input type="password" class="text_field" name="repassword"
 placeholder="Retype your password" required
 title="Password does not match"
 onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');"/>
            <button type="submit">Register</button>
    </form>
    <div class="switch-link">
      <p>Already registered? <a href="login.php">Login</a></p>
    </div>
    </form>
  </div>
</body>
</html>
