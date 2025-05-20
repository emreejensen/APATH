<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav>
    <ul>
        <li><a href="volunteer_home.php" class="<?php echo ($current_page == 'volunteer_home.php') ? 'active' : ''; ?>">Home</a></li>
        <li><a href="check_pickup_needs.php" class="<?php echo ($current_page == 'check_pickup_needs.php') ? 'active' : ''; ?>">Check Pickup Needs</a></li>
		<li><a href="volunteer_profile.php" class="<?php echo ($current_page == 'volunteer_profile.php') ? 'active' : ''; ?>">Personal Profile</a></li>
        <li><a href="volunteer_car.php" class="<?php echo ($current_page == 'volunteer_car.php') ? 'active' : ''; ?>">Car Information</a></li>
        <li><a href="volunteer_house.php" class="<?php echo ($current_page == 'volunteer_house.php') ? 'active' : ''; ?>">House Information</a></li>
        <li><a href="volunteer_pickup.php" class="<?php echo ($current_page == 'volunteer_pickup.php') ? 'active' : ''; ?>">Pickup Assignment</a></li>
        <li><a href="volunteer_temp_house.php" class="<?php echo ($current_page == 'volunteer_temp_house.php') ? 'active' : ''; ?>">Temporary House Assignment</a></li>
		<li><a href="logout.php" class="<?php echo ($current_page == 'logout.php') ? 'active' : ''; ?>">Logout</a></li>
    </ul>
</nav>