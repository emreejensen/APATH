<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 1) {
    echo "User not authenticated or not a volunteer.";
    var_dump($_SESSION);
    exit(); // Prevent further code execution
}

include "connection.php";

// Fetch students without a confirmed pickup
$sql = "SELECT s.s_id, s.first_name, s.last_name, s.email, s.phone
        FROM apath_student s
        LEFT JOIN apath_pickup p ON s.s_id = p.s_id
        WHERE p.s_id IS NULL OR p.approved = 0";
$result = mysqli_query($dbc, $sql);

mysqli_close($dbc);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Pickup Needs - Volunteer</title>
    <link rel="stylesheet" href="apath.css">
</head>
<body>
    <div class="container">        
		<h1>APATH</h1>
		
		<?php
        $current_page = basename($_SERVER['PHP_SELF']);
        include "v_nav.php";
        ?>

        <h2>Check Pickup Needs</h2>

		
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><a href="confirm_pickup.php?s_id=<?php echo $row['s_id']; ?>">Confirm Pickup</a></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No students need pickup at the moment.</p>
        <?php endif; ?>
    </div>
</body>
</html>