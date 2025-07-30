<!-- patient/register.php -->
<?php include('../includes/header.php'); ?>

<h2>Patient Registration</h2>
<form action="register_handler.php" method="POST">
    <input type="text" name="name" placeholder="Full Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="text" name="phone" placeholder="Phone Number" required><br>
    <input type="text" name="address" placeholder="Address" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Register</button>
</form>
<p>Already registered? <a href="login.php">Login here</a></p>

<?php include('../includes/footer.php'); ?>
