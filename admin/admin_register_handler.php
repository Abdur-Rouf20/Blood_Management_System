<?php
include('../includes/db.php');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM admins WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('Email already registered.'); window.location.href='admin_register.php';</script>";
        exit();
    }

    // Insert new admin
    $stmt = $conn->prepare("INSERT INTO admins (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Admin registered successfully!'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Error occurred.'); window.location.href='admin_register.php';</script>";
    }
}
?>
