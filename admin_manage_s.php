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
    <title>ADMIN MANAGE STUDENTS - APATH</title>
    <link rel="stylesheet" href="apath.css">
</head>

<body>
    <div class="container">
        <h1>APATH</h1>
        
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        include "a_nav.php";
        ?>

        <h2>Manage Students</h2>
        
        <div class="table-container">
            <?php
            $sqs = "SELECT * FROM apath_student ORDER BY first_name ASC";
            $result = mysqli_query($dbc, $sqs);

            echo "<table>";
            echo "<tr> 
                <th>S_ID</th>
                <th>First Name</th> 
                <th>Last Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Level</th>
                <th>Flight Info</th>
                <th>Flight Airline</th>
                <th>Flight Date</th>
                <th>Flight Time</th>
                <th>Connecting Flight Info</th>
                <th>Connecting Flight Airline</th>
                <th>Connecting Flight Date</th>
                <th>Connecting Flight Time</th>
                <th>Big Luggage</th>
                <th>Small Luggage</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>";

            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td><a href='admin_edit_student.php?id=" . htmlspecialchars($row['s_id']) . "'>" . htmlspecialchars($row['s_id']) . "</a></td>";
                echo "<td>" . htmlspecialchars($row['first_name'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['last_name'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['phone'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['email'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['gender'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['level'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['flight_info'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['flight_airline'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['flight_date'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['flight_time'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['c_flight_info'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['c_flight_airline'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['c_flight_date'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['c_flight_time'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['big_luggage'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['small_luggage'] ?? '') . "</td>";
                echo "<td><a href='admin_edit_student.php?id=" . htmlspecialchars($row['s_id']) . "'>Edit</a></td>";
                echo "<td><a href='admin_delete_student.php?id=" . htmlspecialchars($row['s_id']) . "'>Delete</a></td>";
                echo "</tr>";
            }
            echo "</table>";
            ?>
        </div>
    </div>
</body>
</html>