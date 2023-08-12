<?php

include_once "connection_proc.php";

$sql = "SELECT * from adminlogin;;";
$res = mysqli_query($conn, $sql);
$ress = mysqli_num_rows($res);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
</head>
<body>
    <h2>Welcome To Admin Page</h2>
    <div class="container">
        <a href="../admin/generatereport.php">Generate Report</a>
        <a href="../admin/reporthtml.php">Generate Report for entries</a>

        <a href="../admin/i1.php">Add Owner</a>

    </div>
</body>
</html>