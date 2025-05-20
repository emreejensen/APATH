<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 1) {
    echo "User not authenticated or not a volunteer.";
    var_dump($_SESSION);
    exit(); // Prevent further code execution
}

include "connection.php";

$v_id = $_SESSION['user_id'];
$s_id = $_GET['s_id'];

// Fetch flight date and time for the student
$query = "
    SELECT s.flight_date, s.flight_time
    FROM apath_student s
    WHERE s.s_id = $s_id
";
$result = mysqli_query($dbc, $query);
$row = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['confirm'])) {
        // Confirm the pickup
        $insert_query = "INSERT INTO apath_pickup (v_id, s_id, approved) VALUES ($v_id, $s_id, 0)
                         ON DUPLICATE KEY UPDATE v_id = VALUES(v_id), approved = VALUES(approved)";
        mysqli_query($dbc, $insert_query);
        $message = "Thank you for volunteering. You will see the detail information about this pickup task under Pickup Assignment.";
    } elseif (isset($_POST['cancel'])) {
        header("Location: check_pickup_needs.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Pickup - APATH</title>
    <link rel="stylesheet" href="apath.css">
</head>
<body>
    <div class="container">
        <h1>APATH</h1>
		
		<?php
        $current_page = basename($_SERVER['PHP_SELF']);
        include "v_nav.php";
        ?>


        <h2>Confirm Pickup</h2>
        <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
        <?php else: ?>
            <p>Please confirm that you are available on <?php echo htmlspecialchars($row['flight_date']); ?>, at <?php echo htmlspecialchars($row['flight_time']); ?> to pick up a student.</p>
            <form method="post">
                <button type="submit" name="confirm" class="btn">Confirm</button>
                <button type="submit" name="cancel" class="btn">Cancel</button>
            </form>
        <?php endif; ?>

        <p class="footer"><a href="#">Covid Information and Guidelines</a></p>
    </div>
</body>
</html>