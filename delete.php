<?php
session_start();
require_once "connection.php";
require_once "navbar.php";

$id = $_GET["id"];
$sql = "SELECT * FROM car_rental WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);


if ($row["picture"] != "car.png") {
    unlink("pictures/{$row["picture"]}");
}


$sqlDelete = "DELETE FROM `car_rental` WHERE id = $id";
mysqli_query($conn, $sqlDelete);
header("Location: dashboard.php");
