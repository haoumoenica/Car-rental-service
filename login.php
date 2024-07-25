<?php
session_start();

if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit();
}

if (isset($_SESSION["admin"])) {
    header("Location: dashboard.php");
    exit();
}

require_once "connection.php";
require_once "navbar.php";
require_once "footer.php";


$error = false;
$email_address = $email_addressError = $passwordError = "";


if (isset($_POST["login-btn"])) {
    $email_address = cleanInput($_POST["email_address"]);
    $password = cleanInput($_POST["password"]);

    if (empty($email_address)) {
        $error = true;
        $email_addressError = "Email is required!";
    } elseif (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $email_addressError = "Not a valid email!";
    }


    if (empty($password)) {
        $error = true;
        $passwordError = "Password is required!";
    }

    if (!$error) { # $error == false
        $password = hash("sha256", $password);

        $sql = "SELECT * FROM `users` WHERE email_address = '$email_address' AND password = '$password'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) == 1) {
            # you can login 
            # we need to check if the whoever logged in is a user or adm 
            if ($row["status"] == "admin") {
                # send you to the dashboard
                $_SESSION["admin"] = $row["id"];
                header("Location: dashboard.php");
            } else {
                # send you to the home page
                $_SESSION["user"] = $row["id"];
                echo "  <div class='alert alert-info' role='alert'>
                            You have successfully logged in!
                        </div>";
                header("refresh: 3; url= home.php");
            }
        } else {
            echo "Incorrect credintials!";
        }
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
    <div class="container mt-5">
        <h1>Login Page</h1>
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" autocomplete="off" method="post">
            <input type="email" placeholder="something@gmail.com" class="form-control mt-3" name="email_address">
            <p class="text-danger"><?= $email_addressError ?></p>
            <input type="password" placeholder="your password!" class="form-control mt-3" name="password">
            <p class="text-danger"><?= $passwordError ?></p>
            <input type="submit" value="Login" name="login-btn" class="btn btn-info mt-3">
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>