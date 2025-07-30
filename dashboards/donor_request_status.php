<?php
session_start();
require_once 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['donor_id'])) {
    header("Location: donor_login.php");
    exit();
}

$donor_id = $_SESSION['donor_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Request Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 30px;
        }
        h2 {
            color: crimson;
        }
        table {
            width: 100%;
            margin-top: 25px;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
        }
        th {
            background-color: crimson;
            color: white;
        }
    </style>
</head>
<body>

<h2>📋 My Blood Request Status</h2>

<?php
$query = "SELECT r.id, r.blood_group, r.units, r.status, r.timestamp, p.name AS patient_name
          FROM blood_requests r
          JOIN patients p ON r.patient_id = p.id
          WHERE r.donor_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $donor_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Request ID</th>
                <th>Patient Name</th>
                <th>Blood Group</th>
                <th>Units</th>
                <th>Status</th>
                <th>Requested On</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['patient_name']}</td>
                <td>{$row['blood_group']}</td>
                <td>{$row['units']}</td>
                <td>{$row['status']}</td>
                <td>{$row['timestamp']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No blood requests found.</p>";
}
?>

</body>
</html>
