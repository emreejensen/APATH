<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 0) { // Assuming user_type 0 is for admin
    header("Location: login.php");
    exit();
}

include "connection.php";

if (isset($_GET['id'])) {
    $v_id = $_GET['id'];

    // Step 1: Delete from apath_pickup where v_id matches
    $delete_pickup_query = "DELETE FROM apath_pickup WHERE v_id='$v_id'";
    mysqli_query($dbc, $delete_pickup_query);  // Delete related pickup records first

    // Step 2: Delete from apath_volunteer where v_id matches
    $delete_volunteer_query = "DELETE FROM apath_volunteer WHERE v_id='$v_id'";
    if (mysqli_query($dbc, $delete_volunteer_query)) {
        // Step 3: Delete from apath_users where id matches v_id
        $delete_user_query = "DELETE FROM apath_users WHERE id='$v_id'"; // Use v_id as id in apath_users
        if (mysqli_query($dbc, $delete_user_query)) {
            ob_start(); // Start output buffering
            echo "Volunteer deleted successfully";
            header("Location: admin_manage_v.php");
            ob_end_flush(); // Flush the output buffer and send the headers
            exit();
        } else {
            echo "Error deleting user: " . mysqli_error($dbc);
        }
    } else {
        echo "Error deleting volunteer: " . mysqli_error($dbc);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Volunteer - APATH</title>
    <link rel="stylesheet" href="apath.css">
</head>
<body>
    <div class="container">
        <h1>APATH</h1>

        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        include "a_nav.php";
        ?>

        <h2>Delete Volunteer</h2>
        <p>Are you sure you want to delete the following volunteer?</p>
        <p>First Name: <?php echo htmlspecialchars($volunteer['first_name'] ?? ''); ?></p>
        <p>Last Name: <?php echo htmlspecialchars($volunteer['last_name'] ?? ''); ?></p>
        <p>Phone: <?php echo htmlspecialchars($volunteer['phone'] ?? ''); ?></p>
        <p>Email: <?php echo htmlspecialchars($volunteer['email'] ?? ''); ?></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $v_id; ?>" method="POST">
            <button type="submit">Confirm Delete</button>
        </form>
        <a href="admin_manage_v.php">Cancel</a>
    </div>
</body>
</html>
