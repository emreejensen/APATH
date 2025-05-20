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

$user_id = $_SESSION['user_id'];
$result = mysqli_query($dbc, "SELECT first_name, last_name FROM apath_users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($result);

$firstname = $user['first_name'];
$lastname = $user['last_name'];
$gender = $family = $type = $future = $faset = $school = $major = $email = $phone = $wechat = $covid = $password = $confirmpassword = $special = $comment = $admin = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gender = isset($_POST["gender"]) ? test_input($_POST["gender"]) : '';
    $family = isset($_POST["family"]) ? test_input($_POST["family"]) : '';
    $type = isset($_POST["type"]) ? test_input($_POST["type"]) : '';
    $future = test_input($_POST["future"]);
    $faset = test_input($_POST["faset"]);
    $school = test_input($_POST["school"]);
    $major = test_input($_POST["major"]);
    $email = test_input($_POST["email"]);
    $phone = test_input($_POST["phone"]);
    $wechat = test_input($_POST["wechat"]);
    $covid = isset($_POST["covid"]) ? test_input($_POST["covid"]) : '';
    $password = test_input($_POST["password"]); // Plain text password
    $confirmpassword = test_input($_POST["confirmpassword"]);
    $special = isset($_POST["special"]) ? test_input($_POST["special"]) : '';
    $comment = test_input($_POST["comment"]);
    $admin = test_input($_POST["admin"]);

    $sql = "INSERT INTO apath_student (s_id, gender, family, student_type, future, faset, school, major, email, phone, wechat, covid, password, special, comment, admin_comments)
    VALUES ('$user_id', '$gender', '$family', '$type', '$future', '$faset', '$school', '$major', '$email', '$phone', '$wechat', '$covid', '$password', '$special', '$comment', '$admin')
    ON DUPLICATE KEY UPDATE gender='$gender', family='$family', student_type='$type', future='$future', faset='$faset', school='$school', major='$major', email='$email', phone='$phone', wechat='$wechat', covid='$covid', password='$password', special='$special', comment='$comment', admin_comments='$admin'";

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
    <title>APATH Personal Profile - STUDENT</title>
    <link rel="stylesheet" href="apath.css">
</head>
<body>
    <div class="container">
        <h1>APATH</h1>
		
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        include "apath_nav.php";
        ?>
        
        <br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <h2>Personal Profile</h2>
			<div class="form-group">
			Last Name<span class="required">*</span>:
            <input type="text" name="lastname" value="<?php echo $lastname; ?>" readonly><br><br>

            First Name<span class="required">*</span>:
            <input type="text" name="firstname" value="<?php echo $firstname; ?>" readonly><br><br>
            
            Gender<span class="required">*</span>: <br>
            <input type="radio" name="gender" value="Male" <?php if(isset($gender)&&$gender=="Male") echo "checked"; ?>> Male
            <input type="radio" name="gender" value="Female" <?php if(isset($gender)&&$gender=="Female") echo "checked"; ?>> Female
            <input type="radio" name="gender" value="Other" <?php if(isset($gender)&&$gender=="Other") echo "checked"; ?>> Other
            <br><br>
            
            Bringing family/relatives or not?<span class="required">*</span>: <br>
            <input type="radio" name="family" value="Yes" <?php if(isset($family)&&$family=="Yes") echo "checked"; ?>> Yes
            <input type="radio" name="family" value="No" <?php if(isset($family)&&$family=="No") echo "checked"; ?>> No
            <br><br>
            
            <br>
            
            Are you a returning student or first-time student?<span class="required">*</span>: <br>
            <input type="radio" name="type" value="Returning" <?php if(isset($type)&&$type=="Returning") echo "checked"; ?>> Returning
            <input type="radio" name="type" value="First Time" <?php if(isset($type)&&$type=="First Time") echo "checked"; ?>> First Time
            <br><br>
            
            <br>
            
            I'm coming to the U.S. to be a<span class="required">*</span>: <br>
            <select name="future">
            <option>-- Select --</option>
            <option value="under" <?php if($future=="under") echo "selected";?>>Undergraduate Student</option>
            <option value="grad" <?php if($future=="grad") echo "selected";?>>Graduate Student</option>
            <option value="visit" <?php if($future=="visit") echo "selected";?>>Visiting Scholar</option>
            <option value="other" <?php if($future=="other") echo "selected";?>>Other</option>
            </select>
            </span>
            <br><br>
            
            <br>
            
            Are you attending FASET? If you will attend FASET on 08/16, 
            please choose FASET 6<span class="required">*</span>: <br>
            <select name="faset">
            <option>-- Select --</option>
            <option value="not" <?php if($faset=="not") echo "selected";?>>NOT</option>
            <option value="faset_6" <?php if($faset=="faset_6") echo "selected";?>>6</option>
            <option value="faset_7" <?php if($faset=="faset_7") echo "selected";?>>7</option>
            </select>
            </span>
            <br><br>
            
            School you graduated from<span class="required">*</span>:
            <input type="text" name="school" value="<?php echo $school; ?>"><br><br>
            
            Major<span class="required">*</span>:
            <input type="text" name="major" value="<?php echo $major; ?>"><br><br>
            
            Email<span class="required">*</span>:
            <input type="email" name="email" value="<?php echo $email; ?>"><br><br>
            
            Phone (in case of emergency)<span class="required">*</span>:
            <input type="phone" name="phone" value="<?php echo $phone; ?>"><br><br>
            
            WeChat ID:
            <input type="text" name="wechat" value="<?php echo $wechat; ?>"><br><br>
            
            Did you already get COVID Vaccine?<span class="required">*</span>: <br>
            <input type="radio" name="covid" value="Yes" <?php if(isset($covid)&&$covid=="Yes") echo "checked"; ?>> Yes
            <input type="radio" name="covid" value="No" <?php if(isset($covid)&&$covid=="No") echo "checked"; ?>> No
            <br><br>
            
            Password<span class="required">*</span>:
            <input type="password" name="password"><br><br>
            
            Confirm Password<span class="required">*</span>:
            <input type="password" name="confirmpassword"><br><br>
            
            <br>
            <br>
            
            Special Attention?<span class="required">*</span>: <br>
            <input type="radio" name="special" value="Yes" <?php if(isset($special)&&$special=="Yes") echo "checked"; ?>> Yes
            <input type="radio" name="special" value="No" <?php if(isset($special)&&$special=="No") echo "checked"; ?>> No
            <br><br>

            <br>
            
            Any Comments: 
            <textarea name="comment" rows="10" columns="50"><?php echo $comment; ?></textarea> <br><br>

            Admin Comments: 
            <textarea name="admin" rows="10" columns="50"><?php echo $admin; ?></textarea>
            <br><br>
            
            <br><br>
            <button type="submit">Submit</button>
			</div>
        </form>
        <p class="footer"><a href="#">Covid Information and Guidelines</a></p>
    </div>
</body>
</html>