<?php

session_start();

if(!isset($_SESSION['user']) && !isset($_SESSION['admin'])){
  header("location: login.php");
}

if(isset($_SESSION["admin"])){
  header("location: dashboard.php");
}

require_once("./db_connect.php");
require_once("./functions.php");

$sqlFlights = "SELECT * FROM flightBookings";
$resultFlights = mysqli_query($conn, $sqlFlights);
$rows = mysqli_fetch_all($resultFlights, MYSQLI_ASSOC);

$arrival = "";

foreach($rows as $value){
  $arrival .= "<option value='{$value['id']}'>{$value['arrival']}</option>";
}

if(isset($_POST['create'])){

  $arrival = $_POST['arrival'];

  if(empty($arrival)){
    echo "<div class='alert alert-danger' role='alert'>
  <h4 class='alert-heading'>something went wrong</h4>
  <p>Your Product did not create!</p>
  <hr>
  <p class='mb-0'>Please fill the blanks and try again.</p>
</div>";
  } else {
    $sql = "INSERT INTO `userBooking`(`userID`, `bookingID`) VALUES ({$_SESSION['user']},{$arrival})";
  }

  if(mysqli_query($conn, $sql)){
    echo "<div class='alert alert-success' role='alert'>
    <h4 class='alert-heading'>Well done!</h4>
    <p>Your Product has been Created successfully!</p>
    <hr>
    <p class='mb-0'> now you can find it on the main page.</p>
  </div>";
  header("refresh: 3; url=home.php");
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
    <h1 style="font-size: 24px;">Book your ticket</h1>
    <div class="mb-3">
      <form method="post" enctype="multipart/form-data" style="margin-bottom: 20px">
        <div class="row" style="margin-bottom: 20px">
          <div class="col">
            <input type="text" class="form-control" placeholder="Passenger Name*" name="passengerName">
          </div>

        </div>
        <div class="row" style="margin-bottom: 20px">
          <div class="col">
            <select type="text" class="form-control" placeholder="Departure from*" name="departure">
              <option value="1">VIENNA</option>
            </select>
          </div>
          <div class="col">
            <select type="text" class="form-control" placeholder="Arrival to*" name="arrival">
              <option value="null">Select your destination</option>
              <?= $arrival ?>
            </select>
          </div>
        </div>
        <div class="row" style="margin-bottom: 20px">
          <div class="col">
            <input type="date" class="form-control" placeholder="Departure Date*" name="date">
          </div>

        </div>
        <input type="submit" class="btn btn-success" value="Book Ticket" name="create">
      </form>
      <a href="home.php" class="btn btn-secondary" type="text">Back</a>
    </div>
  </div>
</body>

</html>