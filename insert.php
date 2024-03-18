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


// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO students (lrn, last_name, first_name, middle_name, extension_name, birthday, place_of_birth, sex, age, mother_tongue, house_no, street_name, barangay, municipality_city, province, country, zip_code, father_last_name, father_first_name, father_middle_name, father_contact_number, mother_last_name, mother_first_name, mother_middle_name, mother_contact_number, guardian_last_name, guardian_first_name, guardian_middle_name, guardian_contact_number, grade_level) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if ($stmt === false) {
    die('Error preparing statement: ' . $conn->error);
}

// Bind parameters
$stmt->bind_param("ssssssssisssssssssssssssssssss", $lrn, $last_name, $first_name, $middle_name, $extension_name, $birthday, $place_of_birth, $sex, $age, $mother_tongue, $house_no, $street_name, $barangay, $municipality_city, $province, $country, $zip_code, $father_last_name, $father_first_name, $father_middle_name, $father_contact_number, $mother_last_name, $mother_first_name, $mother_middle_name, $mother_contact_number, $guardian_last_name, $guardian_first_name, $guardian_middle_name, $guardian_contact_number, $grade_level);

if ($stmt === false) {
    die('Error binding parameters: ' . $stmt->error);
}

// Set parameters
$lrn = $_POST['lrn'];
$last_name = $_POST['last_name'];
$first_name = $_POST['first_name'];
$middle_name = $_POST['middle_name'];
$extension_name = $_POST['extension_name'];
$birthday = $_POST['birthday'];
$place_of_birth = $_POST['place_of_birth'];
$sex = $_POST['sex'];
$age = $_POST['age'];
$grade_level = $_POST['grade_level'];
$mother_tongue = $_POST['mother_tongue'];
$house_no = $_POST['house_no'];
$street_name = $_POST['street_name'];
$barangay = $_POST['barangay'];
$municipality_city = $_POST['municipality_city'];
$province = $_POST['province'];
$country = $_POST['country'];
$zip_code = $_POST['zip_code'];
$father_last_name = $_POST['father_last_name'];
$father_first_name = $_POST['father_first_name'];
$father_middle_name = $_POST['father_middle_name'];
$father_contact_number = $_POST['father_contact_number'];
$mother_last_name = $_POST['mother_last_name'];
$mother_first_name = $_POST['mother_first_name'];
$mother_middle_name = $_POST['mother_middle_name'];
$mother_contact_number = $_POST['mother_contact_number'];
$guardian_last_name = $_POST['guardian_last_name'];
$guardian_first_name = $_POST['guardian_first_name'];
$guardian_middle_name = $_POST['guardian_middle_name'];
$guardian_contact_number = $_POST['guardian_contact_number'];

// Execute statement
$result = $stmt->execute();

if ($result) {
    // Records inserted successfully
    echo "New records created successfully";
} else {
    // Handle error
    $_SESSION['error_message'] = "Error executing statement: " . $stmt->error;
}

echo "New records created successfully";

// Close statement and connection
$stmt->close();
$conn->close();

// Redirect back to the form page
header("Location: admission.php");
exit();
?>
