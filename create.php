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
require_once "file_upload.php";
require_once "navbar.php";
require_once "footer.php";

if (isset($_POST["create"])) {
    $brand = $_POST["brand"];
    $model = $_POST["model"];
    $year_of_making = $_POST["year_of_making"];
    $price = $_POST["price"];
    $horse_power = $_POST["horse_power"];
    $car_type = $_POST["car_type"];
    $gear_type = $_POST["gear_type"];
    $available = $_POST["available"];
    $number_of_doors = $_POST["number_of_doors"];
    // $location = $_POST["location"];
    $picture = fileUpload($_FILES["picture"]);

    $sql = "INSERT INTO car_rental (brand, model, year_of_making, price, horse_power, car_type, gear_type, available, number_of_doors, picture) VALUES ('$brand','$model', $year_of_making, $price, $horse_power, '$car_type', '$gear_type', '$available', $number_of_doors, '{$picture[0]}')";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success' role='alert'>
            New record has been created, {$picture[1]}
          </div>";
        header("refresh: 3; url= dashboard.php");
    } else {
        echo "<div class='alert alert-danger' role='alert'>
            error found, {$picture[1]}
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

</head>

<body>
    <div><?php require_once "./navbar.php"; ?></div>
    <div class="container mt-5">
        <h2>Create a new car</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="brand" class="form-label">Brand</label>
                <input type="text" class="form-control" id="brand" aria-describedby="brand" name="brand">
            </div>
            <div class="mb-3 mt-3">
                <label for="model" class="form-label">Model</label>
                <input type="text" class="form-control" id="model" aria-describedby="model" name="model">
            </div>
            <div class="mb-3">
                <label for="year_of_making" class="form-label">Year</label>
                <input type="number" class="form-control" id="year_of_making" aria-describedby="year_of_making" name="year_of_making">
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" id="price" aria-describedby="price" name="price">
                </div>
                <div class="mb-3">
                    <label for="picture" class="form-label">Picture</label>
                    <input type="file" class="form-control" id="picture" aria-describedby="picture" name="picture">
                </div>
                <div class="mb-3">
                    <p>Car type:</p>
                    <select class="form-select" aria-label="Default select example" name="car_type">
                        <option value="SUV">SUV</option>
                        <option value="Sedan">Sedan</option>
                        <option value="Coupe">Coupe</option>
                        <option value="Minivan">Minivan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <p>Gear type:</p>
                    <select class="form-select" aria-label="Default select example" name="gear_type">
                        <option value="Automatic">Automatic</option>
                        <option value="Manual">Manual</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="number_of_doors" class="form-label">Doors</label>
                    <input type="number" class="form-control" id="number_of_doors" aria-describedby="number_of_doors" name="number_of_doors">
                </div>
                <div class="mb-3">
                    <label for="horse_power" class="form-label">Horse power</label>
                    <input type="number" class="form-control" id="horse_power" aria-describedby="horse_power" name="horse_power">
                </div>
                <div class="mb-3">
                    <p>Availability</p>
                    <select class="form-select" aria-label="Default select example" name="available">

                        <option value="Available">Available</option>
                        <option value="Not available">Not available</option>
                    </select>
                </div>
                <button name="create" type="submit" class="btn btn-primary">Create car</button>
                <a href="index.php" class="btn btn-warning">Back to home page</a>
        </form>
    </div>
    <div><?= $footer ?></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>