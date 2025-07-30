<!-- patient/login.php -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Patient Login</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <style>
    body {
      background-color: #fff;
      font-family: Arial, sans-serif;
      color: #900;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-container {
      width: 100%;
      max-width: 400px;
      padding: 40px;
      background-color: #fff;
      border: 2px solid #900;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(144, 0, 0, 0.2);
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #900;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .btn {
      width: 100%;
      background-color: #900;
      color: #fff;
      padding: 12px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #b30000;
    }

    .register-link {
      text-align: center;
      margin-top: 20px;
      font-size: 14px;
    }

    .register-link a {
      color: #900;
      text-decoration: none;
    }

    .register-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>

<div class="login-container">
  <h2>Patient Login</h2>
  <form action="/blood_Donor_management_system/patient/login_handler.php" method="POST">
    <label for="email">Email:</label>
    <input type="text" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit" class="btn">Login</button>
  </form>

  <div class="register-link">
    Not registered? <a href="register.php">Create an account</a>
  </div>
</div>
</body>
</html>
