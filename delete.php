<?php

require_once("./db_connect.php");

$id = $_GET['id'];

$sql = "SELECT * FROM flightBookings WHERE id = {$id}";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if($row['image'] != "default.jpg"){
  unlink("images/$row[image]");
}

$sqlDelete = "DELETE FROM flightBookings WHERE id = {$id}";
$resultDelete = mysqli_query($conn, $sqlDelete);

if($resultDelete){
  header("location: dashboard.php"); //take care of teh location later, maybe index is needed!
}