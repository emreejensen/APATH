<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 0) { // Assuming user_type 0 is for admin
    header("Location: login.php");
    exit();
}

include "connection.php";

if (isset($_GET['id'])) {
    $v_id = $_GET['id'];
    $query = "SELECT * FROM apath_volunteer WHERE v_id='$v_id'";
    $result = mysqli_query($dbc, $query);
    $volunteer = mysqli_fetch_assoc($result);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = test_input($_POST["first_name"]);
        $last_name = test_input($_POST["last_name"]);
        $phone = test_input($_POST["phone"]);
        $car_manufacture = test_input($_POST["car_manufacture"]);
        $car_model = test_input($_POST["car_model"]);
        $car_year = test_input($_POST["car_year"]);
        $car_seats = test_input($_POST["car_seats"]);
        $car_big_luggage = test_input($_POST["car_big_luggage"]);
        $email = test_input($_POST["email"]);

        // Set default values for integer fields if they are empty
        $car_year = empty($car_year) ? 0 : $car_year;
        $car_seats = empty($car_seats) ? 0 : $car_seats;
        $car_big_luggage = empty($car_big_luggage) ? 0 : $car_big_luggage;

        $sql = "UPDATE apath_volunteer SET 
                first_name='$first_name', 
                last_name='$last_name', 
                phone='$phone', 
                car_manufacture='$car_manufacture', 
                car_model='$car_model', 
                car_year='$car_year', 
                car_seats='$car_seats', 
                car_big_luggage='$car_big_luggage', 
                email='$email'
                WHERE v_id='$v_id'";

        if (mysqli_query($dbc, $sql)) {
            ob_start(); // Start output buffering
            echo "Volunteer information updated successfully";
            header("Location: admin_manage_v.php");
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
    <title>Edit Volunteer - APATH</title>
    <link rel="stylesheet" href="apath.css">
</head>
<body>
    <div class="container">
        <h1>APATH</h1>
        
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        include "a_nav.php";
        ?>

        <h2>Edit Volunteer Information</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $v_id; ?>" method="POST">
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($volunteer['first_name'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($volunteer['last_name'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($volunteer['phone'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="car_manufacture">Car Manufacture:</label>
                <input type="text" id="car_manufacture" name="car_manufacture" value="<?php echo htmlspecialchars($volunteer['car_manufacture'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="car_model">Car Model:</label>
                <input type="text" id="car_model" name="car_model" value="<?php echo htmlspecialchars($volunteer['car_model'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="car_year">Car Year:</label>
                <input type="number" id="car_year" name="car_year" value="<?php echo htmlspecialchars($volunteer['car_year'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="car_seats">Car Seats:</label>
                <input type="number" id="car_seats" name="car_seats" value="<?php echo htmlspecialchars($volunteer['car_seats'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="car_big_luggage">Big Luggage:</label>
                <input type="number" id="car_big_luggage" name="car_big_luggage" value="<?php echo htmlspecialchars($volunteer['car_big_luggage'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($volunteer['email'] ?? ''); ?>">
            </div>
            <button type="submit">Update</button>
        </form>
        
        <div class="footer">
            <p><a href="#">Covid Information and Guidelines</a></p>
        </div>
    </div>
</body>
</html>