<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'patient') {
    header("Location: ../login.php");
    exit();
}

include('../includes/header.php');
?>

<h2>🩸 Request Blood</h2>

<form action="request_blood_handler.php" method="POST" style="max-width: 500px;">
    <label for="blood_group">Select Blood Group:</label><br>
    <select name="blood_group" id="blood_group" required>
        <option value="">--Select--</option>
        <option value="A+">A+</option>
        <option value="A-">A−</option>
        <option value="B+">B+</option>
        <option value="B-">B−</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB−</option>
        <option value="O+">O+</option>
        <option value="O-">O−</option>
    </select><br><br>

    <label for="bags_needed">Number of Bags:</label><br>
    <input type="number" name="bags_needed" min="1" required><br><br>

    <label for="reason">Reason for Request:</label><br>
    <textarea name="reason" id="reason" rows="4" cols="40" required></textarea><br><br>

    <button type="submit">Submit Request</button>
</form>

<?php include('../includes/footer.php'); ?>
