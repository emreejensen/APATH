<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav>
    <ul>
        <li><a href="home.php" class="<?php echo ($current_page == 'home.php') ? 'active' : ''; ?>">Home</a></li>
        <li><a href="about.php" class="<?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">About</a></li>
        <li><a href="login.php" class="<?php echo ($current_page == 'login.php') ? 'active' : ''; ?>">Login</a></li>
        <li><a href="signup.php" class="<?php echo ($current_page == 'signup.php') ? 'active' : ''; ?>">Sign Up</a></li>
        <li><a href="forum.php" class="<?php echo ($current_page == 'forum.php') ? 'active' : ''; ?>">Forum</a></li>
        <li><a href="contact.php" class="<?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">Contact</a></li>
    </ul>
</nav>