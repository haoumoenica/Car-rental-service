<?php
session_start();

if (isset($_SESSION["user"])) {
    header("Location: home.php");
}

require_once "connection.php";
require_once "footer.php";

$sql = "SELECT * FROM car_rental";

$result = mysqli_query($conn, $sql);

$layout = "";

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        if ($row["available"] == "Available") {
            $availability_text = "Available";
            $availability_class = "text-success";
            $booking = "<a href='booking.php?id={$row["id"]}' class='btn btn-success'>Book</a>";
        } else {
            $availability_text = "Not Available";
            $availability_class = "text-danger";
            $booking = "";
        }


        $layout .= "<div class='col mb-4'>
                        <div class='card h-100'>
                            <div class='h-50'><img src='pictures/{$row["picture"]}' class='card-img-top' alt='Car Image'></div>
                            <div class='card-body'>
                                <h5 class='card-title'>{$row["brand"]} {$row["model"]} ({$row["year_of_making"]})</h5>
                                <p class='card-text'><b>Rental price:</b> {$row["price"]}€/day</p>
                                <p class='card-text'><b>Car type:</b> {$row["car_type"]}</p>
                                <p class='card-text'><b>Gear type:</b> {$row["gear_type"]}</p>
                                <p class='card-text {$availability_class}'><b>{$row["available"]}</b></p>
                                <a href='details.php?id={$row["id"]}' class='btn btn-warning'>Details</a>
                        	    <span>$booking</span>
                            </div>
                        </div>
                    </div>";
    }
} else {
    $layout = "<p>No results found</p>";
}
// mysqli_close($conn);
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
        <h1 class="mt-5">Products List</h1>
        <div class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-1 row-cols-xs-1">
            <?= $layout ?>
        </div>
    </div>
    <div><?= $footer ?></div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>