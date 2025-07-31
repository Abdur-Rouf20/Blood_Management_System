


<?php
session_start();
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php"); // redirect if already logged in
    exit();
}
?>
<?php include('../includes/header.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <style>
        body { background-color: #f2f2f2; }
        .login-container {
            width: 400px;
            margin: 50px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .text-crimson { color: crimson; }
    </style>
</head>
<body>

<div class="login-container">
    <h2 class="text-center text-crimson">Admin Login</h2>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form action="login_handler.php" method="POST">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-crimson w-100">Login</button>
    </form>

    <div class="mt-3 text-center">
        <a href="admin_register.php">Create Account</a>
    </div>
</div>

<style>
    .btn-crimson {
        background-color: crimson;
        color: white;
    }
    .btn-crimson:hover {
        background-color: darkred;
    }
</style>

</body>
</html>

<?php include('../includes/footer.php'); ?>

