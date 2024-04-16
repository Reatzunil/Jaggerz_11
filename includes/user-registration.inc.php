<?php
require_once 'includes/dbh.inc.php';

$message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form data
    $name = isset($_POST["name"]) ? htmlspecialchars($_POST["name"]) : "";
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) ? $_POST["email"] : "";
    $number = isset($_POST["number"]) ? htmlspecialchars($_POST["number"]) : "";
    $availability = isset($_POST["availability"]) ? htmlspecialchars($_POST["availability"]) : "";
    $time = isset($_POST["time"]) ? htmlspecialchars($_POST["time"]) : "";
    $services = isset($_POST["services"]) ? htmlspecialchars($_POST["services"]) : "";
    $image_path = ""; // Initialize to handle file upload separately

    // Check if all required fields are provided
    if (empty($name) || empty($email) || empty($number) || empty($availability) || empty($time) || empty($services)) {
        $message = "Error: Please fill in all required fields.";
    } else {
        // Handle file upload
        if (isset($_FILES["file"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
            $image_name = $_FILES["file"]["name"];
            $target_dir = "uploads/"; // Directory to store uploaded files
            $target_file = $target_dir . basename($image_name);
            $upload_ok = 1;
            $image_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check file size
            if ($_FILES["file"]["size"] > 500000) {
                $message = "Error: File is too large.";
                $upload_ok = 0;
            }
            // Allow certain file formats
            if ($image_type != "jpg" && $image_type != "jpeg" && $image_type != "png") {
                $message = "Error: Only JPG, JPEG, PNG files are allowed.";
                $upload_ok = 0;
            }
            // Check if $upload_ok is set to 0 by an error
            if ($upload_ok == 0) {
                $message = "Error uploading file.";
            } else {
                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    $image_path = $target_file; // Save the file path to use in the database insert
                } else {
                    $message = "Error uploading file.";
                }
            }
        } else {
            $message = "Error uploading file.";
        }

        if (empty($message)) {
            // Prepare and execute SQL statement using prepared statements
            $stmt = $conn->prepare("INSERT INTO reservations (name, email, number, availability, time, services, image_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $name, $email, $number, $availability, $time, $services, $image_path);

            if ($stmt->execute()) {
                $message = "Reservation successfully created.";
            } else {
                $message = "Error: " . $stmt->error;
            }

            // Close prepared statement
            $stmt->close();
        }
    }
}
?>