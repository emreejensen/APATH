<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 2) {
    header("Location: login.php");
    exit();
}

include "connection.php";

$user_id = $_SESSION['user_id'];

// Fetch volunteer information if pickup is approved
$sql = "SELECT v.first_name, v.last_name, v.email, v.phone, v.car_manufacture, v.car_model, v.car_year
        FROM apath_pickup p
        JOIN apath_volunteer v ON p.v_id = v.v_id
        WHERE p.s_id = ? AND p.approved = 1";
$stmt = mysqli_prepare($dbc, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$volunteer_info = mysqli_fetch_assoc($result);

mysqli_close($dbc);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APATH Pickup Information - STUDENT</title>
	<link rel="stylesheet" href="apath.css">
</head>
<body>
<div class="container">
    <h1>APATH</h1>
	
	<?php
	$current_page = basename($_SERVER['PHP_SELF']);
	include "apath_nav.php";
	?>
	
	<br>
	
	<?php if ($volunteer_info): ?>
        <h2>Pickup Information</h2>
        <p>Name: <?php echo htmlspecialchars($volunteer_info['first_name'] . ' ' . $volunteer_info['last_name']); ?></p>
        <p>Email: <?php echo htmlspecialchars($volunteer_info['email']); ?></p>
        <p>Phone: <?php echo htmlspecialchars($volunteer_info['phone']); ?></p>
        <p>Car Manufacture: <?php echo htmlspecialchars($volunteer_info['car_manufacture']); ?></p>
        <p>Car Model: <?php echo htmlspecialchars($volunteer_info['car_model']); ?></p>
        <p>Car Year: <?php echo htmlspecialchars($volunteer_info['car_year']); ?></p>
    <?php else: ?>
		<h2>Pickup Information</h2>
        <p>
            We are working on finding a volunteer to pick you up from the airport; <br>
            Information will be available later.
        </p>
    <?php endif; ?>
	<p class="footer"><a href="#">Covid Information and Guidelines</a></p>
</div>
</body>
</html>