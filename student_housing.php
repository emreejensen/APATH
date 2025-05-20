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
$housing = $nights = $address = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $housing = isset($_POST["housing"]) ? test_input($_POST["housing"]) : '';
    $nights = is_numeric($_POST["nights"]) ? test_input($_POST["nights"]) : '0';
    $address = test_input($_POST["address"]);

    $sql = "UPDATE apath_student SET 
            housing_needed='$housing', 
            housing_nights='$nights', 
            housing_address='$address'
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
    <title>APATH Temp Housing Need - STUDENT</title>
    <link rel="stylesheet" href="apath.css">
</head>
<body>
    <div class="container">
        <h1>APATH</h1>
		
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        include "apath_nav.php";
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <h2>Temporary Housing Need</h2>
			<div class="form-group">
            Do you need temporary housing?<span class="required">*</span>: <br>
            <input type="radio" name="housing" value="Yes" <?php if(isset($housing)&&$housing=="Yes") echo "checked"; ?>> Yes
            <input type="radio" name="housing" value="No" <?php if(isset($housing)&&$housing=="No") echo "checked"; ?>> No
            <br><br>

            If yes, how many nights?<span class="required">*</span>: <br>
            <select name="nights">
            <option>-- Select --</option>
            <option value="1" <?php if($nights=="1") echo "selected";?>>1</option>
            <option value="2" <?php if($nights=="2") echo "selected";?>>2</option>
            <option value="3" <?php if($nights=="3") echo "selected";?>>3</option>
            <option value="4" <?php if($nights=="4") echo "selected";?>>4</option>
            <option value="5" <?php if($nights=="5") echo "selected";?>>5</option>
            <option value="6" <?php if($nights=="6") echo "selected";?>>6</option>
            <option value="7" <?php if($nights=="7") echo "selected";?>>7</option>
            <option value="8" <?php if($nights=="8") echo "selected";?>>8</option>
            <option value="9" <?php if($nights=="9") echo "selected";?>>9</option>
            <option value="10" <?php if($nights=="10") echo "selected";?>>10 or more</option>
            </select>
            <br><br>

            Where should we send you to after this period? <br>
            Please enter exact address here:<span class="required">*</span>:
            <input type="text" name="address" value="<?php echo $address; ?>"><br><br>

            <button type="submit">Submit</button>
			</div>
        </form>
		<p class="footer"><a href="#">Covid Information and Guidelines</a></p>
    </div>
</body>
</html>