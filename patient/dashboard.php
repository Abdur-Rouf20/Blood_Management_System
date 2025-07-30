<?php
session_start();

// Check if logged in as patient
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'patient') {
    header("Location: login.php");
    exit();
}

include('../includes/header.php');
?>

<h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>

<div style="margin-top: 20px;">
    <a href="request_blood.php"><button>🩸 Request Blood</button></a><br><br>
    <a href="search_donor.php"><button>🔍 Search Donors</button></a><br><br>
    <!-- Optional: Uncomment later -->
    <!-- <a href="request_history.php"><button>📜 View Requests</button></a><br><br> -->
    <a href="../logout.php"><button>🚪 Logout</button></a>
</div>

<?php include('../includes/footer.php'); ?>
