<html>
  <head>
    <title>Manage Stations</title>
    <style>
@import url('https://fonts.googleapis.com/css2?family=Mulish:wght@600&display=swap'); 

        table {
  border-collapse: collapse;
  width: 100%;
  margin-top: 30px;
}
.b{
  display: flex;
  align-items: center;
  text-align: center;
  width: 140px;
  height: 20px;
  padding: 10px 20px;
  color: black;
  border: 2px solid black;
  background-color: palegreen;
  margin-left: 10px;
}
.b:hover{
  background-color: salmon;
  color: #f2f2f2;
}
a{
  font-family: 'Mulish', sans-serif;
  text-decoration: none;
  font-size: 1.3rem;
  padding: 30px 30px;
  color: black;
  

}
a:hover{
  color: white;
}

th, td {
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
  margin-top: 30px;
}
.ab{
  display: flex;
}

    </style>
  </head>
  <body>
    <div class="ab">
    <div class="b"><a href="logout.php">
        Logout
    </a>
    </div>
    <div class="b">
    <a href="handleres.php" style="margin-left: -20px;">
        Reservations
    </a>
    </div>
    </div>

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
      // Add a station
    //   if (isset($_POST['add_name']) && isset($_POST['add_location'])) {
    //     $name = mysqli_real_escape_string($db, $_POST['add_name']);
    //     $location = mysqli_real_escape_string($db, $_POST['add_location']);
    //             // Add the station to the database
    //             $query = "INSERT INTO stations (name, location, c_id) VALUES ('$name', '$location', '$c_id')";
    //             mysqli_query($db, $query);
    //           }
              // Delete a station
              if (isset($_POST['delete_id'])) {
                $id = mysqli_real_escape_string($db, $_POST['delete_id']);
                // Delete the station from the database
                $query = "DELETE FROM station WHERE s_id='$id' AND c_id='$c_id'";
                mysqli_query($db, $query);
              }
              // Update a station
              if (isset($_POST['update_id']) && isset($_POST['update_name']) && isset($_POST['update_location'])) {
                $id = mysqli_real_escape_string($db, $_POST['update_id']);
                $name = mysqli_real_escape_string($db, $_POST['update_name']);
                $location = mysqli_real_escape_string($db, $_POST['update_location']);
                // Update the station in the database
                $query = "UPDATE station SET s_name='$name', location='$location' WHERE s_id='$id' AND c_id='$c_id'";
                mysqli_query($db, $query);
              }
              // Display the stations owned by the owner
              $query = "SELECT s_id, s_name FROM station WHERE c_id='$c_id'";
              $result = mysqli_query($db, $query);
            ?>
            <table>
              <tr>
                <th>ID</th>
                <th>Name</th>
                
                <th>Actions</th>
              </tr>
              <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td><?php echo $row['s_id']; ?></td>
                  <td><?php echo $row['s_name']; ?></td>
                  
                  <td>
                    <form method="post">
                      <input type="hidden" name="delete_id" value="<?php echo $row['s_id']; ?>">
                      <input type="submit" value="Delete">
                    </form>
                    <form method="post">
                      <input type="hidden" name="update_id" value="<?php echo $row['s_id']; ?>">
                      <input type="text" name="update_name" value="<?php echo $row['s_name']; ?>">
                      
                      <input type="submit" value="Update">
                    </form>
                  </td>
                </tr>
              <?php endwhile; ?>
            </table
        
