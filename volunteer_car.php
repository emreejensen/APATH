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

$firstname = $user['first_name'];
$lastname = $user['last_name'];

$car_manufacture = $car_model = $car_year = $car_seats = $car_big_luggage = "";

// Check if volunteer record exists
$volunteer_result = mysqli_query($dbc, "SELECT * FROM apath_volunteer WHERE v_id='$user_id'");
$volunteer_exists = mysqli_num_rows($volunteer_result) > 0;

if ($volunteer_exists) {
    $volunteer = mysqli_fetch_assoc($volunteer_result);
    $car_manufacture = $volunteer['car_manufacture'];
    $car_model = $volunteer['car_model'];
    $car_year = $volunteer['car_year'];
    $car_seats = $volunteer['car_seats'];
    $car_big_luggage = $volunteer['car_big_luggage'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_manufacture = test_input($_POST["car_manufacture"]);
    $car_model = test_input($_POST["car_model"]);
    $car_year = is_numeric($_POST["car_year"]) ? test_input($_POST["car_year"]) : '0';
    $car_seats = is_numeric($_POST["car_seats"]) ? test_input($_POST["car_seats"]) : '0';
    $car_big_luggage = is_numeric($_POST["car_big_luggage"]) ? test_input($_POST["car_big_luggage"]) : '0';

    if ($volunteer_exists) {
        $sql = "UPDATE apath_volunteer SET 
                car_manufacture='$car_manufacture', 
                car_model='$car_model', 
                car_year='$car_year', 
                car_seats='$car_seats', 
                car_big_luggage='$car_big_luggage'
                WHERE v_id='$user_id'";
    } else {
        $sql = "INSERT INTO apath_volunteer (v_id, first_name, last_name, car_manufacture, car_model, car_year, car_seats, car_big_luggage)
                VALUES ('$user_id', '$firstname', '$lastname', '$car_manufacture', '$car_model', '$car_year', '$car_seats', '$car_big_luggage')";
    }

    if (mysqli_query($dbc, $sql)) {
        echo "Car information updated successfully.";
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
    <title>VOLUNTEER CAR INFO - APATH</title>
    <link rel="stylesheet" href="apath.css">
</head>

<body>
    <div class="container">
        <h1>APATH</h1>

        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        include "v_nav.php";
        ?>

        <h2>Car Information</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <div class="form-group">
                What is the manufacture of your car:
                <input type="text" name="car_manufacture" value="<?php echo $car_manufacture; ?>"><br><br>

                What is the model of your car:
                <input type="text" name="car_model" value="<?php echo $car_model; ?>"><br><br>

                What is the year of your car:
                <input type="number" name="car_year" value="<?php echo $car_year; ?>"><br><br>

                How many seats your car has (use number from 0-9):
                <input type="number" name="car_seats" value="<?php echo $car_seats; ?>" min="0" max="9"><br><br>

                How many pieces of big luggage your vehicle could handle (use a number from 0-9):
                <input type="number" name="car_big_luggage" value="<?php echo $car_big_luggage; ?>" min="0" max="9"><br><br>

                <button type="submit">Update Car Info</button>
            </div>
        </form>

        <p class="footer"><a href="#">Covid Information and Guidelines</a></p>
    </div>
</body>
</html>
