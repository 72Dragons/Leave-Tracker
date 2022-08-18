<?php
$servername = "localhost";
$username = "db_bot";
$password = "dragon";
$db_name="leave_tracker4_dp";

// Create connection
$con = new mysqli($servername, $username, $password,$db_name);

// Check connection
if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}
?>
