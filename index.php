<?php

require_once("./db_connect.php");

$sql = "SELECT * FROM flightBookings";
$result = mysqli_query($conn,$sql);

$layout = "";

if(mysqli_num_rows($result) == 0){
  $layout = "No Result";
  }else{
  $rows = mysqli_fetch_all($result,MYSQLI_ASSOC);
  foreach($rows as $value){
    $layout .="<div class='card' style='width: 18rem;'>
    <img src='images/{$value['image']}' class='card-img-top' alt='...'>
    <div class='card-body'>
      <h6 href='search.php?flightNumber={$value['flightNumber']}'class='card-title'>Flight no: {$value['flightNumber']}</h6><br>
      <h7 class='card-title'>Departure from: {$value['departure']}</h7><br>
      <h8 class='card-title'>Arrival to: {$value['arrival']}</h8><br>
      <a href='details.php?id={$value['id']}' class='btn btn-primary'>Details</a>
      <a href='delete.php?id={$value['id']}' class='btn btn-danger'>Delete</a>
      <a href='update.php?id={$value['id']}' class='btn btn-outline-info'>Update</a>
    </div>
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
</head>

<body>
  <?= $layout ?>
</body>

</html>