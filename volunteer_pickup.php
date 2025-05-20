<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 1) {
    header("Location: login.php");
    exit();
}

include "connection.php";

$user_id = $_SESSION['user_id'];

// Fetch student information if pickup is approved
$sql = "SELECT s.first_name, s.last_name, s.email, s.phone, s.gender, s.major, 
               s.flight_info, s.flight_airline, s.flight_date, s.flight_time,
               s.c_flight_info, s.c_flight_airline, s.c_flight_date, s.c_flight_time,
               s.big_luggage, s.small_luggage
        FROM apath_pickup p
        JOIN apath_student s ON p.s_id = s.s_id
        WHERE p.v_id = ? AND p.approved = 1";
$stmt = mysqli_prepare($dbc, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$student_info = mysqli_fetch_assoc($result);

mysqli_close($dbc);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pickup Assignment - Volunteer</title>
    <link rel="stylesheet" href="apath.css">
</head>
<body>
    <div class="container">
	
		<h1>APATH</h1>
		
		<?php
        $current_page = basename($_SERVER['PHP_SELF']);
        include "v_nav.php";
        ?>

        <h2>Pickup Assignment</h2>
		
        <?php if ($student_info): ?>
            <h3>Student Information</h3>
            <p>Name: <?php echo htmlspecialchars($student_info['first_name'] . ' ' . $student_info['last_name']); ?></p>
            <p>Email: <?php echo htmlspecialchars($student_info['email']); ?></p>
            <p>Phone: <?php echo htmlspecialchars($student_info['phone']); ?></p>
            <p>Gender: <?php echo htmlspecialchars($student_info['gender']); ?></p>
            <p>Major: <?php echo htmlspecialchars($student_info['major']); ?></p>
            <h3>Flight Information</h3>
            <p>Flight Info: <?php echo htmlspecialchars($student_info['flight_info']); ?></p>
            <p>Flight Airline: <?php echo htmlspecialchars($student_info['flight_airline']); ?></p>
            <p>Flight Date: <?php echo htmlspecialchars($student_info['flight_date']); ?></p>
            <p>Flight Time: <?php echo htmlspecialchars($student_info['flight_time']); ?></p>
            <h3>Connecting Flight Information</h3>
            <p>Connecting Flight Info: <?php echo htmlspecialchars($student_info['c_flight_info']); ?></p>
            <p>Connecting Flight Airline: <?php echo htmlspecialchars($student_info['c_flight_airline']); ?></p>
            <p>Connecting Flight Date: <?php echo htmlspecialchars($student_info['c_flight_date']); ?></p>
            <p>Connecting Flight Time: <?php echo htmlspecialchars($student_info['c_flight_time']); ?></p>
            <h3>Luggage Information</h3>
            <p>Big Luggage: <?php echo htmlspecialchars($student_info['big_luggage']); ?></p>
            <p>Small Luggage: <?php echo htmlspecialchars($student_info['small_luggage']); ?></p>
        <?php else: ?>
            <p>No approved pickup information found.</p>
        <?php endif; ?>
		
<p class="footer"><a href="#">Covid Information and Guidelines</a></p>
</div>
</body>
</html>