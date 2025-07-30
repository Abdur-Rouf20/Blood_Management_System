<?php
include('../includes/db.php');

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO patients (name, email, phone, address, password) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $email, $phone, $address, $password);

if ($stmt->execute()) {
    header("Location: login.php?msg=registered");
} else {
    echo "Error: " . $stmt->error;
}
?>
