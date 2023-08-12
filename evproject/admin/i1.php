<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    form {
  width: 80%;
  margin: 0 auto;
  padding: 30px;
  border: 1px solid #ccc;
  border-radius: 10px;
}

label {
  display: block;
  margin-bottom: 8px;
  font-size: 16px;
}

input[type="text"], input[type="email"], input[type="tel"], textarea {
  width: 100%;
  padding: 12px 20px;
  margin-bottom: 20px;
  box-sizing: border-box;
  border: 2px solid #ccc;
  border-radius: 4px;
}

input[type="submit"] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin-bottom: 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type="submit"]:hover {
  background-color: #45a049;
}

</style>
<body>
<form method="post" action="ins1.php">
<label for="name">COMPANY ID:</label><br>
  <input type="text" id="c_id" name="c_id"><br>
  
  <label for="phone">COMAPNY PHONE:</label><br>
  <input type="tel" id="phone" name="phone"><br>
  
  <label for="name">COMPANY NAME:</label><br>
  <input type="text" id="c_name" name="c_name"><br>
  
  <label for="name">COMPANY EMAIL:</label><br>
  <input type="text" id="c_email" name="c_email"><br>
  <input type="submit" value="NEXT">
</form> 

</body>
</html>