<!-- donor_dashboard.php placeholder -->
 <?php
session_start();

// Check if donor is logged in
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
  <title>Donor Dashboard</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <style>
    body {
      background-color: #fff;
      color: #900;
      font-family: Arial, sans-serif;
      padding: 20px;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 2px solid #900;
      padding-bottom: 10px;
      margin-bottom: 30px;
    }

    h1 {
      margin: 0;
    }

    nav button {
      background-color: #900;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 14px;
      transition: background-color 0.3s ease;
    }

    nav button:hover {
      background-color: #b30000;
    }

    .dashboard-buttons {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
      max-width: 600px;
    }

    .dashboard-buttons form {
      flex: 1;
    }

    .dashboard-buttons button {
      width: 100%;
      padding: 20px;
      font-size: 18px;
      border-radius: 8px;
    }
  </style>
</head>
<?php include('../includes/header.php'); ?>
<body>
  <header>
    <h1>Welcome, <?= htmlspecialchars($donor_name) ?></h1>
    <nav>
      <form action="../auth/logout.php" method="post" style="display:inline;">
        <button type="submit">Logout</button>
      </form>
    </nav>
  </header>

  <main>
    <div class="dashboard-buttons">
      <form action="../actions/donate.php" method="get">
        <button type="submit" class="btn">Donate Blood</button>
      </form>

      <form action="../actions/request_blood.php" method="get">
        <button type="submit" class="btn">Request Blood</button>
      </form>

      <form action="../actions/withdraw.php" method="get">
        <button type="submit" class="btn">Withdraw Blood</button>
      </form>

      <form action="../actions/search_donor.php" method="get">
        <button type="submit" class="btn">Search Blood</button>
      </form>
    </div>
  </main>
</body>
<footer> 
  <?php include('../includes/footer.php'); ?>
</footer>
</html>

