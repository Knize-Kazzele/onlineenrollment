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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if selected_schedules[] is set
    if (isset($_POST['selected_students'])) {
        // Get the selected schedule IDs
        $selected_students = $_POST['selected_students'];

        $id = $_GET['id'];

        // Iterate over the selected schedule IDs
        foreach ($selected_students as $student) {
            // Insert the schedule into the database (Assuming you have a table named 'student_schedule' to store the relation between students and schedules)
            $sql = "INSERT INTO encodedstudentsubjects (student_id, schedule_id) VALUES (:student_id, :schedule_id)";
            $query = $conn->prepare($sql);
            $query->bindParam(':student_id', $student, PDO::PARAM_INT);
            $query->bindParam(':schedule_id', $id, PDO::PARAM_INT);
            $query->execute();
        }

        // Redirect back to the page with a success message
        header('location:encode_student.php?success=1');
        exit;
    } else {
        // If no schedules were selected, redirect back with an error message
        header('location:encode_student.php?error=no_schedule_selected');
        exit;
    }
} else {
    // If the form was not submitted via POST method, redirect back
    header('location:encode_student.php');
    exit;
}
?>
