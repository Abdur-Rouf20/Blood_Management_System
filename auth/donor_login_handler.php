<?php
// donor_login_handler.php
session_start();
require_once('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Check if user exists
    $query = "SELECT id, name, email, password FROM donors WHERE email = ? OR name = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Authentication success
            $_SESSION['donor_id'] = $user['id'];
            $_SESSION['donor_name'] = $user['name'];
            header('Location: ../dashboards/donor_dashboard.php');
            exit();
        } else {
            echo "<script>alert('Incorrect password!'); window.location.href='donor_login.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('User not found!'); window.location.href='donor_login.php';</script>";
        exit();
    }
} else {
    header('Location: donor_login.php');
    exit();
}
