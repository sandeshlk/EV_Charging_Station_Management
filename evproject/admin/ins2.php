<?php 
include_once "connection_proc.php";


// Get the form data
$s_id = $_POST['s_id'];
$tc = $_POST['tc'];
$s_name = $_POST['s_name'];
$c_id = $_POST['c_id'];
$to = $_POST['to'];

// Validate the form data
if (empty($s_id) || empty($tc) || empty($s_name) || empty($c_id) || empty($to)){
  echo "empty fields detected";
    // One or more fields are empty
  // Redirect the user back to the form and display an error message
  header('Location: i2.php?error=emptyfields');
  exit;
}



if ($conn->connect_error) {
  // Database connection failed
  // Redirect the user back to the form and display an error message
  header('Location: i2.php?error=dbconnectionfailed');
  exit;
}

// Create the INSERT statement
$sql = "INSERT INTO station (s_id, timing_close, s_name, c_id ,timing_open) VALUES (?, ?, ?, ?, ?)";

// Prepare the statement
$stmt = $conn->prepare($sql);

if (!$stmt) {
  // Statement preparation failed
  // Redirect the user back to the form and display an error message
  header('Location: i2.php?error=sqlfailed');
  exit;
}

// Bind the parameters
$stmt->bind_param('ssss', $s_id, $timing_close, $s_name, $c_id, $timing_open);

// Execute the statement
$result = $stmt->execute();

if (!$result) {
  // Statement execution failed
  // Redirect the user back to the form and display an error message
  header('Location: i2.php?error=sqlfailed');
  exit;
}

// Redirect the user to a thank you page
header('Location: i3.php');
exit;




?>