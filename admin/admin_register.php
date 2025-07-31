<!DOCTYPE html>
<html>
<head>
    <title>Admin Registration</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <style>
        body { background-color: #f2f2f2; }
        .register-container {
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

<div class="register-container">
    <h2 class="text-center text-crimson">Admin Registration</h2>
    <form action="admin_register_handler.php" method="POST">
        <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="full_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required minlength="6">
        </div>
        <button type="submit" class="btn btn-crimson w-100">Register</button>
    </form>
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
