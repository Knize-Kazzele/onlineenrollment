<?php
// Include config file
include_once 'config.php';

// Check if the ID parameter is set and is a valid integer
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    // Prepare an update statement
    $sql = "UPDATE student SET isVerified = 1 WHERE student_id = :student_id";

    if($stmt = $conn->prepare($sql)){
        // Bind parameters
        $stmt->bindParam(":student_id", $param_id, PDO::PARAM_INT);

        // Set parameters
        $param_id = trim($_GET['id']);

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Records updated successfully. Redirect to previous page
            header("location: {$_SERVER['HTTP_REFERER']}?verified=1");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    unset($stmt);
    
    // Close connection
    unset($conn);
} else{
    // ID parameter is missing or invalid. Redirect to error page
    header("location: error.php");
    exit();
}
?>
