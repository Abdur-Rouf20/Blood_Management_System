<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'patient') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_SESSION['user_id'];
    $blood_group = $_POST['blood_group'];
    $bags_needed = $_POST['bags_needed'];
    $reason = $_POST['reason'];
    $status = "Pending";
    $requested_at = date('Y-m-d H:i:s');

    $sql = "INSERT INTO blood_requests_patient (patient_id, blood_group, bags_needed, reason, status, requested_at) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isisss", $patient_id, $blood_group, $bags_needed, $reason, $status, $requested_at);

   
    if ($stmt->execute()) {
        echo "<script>
            alert('Request submitted successfully');
            window.location.href = 'dashboard.php';
        </script>";
        exit();
    } else {
        echo "❌ Error submitting request: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: request_blood.php");
    exit();
}
?>
