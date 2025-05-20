<?php
session_start();

// Check if cookies are set
if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_type'])) {
    // Set session variables from cookies
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['user_type'] = $_COOKIE['user_type'];

    // Redirect based on user type
    if ($_SESSION['user_type'] == 0) {
        header("Location: admin_profile.php"); // Redirect to admin home page
    } else if ($_SESSION['user_type'] == 1) {
        header("Location: volunteer_home.php"); // Redirect to volunteer home page
    } else {
        header("Location: student_home.php"); // Redirect to student home page
    }
    exit(); // Stop further execution of the script to avoid output
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APATH HOME</title>
    <link rel="stylesheet" href="apath.css">
    <style>
    .error {color: #FF0000;}
    </style>
</head>

<body>
    <div class="container">
        <h1>APATH</h1>
        
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        include "nav.php";
        ?>

		<h2>Welcome to APATH</h2>

        <p>Get Started Today:</p>
        <a href="login.php">Enter Login</a> or <a href="signup.php">Sign Up</a>
		
		<img src="welcome.jpg" alt="Travel Collage" style="width:100%; max-width:600px; display:block; margin:20px auto;">

    <p class="footer"><a href="#">Covid Information and Guidelines</a></p>
	</div>
</body>
</html>