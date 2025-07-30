<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$admin_name = $_SESSION['admin_name'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial;
            background: white;
            padding: 30px;
        }
        h2 {
            color: crimson;
            margin-bottom: 20px;
        }
        ul {
            list-style: none;
            padding-left: 0;
        }
        li {
            margin-bottom: 15px;
        }
        a {
            text-decoration: none;
            color: white;
            background-color: crimson;
            padding: 12px 18px;
            border-radius: 5px;
            display: inline-block;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-color: darkred;
        }
        .logout {
            margin-top: 30px;
            display: inline-block;
            background: #555;
        }
    </style>
</head>
<body>

<h2>Welcome, <?php echo htmlspecialchars($admin_name); ?>!</h2>

<ul>
    <li><a href="view_requests.php">View User Requests (Donor + Patient)</a></li>
    <li><a href="manage_requests.php">Accept / Reject Requests</a></li>
    <li><a href="inventory.php">View / Print Inventory</a></li>
    <li><a href="user_lists.php">View Donors & Patients Lists</a></li>
    <li><a href="crossmatch_reports.php">Generate Crossmatch Reports</a></li>
    <li><a href="view_crossmatch_reports.php">View Crossmatch Reports</a></li>

</ul>

<a class="logout" href="../logout.php">Logout</a>

</body>
</html>
