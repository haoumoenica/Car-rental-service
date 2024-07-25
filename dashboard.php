<?php
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}
if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit();
}

require_once "connection.php";
require_once "footer.php";

$sqlUser = "SELECT * FROM users WHERE id = " . $_SESSION["admin"];
$resultUser = mysqli_query($conn, $sqlUser);
$rowUser = mysqli_fetch_assoc($resultUser);
$sql = "SELECT * FROM car_rental left join booking on car_rental.id = booking.car";

$result = mysqli_query($conn, $sql);

$layout = "";

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $status = "";
        $confirmation = "";
        if ($row["available"] == "Available") {
            $availability_text = "Available";
            $availability_class = "text-success";
        } else {
            $availability_text = "Not Available";
            $availability_class = "text-danger";
            if ($row["status"] == "pending") {
                $status = "<p class='card-text'><b>Status:</b> {$row["status"]}</p>";
                $confirmation = "<a href='#' class='btn btn-info'>Confirm booking!</a>";
            }
        }

        $layout .= "<div class='col mb-4'>
                <div class='card h-100 d-flex flex-column'>
                    <div class='h-50'><img src='pictures/{$row["picture"]}' class='card-img-top' alt='Car Image'></div>
                    <div class='card-body d-flex flex-column'>
                        <h5 class='card-title'>{$row["brand"]} {$row["model"]} ({$row["year_of_making"]})</h5>
                        <p class='card-text'><b>Rental price:</b> {$row["price"]}€/day</p>
                        <p class='card-text'><b>Car type:</b> {$row["car_type"]}</p>
                        <p class='card-text'><b>Gear type:</b> {$row["gear_type"]}</p>
                        <div class='mt-2'>$status</div>
                        <p class='card-text {$availability_class} mt-2'><b>{$availability_text}</b></p>
                        <div class='mt-auto'>
                            <a href='details.php?id={$row["id"]}' class='btn btn-success'>Details</a>
                            <a href='update.php?id={$row["id"]}' class='btn btn-warning'>Update</a>
                            <a href='delete.php?id={$row["id"]}' class='btn btn-danger'>Delete</a>
                        </div>
                        <div class='mt-3'>$confirmation</div>
                    </div>
                </div>
            </div>";
    }
} else {
    $layout = "<p>No results found</p>";
}

mysqli_close($conn);
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
        <h1>Welcome <?= $rowUser["first_name"] . " " . $rowUser["last_name"] ?></h1>
    </div>
    <div class="container mt-5">
        <a class="btn btn-primary" href="create.php">Create a product</a>
        <h1 class="mt-5">Products List</h1>
        <div class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-1 row-cols-xs-1">
            <?= $layout ?>
        </div>
    </div>
    <div><?= $footer ?></div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>