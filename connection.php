<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "4450spring25";
$dbc = mysqli_connect($hostname, $username, $password, $dbname) OR die("Cannot Connect to Database, ERROR...");
echo "Connected to the Database ".$dbname." SUCCCESSFULLY! <br>";
?>