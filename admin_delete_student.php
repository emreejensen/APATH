<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 0) { // Assuming user_type 0 is for admin
    header("Location: login.php");
    exit();
}

include "connection.php";

if (isset($_GET['id'])) {
    $s_id = $_GET['id'];

    // First, delete rows from apath_pickup where s_id is referenced
    $delete_pickup_sql = "DELETE FROM apath_pickup WHERE s_id='$s_id'";
    mysqli_query($dbc, $delete_pickup_sql); // Execute deletion of dependent rows

    // Then, delete the student from apath_student
    $delete_student_sql = "DELETE FROM apath_student WHERE s_id='$s_id'";
    mysqli_query($dbc, $delete_student_sql); // Delete the student record

    // Now, delete the user from apath_users
    $delete_user_sql = "DELETE FROM apath_users WHERE id='$s_id'"; // Assuming the id in apath_users is the same as s_id
    if (mysqli_query($dbc, $delete_user_sql)) {
        ob_start(); // Start output buffering
        echo "Student and related records deleted successfully";
        header("Location: admin_manage_s.php"); // Redirect to manage students page
        ob_end_flush(); // Flush the output buffer and send the headers
        exit();
    } else {
        echo "Error: " . $delete_user_sql . "<br>" . mysqli_error($dbc);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student - APATH</title>
    <link rel="stylesheet" href="apath.css">
</head>
<body>
    <div class="container">
        <h1>APATH</h1>
        
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        include "a_nav.php";
        ?>

        <h2>Delete Student</h2>
        <p>Are you sure you want to delete the following student?</p>
        <p>First Name: <?php echo htmlspecialchars($student['first_name'] ?? ''); ?></p>
        <p>Last Name: <?php echo htmlspecialchars($student['last_name'] ?? ''); ?></p>
        <p>Phone: <?php echo htmlspecialchars($student['phone'] ?? ''); ?></p>
        <p>Email: <?php echo htmlspecialchars($student['email'] ?? ''); ?></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $s_id; ?>" method="POST">
            <button type="submit">Confirm Delete</button>
        </form>
        <a href="admin_manage_s.php">Cancel</a>
    </div>
</body>
</html>
