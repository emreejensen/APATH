<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav>
    <ul>
        <li><a href="admin_profile.php" class="<?php echo ($current_page == 'admin_profile.php') ? 'active' : ''; ?>">Personal Profile</a></li>
        <li><a href="admin_announcement.php" class="<?php echo ($current_page == 'admin_announcement.php') ? 'active' : ''; ?>">Create Announcement</a></li>
        <li><a href="admin_manage_s.php" class="<?php echo ($current_page == 'admin_manage_s.php') ? 'active' : ''; ?>">Manage Students</a></li>
        <li><a href="admin_manage_v.php" class="<?php echo ($current_page == 'admin_manage_v.php') ? 'active' : ''; ?>">Manage Volunteers</a></li>
        <li><a href="admin_temp_house_s.php" class="<?php echo ($current_page == 'admin_temp_house_s.php') ? 'active' : ''; ?>">Students Need Temp Housing</a></li>
        <li><a href="admin_assign_house_v.php" class="<?php echo ($current_page == 'admin_assign_house_v.php') ? 'active' : ''; ?>">Assign Housing Volunteer</a></li>
		<li><a href="admin_need_pickup_s.php" class="<?php echo ($current_page == 'admin_need_pickup_s.php') ? 'active' : ''; ?>">Students Need Pickup</a></li>
		<li><a href="admin_assign_pickup_v.php" class="<?php echo ($current_page == 'admin_assign_pickup_v.php') ? 'active' : ''; ?>">Assign Pickup Volunteer</a></li>
		<li><a href="logout.php" class="<?php echo ($current_page == 'logout.php') ? 'active' : ''; ?>">Logout</a></li>
    </ul>
</nav>