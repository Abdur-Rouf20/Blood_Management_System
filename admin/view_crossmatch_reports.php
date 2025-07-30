<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../index.php");
    exit();
}
include '../db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Crossmatch Reports</title>
</head>
<body>
    <h2>Crossmatch Reports</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>Bag Number</th>
            <th>Blood Group</th>
            <th>Donor Name</th>
            <th>Patient Name</th>
            <th>Match Status</th>
            <th>Timestamp</th>
        </tr>
        <?php
        $sql = "SELECT * FROM crossmatch_reports ORDER BY timestamp DESC";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['bag_number']}</td>
                    <td>{$row['blood_group']}</td>
                    <td>{$row['donor_name']}</td>
                    <td>{$row['patient_name']}</td>
                    <td>{$row['match_status']}</td>
                    <td>{$row['timestamp']}</td>
                </tr>";
        }
        ?>
    </table>
</body>
</html>
