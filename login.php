<?php
session_start();

function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST["email"]);
    $pw = test_input($_POST["pw"]);

    include "connection.php";
    // Query based on email
    $sqs = "SELECT * FROM apath_users WHERE email='$email'";
    $result = mysqli_query($dbc, $sqs);
    $num_rows = mysqli_num_rows($result);
    if ($num_rows == 1) {
        $row = mysqli_fetch_array($result);
        $dbpw = $row["pw"];
        $dbid = $row["id"];
        $type = $row["type"];
        if ($pw == $dbpw) {
            $_SESSION['user_id'] = $dbid;
            $_SESSION['user_type'] = $type;

            if (isset($_POST['remember_me'])) {
                setcookie('user_id', $dbid, time() + (30 * 24 * 60 * 60), "/");
                setcookie('user_type', $type, time() + (30 * 24 * 60 * 60), "/");
            }

            if ($type == 0) {
                header("Location: admin_profile.php");
            } else if ($type == 1) {
                header("Location: volunteer_home.php");
            } else if ($type == 2) {
                header("Location: student_home.php");
            }
            exit();
        } else {
            echo "Sorry, your password is not correct!";
        }
    } else if ($num_rows == 0) {
        echo "Email is not in our system. Please register first!";
    } else {
        echo "Something happened...Please try again later!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APATH LOGIN</title>
    <link rel="stylesheet" href="apath.css">
</head>

<body>
    <div class="container">
        <h1>APATH</h1>
        
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        include "nav.php";
        ?>
        
        <h2>Login Form</h2>
		<br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" maxlength="50">
            </div>
            <div class="form-group">
                <label for="pw">Password:</label>
                <input type="password" id="pw" name="pw" maxlength="60">
            </div>
			<br>
            <div class="button-container">
            <button type="submit">Login</button>
            </div>
        </form>
		
		<br><br>
		<p>No Account? <a href="signup.php">Create One</a></p>
		<p class="footer"><a href="#">Covid Information and Guidelines</a></p>
		
    </div>
</body>
</html>