<?php

$hostname = "127.0.0.1"; // this is the hostname that you can find in the PhpMyAdmin and you can write "localhost" too
$username = "root"; // be default the userName for the databases is root
$password = ""; // by default there is no password in the databases
$dbname = "car_rental"; // here we need to write the Database name

$conn = mysqli_connect($hostname, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function cleanInput($input)
{
    $data = trim($input);
    $data = strip_tags($data);
    $data = htmlspecialchars($data);

    return $data;
}
