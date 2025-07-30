<!-- request_blood.php placeholder -->
 <?php
session_start();

if (!isset($_SESSION['donor_id'])) {
    header('Location: ../auth/donor_login.php');
    exit();
}

$donor_name = $_SESSION['donor_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Request Blood</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
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
    h2 {
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
</head>
<body>
  <div class="form-container">
    <h2>Request Blood</h2>
    <form action="request_blood_handler.php" method="post">
      <label>Donor Name:</label>
      <input type="text" value="<?= htmlspecialchars($donor_name) ?>" readonly>

      <label for="blood_group">Blood Group Needed:</label>
      <select name="blood_group" id="blood_group" required>
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

      <label for="bags">Number of Bags:</label>
      <input type="number" name="bags" min="1" max="10" required>

      <button type="submit">Submit Request</button>
    </form>
  </div>
</body>
</html>

