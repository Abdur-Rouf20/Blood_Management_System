<?php
// Connect to DB
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_donor_management_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$donors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $blood_group = $_POST['blood_group'];

  // Fetch donors by blood group
  $sql = "SELECT name, phone FROM donors WHERE blood_group = '$blood_group'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $donors[] = $row;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Search Blood</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f5f5f5; margin: 0; padding: 0;">

  <!-- Header -->
  <header style="background-color: crimson; color: white; padding: 20px; text-align: center;">
    <h1>Search for Blood</h1>
  </header>

  <!-- Form -->
  <main style="padding: 40px;">
    <form method="POST" style="max-width: 400px; margin: auto; background-color: white; padding: 20px; border-radius: 8px;">
      <label for="blood_group"><strong>Select Blood Group:</strong></label><br>
      <select name="blood_group" required style="width: 100%; padding: 10px; margin-top: 10px; margin-bottom: 20px;">
        <option value="">--Select--</option>
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
      </select><br>
      <button type="submit" style="background-color: crimson; color: white; padding: 10px 20px; border: none;">Search Donors</button>
    </form>

    <!-- Search Results -->
    <section style="margin-top: 40px; max-width: 600px; margin-left: auto; margin-right: auto;">
      <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <h2 style="text-align: center;">Available Donors:</h2>
        <?php if (count($donors) > 0): ?>
          <ul style="list-style: none; padding: 0;">
            <?php foreach ($donors as $donor): ?>
              <li style="background: #fff; padding: 15px; margin-bottom: 10px; border-radius: 5px;">
                <strong>Name:</strong> <?= htmlspecialchars($donor['name']) ?><br>
                <strong>Phone:</strong> <?= htmlspecialchars($donor['phone']) ?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <p style="text-align: center; color: red;">No donors found for the selected blood group.</p>
        <?php endif; ?>
      <?php endif; ?>
    </section>
  </main>

</body>
</html>
