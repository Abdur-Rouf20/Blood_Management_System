<?php
session_start();
require_once 'db.php'; // adjust path if your db.php is elsewhere
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Donors</title>
    <style>
        body {
            font-family: Arial;
            background-color: #fff;
            margin: 30px;
        }
        h2 {
            color: crimson;
        }
        form {
            margin-top: 20px;
        }
        select, button {
            padding: 10px;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
        }
        th {
            background-color: crimson;
            color: white;
        }
    </style>
</head>
<body>

<h2>🔍 Search Donors by Blood Group</h2>

<form method="POST" action="">
    <label>Select Blood Group:</label>
    <select name="blood_group" required>
        <option value="">--Select--</option>
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
    </select>
    <button type="submit">Search</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $group = $_POST['blood_group'];

    $stmt = $conn->prepare("SELECT name, email, phone, blood_group FROM donors WHERE blood_group = ?");
    $stmt->bind_param("s", $group);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h3>🩸 Donors Available for: <u>$group</u></h3>";

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Name</th><th>Email</th><th>Phone</th><th>Blood Group</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['blood_group']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No donors found for <strong>$group</strong>.</p>";
    }
}
?>

</body>
</html>
