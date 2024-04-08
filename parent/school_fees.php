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
                    FROM transactions
                    WHERE user_id = $parent_id;";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table datatable">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Reference No.</th>";
                                        echo "<th>Payment Method</th>";
                                        echo "<th>Payment Type</th>";
                                        echo "<th>Payment Amount</th>";
                                        echo "<th>Payment Date</th>";
                                        echo "<th>Status</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                       
                                        echo "<td>" .$row['reference_number']."</td>";
                                        echo "<td>" . $row['payment_method'] . "</td>";
                                        echo "<td>" . $row['payment_type'] . "</td>";
                                        echo "<td>" .'₱'.''. $row["payment_amount"] . "</td>";
                                        echo "<td>". $row["created_at"] . "</td>";
                                        echo "<td>";
                                            if ($row["status"] == 0) {
                                                echo '<span class="badge bg-warning text-dark">Not yet verified</span>';
                                            } else {
                                                echo '<span class="badge bg-success text-dark">Verified</span>';
                                            }
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
                            <div>
                            <table class="table table-hover">
                   
                    <tbody>
                    
                            <?php
// Include config file
require_once "config1.php";

// Attempt select query execution
$sql = "SELECT *
        FROM student
        INNER JOIN payments on student.grade_level = payments.grade_level 
        WHERE student.userId = $parent_id";
if($result = mysqli_query($link, $sql)){
    // Add your additional query here
    $sql2 = "SELECT *, COUNT(*) AS transaction_count FROM transactions WHERE user_id = $parent_id";
    if($result2 = mysqli_query($link, $sql2)){
        $row2 = mysqli_fetch_assoc($result2);
        $transactionCount = $row2['transaction_count'];
        mysqli_free_result($result2);
    } else {
        echo "Oops! Something went wrong while checking transactions.";
        exit; // Exit if there's an error
    }

    // If there are transactions, disable the button or display a message
    if($transactionCount > 0) {
        echo'<div style="text-align: center; margin-top:30px;">';
        echo '<button type="button" class="btn btn-primary" disabled>Payments Already Made<br>Please proceed to the accounting</button>';
        echo'</div>';
    } else {
       
    
    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_array($result)) {

                        echo'<tr>';
                        echo'<td class="col-md-9"><em>Total Tuition Fee:</em></h4></td>';
                        echo'<td>   </td>'; 
                        echo'<td>   </td>';
                        echo'<td class="col-md-1 text-center">₱'.$row['total_whole_year'].'</td>';
                        echo'</tr>';
                        
                        echo'<tr>';
                        echo'<td class="col-md-9"><em>Book Fee:</em></h4></td>';
                        echo'<td>   </td>'; 
                        echo'<td>   </td>';
                        echo'<td class="col-md-1 text-center">₱'.$row['books'].'</td>';
                        echo'</tr>';

                        echo'<tr>';
                        echo'<td class="col-md-9"><em>School Uniform Fee:</em></h4></td>';
                        echo'<td>   </td>'; 
                        echo'<td>   </td>';
                        echo'<td class="col-md-1 text-center">₱'.$row['school_uniform'].'</td>';
                        echo'</tr>';

                        echo'<tr>';
                        echo'<td class="col-md-9"><em>P.E Uniform:</em></h4></td>';
                        echo'<td>   </td>'; 
                        echo'<td>   </td>';
                        echo'<td class="col-md-1 text-center">₱'.$row['pe_uniform'].'</td>';
                        echo'</tr>';
                        
                        echo'<tr>';
                            echo'<td>   </td>';
                            echo'<td>   </td>';
                            echo'<td class="text-right"><h4><strong>Total: </strong></h4></td>';
                            $total = $row['total_whole_year'] + $row['books'] + $row['school_uniform'] + $row['pe_uniform'];
                            echo'<td class="text-center text-danger"><h4><strong>₱'.$total.'</strong></h4></td>';
                        echo'</tr>';

                        echo '</tbody>';
                        echo '</table>';

                        echo'<div style="text-align: center;">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">Make a Payment</button>
                        </div>';
                        
        }
        // Free result set
        mysqli_free_result($result);
    } else{
        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
    }
}
} else{
    echo "Oops! Something went wrong. Please try again later.";
}
// Close connection

?>                          
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
                <!-- Payment form -->
                <!-- Payment form -->
            <!-- Payment form -->
<form id="paymentForm" method="post" action="make_payment.php" enctype="multipart/form-data">
<div class="mb-3">
    <label for="payment_type" class="form-label">Payment Type</label>
    <select class="form-select" id="payment_type" name="payment_type">
        <option value="cash">Cash</option>
        <option value="installment">Installment</option>
    </select>
</div>
    <div class="mb-3">
        <label for="payment_amount" class="form-label">Payment Amount</label>
        <input type="text" class="form-control" id="payment_amount" name="payment_amount" required>
    </div>
    <div class="mb-3">
    <label class="form-label">Payment Method</label>
    <div class="form-check">
        <div style="display: inline-block; margin-right: 20px;">
            <label class="form-check-label" for="payment_method_cash">
                <img src="../images/cash_icon.png" alt="Cash Icon" class="payment-icon" style="width: 75px; height: 65px; vertical-align: middle; margin-right: 5px;">
            </label>
            <input class="form-check-input" type="radio" name="payment_method" id="payment_method_cash" value="Cash" checked>
        </div>
        <div style="display: inline-block;">
            <label class="form-check-label" for="payment_method_gcash">
                <img src="../images/gcash_icon.png" alt="GCash Icon" class="payment-icon" style="width: 200px; height: 65px; vertical-align: middle; margin-right: 5px;">
            </label>
            <input class="form-check-input" type="radio" name="payment_method" id="payment_method_gcash" value="GCash">
        </div>
    </div>
</div>

<div id="additionalFields" class="mb-3" style="display: none;">

    <div class="mb-3" style="text-align: center;">
        <img id="uploadedImage" src="../images/gcash.png" alt="gcash qr">
    </div>
    <!-- Additional fields for GCash payment method -->
    <div class="mb-3">
        <label for="gcash_number" class="form-label">GCash Number</label>
        <input type="text" class="form-control" id="gcash_number" name="gcash_number">
    </div>
    <div class="mb-3">
        <label for="reference_number" class="form-label">Reference Number</label>
        <input type="text" class="form-control" id="reference_number" name="reference_number">
    </div>
    <div class="mb-3">
        <label for="screenshot" class="form-label">Upload Screenshot</label>
        <input type="file" class="form-control" id="screenshot" name="screenshot">
    </div>
    <!-- Add more input fields as needed -->
</div>
    <!-- Add more fields as needed -->
    <button type="submit" class="btn btn-primary">Make Payment</button>
</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php

require_once "config1.php";

// Attempt select query execution
$sql = "SELECT *
        FROM student
        INNER JOIN payments on student.grade_level = payments.grade_level 
        WHERE student.userId = $parent_id";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_array($result)) {
            $balance = $row['total_whole_year'] + $row['books'] + $row['school_uniform'] + $row['pe_uniform'];
            $installment_balance = $row['upon_enrollment'];
        }
        // Free result set
        mysqli_free_result($result);
    } else{
        $installment_balance = $row['upon_enrollment'];
    }
} else{
    echo "Oops! Something went wrong. Please try again later.";
}
// Close connection
mysqli_close($link);
?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var paymentTypeSelect = document.getElementById("payment_type");
    var paymentAmountInput = document.getElementById("payment_amount");
    var balance = <?php echo json_encode($balance); ?>; 
    var installment_balance = <?php echo json_encode($installment_balance); ?>; // Assigning the balance to JavaScript variable

    var cashRadio = document.getElementById("payment_method_cash");
    var gcashRadio = document.getElementById("payment_method_gcash");
    var additionalFieldsDiv = document.getElementById("additionalFields");

    // Set initial state based on default selection
    if (cashRadio.checked) {
        additionalFieldsDiv.style.display = 'none';
    } else if (gcashRadio.checked) {
        additionalFieldsDiv.style.display = 'block';
    }

    // Add event listeners to radio buttons to toggle additional fields
    cashRadio.addEventListener("change", function() {
        additionalFieldsDiv.style.display = 'none';
    });

    gcashRadio.addEventListener("change", function() {
        additionalFieldsDiv.style.display = 'block';
    });

    // Function to update payment amount based on payment type
    function updatePaymentAmount() {
        var selectedPaymentType = paymentTypeSelect.value;
        if (selectedPaymentType === 'cash') {
            // Set payment amount to the current balance
            paymentAmountInput.value = balance;
        } else if(selectedPaymentType === 'installment') {
            // Allow user to input payment amount manually
            paymentAmountInput.value = installment_balance;
        }
        else{
            paymentAmountInput.value='';
        }
    }

    // Set initial state based on default selection
    updatePaymentAmount();

    // Add event listener to payment type select
    paymentTypeSelect.addEventListener("change", updatePaymentAmount);
});
</script>





    <?php

    include 'script.php';
  ?>

</body>

</html>
