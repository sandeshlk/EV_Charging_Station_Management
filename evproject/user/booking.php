
<?php

session_start();

// Connect to the database
$db = new mysqli('localhost', 'root', '', 'ev');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to make a reservation.";
    exit;
}


?>
<br>
<h4><?php  echo "Logged in as :" ;?>           <?php echo $_SESSION['user_id'];?></h4>
<a href="logout.php">
        Logout
    </a>
<br>
<form action="updatestatus.php" method="post">
    <input type="submit" name="update_status" value="Update Status">
</form>
<h4><?php  echo "Booked:" ;?></h4>
<br>

<?php

$user_id=$_SESSION['user_id'];
// Display the reservations for the user
$query = "SELECT r.r_id, r.s_id, r.start_time, r.end_time, r.status,s.s_name AS station_name, c.c_name,c.c_contact, c.c_email
FROM reservations r
INNER JOIN station s ON r.s_id = s.s_id
INNER JOIN company c ON s.c_id = c.c_id 
WHERE r.user_id='$user_id';
";
$result = mysqli_query($db, $query);
?>
<table>
<tr>
<th>RESERVATION ID</th>
<th>STATION ID</th>
<th>START</th>
<th>END</th>
<th>Station Name</th>
<th>Company Name</th>

<th>CONTACT</th>
<th>E-MAIL</th>
<th>STATUS</th>


</tr>
<?php while ($row = mysqli_fetch_assoc($result)): ?>
<tr>
<td><?php echo $row['r_id']; ?></td>
<td><?php echo $row['s_id']; ?></td>
<td><?php echo $row['start_time']; ?></td>
<td><?php echo $row['end_time']; ?></td>
<td><?php echo $row['station_name']; ?></td>
<td><?php echo $row['c_name']; ?></td>

<td>
<?php echo $row['c_contact']; ?>
</td>
<td><?php echo $row['c_email']; ?></td>
<td><?php echo $row['status']; ?></td>


</tr>
<?php endwhile; ?>
</table>

<?php
// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Get the form data
    $s_id = intval($_POST['s_id']);

    $start_time = mysqli_real_escape_string($db, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($db, $_POST['end_time']);
    $date = $_POST['dat'];

    // Check if the station is open at the specified time
    $query = "SELECT COUNT(*) FROM station WHERE s_id = $s_id AND timing_open <= '$start_time' AND timing_close >= '$end_time'";
    $result = mysqli_query($db, $query);
    $count = mysqli_fetch_row($result)[0];
    if ($count == 0) {
        // Station is closed at the specified time
        echo "Sorry, the station is closed at the specified time. Please choose a different time.";
    } else {
        // Check if the slot is available
        $query = "SELECT COUNT(*) FROM reservations WHERE s_id = $s_id AND start_time <= '$end_time' AND end_time >= '$start_time'";
        $result = mysqli_query($db, $query);
        $count = mysqli_fetch_row($result)[0];
        if ($count > 0) {
            // Slot is not available
            echo "Sorry, the slot is not available. Please choose a different time.";
        } else {
            // Slot is available, book it
            $user_id = intval($_SESSION['user_id']);
            $query = "INSERT INTO reservations (s_id, user_id, start_time, end_time, date) VALUES ($s_id, $user_id, '$start_time', '$end_time', '$date')";
            mysqli_query($db, $query);

            // Decrement the number of available slots
            $query = "UPDATE features SET available_slots = available_slots - 1 WHERE s_id = $s_id";
            mysqli_query($db, $query);

            // Check if there are any available slots
            $query = "SELECT no_of_slots FROM features WHERE s_id = $s_id";
            $result = mysqli_query($db, $query);
            $no_of_slots = mysqli_fetch_assoc($result)['no_of_slots'];
            if ($no_of_slots == 0) {
                // No available slots
                echo "Sorry, there are no available slots at this station. Please try again later";
                exit();
            }
            echo "Your reservation has been booked successfully!";
        }
    }
}

// Get the list of available stations
$query = "SELECT S.s_id, S.s_name , S.timing_open, S.timing_close ,F.available_slots FROM station S, features F where S.s_id=F.s_id and F.available_slots>0";
$result = mysqli_query($db, $query);

?>
<html>

<head>
    <style>
        *{
            margin: 10px;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }
      
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            background-color: #4caf50;
            color: white;
        }

        form {
            display: inline-block;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            border: none;
            color: white;
            padding: 8px 20px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #46a049;
        }
    </style>


</head>


<h2>Available Stations</h2>
<table>
    <tr>
        <th>Station ID</th>
        <th>Station Name</th>
        <th>Slots remianing</th>

        <th>Open</th>
        <th>Close</th>
       

        <th>Action</th>
    </tr>
  
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['s_id']; ?></td>
            <td><?php echo $row['s_name']; ?></td>
            <td><?php echo $row['available_slots']; ?></td>

            <td><?php echo $row['timing_open']; ?></td>
            <td><?php echo $row['timing_close']; ?></td>

            <td>
                <form method="post" action="booking.php">
                    <input type="hidden" name="s_id" value="<?php echo $row['s_id']; ?>">


                    <label for="start_time">Start Time:</label>
                    <input type="time" id="start_time" name="start_time" required>
                    <label for="end_time">End Time:</label>
                    <input type="time" id="end_time" name="end_time" required>
                    <input type="date" id="dat" name="dat" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
                    <input type="submit" name="submit" value="Book">
                </form>
            </td>
        </tr>
    <?php } ?>
</table>

</html>