<?php

include 'config.php';

session_start();

$parent_id = $_SESSION['parent_id'];

if(!isset($parent_id)){
   header('location:login.php');
   exit; // Add exit to stop further execution
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Parent</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <?php include 'asset.php';?>

</head>

<body>

    <?php 
    include 'header.php';
    include 'sidebar.php';
?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>School Fees</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">School Fees</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">

            <div class="row">
                <div class="col-lg-8">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"></h5>
                        </div>
                        <?php
                    // Include config file
                    require_once "config1.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT *
                    FROM student
                    INNER JOIN payments on student.grade_level = payments.grade_level 
                    WHERE student.userId = $parent_id";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table datatable">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Grade Level</th>";
                                        
                                        echo "<th>Total Tuition Fee w/o Books</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                       
                                        echo "<td>" .$row['grade_level']."</td>";
                                        echo "<td>" . $row['total_whole_year'] . "</td>";
                                        echo "<td>";
                                            // Button trigger modal
                                            echo '';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 
                 
                    ?>

                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div style="text-align: center;">
                            <?php
// Include config file
require_once "config1.php";

// Attempt select query execution
$sql = "SELECT *
        FROM student
        INNER JOIN payments on student.grade_level = payments.grade_level 
        WHERE student.userId = $parent_id";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_array($result)) {
            echo ' <h5 class="card-title">Balance: ₱'.$row['total_whole_year'].'</h5>';
        }
        // Free result set
        mysqli_free_result($result);
    } else{
        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
    }
} else{
    echo "Oops! Something went wrong. Please try again later.";
}
// Close connection
mysqli_close($link);
?>

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">Make a Payment</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            </div>
        </section>

    </main><!-- End #main -->

    <!-- Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Make a Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <!-- Add payment form here -->
                    <form method="post" action="make_payment.php">
                        <!-- Payment form fields go here -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    include 'footer.php';
    include 'script.php';
  ?>

</body>

</html>
