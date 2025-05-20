<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APATH Home - STUDENT</title>
	<link rel="stylesheet" href="apath.css">
</head>

<body>
    <div class="container">
        <h1>APATH</h1>
		
		<?php
		$current_page = basename($_SERVER['PHP_SELF']);
		include "apath_nav.php";
		?>

<h1>Student Home Page</h1>

<img src="atlanta_s.jpg" alt="Welcome to Atlanta" class="atlanta-image" />

<style>
    .atlanta-image {
        width: 100%;  /* Makes the image responsive, scaling it to the width of its container */
        max-width: 500px;  /* Limits the maximum width of the image */
        height: auto;  /* Maintains the aspect ratio of the image */
    }
</style>

<h2>
Welcome to Atlanta, GA<br>
</h2>

<h3>
Please complete your <a href="student_profile.php">personal profile</a>. <br>
<p>If you need airport pickup, please provide your <a href="student_flight.php">flight information</a>.</p>
<p>If you need temporary housing, please complete the <a href="student_housing.php">temp housing needs form</a>.</p>

</h3>

<p class="footer"><a href="#">Covid Information and Guidelines</a></p>
</div>
</body>
</html>