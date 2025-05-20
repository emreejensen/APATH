<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 1) {
    header("Location: login.php");
    exit();
}

include "connection.php";

function test_input($data) {
    if (is_null($data)) return '';
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$user_id = $_SESSION['user_id'];
$result = mysqli_query($dbc, "SELECT first_name, last_name FROM apath_users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($result);

$first_name = $user['first_name'];
$last_name = $user['last_name'];
$phone = $email = "";

// Check for existing volunteer info
$volunteer_result = mysqli_query($dbc, "SELECT * FROM apath_volunteer WHERE v_id='$user_id'");
$volunteer_exists = mysqli_num_rows($volunteer_result) > 0;

if ($volunteer_exists) {
    $volunteer = mysqli_fetch_assoc($volunteer_result);
    $phone = $volunteer['phone'];
    $email = $volunteer['email'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = test_input($_POST["first_name"]);
    $last_name = test_input($_POST["last_name"]);
    $phone = test_input($_POST["phone"]);
    $email = test_input($_POST["email"]);

    // Update name in apath_users
    mysqli_query($dbc, "UPDATE apath_users SET first_name='$first_name', last_name='$last_name' WHERE id='$user_id'");
	mysqli_query($dbc, "UPDATE apath_volunteer SET first_name='$first_name', last_name='$last_name' WHERE v_id='$user_id'");

    // Update or insert into apath_volunteer
    if ($volunteer_exists) {
        $sql = "UPDATE apath_volunteer 
                SET phone='$phone', email='$email'
                WHERE v_id='$user_id'";
    } else {
        $sql = "INSERT INTO apath_volunteer (v_id, first_name, last_name, phone, email)
                VALUES ('$user_id', '$first_name', '$last_name', '$phone', '$email')";
    }

    if (mysqli_query($dbc, $sql)) {
        echo "Profile updated successfully.";
    } else {
        echo "Error: " . mysqli_error($dbc);
    }
}

mysqli_close($dbc);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOLUNTEER PROFILE - APATH</title>
    <link rel="stylesheet" href="apath.css">
</head>
<body>
    <div class="container">
        <h1>APATH</h1>

        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        include "v_nav.php";
        ?>

        <h2>Personal Profile</h2>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                First Name<span class="required">*</span>:
                <input type="text" name="first_name" value="<?php echo $first_name; ?>"><br><br>

                Last Name<span class="required">*</span>:
                <input type="text" name="last_name" value="<?php echo $last_name; ?>"><br><br>

                Phone:
                <input type="text" name="phone" value="<?php echo $phone; ?>"><br><br>

                Email:
                <input type="email" name="email" value="<?php echo $email; ?>"><br><br>

                <button type="submit">Update Profile</button>
            </div>
        </form>

        <p class="footer"><a href="#">Covid Information and Guidelines</a></p>
    </div>
</body>
</html>