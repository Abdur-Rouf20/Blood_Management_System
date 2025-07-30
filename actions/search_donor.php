<!-- search_donor.php placeholder -->
 <?php
session_start();

if (!isset($_SESSION['donor_id']) && !isset($_SESSION['patient_id'])) {
    header('Location: ../pages/index.php');
    exit();
}

require_once('../includes/db.php');

$search_results = [];
$search_blood_group = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search_blood_group = $_POST['blood_group'] ?? '';

    $valid_groups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
    if (in_array($search_blood_group, $valid_groups)) {
        $stmt = $conn->prepare("SELECT name, phone, blood_group, address FROM donors WHERE blood_group = ?");
        $stmt->bind_param("s", $search_blood_group);
        $stmt->execute();
        $result = $stmt->get_result();
        $search_results = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    } else {
        $search_results = [];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Search Donors</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <style>
    body {
      background-color: #fff;
      color: #900;
      font-family: Arial, sans-serif;
      padding: 20px;
    }
    .form-container {
      max-width: 600px;
      margin: auto;
      border: 2px solid #900;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 0 10px rgba(144, 0, 0, 0.2);
      margin-bottom: 30px;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #900;
    }
    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }
    select {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    button {
      background-color: #900;
      color: white;
      border: none;
      padding: 12px;
      width: 100%;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
    }
    button:hover {
      background-color: #b30000;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid #900;
      padding: 10px;
      text-align: left;
    }
    th {
      background-color: #900;
      color: white;
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h2>Search Donors by Blood Group</h2>
    <form method="post" action="">
      <label for="blood_group">Select Blood Group:</label>
      <select name="blood_group" id="blood_group" required>
        <option value="">--Select--</option>
        <option value="A+" <?= $search_blood_group == 'A+' ? 'selected' : '' ?>>A+</option>
        <option value="A-" <?= $search_blood_group == 'A-' ? 'selected' : '' ?>>A-</option>
        <option value="B+" <?= $search_blood_group == 'B+' ? 'selected' : '' ?>>B+</option>
        <option value="B-" <?= $search_blood_group == 'B-' ? 'selected' : '' ?>>B-</option>
        <option value="AB+" <?= $search_blood_group == 'AB+' ? 'selected' : '' ?>>AB+</option>
        <option value="AB-" <?= $search_blood_group == 'AB-' ? 'selected' : '' ?>>AB-</option>
        <option value="O+" <?= $search_blood_group == 'O+' ? 'selected' : '' ?>>O+</option>
        <option value="O-" <?= $search_blood_group == 'O-' ? 'selected' : '' ?>>O-</option>
      </select>

      <button type="submit">Search</button>
    </form>
  </div>

  <?php if (!empty($search_results)) : ?>
    <div class="form-container">
      <h2>Donor Results</h2>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Blood Group</th>
            <th>Address</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($search_results as $donor): ?>
            <tr>
              <td><?= htmlspecialchars($donor['name']) ?></td>
              <td><?= htmlspecialchars($donor['phone']) ?></td>
              <td><?= htmlspecialchars($donor['blood_group']) ?></td>
              <td><?= htmlspecialchars($donor['address']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <div class="form-container">
      <p>No donors found for blood group <?= htmlspecialchars($search_blood_group) ?>.</p>
    </div>
  <?php endif; ?>

</body>
</html>

