<!-- index.php placeholder -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Blood Donor Management System</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #fff;
      color: #900; /* Crimson */
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    h1 {
      font-size: 36px;
      margin-bottom: 40px;
      color: #900;
    }

    .button-container {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .btn {
      padding: 15px 30px;
      font-size: 18px;
      border: none;
      border-radius: 5px;
      background-color: #900; /* Crimson */
      color: white;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .btn:hover {
      background-color: #b30000; /* Darker crimson on hover */
    }

    footer {
      position: absolute;
      bottom: 20px;
      font-size: 14px;
      color: #888;
    }
  </style>
</head>
<body>

  <h1>Welcome to Blood Donor Management System</h1>

  <div class="button-container">
    <form action="/blood_Donor_management_system/auth/donor_login.php" method="get">
      <button class="btn" type="submit">Login as Donor</button>
    </form>

    <form action="/blood_Donor_management_system/patient/login.php" method="get">
      <button class="btn" type="submit">Login as Patient</button>
    </form>

    <form action="/blood_Donor_management_system/admin/login.php" method="get">
      <button class="btn" type="submit">Login as Admin</button>
    </form>

  </div>
  <div>
  <p> Donate Blood Save Lives. </p>  
  </div>

  <footer>
    &copy; <?= date("Y") ?> Blood Management System. All rights reserved By Abdur Rouf.
  </footer>

</body>
</html>

