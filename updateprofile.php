<?php

session_start();

$session = 0;
$goBack = "";

if(isset($_SESSION['admin'])){
  $session = $_SESSION['admin'];
  $goBack = "dashboard.php";
}

if(isset($_SESSION['user'])){
  $session = $_SESSION['user'];
  $goBack = "home.php";
}

require_once("./db_connect.php");
require_once("./functions.php");

$sql = "SELECT * FROM users WHERE id = {$session}";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $email = $_POST['email'];
  $dateOfBirth = $_POST['dateOfBirth'];
  $image = fileUpload($_FILES['image']);

if($_FILES['image']['error'] == 4){
  $sqlUpdate = "UPDATE `users` SET `firstName`='{$firstName}',`lastName`='{$lastName}',`email`='{$email}',`dateOfBirth`='{$dateOfBirth}' WHERE id = {$session}";
} else {
  $sqlUpdate ="UPDATE `users` SET `firstName`='{$firstName}',`lastName`='{$lastName}',`email`='{$email}',`dateOfBirth`='{$dateOfBirth}',`image`='{$image[0]}' WHERE id = {$session}";
}

$resultUpdate = mysqli_query($conn, $sqlUpdate);

if($resultUpdate){
  echo "<div class='alert alert-success' role='alert'>
    <h4 class='alert-heading'>Well done! {$image[1]}</h4>
    <p>Your Product has been Created successfully!</p>
    <hr>
    <p class='mb-0'> now you can find it on the main page.</p>
  </div>";
  header("refresh: 3; url={$goBack}");
} else {
  echo "<div class='alert alert-danger' role='alert'>
    <h4 class='alert-heading'>something went wrong</h4>
    <p>Your Product did not create!</p>
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
      <input type="text" class="form-control" name="firstName" value="<?= $row['firstName']?>">

    </div>
    <div class="form-group">
      <label for="lastName">Last name</label>
      <input type="text" class="form-control" name="lastName" value="<?= $row['lastName']?>">

    </div>
    <div class="form-group">
      <label for="email">Email address</label>
      <input type="email" class="form-control" aria-describedby="emailHelp" name="email" value="<?= $row['email']?>">

    </div>

    <div class="form-group">
      <label for="dateOfBirth">Date of birth</label>
      <input type="date" class="form-control" name="dateOfBirth" value="<?= $row['dateOfBirth']?>">
    </div>
    <div class="form-group">
      <label for="image">Image</label>
      <input type="file" class="form-control" name="image" value="<?= $row['image']?>">

    </div>
    <button type="submit" name="update" class="btn btn-primary">Submit</button>
    <a href="<?= $goBack ?>" class="btn btn-outline-info">Back to main page</a>
  </form>
</body>

</html>