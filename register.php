<?php

session_start();

if(isset($_SESSION["admin"])){
  header("location: dashboard.php");
}

if(isset($_SESSION["user"])){
  header("location: home.php");
}

require_once("./db_connect.php");
require_once("./functions.php");

$error = false;

$firstName = $fnameError = $lastName = $lnameError = $email = $emailError = $passError = $dateOfBirth = $dateError = "";

if(isset($_POST['register'])){

  $firstName = cleanInputs($_POST['firstName']);
  $lastName = cleanInputs($_POST['lastName']);
  $email = cleanInputs($_POST['email']);
  $password = cleanInputs($_POST['password']);
  $dateOfBirth = cleanInputs($_POST['dateOfBirth']);
  $image = fileUpload($_FILES['image']);

  #first name validation
  if(empty($firstName)){
    $error = true;
    $fnameError = 'You can leave the first name empty';
  } elseif(strlen($firstName) < 3){
    $error = true;
    $fnameError = "First name must be at least 3 chars";
  } elseif(!preg_match("/^[a-zA-Z\s]+$/", $firstName)){
    $error = true;
    $fnameError = "First name must contain only letters and spaces";
  }

  #last name validation
  if(empty($lastName)){
    $error = true;
    $lnameError = 'You can leave the last name empty';
  } elseif(strlen($lastName) < 3){
    $error = true;
    $lnameError = "Last name must be at least 3 chars";
  } elseif(!preg_match("/^[a-zA-Z\s]+$/", $lastName)){
    $error = true;
    $lnameError = "Last name must contain only letters and spaces";
  }

  #email validation
  if(empty($email)){
    $error = true;
    $emailError = 'You can leave the email empty';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL )){
    $error = true;
    $emailError = "Please enter a valid email";
  } else {
    $sql = "SELECT email FROM `users` WHERE email = '{$email}'";
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) != 0){
      $error = true;
      $emailError = "This email is already exists";
    }
  }

  #password validation
  if(empty($password)){
    $error = true;
    $passError = "You can leave the password empty";
  } elseif(strlen($password) < 6){
    $error = true;
    $passError = "Password must be at least 6 chars";
  }

  #date fo birth validation
  if(empty($dateOfBirth)){
    $error = true;
    $dateError = "Please select the date of birth";
  }

  if(!$error){
    $password = hash("sha256", $password);
  }

  $insertQuery = "INSERT INTO `users`(`firstName`, `lastName`, `email`, `password`, `dateOfBirth`, `image`) VALUES ('{$firstName}','{$lastName}','{$email}','{$password}','{$dateOfBirth}','{$image[0]}')";

  $result = mysqli_query($conn,$insertQuery);

  if($result){
    echo "<div class='alert alert-success' role='alert'>
    <h4 class='alert-heading'>Well done! {$image[1]}</h4>
    <p>You registered successfully!</p>
  </div>";

    $firstName = $lastName = $email = $dateOfBirth = "";
  } else {
    echo "<div class='alert alert-danger' role='alert'>
    <h4 class='alert-heading'>something went wrong</h4>
    <p>Your You didn't register!</p>
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

  <form class="container" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label for="firstName">First Name</label>
      <input type="text" class="form-control" name="firstName" value="<?= $firstName?>">
      <small class="form-text text-danger"><?= $fnameError ?></small>
    </div>
    <div class="form-group">
      <label for="lastName">Last name</label>
      <input type="text" class="form-control" name="lastName" value="<?= $lastName?>">
      <small class="form-text text-danger"><?= $lnameError ?></small>
    </div>
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
    <div class="form-group">
      <label for="dateOfBirth">Date of birth</label>
      <input type="date" class="form-control" name="dateOfBirth" value="<?= $dateOfBirth?>">
      <small class="form-text text-danger"><?= $dateError?></small>
    </div>
    <div class="form-group">
      <label for="image">Image</label>
      <input type="file" class="form-control" name="image" value="<?= $image?>">

    </div>
    <button type="submit" name="register" class="btn btn-primary">Submit</button>
    <a href="index.php" class="btn btn-outline-info">Back to main page</a>
  </form>
</body>

</html>