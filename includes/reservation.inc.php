<?php

require_once 'includes/dbh.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $number = $_POST["number"];
    $availability = $_POST["availability"];
    $time = $_POST["time"];
    $services = $_POST["services"];
    $file_name = $_FILES["file"]["name"];

    // Prepare SQL statement to insert data into the reservations table
    $sql = "INSERT INTO reservations (name, email, number, availability, time, services, file_name)
            VALUES ('$name', '$email', '$number', '$availability', '$time', '$services', '$file_name')";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        echo "Reservation successfully created.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
