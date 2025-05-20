<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN HOME - APATH</title>
    <link rel="stylesheet" href="apath.css">
</head>

<body>
    <div class="container">
        <h1>APATH</h1>
        
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        include "a_nav.php";
        ?>
        
        <?php
        // Commenting out database connection and query code
        /*
        if (!isset($_SESSION['user_id'])) {
            die("User ID is not set in the session.");
        }

        $id = $_SESSION['user_id']; // Use session variable for user ID
        echo "The ID of this user is " . $id . "<br>";


        include "connection.php";

        $sqs = "SELECT * FROM users WHERE id=$id";
        echo "SQL statement is: " . $sqs . "<br>"; // Debugging

        $result = mysqli_query($dbc, $sqs);

        if ($result && mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $dbid = $row["id"];
            $dblastname = htmlspecialchars($row["lastname"]);
            $dbfirstname = htmlspecialchars($row["firstname"]);
            $dbgender = htmlspecialchars($row["gender"]);
            $dbaffiliation = htmlspecialchars($row["affiliation"]);
            $dbemail = htmlspecialchars($row["email"]);
            $dbphone = htmlspecialchars($row["phone"]);
            $dbpw = htmlspecialchars($row["pw"]);
            $dbpw2 = htmlspecialchars($row["pw2"]);
        } else {
            die("Something is wrong! User not found.");
        }
        */

        // Placeholder values for form fields
        $dblastname = "Johnson";
        $dbfirstname = "Carol";
        $dbgender = "Female";
        $dbaffiliation = "Jason";
        $dbemail = "";
        $dbphone = "";
        ?>

        <h2>Display Admin Profile Form</h2>

        <form action="admin_edit.php" method="post">   
<div class="form-group">		
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" value="<?php echo $dblastname; ?>" required>
            <br><br>

            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" value="<?php echo $dbfirstname; ?>" required>
            <br><br>
            
            <label for="level">Gender:</label>
            <br>
            <input type="radio" name="level" value="Male" <?php if ($dbgender == "Male") echo "checked"; ?>> Male <br>
            <input type="radio" name="level" value="Female" <?php if ($dbgender == "Female") echo "checked"; ?>> Female <br>
            <input type="radio" name="level" value="Other" <?php if ($dbgender == "Other") echo "checked"; ?>> Other <br><br>

            <label for="affiliation">Affiliation/Recommended By:</label>
            <input type="text" id="affiliation" name="affiliation" value="<?php echo $dbaffiliation; ?>" required>
            <br><br>
     
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" value="<?php echo $dbemail; ?>" required>
            <br><br>

            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" value="<?php echo $dbphone; ?>" required>
            <br><br>

            <label for="password1">Password:</label>
            <input type="password" id="password1" name="password1" maxlength="30">
            <br><br>

            <label for="password2">Confirm Password:</label>
            <input type="password" id="password2" name="password2" maxlength="30">
            <br><br>

            <button type="submit">Submit</button>
        </div>
		</form>
    </div>
</body>
</html>