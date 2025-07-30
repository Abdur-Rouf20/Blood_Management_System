<?php
// donor_register_handler.php
require_once('../includes/db.php'); // include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name']);
    $email       = trim($_POST['email']);
    $phone       = trim($_POST['phone']);
    $blood_group = $_POST['blood_group'];
    $address     = trim($_POST['address']);
    $password    = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if donor already exists
    $check_query = "SELECT id FROM donors WHERE email = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Email already registered. Please login.'); window.location.href='donor_login.php';</script>";
        exit();
    }
    $stmt->close();

    // Insert into donors table
    $insert_query = "INSERT INTO donors (name, email, phone, blood_group, address, password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ssssss", $name, $email, $phone, $blood_group, $address, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! Please login.'); window.location.href='donor_login.php';</script>";
    } else {
        echo "<script>alert('Error occurred. Please try again.'); window.location.href='donor_register.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: donor_register.php");
    exit();
}
