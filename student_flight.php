<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 2) {
    header("Location: login.php");
    exit();
}

include "connection.php";

function test_input($data) {
    if (is_null($data)) {
        return '';
    }
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function convert_date_format($date) {
    if (empty($date)) {
        return '1970-01-01'; // Default date value
    }
    $date_obj = DateTime::createFromFormat('m/d/Y', $date);
    return $date_obj ? $date_obj->format('Y-m-d') : '1970-01-01'; // Default date value
}

$user_id = $_SESSION['user_id'];

$info = $airline = $date = $time = $c_info = $c_airline = $c_date = $c_time = $big = $small = "";
$pickup = $flight = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $info = test_input($_POST["flight_info"]);
    $airline = test_input($_POST["flight_airline"]);
    $date = convert_date_format(test_input($_POST["flight_date"]));
    $time = test_input($_POST["flight_time"]);
    $c_info = test_input($_POST["c_flight_info"]);
    $c_airline = test_input($_POST["c_flight_airline"]);
    $c_date = convert_date_format(test_input($_POST["c_flight_date"]));
    $c_time = test_input($_POST["c_flight_time"]);
    $big = is_numeric($_POST["big_luggage"]) ? test_input($_POST["big_luggage"]) : '0';
    $small = is_numeric($_POST["small_luggage"]) ? test_input($_POST["small_luggage"]) : '0';
    $pickup = isset($_POST["pickup"]) ? test_input($_POST["pickup"]) : '';
    $flight = isset($_POST["flight"]) ? test_input($_POST["flight"]) : '';

    // Update query without checking for empty fields
    $sql = "UPDATE apath_student SET 
            flight_info='$info', 
            flight_airline='$airline', 
            flight_date='$date', 
            flight_time='$time', 
            c_flight_info='$c_info', 
            c_flight_airline='$c_airline', 
            c_flight_date='$c_date', 
            c_flight_time='$c_time', 
            big_luggage='$big', 
            small_luggage='$small',
            pickup='$pickup',
            flight='$flight'
            WHERE s_id='$user_id'";

    if (mysqli_query($dbc, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($dbc);
    }
}

mysqli_close($dbc);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APATH Flight Information - STUDENT</title>
    <link rel="stylesheet" href="apath.css">
</head>
<body>
    <div class="container">
        <h1>APATH</h1>
        
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        include "apath_nav.php";
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			<h2>Flight Information</h2>
			<div class="form-group">
            Do you need airport pickup?<span class="required">*</span>: <br>
            <input type="radio" name="pickup" value="Yes" <?php if(isset($pickup)&&$pickup=="Yes") echo "checked"; ?>> Yes
            <input type="radio" name="pickup" value="No" <?php if(isset($pickup)&&$pickup=="No") echo "checked"; ?>> No
            <br><br>

            Do you have the flight information?<span class="required">*</span>: <br>
            <input type="radio" name="flight" value="Yes" <?php if(isset($flight)&&$flight=="Yes") echo "checked"; ?>> Yes
            <input type="radio" name="flight" value="No" <?php if(isset($flight)&&$flight=="No") echo "checked"; ?>> No
            <br><br>

            Flight Information:
            <input type="text" name="flight_info" value="<?php echo htmlspecialchars($info); ?>"><br><br>

            Flight Airline:
            <input type="text" name="flight_airline" value="<?php echo htmlspecialchars($airline); ?>"><br><br>

            Flight Date (MM/DD/YYYY):
            <input type="text" name="flight_date" value="<?php echo htmlspecialchars($date); ?>"><br><br>

            Flight Time:
            <input type="text" name="flight_time" value="<?php echo htmlspecialchars($time); ?>"><br><br>

            Connecting Flight Information:
            <input type="text" name="c_flight_info" value="<?php echo htmlspecialchars($c_info); ?>"><br><br>

            Connecting Flight Airline:
            <input type="text" name="c_flight_airline" value="<?php echo htmlspecialchars($c_airline); ?>"><br><br>

            Connecting Flight Date (MM/DD/YYYY):
            <input type="text" name="c_flight_date" value="<?php echo htmlspecialchars($c_date); ?>"><br><br>

            Connecting Flight Time:
            <input type="text" name="c_flight_time" value="<?php echo htmlspecialchars($c_time); ?>"><br><br>

            How many pieces of big luggage your vehicle could handle (use a number from 0-9):
            <input type="number" name="big_luggage" value="<?php echo htmlspecialchars($big); ?>" min="0" max="9"><br><br>

            How many pieces of small luggage your vehicle could handle (use a number from 0-9):
            <input type="number" name="small_luggage" value="<?php echo htmlspecialchars($small); ?>" min="0" max="9"><br><br>

            <button type="submit">Submit</button>
			</div>
        </form>

        <p class="footer"><a href="#">Covid Information and Guidelines</a></p>
    </div>
</body>
</html>