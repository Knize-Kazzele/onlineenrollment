<?php

include 'config.php';

session_start();

$accounting_id = $_SESSION['accounting_id'];

if(!isset($accounting_id)){
   header('location:login.php');
   exit; // Add exit to stop further execution
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Accounting</title>
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
            <h1>Installment</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Installment</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"></h5>
                            <?php
// Check if the 'deleted' parameter is set and equals to 1
if(isset($_GET['deleted']) && $_GET['deleted'] == 1){
    echo "<div class='alert alert-success'>Record deleted successfully.</div>";
}
?>
                        </div>
                        <?php
                    // Include config file
                    require_once "config1.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM transactions where payment_type= 'installment'";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table datatable">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Reference No.</th>";
                                        echo "<th>Payment Method</th>";
                                        echo "<th>Payment Amount</th>";
                                        echo "<th>Payment Date</th>";
                                        echo "<th>Status</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                       
                                    echo "<td>" .$row['reference_number']."</td>";
                                    echo "<td>" . $row['payment_method'] . "</td>";
                                    echo "<td>" .'₱'.''. $row["payment_amount"] . "</td>";
                                    echo "<td>". $row["created_at"] . "</td>";
                                    echo "<td>";
                                        if ($row["status"] == 0) {
                                            echo '<span class="badge bg-warning text-dark">Not yet verified</span>';
                                        } else {
                                            echo '<span class="badge bg-success text-dark">Verified</span>';
                                        }
                                    echo "</td>";
                                        echo "<td>";
                                            echo '<a href="read.php?id='. $row['payment_id'] .'" class="r-2" title="View Record" data-toggle="tooltip"><span class="bi bi-eye-fill"></span></a>';
                                            echo '<a href="edit_payment.php?id='. $row['payment_id'] .'" class="m-2" title="Update Record" data-toggle="tooltip"><span class="bi bi-pencil-fill"></span></a>';
                                            echo '<a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal'.$row['payment_id'].'" title="Delete Record" data-toggle="tooltip"><span class="bi bi-trash-fill"></span></a>';
                                            
                                            // Delete Modal
                                            echo '
                                            <div class="modal fade" id="deleteModal'.$row['payment_id'].'" tabindex="-1" aria-labelledby="deleteModalLabel'.$row['payment_id'].'" aria-hidden="true">
                                              <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel'.$row['payment_id'].'">Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                  </div>
                                                  <div class="modal-body">
                                                    Are you sure you want to delete this record?
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <a href="delete.php?id='.$row['payment_id'].'" class="btn btn-danger">Delete</a>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>';
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
 
                    // Close connection
                    mysqli_close($link);
                    ?>

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