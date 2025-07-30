<!-- db.php placeholder -->
<?php
$servername = "localhost";
$username = "root";         // default for XAMPP
$password = "";             // default is empty for XAMPP
$dbname = "blood_donor_management_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
