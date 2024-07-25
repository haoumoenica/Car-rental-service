<?php
session_start();

if (isset($_SESSION["user"])) {
}

require_once "connection.php";
require_once "file_upload.php";

$error = false;
$first_name = $last_name = $dob = $picture = $email_address = $password = '';
$first_nameError = $last_nameError = $dobError = $pictureError = $email_addressError = $passwordError = '';

if (isset($_POST['btn-signup'])) {

    $first_name = cleanInput($_POST['first_name']);
    $last_name = cleanInput($_POST['last_name']);
    $dob = cleanInput($_POST['dob']);
    $email_address = cleanInput($_POST['email_address']);
    $password = cleanInput($_POST['password']);
    $picture = fileUpload($_FILES['picture']);

    if (empty($first_name)) {
        $error = true;
        $first_nameError = "First Name can't be empty!";
    } elseif (strlen($first_name) < 3) {
        $error = true;
        $first_nameError = "First Name can't be less than 2 characters!";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $first_name)) {
        $error = true;
        $first_nameError = "First Name must contain only letters and spaces!";
    }

    if (empty($last_name)) {
        $error = true;
        $last_nameError = "Last Name can't be empty!";
    } elseif (strlen($last_name) < 3) {
        $error = true;
        $last_nameError = "Last Name can't be less than 2 characters!";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $last_name)) {
        $error = true;
        $last_nameError = "Last Name must contain only letters and spaces!";
    }

    if (empty($dob)) {
        $error = true;
        $dobError = "Date of birth can't be empty!";
    }

    if (empty($email_address)) {
        $error = true;
        $email_addressError = "Email is required!";
    } elseif (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $email_addressError = "Please type a valid email!";
    } else {
        $searchIfEmailExists = "SELECT email_address FROM users WHERE email_address = '$email_address'";
        $result = mysqli_query($conn, $searchIfEmailExists);
        if (mysqli_num_rows($result) != 0) {
            $error = true;
            $email_addressError = "Email already exists!";
        }
    }

    if (empty($password)) {
        $error = true;
        $passwordError = "Password can't be empty!";
    } elseif (strlen($password) < 6) {
        $error = true;
        $passwordError = "Password can't be less than 6 characters";
    }

    if (!$error) {
        $password = hash('sha256', $password);

        $sql = "INSERT INTO `users`(`first_name`, `last_name`, `dob`, `picture`, `email_address`, `password`) VALUES ('$first_name','$last_name','$dob','$picture[0]','$email_address','$password')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "  <div class='alert alert-success' role='alert'>
                        Congratulations, you have successfully created your profile!
                    </div>";
        } else
            echo "Error!";

        header("refresh: 3; url= login.php");
    }
}
// if (isset($_POST['btn-signup'])) {
//     $first_name = trim($_POST['first_name']);
//     $first_name = strip_tags($first_name);
//     $first_name = htmlspecialchars($first_name);

//     $last_name = trim($_POST['last_name']);
//     $last_name = strip_tags($last_name);
//     $last_name = htmlspecialchars($last_name);

//     $dob = trim($_POST['dob']);
//     $dob = strip_tags($dob);
//     $dob = htmlspecialchars($dob);

//     $email_address = trim($_POST['email_address']);
//     $email_address = strip_tags($email_address);
//     $email_address = htmlspecialchars($email_address);

//     $picture = fileUpload($_FILES['picture']);
// }


// $sql = "SELECT * FROM users";

// $result = mysqli_query($conn, $sql);


?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>

    <div class="container mt-5">
        <h2 class="mb-3">Registration Form</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data" method="POST">
            <div class="mb-3">
                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $first_name ?>">
                <p class="text-danger"><?= $first_nameError ?></p>
            </div>
            <div class="mb-3">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $last_name ?>">
                <p class="text-danger"><?= $last_nameError ?></p>
            </div>
            <div class="mb-3">
                <label for="dob">Date of Birth:</label>
                <input type="date" class="form-control" id="dob" name="dob" value="<?= $dob ?>">
                <p class="text-danger"><?= $dobError ?></p>

            </div>
            <div class="mb-3">
                <label for="picture">Picture:</label>
                <input type="file" class="form-control" id="picture" name="picture">
            </div>
            <div class="mb-3">
                <label for="email_address">Email Address:</label>
                <input type="email" class="form-control" id="email_address" name="email_address" value="<?= $email_address ?>">
            </div>
            <p class="text-danger"><?= $email_addressError ?></p>
            <div class="mb-3">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password">
                <p class="text-danger"><?= $passwordError ?></p>
            </div>
            <div class="mb-3">
                <label for="rpassword">Repeat your password:</label>
                <input type="password" class="form-control" id="rpassword" name="rpassword">
                <p class="text-danger"><?= $passwordError ?></p>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-success" name="btn-signup">Register</button>
            </div>
        </form>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>