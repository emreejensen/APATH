<?php
session_start();
echo "<h1>Admin Edits Confirmation Page</h1>";

include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<pre>";
    print_r($_POST); // Debugging: Show received data
    echo "</pre>";

    // Validate ID
    if (!isset($_POST["id"]) || empty($_POST["id"]) || !is_numeric($_POST["id"])) {
        die("<p class='error'>Error: Invalid user ID.</p>");
    }

    $id = intval($_POST["id"]); // Ensure it's an integer
	$lastname = mysqli_real_escape_string($dbc, trim($_POST["lastname"]));
    $firstname = mysqli_real_escape_string($dbc, trim($_POST["firstname"]));
	$gender = mysqli_real_escape_string($dbc, trim($_POST["gender"]));
	$affiliation = mysqli_real_escape_string($dbc, trim($_POST["affiliation"]));
    $email = mysqli_real_escape_string($dbc, trim($_POST["email"]));
    $phone = mysqli_real_escape_string($dbc, trim($_POST["phone"]));
    $username = mysqli_real_escape_string($dbc, trim($_POST["username"]));
	$pw = mysqli_real_escape_string($dbc, trim($_POST["pw"]));
	$pw2 = mysqli_real_escape_string($dbc, trim($_POST["pw2"]));

    // Check if password is updated
    if (!empty($_POST["password1"]) && $_POST["password1"] === $_POST["password2"]) {
        $pw = password_hash($_POST["password1"], PASSWORD_BCRYPT);
        $sqs = "UPDATE users SET lastname='$lastname', firstname='$firstname', 
				gender='$gender', affiliation='$affiliation', email='$email', 
                phone='$phone', username='$username', pw='$pw' WHERE id=$id";
    } else {
        $sqs = "UPDATE users SET lastname='$lastname', firstname='$firstname', 
				gender='$gender', affiliation='$affiliation', email='$email', 
                phone='$phone', username='$username', pw='$pw' WHERE id=$id";
    }

    echo "<p>SQL Query: $sqs</p>"; // Debugging output

    mysqli_query($dbc, $sqs);

    if (mysqli_affected_rows($dbc) >= 0) {
        echo "<p>You have successfully updated this user!</p>";
        echo "<p>Please <a href='user_home.php'>click here</a> to go back.</p>";
    } else {
        echo "<p class='error'>Something is wrong with the update!</p>";
    }
}
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<title>Admin Edits Confirmation Page</title>
</head>
</html>