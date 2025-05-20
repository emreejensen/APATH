<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 0) { // Assuming user_type 0 is for admin
    header("Location: login.php");
    exit();
}

include "connection.php";

if (isset($_GET['id'])) {
    $s_id = $_GET['id'];
    $query = "SELECT * FROM apath_student WHERE s_id='$s_id'";
    $result = mysqli_query($dbc, $query);
    $student = mysqli_fetch_assoc($result);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = test_input($_POST["first_name"]);
        $last_name = test_input($_POST["last_name"]);
        $phone = test_input($_POST["phone"]);
        $email = test_input($_POST["email"]);
        $gender = test_input($_POST["gender"]);
        $flight_info = test_input($_POST["flight_info"]);
        $flight_airline = test_input($_POST["flight_airline"]);
        
        // Check for empty flight_date and set it to NULL if empty
        $flight_date = !empty($_POST["flight_date"]) ? test_input($_POST["flight_date"]) : NULL;
        
        $flight_time = test_input($_POST["flight_time"]);
        $c_flight_info = test_input($_POST["c_flight_info"]);
        $c_flight_airline = test_input($_POST["c_flight_airline"]);
        
        // Check for empty c_flight_date and set it to NULL if empty
        $c_flight_date = !empty($_POST["c_flight_date"]) ? test_input($_POST["c_flight_date"]) : NULL;
        
        $c_flight_time = test_input($_POST["c_flight_time"]);
        
        // Check for empty luggage values and set them to NULL if empty
        $big_luggage = !empty($_POST["big_luggage"]) ? test_input($_POST["big_luggage"]) : NULL;
        $small_luggage = !empty($_POST["small_luggage"]) ? test_input($_POST["small_luggage"]) : NULL;

        $sql = "UPDATE apath_student SET 
                first_name='$first_name', 
                last_name='$last_name', 
                phone='$phone', 
                email='$email', 
                gender='$gender', 
                flight_info='$flight_info', 
                flight_airline='$flight_airline', 
                flight_date=" . ($flight_date ? "'$flight_date'" : "NULL") . ", 
                flight_time='$flight_time', 
                c_flight_info='$c_flight_info', 
                c_flight_airline='$c_flight_airline', 
                c_flight_date=" . ($c_flight_date ? "'$c_flight_date'" : "NULL") . ", 
                c_flight_time='$c_flight_time',
                big_luggage=" . ($big_luggage !== NULL ? "'$big_luggage'" : "NULL") . ", 
                small_luggage=" . ($small_luggage !== NULL ? "'$small_luggage'" : "NULL") . "
                WHERE s_id='$s_id'";

        if (mysqli_query($dbc, $sql)) {
            ob_start(); // Start output buffering
            echo "Student information updated successfully";
            header("Location: admin_manage_s.php");
            ob_end_flush(); // Flush the output buffer and send the headers
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($dbc);
        }
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - APATH</title>
    <link rel="stylesheet" href="apath.css">
</head>
<body>
    <div class="container">
        <h1>APATH</h1>
        
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        include "a_nav.php";
        ?>

        <h2>Edit Student Information</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $s_id; ?>" method="POST">
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($student['first_name'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($student['last_name'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($student['phone'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <input type="text" id="gender" name="gender" value="<?php echo htmlspecialchars($student['gender'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="flight_info">Flight Info:</label>
                <input type="text" id="flight_info" name="flight_info" value="<?php echo htmlspecialchars($student['flight_info'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="flight_airline">Flight Airline:</label>
                <input type="text" id="flight_airline" name="flight_airline" value="<?php echo htmlspecialchars($student['flight_airline'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="flight_date">Flight Date:</label>
                <input type="date" id="flight_date" name="flight_date" value="<?php echo htmlspecialchars($student['flight_date'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="flight_time">Flight Time:</label>
                <input type="time" id="flight_time" name="flight_time" value="<?php echo htmlspecialchars($student['flight_time'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="c_flight_info">Connecting Flight Info:</label>
                <input type="text" id="c_flight_info" name="c_flight_info" value="<?php echo htmlspecialchars($student['c_flight_info'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="c_flight_airline">Connecting Flight Airline:</label>
                <input type="text" id="c_flight_airline" name="c_flight_airline" value="<?php echo htmlspecialchars($student['c_flight_airline'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="c_flight_date">Connecting Flight Date:</label>
                <input type="date" id="c_flight_date" name="c_flight_date" value="<?php echo htmlspecialchars($student['c_flight_date'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="c_flight_time">Connecting Flight Time:</label>
                <input type="time" id="c_flight_time" name="c_flight_time" value="<?php echo htmlspecialchars($student['c_flight_time'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="big_luggage">Big Luggage:</label>
                <input type="number" id="big_luggage" name="big_luggage" value="<?php echo htmlspecialchars($student['big_luggage'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="small_luggage">Small Luggage:</label>
                <input type="number" id="small_luggage" name="small_luggage" value="<?php echo htmlspecialchars($student['small_luggage'] ?? ''); ?>">
            </div>
            <button type="submit">Update</button>
        </form>
        
        <div class="footer">
            <p><a href="#">Covid Information and Guidelines</a></p>
        </div>
    </div>
</body>
</html>