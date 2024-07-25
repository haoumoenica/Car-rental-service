<?php
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

require_once "connection.php";
require_once "file_upload.php";

if (isset($_SESSION["admin"])) {
    $session = $_SESSION["admin"];
    $backTo = "dashboard.php";
} else {
    $session = $_SESSION["user"];
    $backTo = "home.php";
}

$sql = "SELECT * FROM users WHERE id = $session";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (isset($_POST["edit"])) {
    $fname = cleanInput($_POST["first_name"]);
    $lname = cleanInput($_POST["last_name"]);
    $email_address = cleanInput($_POST["email_address"]);
    $dob = cleanInput($_POST["dob"]);
    $picture = fileUpload($_FILES["picture"]);

    if ($_FILES["picture"]["error"] == 4) {
        $sqlUpdate = "UPDATE users SET first_name = '$fname', last_name = '$lname', dob= '$dob', email_address = '$email_address' WHERE id = $session ";
    } else {
        if ($row["picture"] != 'avatar.jpg') {
            unlink("pictures/" . $row["picture"]);
        }
        $sqlUpdate = "UPDATE users SET first_name = '$fname', last_name = '$lname', dob= '$dob', email_address = '$email_address', picture = '$picture[0]' WHERE id = $session ";
    }
    $result = mysqli_query($conn, $sqlUpdate);

    if ($result) {
        header("Location: " . $backTo);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <div><?php require_once "./navbar.php"; ?></div>
    <div class="container">
        <h1>Edit profile!</h1>

        <form enctype="multipart/form-data" method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
            <input type="text" name="first_name" class="form-control mb-3" value="<?= $row["first_name"] ?>">
            <input type="text" name="last_name" class="form-control mb-3" value="<?= $row["last_name"] ?>">
            <input type="email" name="email_address" class="form-control mb-3" value="<?= $row["email_address"] ?>">
            <input type="date" name="dob" class="form-control mb-3" value="<?= $row["dob"] ?>">
            <input type="file" name="picture" class="form-control mb-3">
            <input type="submit" name="edit" value="Update profile" class="btn btn-warning">
        </form>
    </div>
</body>

</html>