<?php
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: index.php");
}

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
if (isset($_SESSION["admin"])) {
    header("Location: dashboard.php");
    exit();
}

require_once "connection.php";
require_once "footer.php";


if (isset($_POST["book"])) {

    $carId = $_GET["id"];
    $userId = $_SESSION["user"];
    $start_date = cleanInput($_POST["start_date"]);
    $end_date = cleanInput($_POST["end_date"]);
    $payment = cleanInput($_POST["payment"]);

    $sql = "SELECT * FROM car_rental WHERE id = {$carId}";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);



    if ($row["available"] == "Available") {
        $bookingSql = "INSERT INTO booking (`start_date`, end_date, user, car, status, payment) VALUES ('$start_date', '$end_date', $userId, $carId, 'pending', '$payment');";
        $sqlUpdate = "UPDATE car_rental SET available = 'Not Available' WHERE id = $carId";
        mysqli_query($conn, $bookingSql);
        mysqli_query($conn, $sqlUpdate);
        header("Location: home.php");
    } else {
        # not possible
    }
}


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Car Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div><?php require_once "./navbar.php"; ?></div>

    <div class="container mt-5">

        <h1 class="mt-5">Book this car:</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="from" class="form-label">From:</label>
                <input type="date" class="form-control" id="start_date" aria-describedby="start_date" name="start_date">
            </div>
            <div class="mb-3 mt-3">
                <label for="till" class="form-label">Till:</label>
                <input type="date" class="form-control" id="end_date" aria-describedby="end_date" name="end_date">
            </div>
            <div class="mb-3 mt-3">
                <label for="payment" class="form-label">Credit Card Number:</label>
                <input type="number" class="form-control" id="payment" aria-describedby="payment" name="payment">
            </div>
            <button name="book" type="submit" class="btn btn-success">Book this car</button>
            <a href="details.php" class="btn btn-warning">Back to home page</a>

    </div>

    </form>
    </div>
    <div><?= $footer ?></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>