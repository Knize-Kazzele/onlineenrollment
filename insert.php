<?php

session_start();

// Replace these database credentials with your own
$servername = "localhost";
$username = "root";
$password = "";
$database = "enrollment";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the role based on the student type
$role = "student";

// Prepare SQL statement for inserting student records
$stmt = $conn->prepare("INSERT INTO users (username, password, role, first_name, last_name, contact_number, email) VALUES (?, ?, ?, ?, ?, ?, ?)");

if ($stmt === false) {
    die('Error preparing statement: ' . $conn->error);
}

// Bind parameters for inserting student records
$stmt->bind_param("sssssss", $username, $hashed_password, $role, $first_name, $last_name, $contact_number, $email);

if ($stmt === false) {
    die('Error binding parameters: ' . $stmt->error);
}

$username = isset($_POST['username']) ? $_POST['username'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;
$last_name = $_POST['last_name'];
$first_name = $_POST['first_name'];
$contact_number = $_POST['contact_number'];
$email = $_POST['email'];

if ($password) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
} else {
    $hashed_password = null; // Handle this appropriately based on your requirements
}

// Execute statement for inserting student records
$result = $stmt->execute();

if ($result) {
    echo "New records created successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();

// Redirect back to the form page
header("Location: admission.php");
exit();
?>
