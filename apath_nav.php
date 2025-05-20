<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav>
    <ul>
        <li><a href="student_home.php" class="<?php echo ($current_page == 'student_home.php') ? 'active' : ''; ?>">Home</a></li>
        <li><a href="student_profile.php" class="<?php echo ($current_page == 'student_profile.php') ? 'active' : ''; ?>">Personal Profile</a></li>
        <li><a href="student_flight.php" class="<?php echo ($current_page == 'student_flight.php') ? 'active' : ''; ?>">Flight Information</a></li>
        <li><a href="student_housing.php" class="<?php echo ($current_page == 'student_housing.php') ? 'active' : ''; ?>">Temp Housing Need</a></li>
        <li><a href="student_pickup.php" class="<?php echo ($current_page == 'student_pickup.php') ? 'active' : ''; ?>">Pickup Information</a></li>
        <li><a href="student_house_info.php" class="<?php echo ($current_page == 'student_house_info.php') ? 'active' : ''; ?>">Temp Housing Information</a></li>
        <li><a href="logout.php" class="<?php echo ($current_page == 'logout.php') ? 'active' : ''; ?>">Logout</a></li>
    </ul>
</nav>