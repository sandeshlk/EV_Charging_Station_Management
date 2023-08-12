<html>
  <head>
    <title>Company Login</title>
    <style>
     form {
  width: 30%;
  margin: 0 auto;
  text-align: center;
  border: 2px solid #4caf50;
  padding: 20px;
  border-radius: 5px;
}

label {
  display: block;
  margin-bottom: 10px;
}

input[type="text"], input[type="password"] {
  width: 80%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border: 2px solid #ccc;
  border-radius: 4px;
}

input[type="submit"] {
  width: 50%;
  background-color: #4caf50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type="submit"]:hover {
  background-color: #45a049;
}

p {
  color: red;
}


    </style>
  </head>
  <body>
    <?php
      session_start();
      if (isset($_SESSION['c_id'])) {
        header('Location: handlestations.php');
        exit;
      }
      if (isset($_POST['username']) && isset($_POST['password'])) {
        // Connect to the database
        $db = mysqli_connect('localhost', 'root', '', 'ev');
        // Escape the user input to prevent SQL injection attacks
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
        // Check if the username and password are correct
        $query = "SELECT c_id FROM company WHERE username='$username' AND password='$password'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) > 0) {
          // Login successful
          $row = mysqli_fetch_assoc($result);
          $_SESSION['c_id'] = $row['c_id'];
          header('Location: handlestations.php');
          exit;
        } else {
          $error = "Incorrect username or password.";
        }
      }
    ?>
    <?php if (isset($error)): ?>
      <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post">
      <label for="username">Username:</label><br>
      <input type="text" id="username" name="username"><br>
      <label for="password">Password:</label><br>
      <input type="password" id="password" name="password"><br><br>
      <input type="submit" value="Submit">
    </form> 
  </body>
</html>
