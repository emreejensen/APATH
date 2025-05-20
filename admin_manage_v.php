<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 0) { // Assuming user_type 0 is for admin
    header("Location: login.php");
    exit();
}

include "connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN MANAGE VOLUNTEERS - APATH</title>
    <link rel="stylesheet" href="apath.css">
    <style>
    </style>
</head>

<body>
    <div class="container">
        <h1>APATH</h1>
        
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        include "a_nav.php";
        ?>

        <h2>Manage Volunteers</h2>
        
        <div class="table-container">
            <?php
            $sqs = "SELECT * FROM apath_volunteer ORDER BY first_name ASC";
            $result = mysqli_query($dbc, $sqs);

            echo "<table>";
            echo "<tr> 
                <th>V_ID</th>
                <th>First Name</th> 
                <th>Last Name</th>
                <th>Phone</th>
                <th>Car Manufacture</th>
                <th>Car Model</th>
                <th>Car Year</th>
                <th>Car Seats</th>
                <th>Big Luggage</th>
                <th>Email</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>";

            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td><a href='admin_edit_volunteer.php?id=" . htmlspecialchars($row['v_id']) . "'>" . htmlspecialchars($row['v_id']) . "</a></td>";
                echo "<td>" . htmlspecialchars($row['first_name'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['last_name'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['phone'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['car_manufacture'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['car_model'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['car_year'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['car_seats'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['car_big_luggage'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['email'] ?? '') . "</td>";
                echo "<td><a href='edit_volunteer.php?id=" . htmlspecialchars($row['v_id']) . "'>Edit</a></td>";
                echo "<td><a href='delete_volunteer.php?id=" . htmlspecialchars($row['v_id']) . "'>Delete</a></td>";
                echo "</tr>";
            }
            echo "</table>";
            ?>
        </div>
    </div>
</body>
</html>