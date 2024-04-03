<?php

include 'config1.php';

// Check if form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate input
    $sectionName = $_POST['sectionName'];
    $sectionDescription = $_POST['sectionDescription'];

    // Prepare an insert statement
    $sql = "INSERT INTO sections (section_name, section_description) VALUES (?, ?)";

    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $param_sectionName, $param_sectionDescription);

        // Set parameters
        $param_sectionName = $sectionName;
        $param_sectionDescription = $sectionDescription;

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Redirect to subject management page with success message
            header("location: section.php?added=1");
            exit();
        } else{
            echo "Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>
