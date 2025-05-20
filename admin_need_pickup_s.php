<?php
ob_start();
session_start();
include "connection.php";

// Handle the form submission for assigning a volunteer
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['assign_volunteer'])) {
    if (isset($_POST['s_id']) && isset($_POST['v_id'])) {
        $s_id = $_POST['s_id'];
        $v_id = $_POST['v_id'];
        $approved = 0; // Default approval status (not approved)

        // Check if the volunteer is already assigned to the student
        $check_sql = "SELECT * FROM apath_pickup WHERE s_id = ? AND v_id = ?";
        if ($stmt = mysqli_prepare($dbc, $check_sql)) {
            mysqli_stmt_bind_param($stmt, 'ii', $s_id, $v_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            // If not assigned already, insert into the database
            if (mysqli_stmt_num_rows($stmt) == 0) {
                $insert_sql = "INSERT INTO apath_pickup (s_id, v_id, approved) VALUES (?, ?, ?)";
                if ($insert_stmt = mysqli_prepare($dbc, $insert_sql)) {
                    mysqli_stmt_bind_param($insert_stmt, 'iii', $s_id, $v_id, $approved);
                    if (mysqli_stmt_execute($insert_stmt)) {
                        echo "<p>Volunteer assigned successfully!</p>";
                    } else {
                        echo "<p>Error: " . mysqli_error($dbc) . "</p>";
                    }
                }
            } else {
                echo "<p>This volunteer is already assigned to this student.</p>";
            }
        }
    } else {
        echo "<p>Invalid input. Please select both a student and a volunteer.</p>";
    }
}

// Fetch students who need pickup (not already assigned to a volunteer)
$students_query = "SELECT s_id, first_name, email, phone FROM apath_student WHERE s_id NOT IN (SELECT s_id FROM apath_pickup)";
$students_result = mysqli_query($dbc, $students_query);

// Fetch all volunteers
$volunteers_query = "SELECT v_id, first_name, email FROM apath_volunteer";
$volunteers_result = mysqli_query($dbc, $volunteers_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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

    <h2>Students Need Pickup</h2>

    <?php
    if (mysqli_num_rows($students_result) > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>First Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>";

        while ($student = mysqli_fetch_assoc($students_result)) {
            echo "<tr>
                    <td>" . htmlspecialchars($student['s_id']) . "</td>
                    <td>" . htmlspecialchars($student['first_name']) . "</td>
                    <td>" . htmlspecialchars($student['email']) . "</td>
                    <td>" . htmlspecialchars($student['phone']) . "</td>
                  </tr>";
        }

        echo "</tbody>
              </table>";
    } else {
        echo "<p>No students need pick-up.</p>";
    }
    ?>

    <h2>Assign Volunteer to Student</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="s_id">Select Student:</label>
            <select id="s_id" name="s_id" required>
                <?php
                // Reset the student result pointer for the dropdown
                mysqli_data_seek($students_result, 0);
                if (mysqli_num_rows($students_result) > 0) {
                    while ($student = mysqli_fetch_assoc($students_result)) {
                        echo "<option value='" . htmlspecialchars($student['s_id']) . "'>" . 
                             htmlspecialchars($student['first_name']) . " (" . htmlspecialchars($student['email']) . ")</option>";
                    }
                } else {
                    echo "<option value=''>No students available</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="v_id">Select Volunteer:</label>
            <select id="v_id" name="v_id" required>
                <?php
                // Fetch volunteers
                mysqli_data_seek($volunteers_result, 0);
                if (mysqli_num_rows($volunteers_result) > 0) {
                    while ($volunteer = mysqli_fetch_assoc($volunteers_result)) {
                        echo "<option value='" . htmlspecialchars($volunteer['v_id']) . "'>" . 
                             htmlspecialchars($volunteer['first_name']) . " (" . htmlspecialchars($volunteer['email']) . ")</option>";
                    }
                } else {
                    echo "<option value=''>No volunteers available</option>";
                }
                ?>
            </select>
        </div>

        <button type="submit" name="assign_volunteer">Assign Volunteer</button>
    </form>
</div>

<?php ob_end_flush(); ?>

</body>
</html>
