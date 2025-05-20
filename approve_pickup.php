<?php
session_start();
include "connection.php";

$s_id = $_GET['s_id'];
$v_id = $_GET['v_id'];

// Query to get student and volunteer information
$query = "
    SELECT s.first_name AS student_first_name, s.last_name AS student_last_name, s.flight_date, s.flight_time, 
           v.first_name AS volunteer_first_name, v.last_name AS volunteer_last_name
    FROM apath_student s
    JOIN apath_volunteer v ON v.v_id = $v_id
    WHERE s.s_id = $s_id
";
$result = mysqli_query($dbc, $query);
$row = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['confirm'])) {
        // Check if the student already has an approved pickup
        $check_query = "SELECT * FROM apath_pickup WHERE s_id = $s_id AND approved = 1";
        $check_result = mysqli_query($dbc, $check_query);
        if (mysqli_num_rows($check_result) == 0) {
            $update_query = "UPDATE apath_pickup SET approved = 1 WHERE s_id = $s_id AND v_id = $v_id";
            mysqli_query($dbc, $update_query);
            $message = "Pick up table has been updated.";
        } else {
            $message = "This student already has an approved pickup.";
        }
    } elseif (isset($_POST['cancel'])) {
        header("Location: admin_assign_pickup_v.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Pickup - APATH</title>
    <link rel="stylesheet" href="apath.css">
</head>
<body>
    <div class="container">
        <h1>APATH</h1>
        
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        include "a_nav.php"; // Admin navigation
        ?>

        <h2>Approve Pickup</h2>
        <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
        <?php else: ?>
            <p>Please confirm that you want to approve</p>
            <p>Volunteer: <?php echo $row['volunteer_first_name'] . ' ' . $row['volunteer_last_name']; ?></p>
            <p>to pick up</p>
            <p>Student: <?php echo $row['student_first_name'] . ' ' . $row['student_last_name']; ?></p>
            <p>on <?php echo $row['flight_date']; ?>, <?php echo $row['flight_time']; ?></p>
            <form method="post">
                <button type="submit" name="confirm" class="btn">Confirm</button>
                <button type="submit" name="cancel" class="btn">Cancel</button>
            </form>
        <?php endif; ?>

        <p class="footer"><a href="#">Covid Information and Guidelines</a></p>
    </div>
</body>
</html>