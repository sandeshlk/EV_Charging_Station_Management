<html>

<head>
    <title>Update Reservation</title>
    <style>
        form {
  display: flex;
 flex-direction: column;
  align-items: center;
  justify-content: center;
}

label {
  width: 120px;
  margin-right: 10px;
  text-align: right;
}

input[type="text"] {
  width: 200px;
  height: 30px;
  padding: 0 10px;
  margin: 20px;
}

input[type="button"], input[type="submit"] {
    margin :30px;
  width: 200px;
  height: 30px;
  margin-left: 10px;
  background-color: #4caf50;
  color: white;
}

    </style>
</head>

<body>
    <?php
    session_start();
    if (!isset($_SESSION['c_id'])) {
        header('Location: companylogin.php');
        exit;
    }
    // Connect to the database
    $db = mysqli_connect('localhost', 'root', '', 'ev');
    // Escape the user input to prevent SQL injection attacks
    $c_id = mysqli_real_escape_string($db, $_SESSION['c_id']);

    if (isset($_POST['calculate'])) {
        $units_consumed = $_POST['units_consumed'];
        $cost_per_unit = $_POST['cost_per_unit'];

        // Call the procedure to calculate the total_cost
        $query = "CALL calculate_total_cost('$units_consumed', '$cost_per_unit', @total_cost)";
        mysqli_query($db, $query);

        // Get the calculated total_cost
        $query = "SELECT @total_cost AS total_cost";
        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_assoc($result);
        $total_cost = $row['total_cost'];
    ?>
        <script>
            document.getElementsByName("total_cost")[0].value = total_cost;
        </script>
    <?php
    }
    if (isset($_POST['update'])) {
        $res_id = $_POST['res_id'];
        $st_id = $_POST['st_id'];
        $comp_id = $_POST['comp_id'];
        $user_id = $_POST['user_id'];
        $units_consumed = $_POST['units_consumed'];
        $cost_per_unit = $_POST['cost_per_unit'];
        $total_cost = $_POST['total_cost'];
        $pay = $_POST['payment'];


        // Insert the updated values into the 'entries' table
        $query = "INSERT INTO entries (res_id, s_id,c_id, user_id, units_consumed, cost_per_unit, total_cost,payment) VALUES ('$res_id', '$st_id','$comp_id', '$user_id', '$units_consumed', '$cost_per_unit', '$total_cost','$pay')";
        mysqli_query($db, $query);
    }
    ?>
    <form method="post">
         <label>Res ID</label>
        <input type="text" name="res_id">
        <label>Station ID:</label>
        <input type="text" name="st_id">
        <label>Company ID:</label>
        <input type="text" name="comp_id">
        <label>User ID:</label>
        <input type="text" name="user_id">
        <br>
        <label>Units Consumed:</label>
        <input type="text" name="units_consumed">
        <br>
        <label>Cost per Unit:</label>
        <input type="text" name="cost_per_unit">
        <br>
        <label>Total Cost:</label>
        <input type="text" name="total_cost" disabled>
        <input type="button" value="Calculate" name="calculate" onClick="calculateTotal()">
        <input type="text" name="payment">
        <br>
        <input type="submit" value="Update" name="update">
    </form>

</body>

</html>