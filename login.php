<?php

require_once("./db_connect.php");
require_once("./functions.php");

$error = false;

$email = $emailError = $passError = "";

if(isset($_POST['login'])){
  $email = cleanInputs($_POST['email']);
  $password = cleanInputs($_POST['password']);

  #email validation
  if(empty($email)){
    $error = true;
    $emailError = 'this input can not be empty';
  } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $error = true;
    $emailError = 'Please type a valid email';
  }

  #password validation
  if(empty($password)){
    $error = true;
    $passError = 'You can not leave this input empty';
  }

  if(!$error){
    $password = hash("sha256", $password);
  }

  $sql = "SELECT * FROM `users` WHERE email = {$email} AND password = {$password}";
  $result = mysqli_query($conn, $sql);
  $count = mysqli_num_rows($result);
  $row = mysqli_fetch_assoc($result);

  if($error){
    echo "<div class='alert alert-danger' role='alert'>
    <h4 class='alert-heading'>something went wrong</h4>
    <hr>
    <p class='mb-0'>Please try again.</p>
  </div>";
  }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

  <h1><?= $loginError ?></h1>
  <form class="container" method="post">


    <div class="form-group">
      <label for="email">Email address</label>
      <input type="email" class="form-control" aria-describedby="emailHelp" name="email" value="<?= $email?>">
      <small class="form-text text-danger"><?= $emailError ?></small>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" name="password">
      <small class="form-text text-danger"><?= $passError ?></small>
    </div>


    <button type="login" name="login" class="btn btn-primary">Login</button>
    <a href="index.php" class="btn btn-outline-info">Back to main page</a>
  </form>
</body>

</html>