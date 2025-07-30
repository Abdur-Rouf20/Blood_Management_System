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

    // Validate blood group
    $valid_groups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
    if (!in_array($blood_group, $valid_groups)) {
        echo "<script>alert('Invalid blood group!'); window.history.back();</script>";
        exit();
    }

    if ($bags < 1) {
        echo "<script>alert('Number of bags must be at least 1.'); window.history.back();</script>";
        exit();
    }

    // Insert donation record (optional, you can create donations table if you want)
    // For now, directly update blood_storage table

    // Check if blood group exists in storage
    $check = $conn->prepare("SELECT bags_available FROM blood_storage WHERE blood_group = ?");
    $check->bind_param("s", $blood_group);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $check->bind_result($current_bags);
        $check->fetch();
        $new_bags = $current_bags + $bags;

        $update = $conn->prepare("UPDATE blood_storage SET bags_available = ? WHERE blood_group = ?");
        $update->bind_param("is", $new_bags, $blood_group);
        $update->execute();
        $update->close();
    } else {
        // Insert new blood group record
        $insert = $conn->prepare("INSERT INTO blood_storage (blood_group, bags_available) VALUES (?, ?)");
        $insert->bind_param("si", $blood_group, $bags);
        $insert->execute();
        $insert->close();
    }
    $check->close();

    echo "<script>alert('Donation recorded successfully! Thank you.'); window.location.href='../dashboards/donor_dashboard.php';</script>";
} else {
    header('Location: donate.php');
    exit();
}
