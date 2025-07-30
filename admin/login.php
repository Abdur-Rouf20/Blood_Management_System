<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <?php include('../includes/header.php'); ?>
<head>
    <title>Admin Login</title>
    <style>
        body { font-family: Arial; padding: 30px; background: #fff; }
        h2 { color: crimson; }
        form { max-width: 350px; }
        input { width: 100%; padding: 10px; margin: 8px 0; }
        button { background: crimson; color: white; padding: 10px; border: none; cursor: pointer; }
        .error { color: red; margin: 10px 0; }
    </style>
</head>

<body>

<h2>Admin Login</h2>

<form method="POST" action="login_handler.php">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>

<?php
if (isset($_GET['error'])) {
    echo '<p class="error">'.htmlspecialchars($_GET['error']).'</p>';
}
?>

</body>
<?php include('../includes/footer.php'); ?>
</html>
