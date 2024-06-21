<?php

session_start();

require_once("./db_connect.php");
require_once("./functions.php");

$session = 0;
$goBack = "";

if(isset($_SESSION['admin'])){
  $session = $_SESSION['admin'];
  $goBack = "dashboard.php";
}

// if(isset($_SESSION['user'])){
//   $session = $_SESSION['user'];
//   $goBack = "home.php";
// }

$id = $_GET['id'];

$sql = "SELECT * FROM flightBookings WHERE id = {$id}";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

  $image = fileUpload($_FILES['image']);
  $flightNumber = $_POST['flightNumber'];
  $departure = $_POST['departure'];
  $arrival = $_POST['arrival'];
  $date = $_POST['date'];
  $ticketPrice = $_POST['ticketPrice'];

  if($_FILES['image']['error'] == 4){
    $sqlUpdate = "UPDATE `flightBookings` SET `flightNumber`='{$flightNumber}',`departure`='{$departure}',`arrival`='{$arrival}',`date`='{$date}',`ticketPrice`='{$ticketPrice}' WHERE id = {$id}";
  } else {
    $sqlUpdate = "UPDATE `flightBookings` SET `image`='{$image[0]}',`flightNumber`='{$flightNumber}',`departure`='{$departure}',`arrival`='{$arrival}',`date`='{$date}',`ticketPrice`='{$ticketPrice}' WHERE id = {$id}";
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

<body style="background-color: #145DA0">

  <div class="container" style="margin-top: 40px; ">
    <h1 style="font-size: 24px;">Change your ticket</h1>
    <div class="mb-3">
      <form method="post" enctype="multipart/form-data" style="margin-bottom: 20px">
        <div class="row" style="margin-bottom: 20px">

          <div class="col">
            <input type="text" class="form-control" placeholder="Flight Number" name="flightNumber"
              value="<?= $row["flightNumber"]?>">
          </div>
        </div>
        <div class="row" style="margin-bottom: 20px">
          <div class="col">
            <input type="text" class="form-control" placeholder="Departure from*" name="departure"
              value="<?= $row["departure"]?>">
          </div>
          <div class="col">
            <input type="text" class="form-control" placeholder="Arrival to*" name="arrival"
              value="<?= $row["arrival"]?>">
          </div>
        </div>
        <div class="row" style="margin-bottom: 20px">
          <div class="col">
            <input type="date" class="form-control" placeholder="Date*" name="date" value="<?= $row["date"]?>">
          </div>
          <div class="col">
            <input type="text" class="form-control" placeholder="ticketPrice*" name="ticketPrice"
              value="<?= $row["ticketPrice"]?>">
          </div>
        </div>
    </div>
    <input type="file" class="form-control" placeholder="image url" name="image" style="margin-bottom: 20px"
      value="<?= $row["image"]?>">
    <input type="submit" class="btn btn-success" value="Update Ticket" name="update">
    </form>
    <a href="<?= $goBack ?>" class="btn btn-secondary" type="text">Back</a>
  </div>
  </div>
</body>

</html>