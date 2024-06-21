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