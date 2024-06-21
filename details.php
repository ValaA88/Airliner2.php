<?php

session_start();

require_once("./db_connect.php");

$session = 0;
$goBack = "";

if(isset($_SESSION['user'])){
  $session = $_SESSION['user'];
  $goBack = "home.php";
}

if(isset($_SESSION['admin'])){
  $session = $_SESSION['admin'];
  $goBack = "dashboard.php";
}

$id = $_GET['id'];

$sql = "SELECT * FROM flightBookings WHERE id = {$id}";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$layout = "
<div class='card' style='width: 18rem;'>
    <img src='...' class='card-img-top' alt='...'>
    <div class='card-body'>

      <h6 class='card-title'>Flight no: {$row['flightNumber']}</h6><br>
      <h7 class='card-title'>Departure from: {$row['departure']}</h7><br>
      <h9 class='card-title'>Arrival to: {$row['arrival']}</h9><br>
      <h10 class='card-title'>Date: {$row['date']}</h10><br>

      <h13 class='card-title'>Ticket Price: {$row['ticketPrice']}</h13><br>

      <a href='{$goBack}' class='btn btn-primary'>Back to main page</a>
    </div>
  </div>
";


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
  <?= $layout ?>
</body>

</html>