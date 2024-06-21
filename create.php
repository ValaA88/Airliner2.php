<?php

session_start();

if(!isset($_SESSION['user']) && !isset($_SESSION['admin'])){
  header("location: login.php");
}

if(isset($_SESSION['user'])){
  header("location: home.php");
}

require_once("./db_connect.php");
require_once("./functions.php");

if(isset($_POST['create'])){

  $image = fileUpload($_FILES['image']);
  $flightNumber = $_POST['flightNumber'];
  $departure = $_POST['departure'];
  $arrival = $_POST['arrival'];
  $date = $_POST['date'];
  $ticketPrice = $_POST['ticketPrice'];

  if(empty($flightNumber) || empty($departure) || empty($arrival) || empty($date) || empty($ticketPrice)){
    echo "<div class='alert alert-danger' role='alert'>
  <h4 class='alert-heading'>something went wrong</h4>
  <p>Your Product did not create!</p>
  <hr>
  <p class='mb-0'>Please fill the blanks and try again.</p>
</div>";
  } else {
    $sql = "INSERT INTO `flightBookings`(`image`, `flightNumber`, `departure`, `arrival`, `date`, `ticketPrice`) VALUES ('{$image[0]}','{$flightNumber}','{$departure}','{$arrival}','{$date}','{$ticketPrice}')";
  }

  $result = mysqli_query($conn, $sql);

  if($result){
    echo "<div class='alert alert-success' role='alert'>
    <h4 class='alert-heading'>Well done! {$image[1]}</h4>
    <p>Your Product has been Created successfully!</p>
    <hr>
    <p class='mb-0'> now you can find it on the main page.</p>
  </div>";
  header("refresh: 3; url=dashboard.php");
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
    <h1 style="font-size: 24px;">Insert flight infos</h1>
    <div class="mb-3">
      <form method="post" enctype="multipart/form-data" style="margin-bottom: 20px">
        <div class="row" style="margin-bottom: 20px">
          <div class="col">
            <input type="text" class="form-control" placeholder="Flight Number" name="flightNumber">
          </div>
        </div>
        <div class="row" style="margin-bottom: 20px">
          <div class="col">
            <input type="text" class="form-control" placeholder="Departure from*" name="departure">
          </div>
          <div class="col">
            <input type="text" class="form-control" placeholder="Arrival to*" name="arrival">
          </div>
        </div>
        <div class="row" style="margin-bottom: 20px">
          <div class="col">
            <input type="date" class="form-control" placeholder="Departure Date*" name="date">
          </div>
          <div class="col">
            <input type="text" class="form-control" placeholder="Ticket Price*" name="ticketPrice">
          </div>
        </div>
        <div class="row" style="margin-bottom: 20px">
          <div class="col">
            <input type="file" class="form-control" placeholder="image url" name="image" style="margin-bottom: 20px">
          </div>

        </div>


        <input type="submit" class="btn btn-success" value="Add flight" name="create">
      </form>
      <a href="dashboard.php" class="btn btn-secondary" type="text">Back</a>
    </div>
  </div>
</body>

</html>