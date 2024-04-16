<?php

$servername = "localhost"; // Change to your MySQL server hostname
$username = "id22046528_jagger1"; // Change to your MySQL username
$password = "Jaggerz1@"; // Change to your MySQL password
$dbname = "id22046528_jaggerz";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

?>

/*
$servername = "localhost"; // Change to your MySQL server hostname
$username = "id22046528_jagger1"; // Change to your MySQL username
$password = "Jaggerz1@"; // Change to your MySQL password
$dbname = "id22046528_jaggerz";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$dsn = "mysql:host=localhost;dbname=id22046528_jaggerz";//name of the db
$dbusername = "id22046528_jagger1"; //db username
$dbpassword = "Jaggerz1@";//db password

try {
    
    $pdo = new PDO($dsn, $dbusername, $dbpassword); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) { 
    echo "Connection failed: " . $e->getMessage();
}