<?php
// Your database connection logic
include 'config.php';

// Start session and error reporting
session_start();
error_reporting(E_ALL);

// Check if the user is logged in
$registrar_id = $_SESSION['registrar_id'];
if (!isset($registrar_id)) {
    header('location:login.php');
    exit; // Stop further execution
}
else {
    $error = ""; // Initialize $error variable
    $msg = ""; // Initialize $error variable
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Registrar</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <?php include 'asset.php';?>

</head>

<body>

    <?php 
    include 'header.php';
    include 'sidebar.php';
    // Fetch user details for editing
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM student WHERE student_id = :id";
        $query = $conn->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $student = $query->fetch(PDO::FETCH_ASSOC);
    }
?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Student Schedule & Subject</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Student Schedule & Subject</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                        
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->
    
    <?php
    include 'footer.php';
    include 'script.php';
  ?>

</body>

</html>