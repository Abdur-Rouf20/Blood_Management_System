<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['patient_id'])) {
    header("Location: patient_login.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("UPDATE patients SET name=?, email=?, phone=?, address=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $email, $phone, $address, $patient_id);

    if ($stmt->execute()) {
        $msg = "Profile updated successfully.";
    } else {
        $msg = "Error updating profile: " . $stmt->error;
    }
}

// Fetch profile
$stmt = $conn->prepare("SELECT name, email, phone, address FROM patients WHERE id=?");
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Profile</title>
    <style>
        body { font-family: Arial; padding: 30px; background: #fff; }
        h2 { color: crimson; }
        form { max-width: 400px; }
        input, textarea { width: 100%; padding: 10px; margin: 8px 0; }
        button { background: crimson; color: white; padding: 10px; border: none; cursor: pointer; }
        .msg { margin: 15px 0; color: green; }
    </style>
</head>
<body>

<h2>Patient Profile</h2>

<?php if (isset($msg)) echo "<p class='msg'>$msg</p>"; ?>

<form method="POST" action="">
    <label>Name</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($patient['name']); ?>" required>

    <label>Email</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($patient['email']); ?>" required>

    <label>Phone</label>
    <input type="text" name="phone" value="<?php echo htmlspecialchars($patient['phone']); ?>" required>

    <label>Address</label>
    <textarea name="address" rows="3" required><?php echo htmlspecialchars($patient['address']); ?></textarea>

    <button type="submit">Update Profile</button>
</form>

</body>
</html>
