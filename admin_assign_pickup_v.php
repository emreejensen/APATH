<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN HOME - APATH</title>
    <link rel="stylesheet" href="apath.css">
</head>

<body>
    <div class="container">
        <h1>APATH</h1>
        
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        include "a_nav.php"; // Admin navigation
        ?>
        
        <h2>Assign Pickup Volunteer</h2>
		
        
        <?php
        include "connection.php"; // Database connection

        // Query to get students with assigned volunteers
        $query = "
            SELECT s.first_name, s.last_name, s.gender, s.flight_date, s.flight_time, p.s_id, p.v_id, p.approved
            FROM apath_student s
            RIGHT JOIN apath_pickup p ON s.s_id = p.s_id
            ORDER BY s.flight_date, s.flight_time
        ";
        $result = mysqli_query($dbc, $query);
        ?>
<div class="table-container">
        <table>
            <tr>
                <th>To Confirm/Approve</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Arriving Date</th>
                <th>Arriving Time</th>
                <th>Volunteer ID</th>
                <th>Already Approved?</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><a href="approve_pickup.php?s_id=<?php echo $row['s_id']; ?>&v_id=<?php echo $row['v_id']; ?>">Approve</a></td>
                <td><?php echo $row['first_name']; ?></td>
                <td><?php echo $row['last_name']; ?></td>
                <td><?php echo $row['gender']; ?></td>
                <td><?php echo $row['flight_date']; ?></td>
                <td><?php echo $row['flight_time']; ?></td>
                <td><?php echo $row['v_id']; ?></td>
                <td><?php echo $row['approved'] ? 'Yes' : 'No'; ?></td>
            </tr>
            <?php } ?>
        </table>
		</div>

        <p class="footer"><a href="#">Covid Information and Guidelines</a></p>
    </div>
</body>
</html>