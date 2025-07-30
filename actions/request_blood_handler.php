<?php
session_start();
require_once('../includes/db.php');

if (!isset($_SESSION['donor_id'])) {
    header('Location: ../auth/donor_login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $donor_id = $_SESSION['donor_id'];
    $donor_name = $_SESSION['donor_name'];
    $blood_group = $_POST['blood_group'];
    $bags = (int) $_POST['bags'];

    $valid_groups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
    if (!in_array($blood_group, $valid_groups)) {
        echo "<script>alert('Invalid blood group selected!'); window.history.back();</script>";
        exit();
    }

    if ($bags < 1) {
        echo "<script>alert('Number of bags must be at least 1.'); window.history.back();</script>";
        exit();
    }

    // Check if requested blood is available
    $stmt = $conn->prepare("SELECT bags_available FROM blood_storage WHERE blood_group = ?");
    $stmt->bind_param("s", $blood_group);
    $stmt->execute();
    $stmt->bind_result($available_bags);
    $stmt->fetch();
    $stmt->close();

    if ($available_bags < $bags) {
        echo "<script>alert('Not enough blood bags available. Current stock: $available_bags'); window.history.back();</script>";
        exit();
    }

    // Insert request record
    $insert = $conn->prepare("INSERT INTO blood_requests (donor_id, blood_group, bags_requested, status, requested_at) VALUES (?, ?, ?, 'pending', NOW())");
    $insert->bind_param("isi", $donor_id, $blood_group, $bags);

    if ($insert->execute()) {
        echo "<script>alert('Blood request submitted successfully. Please wait for approval.'); window.location.href='../dashboards/donor_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error submitting request. Please try again.'); window.history.back();</script>";
    }
    $insert->close();
    $conn->close();
} else {
    header('Location: request_blood.php');
    exit();
}
