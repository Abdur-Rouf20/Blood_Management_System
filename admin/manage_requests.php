<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $request_id = (int) $_POST['request_id'];

    if ($action === 'accept') {
        $status = 'Approved';

        // Start transaction
        $conn->begin_transaction();

        try {
            // Update request status
            $stmt = $conn->prepare("UPDATE requests SET status=? WHERE id=?");
            $stmt->bind_param("si", $status, $request_id);
            $stmt->execute();

            // Get request details
            $stmt = $conn->prepare("SELECT blood_group, units, donor_id, patient_id FROM requests WHERE id=?");
            $stmt->bind_param("i", $request_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $request_data = $result->fetch_assoc();

            if ($request_data) {
                $bg = $request_data['blood_group'];
                $units = (int)$request_data['units'];
                $donor_id = $request_data['donor_id'];
                $patient_id = $request_data['patient_id'];

                // Reduce inventory
                $stmt = $conn->prepare("UPDATE blood_storage SET units_available = units_available - ? WHERE blood_group = ?");
                $stmt->bind_param("is", $units, $bg);
                $stmt->execute();

                // Check inventory is not negative
                $stmt = $conn->prepare("SELECT units_available FROM blood_storage WHERE blood_group = ?");
                $stmt->bind_param("s", $bg);
                $stmt->execute();
                $stock = $stmt->get_result()->fetch_assoc();

                if ($stock['units_available'] < 0) {
                    throw new Exception("Insufficient stock for blood group $bg.");
                }

                // Crossmatch report
                $bag_number = uniqid("BAG_");
                $donor_name = "-";
                $patient_name = "-";

                if ($donor_id) {
                    $stmt = $conn->prepare("SELECT name FROM donors WHERE id=?");
                    $stmt->bind_param("i", $donor_id);
                    $stmt->execute();
                    $donor = $stmt->get_result()->fetch_assoc();
                    if ($donor) $donor_name = $donor['name'];
                }

                if ($patient_id) {
                    $stmt = $conn->prepare("SELECT name FROM patients WHERE id=?");
                    $stmt->bind_param("i", $patient_id);
                    $stmt->execute();
                    $patient = $stmt->get_result()->fetch_assoc();
                    if ($patient) $patient_name = $patient['name'];
                }

                $match_status = "Matched";

                $stmt = $conn->prepare("INSERT INTO crossmatch_reports (bag_number, blood_group, donor_name, patient_name, match_status)
                                        VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $bag_number, $bg, $donor_name, $patient_name, $match_status);
                $stmt->execute();
            }

            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
            $error_msg = "Error processing request: " . $e->getMessage();
        }

    } elseif ($action === 'reject') {
        $status = 'Rejected';
        $stmt = $conn->prepare("UPDATE requests SET status=? WHERE id=?");
        $stmt->bind_param("si", $status, $request_id);
        $stmt->execute();
    }
}

// Fetch all requests
$sql = "SELECT r.id, r.blood_group, r.units, r.status, r.timestamp, 
               d.name AS donor_name, p.name AS patient_name, r.request_type
        FROM requests r
        LEFT JOIN donors d ON r.donor_id = d.id
        LEFT JOIN patients p ON r.patient_id = p.id
        ORDER BY r.timestamp DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Blood Requests</title>
    <style>
        body { font-family: Arial; background: white; padding: 30px; }
        h2 { color: crimson; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: crimson; color: white; }
        button { padding: 7px 12px; margin: 0 3px; border: none; color: white; cursor: pointer; border-radius: 3px; }
        .accept-btn { background-color: green; }
        .reject-btn { background-color: red; }
    </style>
</head>
<body>

<h2>Manage Blood Requests</h2>

<?php if (!empty($error_msg)): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error_msg); ?></p>
<?php endif; ?>

<table>
    <tr>
        <th>ID</th>
        <th>Request Type</th>
        <th>Donor Name</th>
        <th>Patient Name</th>
        <th>Blood Group</th>
        <th>Units</th>
        <th>Status</th>
        <th>Requested At</th>
        <th>Actions</th>
    </tr>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars(ucfirst($row['request_type'] ?? 'unknown')); ?></td>
                <td><?php echo htmlspecialchars($row['donor_name'] ?? '-'); ?></td>
                <td><?php echo htmlspecialchars($row['patient_name'] ?? '-'); ?></td>
                <td><?php echo htmlspecialchars($row['blood_group']); ?></td>
                <td><?php echo htmlspecialchars($row['units']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td><?php echo htmlspecialchars($row['timestamp']); ?></td>
                <td>
                    <?php if ($row['status'] === 'Pending'): ?>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="action" value="accept">
                            <button type="submit" class="accept-btn">Accept</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="action" value="reject">
                            <button type="submit" class="reject-btn">Reject</button>
                        </form>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="9">No requests found.</td></tr>
    <?php endif; ?>
</table>

</body>
</html>
