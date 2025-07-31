<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'patient') {
    header("Location: ../login.php");
    exit();
}

include('../includes/header.php');
?>
<style>
    body {
      background-color: #fff;
      color: #900;
      font-family: Arial, sans-serif;
      padding: 20px;
    }
    .form-container {
      max-width: 500px;
      margin: auto;
      border: 2px solid #900;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 0 10px rgba(144, 0, 0, 0.2);
    }
    h2,input {
      text-align: center;
      margin-bottom: 25px;
      color: #900;
    }
    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }
    select, input[type="number"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    button {
      background-color: #900;
      color: white;
      border: none;
      padding: 15px;
      width: 100%;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
    }
    button:hover {
      background-color: #b30000;
    }
  </style>
<h2>🩸 Request Blood</h2>
<div class= "form-container" >
<form action="request_blood_handler.php" method="POST" style="max-width: 500px;">
    <label for="blood_group">Select Blood Group:</label><br>
    <select name="blood_group" id="blood_group" required>
        <option value="">--Select--</option>
        <option value="A+">A+</option>
        <option value="A-">A−</option>
        <option value="B+">B+</option>
        <option value="B-">B−</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB−</option>
        <option value="O+">O+</option>
        <option value="O-">O−</option>
    </select><br><br>

    <label for="bags_needed">Number of Bags:</label><br>
    <input type="number" name="bags_needed" min="1" required><br><br>

    <label for="reason">Reason for Request:</label><br>
    <textarea name="reason" id="reason" rows="4" cols="40" required></textarea><br><br>

    <button type="submit">Submit Request</button>
</form>
</div>
<?php include('../includes/footer.php'); ?>
