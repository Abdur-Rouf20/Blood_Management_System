<?php
session_start();
require_once 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['patient_id'])) {
    header("Location: patient_login.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Blood Request Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            padding: 30px;
        }
        h2 {
            color: crimson;
        }
        table {
            width: 100%;
            margin-top: 20px;
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
$query = "SELECT r.id, r.blood_group, r.units, r.status, r.timestamp, d.name AS donor_name
          FROM blood_requests_patient r
          LEFT JOIN donors d ON r.donor_id = d.id
          WHERE r.patient_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Request ID</th>
                <th>Donor Name</th>
                <th>Blood Group</th>
                <th>Units</th>
                <th>Status</th>
                <th>Requested On</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>" . ($row['donor_name'] ?? 'Pending Assignment') . "</td>
                <td>{$row['blood_group']}</td>
                <td>{$row['units']}</td>
                <td>{$row['status']}</td>
                <td>{$row['timestamp']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>You haven't made any blood requests yet.</p>";
}
?>

</body>
</html>
