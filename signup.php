<?php
// Initialize error messages and default values
$emailErr = $passwordErr = $typeErr = "";
$email = "";
$password1 = ""; 
$type = "";
$phone = "";
$flag = 0; // No Red Flag - Ready to Insert
$sqs = ""; // Prevent "undefined variable" error

// Function to sanitize input
function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process input values
    $email = test_input($_POST["email"] ?? '');
    $password1 = test_input($_POST["password1"] ?? '');
    $type = $_POST["type"] ?? '';
    $phone = test_input($_POST["phone"] ?? '');

    // Validate Email
    if ($email == "") {
        $emailErr = "Email is required!";
        $flag = 1;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format!";
        $flag = 2;
    }

    // Validate password
    if ($password1 == "") {
        $passwordErr = "Password is required!";
        $flag = 3;
    }

    // Validate Type
    if ($type == "") {
        $typeErr = "Type is required (Volunteer/Traveler to GTECH/Admin)!";
        $flag = 4;
    }

    // Extract first name and last name from email
    if ($email != "") {
        $name_parts = explode('@', $email);
        $first_name = $name_parts[0];
        $last_name = $name_parts[0]; // Use the same part for both first and last name
    }

    // Get ready for insert into database
    if ($flag == 0) {
        include "connection.php";
        // Check if email already exists in the database
        $sqs = "SELECT * FROM apath_users WHERE email = '$email'";
        $qresult = mysqli_query($dbc, $sqs);
        $num1 = mysqli_num_rows($qresult);

        if ($num1 != 0) {
            echo "<h3>Email has been used! Please try a different email. </h3>";
        } else {
            // Insert the data into the apath_users table
            $sqs = "INSERT INTO apath_users(email, pw, type, first_name, last_name) 
                    VALUES ('$email', '$password1', '$type', '$first_name', '$last_name')";
            if (mysqli_query($dbc, $sqs)) {
                $user_id = mysqli_insert_id($dbc); // Get the last inserted ID

                // Insert into the relevant table based on account type
                if ($type == "1") {
                    // Volunteer
                    $sql_volunteer = "INSERT INTO apath_volunteer (v_id, email, first_name, last_name, phone) VALUES ('$user_id', '$email', '$first_name', '$last_name', '$phone')";
                    if (!mysqli_query($dbc, $sql_volunteer)) {
                        echo "<h3>Error inserting into apath_volunteer: " . mysqli_error($dbc) . "</h3>";
                    } else {
                        header("Location: volunteer_home.php");
                    }
                } elseif ($type == "2") {
                    // Student
                    $sql_student = "INSERT INTO apath_student (s_id, email, first_name, last_name, phone) VALUES ('$user_id', '$email', '$first_name', '$last_name', '$phone')";
                    if (!mysqli_query($dbc, $sql_student)) {
                        echo "<h3>Error inserting into apath_student: " . mysqli_error($dbc) . "</h3>";
                    } else {
                        header("Location: student_home.php");
                    }
                } elseif ($type == "0") {
                    // Admin
                    $sql_admin = "INSERT INTO apath_admin (admin_id, firstname, lastname, email, phone, password, affiliation) VALUES ('$user_id', '$first_name', '$last_name', '$email', '$phone', '$password1', 'N/A')";
                    if (!mysqli_query($dbc, $sql_admin)) {
                        echo "<h3>Error inserting into apath_admin: " . mysqli_error($dbc) . "</h3>";
                    } else {
                        header("Location: admin_profile.php");
                    }
                }

                exit(); // Prevent further script execution
            } else {
                echo "<h3>Error: " . mysqli_error($dbc) . "</h3>";
            }
        }
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APATH SIGN UP</title>
    <link rel="stylesheet" href="apath.css">
    <style>
    .error {color: #FF0000;}
    </style>
</head>

<body>
    <div class="container">
        <h1>APATH</h1>
        
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        include "nav.php";
        ?>
       
        <h2>Sign Up Form</h2>

        <p>
        We are going to communicate with you using email often. <br>
        Please create your new account with your most frequently used email.
        </p>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
			<label for="email">Email Address:</label>
            <span class="error">*** <?php echo $emailErr; ?></span>
            <input type="text" id="email" name="email" value="<?php echo $email; ?>"> 
			</div>

            <div class="form-group">
            <label for="password1">Password:</label>
            <span class="error">*** <?php echo $passwordErr; ?></span>
            <input type="password" id="password1" name="password1" maxlength="60">
			</div>

            <div class="form-group">
            <label for="type">Account Type (Select One): </label>
            <span class="error">*** <?php echo $typeErr; ?></span><br>
            <input type="radio" name="type" value="1" <?php if ($type == "1") echo "checked"; ?>> I am signing up as a volunteer <br>
            <input type="radio" name="type" value="2" <?php if ($type == "2") echo "checked"; ?>> I am an international student that needs help <br>
            <input type="radio" name="type" value="0" <?php if ($type == "0") echo "checked"; ?>> I am signing up as an admin <br>
            </div>

            <button type="submit">Submit</button>
        </form>
    
        <br><br>
        <p>Already Have An Account? <a href="login.php">Login</a></p>
        <br>
        <p class="footer"><a href="#">Covid Information and Guidelines</a></p>
    </div>
</body>
</html>