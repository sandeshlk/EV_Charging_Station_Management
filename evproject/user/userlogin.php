<?php
  session_start();
  if (isset($_SESSION['user_id'])) {
    // User is already logged in. Redirect to booking page.
    header('Location: booking.php');
    exit;
  }
  if (isset($_POST['username']) && isset($_POST['password'])) {
    // Check login credentials
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Connect to the database
    $conn = mysqli_connect('localhost', 'root', '', 'ev');
    // Check connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
    // Check if username and password are correct
    $result = mysqli_query($conn, "SELECT user_id FROM users WHERE username='$username' AND password='$password'");
    if (mysqli_num_rows($result) == 1) {
      // Login successful, store user id in session
      $row = mysqli_fetch_assoc($result);
      $_SESSION['user_id'] = $row['user_id'];
      

      // Redirect to booking page
      header('Location: booking.php');
      exit;
    }
    // Login failed
    $error = 'Invalid username or password';
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <style>
      body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f5f5f5;
}

form {
  max-width: 800px;
  margin: 10px auto;
  padding: 30px;
  background-color: white;
  border: 7px solid #ddd;
  border-radius: 0px;
}

form label {
  display: block;
  margin-bottom: 8px;
  font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
}

form input[type="text"],
form input[type="password"] {
  width: 100%;
  padding: 12px 20px;
  margin-bottom: 20px;
  box-sizing: border-box;
  border: 1px solid #ccc;
  border-radius: 5px;
}

form input[type="submit"] {
  width: 100%;
  background-color: #4caf50;
  color: white;
  padding: 14px 20px;
  margin-bottom: 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: 1.2s 0ms all;
}

form input[type="submit"]:hover {
  background-color: #45a049;
  box-shadow: grey 10px 10px 40px;
  transition: 1.2s 0ms all;

}

    </style>
  </head>
  <body>
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
