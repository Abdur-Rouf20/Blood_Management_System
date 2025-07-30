<?php
include('../config/db.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="container mt-5">
    <h2 class="text-center">Blood Inventory Report</h2>
    <div class="text-end mb-3">
        <button onclick="window.print()" class="btn btn-primary">🖨️ Print Report</button>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Blood Group</th>
                <th>Total Bags (Units)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT blood_group, units_available FROM blood_storage";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['blood_group']}</td>
                        <td>{$row['units_available']}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<style>
    @media print {
        button {
            display: none;
        }
        .navbar, .sidebar {
            display: none;
        }
        body {
            margin: 2cm;
        }
    }
</style>

<?php include('includes/footer.php'); ?>
