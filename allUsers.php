<?php

session_start();

if(!isset($_SESSION['admin']) && !isset($_SESSION['user'])){
  header("location: login.php");
}

if(isset($_SESSION['user'])){
  header("location: home.php");
}

require_once("./db_connect.php");

$layout = $status = "";

$sql = "SELECT * FROM `users` WHERE `status` != 'adm'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 0){
  $layout = "No result";
} else {
  $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
  foreach($row as $value){
    $layout .= "<div class='card' style='width: 18rem;'>
    <img src='images/{$value['image']}' class='card-img-top' alt='...'>
    <div class='card-body'>
      <h6 class='card-title'>Flight no: {$value['firstName']}</h6><br>
      <h7 class='card-title'>Departure from: {$value['lastName']}</h7><br>
      <h8 class='card-title'>Arrival to: {$value['email']}</h8><br>
      <label name='blocked'>
      <p value=''>user $status</p>";
      if($value['is_blocked'] == 0){
        $layout .= "<a href='blocked_user.php?id={$value['id']}' class='btn btn-warning'>Block</a>";
      }else {
        $layout .= "<a href='unblocked_user.php?id={$value['id']}' class='btn btn-success'>Active</a>";
      }
      $layout .="
      </label>
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <div class="container" style="margin-top: 40px; ">
    <form method="post">
      <?= $layout ?>
      <input type="submit" class="btn btn-success" value="Update" name="blocked">

      <button href="dashboard.php" value="back">Back</button>

    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>