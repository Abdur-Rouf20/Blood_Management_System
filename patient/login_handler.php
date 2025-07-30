<?php
session_start();
include('../includes/db.php');

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM patients WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $patient = $result->fetch_assoc();
    if (password_verify($password, $patient['password'])) {
        $_SESSION['user_type'] = 'patient';
        $_SESSION['patient_id'] = $patient['id'];
        $_SESSION['name'] = $patient['name'];
        header("Location: dashboard.php");
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No account found.";
}
?>
