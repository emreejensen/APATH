<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOLUNTEER HOME - APATH</title>
    <link rel="stylesheet" href="apath.css">
</head>

<body>
    <div class="container">
        <h1>APATH</h1>
        
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        include "v_nav.php";
        ?>
		
		<h1>Volunteer Home Page</h1>

<img src="atlanta_v.jpg" alt="City of Atlanta" class="atlanta-image" />

<style>
    .atlanta-image {
        width: 100%;  /* Makes the image responsive, scaling it to the width of its container */
        max-width: 500px;  /* Limits the maximum width of the image */
        height: auto;  /* Maintains the aspect ratio of the image */
    }
</style>

        <h2>
        Thank you for volunteering with APATH!
        </h2>
		
		<h3>
		<br><a href="check_pickup_needs.php" class="btn">Check Pickup Needs Here<br><br></a>
        If you would like to volunteer for airport pickup, please provide your <a href="volunteer_car.php">car information</a>. <br><br>
		If you would like to view your confirmed assignment, please view <a href="volunteer_pickup.php">pickup assignment</a>.<br><br><br>
        </h3

        <p class="footer"><a href="#">Covid Information and Guidelines</a></p>
    </div>
</body>
</html>