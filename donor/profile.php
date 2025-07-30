<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['donor_id'])) {
    header("Location: donor_login.php");
    exit();
}

$donor_id = $_SESSION['donor_id'];

// Handle form submission to update profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $blood_group = $_POST['blood_group'];

    $stmt = $conn->prepare("UPDATE donors SET name=?, email=?, phone=?, blood_group=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $email, $phone, $blood_group, $donor_id);

    if ($stmt->execute()) {
        $msg = "Profile updated successfully.";
    } else {
        $msg = "Error updating profile: " . $stmt->error;
    }
}

// Fetch updated profile info
$stmt = $conn->prepare("SELECT name, email, phone, blood_group FROM donors WHERE id=?");
$stmt->bind_param("i", $donor_id);
$stmt->execute();
$result = $stmt->get_result();
$donor = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Donor Profile</title>
    <style>
        body { font-family: Arial; padding: 30px; background: #fff; }
        h2 { color: crimson; }
        form { max-width: 400px; }
        input, select { width: 100%; padding: 10px; margin: 8px 0; }
        button { background: crimson; color: white; padding: 10px; border: none; cursor: pointer; }
        .msg { margin: 15px 0; color: green; }
    </style>
</head>
<body>

<h2>Donor Profile</h2>

<?php if (isset($msg)) echo "<p class='msg'>$msg</p>"; ?>

<form method="POST" action="">
    <label>Name</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($donor['name']); ?>" required>

    <label>Email</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($donor['email']); ?>" required>

    <label>Phone</label>
    <input type="text" name="phone" value="<?php echo htmlspecialchars($donor['phone']); ?>" required>

    <label>Blood Group</label>
    <select name="blood_group" required>
        <?php
        $blood_groups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        foreach ($blood_groups as $bg) {
            $selected = ($bg == $donor['blood_group']) ? "selected" : "";
            echo "<option value='$bg' $selected>$bg</option>";
        }
        ?>
    </select>

    <button type="submit">Update Profile</button>
</form>

</body>
</html>
