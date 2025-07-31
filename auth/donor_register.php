<?php
// donor_register.php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Donor Registration</title>
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

    .form-container {
      width: 100%;
      max-width: 500px;
      background-color: #fff;
      border: 2px solid #900;
      border-radius: 10px;
      padding: 40px;
      box-shadow: 0 0 10px rgba(144, 0, 0, 0.2);
    }

    h2 {
      text-align: center;
      color: #900;
      margin-bottom: 30px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
    }

    input,
    select {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .btn {
      background-color: #900;
      color: #fff;
      padding: 12px;
      width: 100%;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #b30000;
    }

    .login-link {
      text-align: center;
      margin-top: 15px;
      font-size: 14px;
    }

    .login-link a {
      color: #900;
      text-decoration: none;
    }

    .login-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2>Donor Registration</h2>
  <form action="donor_register_handler.php" method="post">
    <label for="name">Full Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email Address:</label>
    <input type="text" id="email" name="email" required>

    <label for="phone">Phone Number:</label>
    <input type="text" id="phone" name="phone" required>

    <label for="blood_group">Blood Group:</label>
    <select id="blood_group" name="blood_group" required>
      <option value="">--Select--</option>
      <option value="A+">A+</option>
      <option value="A-">A-</option>
      <option value="B+">B+</option>
      <option value="B-">B-</option>
      <option value="AB+">AB+</option>
      <option value="AB-">AB-</option>
      <option value="O+">O+</option>
      <option value="O-">O-</option>
    </select>

    <label for="address">Address:</label>
    <input type="text" id="address" name="address" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <button class="btn" type="submit">Register</button>
  </form>

  <div class="login-link">
    Already registered? <a href="donor_login.php">Login here</a>
  </div>
</div>

</body>
</html>

