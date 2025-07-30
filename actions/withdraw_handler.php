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
    $patient_name = trim($_POST['patient_name']);

    $valid_groups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

    if (!in_array($blood_group, $valid_groups)) {
        echo "<script>alert('Invalid blood group selected!'); window.history.back();</script>";
        exit();
    }

    if ($bags < 1) {
        echo "<script>alert('Number of bags must be at least 1.'); window.history.back();</script>";
        exit();
    }

    if (empty($patient_name)) {
        echo "<script>alert('Please enter the patient name.'); window.history.back();</script>";
        exit();
    }

    // Check available blood bags
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

    // Deduct bags from blood_storage
    $new_bags = $available_bags - $bags;
    $update = $conn->prepare("UPDATE blood_storage SET bags_available = ? WHERE blood_group = ?");
    $update->bind_param("is", $new_bags, $blood_group);
    $update->execute();
    $update->close();

    // Generate unique bag number (example: timestamp + random number)
    $bag_number = uniqid('BAG');

    // Insert crossmatch report (new table: crossmatch_reports)
    $status = 'matched'; // assuming matched by default

    $insert = $conn->prepare("INSERT INTO crossmatch_reports (bag_number, blood_group, donor_name, patient_name, crossmatch_status, timestamp) VALUES (?, ?, ?, ?, ?, NOW())");
    $insert->bind_param("sssss", $bag_number, $blood_group, $donor_name, $patient_name, $status);
    $insert->execute();
    $insert->close();

    echo "<script>alert('Withdrawal successful!'); window.location.href='../dashboards/donor_dashboard.php';</script>";
} else {
    header('Location: withdraw.php');
    exit();
}
