<?php
// Get the ID from the URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Database connection parameters
$servername = "localhost"; // Your MySQL server
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "enrollment"; // Your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement with a placeholder for the ID
$sql = "SELECT * FROM generatedcor 
INNER JOIN student ON generatedcor.userId = student.student_id 
INNER JOIN gradelevel on student.grade_level = gradelevel.gradelevel_id
INNER JOIN transactions on student.student_id = transactions.user_id
WHERE generatedcor.id = ? AND status = 1 ";

// Prepare and bind parameter
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id); // Assuming ID is a string

// Execute query
$stmt->execute();

// Get result
$result = $stmt->get_result();

// Check if result has rows
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        // Display student information
        $student_name = $row["name"];
        $grade = $row["gradelevel_name"];
        $date = $row["created_at"];
        $formatted_date = date("jS \d\a\y \of F, Y", strtotime($date));
        // Add more fields as needed
    }
} else {
    // No student found with the provided ID
    $student_name = "N/A";
    $grade = "N/A";
}

// Close statement and database connection
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Certification of Registration</title>
<style>
  body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
  }
  .container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
  }
  .address {
    text-align: center;
    margin-bottom: 20px;
  }
  .certification {
    text-indent: 80px;
    text-align: justify;
  }
  .logo {
    float: left;
    margin-left: -50px;
    margin-right: 10px;
    max-width: 100px; /* adjust size as needed */
  }
  .signature {
    float: right;
    margin-left: 10px;
    max-width: 140px; /* adjust size as needed */
  }
   /* Style for print button container */
   .print-button-container {
    position: absolute;
    top: 20px;
    left: 20px;
  }
  /* Style for the print button */
  .print-button {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
  }
  .print-button:hover {
    background-color: #0056b3;
  }
  /* Hide print button when printing */
  @media print {
    .print-button-container {
      display: none;
    }
  }
</style>
</head>
<body>
  <div class="container">
    <center>
    <img src="../images/logo.png" alt="Logo" class="logo">
    <h3>EASTERN ACHIEVER ACADEMY OF TAGUIG INC.</h3>
    <h4>Blk 2 L-23 Ph.1 Pinagsama Village Taguig City</h4>
    </center>
  </div>

  <div class="container">
    <center>
    <h4>CERTIFICATION OF REGISTRATION</h4>
  </center>
  </div>

  <div class="container">
    <p class="certification">
      This is to certify that <?php echo $student_name; ?> with is officially enrolled in <?php echo $grade; ?> at Eastern Achiever Academy of Taguig Inc. 
      School Year 2024-2025 for blended learning Online from August to October. 
      Fully face-to-face from November to the end of SY 2024-2025.
    </p>
    <br>
    <p class="certification">
      This certification is issued for whatever purpose this may serve.
    </p>
    <br>
    <p class="certification">
      Issued on this <?php echo $formatted_date; ?> at Eastern Achiever Academy of Taguig Inc
    </p>
  </div>

  <div class="container">
    <img src="../images/signature.png" alt="Logo" class="signature">
  </div>

  <div class="print-button-container">
    <button class="print-button" onclick="window.print()">Print</button>
  </div>

</body>
</html>
