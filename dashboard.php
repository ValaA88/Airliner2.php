<?php

session_start();

if(!isset($_SESSION['admin']) && !isset($_SESSION['user'])){
  header("location: login.php");
}

if(isset($_SESSION['user'])){
  header("location: home.php");
}

require_once("./db_connect.php");

$sql = "SELECT * FROM users WHERE id = {$_SESSION['admin']}";
$sqlIndex = "SELECT * FROM flightBookings";
$result = mysqli_query($conn, $sql);
$resultIndex = mysqli_query($conn, $sqlIndex);

$row = mysqli_fetch_assoc($result);

$layout = $layoutAllUsers = "";

if(mysqli_num_rows($resultIndex) == 0){
  $layout = "No result";
} else {
  $rows = mysqli_fetch_all($resultIndex, MYSQLI_ASSOC);
  foreach($rows as $value){
    $layout .= "
    <div class='card' style='width: 18rem;'>
    <img src='images/{$value['image']}' class='card-img-top' alt='...'>
    <div class='card-body'>
      <h6 href='search.php?flightNumber={$value['flightNumber']}'class='card-title'>Flight no: {$value['flightNumber']}</h6><br>
      <h7 class='card-title'>Departure from: {$value['departure']}</h7><br>
      <h8 class='card-title'>Arrival to: {$value['arrival']}</h8><br>
      <a href='details.php?id={$value['id']}' class='btn btn-primary'>Details</a>
      <a href='delete.php?id={$value['id']}' class='btn btn-danger'>Delete</a>
      <a href='update.php?id={$value['id']}' class='btn btn-outline-info'>Update</a>
    </div>
  </div>
    ";
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
  <nav class="navbar bg-body-tertiary">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="images/<?= $row['image']?>" alt="Bootstrap" width="30" height="24"><?= $row['firstName']?>
      </a>

      <a href="create.php" class="btn btn-primary" style="margin: 20px; text-align: center;">Create a flight ticket</a>
      <a class="navbar-brand" href="updateprofile.php">Update profile</a>
      <a class="navbar-brand" href="logout.php?logout">Logout</a>
      <a class="navbar-brand" href="allUsers.php">Users</a>
    </div>
  </nav>

  <div class="row row-cols-3">
    <?= $layout ?>
    <?= $layoutAllUsers ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>
</body>

</html>