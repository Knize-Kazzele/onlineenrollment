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

$username = $_POST['username'];
$password = $_POST['password'];
$last_name = $_POST['last_name'];
$first_name = $_POST['first_name'];
$contact_number = $_POST['contact_number'];
$role = $_POST['role'];
$email = $_POST['email'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Execute statement for inserting student records
$result = $stmt->execute();

if ($result) {
    // Records inserted successfully
    echo "New records created successfully";

    // Prepare SQL statement for inserting user credentials into the users table
    $stmt_users = $conn->prepare("INSERT INTO users (username, password, role, last_name, first_name, contact_number, email) VALUES (?, ?, ?, ?, ?, ?, ?)");

    if ($stmt_users === false) {
        die('Error preparing statement for user credentials: ' . $conn->error);
    }

    // Close user credentials statement
    $stmt_users->close();
}


// Close statement and connection
$stmt->close();
$conn->close();

// Redirect back to the form page
header("Location: admission.php");
exit();
?>
