<?php
session_start();

// Check if logged in as patient
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'patient') {
    header("Location: login.php");
    exit();
}

include('../includes/header.php');
?>
<style>
    .dashboard-buttons {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
      max-width: 600px;
    }
    .dashboard-buttons button{
      width: 100%;
      padding: 20px;
      font-size: 18px;
      border-radius: 8px;
    }

    
    .logout {
      background-color: #900;
      color: white;
      border: none;
      padding: 15px;
      width: 450px;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
    }
    .logout:hover {
      background-color: #b30000;
    }
</style>
<h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>

<div class= "dashboard-buttons form">
    <a href="request_blood.php"><button>🩸 Request Blood</button></a><br><br>
    <a href="search_donor.php"><button>🔍 Search Donors</button></a><br><br>
    <a href="request_history.php"><button>📜 View Requests</button></a><br><br>
   
</div>
<br>
<br>
 <a href="../logout.php"><button class = "logout">🚪 Logout</button></a>

<?php include('../includes/footer.php'); ?>
