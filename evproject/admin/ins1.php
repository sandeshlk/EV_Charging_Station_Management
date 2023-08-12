<?php 
include_once "connection_proc.php";


// Get the form data
$c_id = $_POST['c_id'];
$phone = $_POST['phone'];
$c_name = $_POST['c_name'];
$c_email = $_POST['c_email'];

// Validate the form data
if (empty($c_id) || empty($phone) || empty($c_name) || empty($c_email)) {
  echo "empty fields detected";
    // One or more fields are empty
  // Redirect the user back to the form and display an error message
  header('Location: i1.php?error=emptyfields');
  exit;
}



if ($conn->connect_error) {
  // Database connection failed
  // Redirect the user back to the form and display an error message
  header('Location: i1.php?error=dbconnectionfailed');
  exit;
}

// Create the INSERT statement
$sql = "INSERT INTO company (c_id, c_contact, c_name, c_email) VALUES (?, ?, ?, ?)";

// Prepare the statement
$stmt = $conn->prepare($sql);

if (!$stmt) {
  // Statement preparation failed
  // Redirect the user back to the form and display an error message
  header('Location: i1.php?error=sqlfailed');
  exit;
}

// Bind the parameters
$stmt->bind_param('ssss', $c_id, $phone, $c_name, $c_email);

// Execute the statement
$result = $stmt->execute();

if (!$result) {
  // Statement execution failed
  // Redirect the user back to the form and display an error message
  header('Location: i1.php?error=sqlfailed');
  exit;
}

// Redirect the user to a thank you page
header('Location: i2.php');
exit;




?>