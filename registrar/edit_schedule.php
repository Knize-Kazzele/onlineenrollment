<?php

include 'config.php';

session_start();
error_reporting(0);
$registrar_id = $_SESSION['registrar_id'];

if(!isset($registrar_id)){
   header('location:login.php');
}
else{
    if(isset($_POST['edit_schedule'])) {
        // You should add your database connection logic here
        // Assuming $conn is your database connection object

        $schedule_id = $_POST['schedule_id']; // Get schedule ID from the form
        $grade_level = $_POST['grade_level'];
        $subject_name = $_POST['subject_name'];
        $teacher_id = $_POST['teacher_id']; // Assuming 'teacher' is the value of teacher's ID
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];

        $sql = "UPDATE schedules 
                SET grade_level = :grade_level, subject_name = :subject_name, teacher_id = :teacher_id, 
                    start_time = :start_time, end_time = :end_time 
                WHERE id = :schedule_id";
        $query = $conn->prepare($sql);
        $query->bindParam(':schedule_id', $schedule_id, PDO::PARAM_INT);
        $query->bindParam(':grade_level', $grade_level, PDO::PARAM_STR);
        $query->bindParam(':subject_name', $subject_name, PDO::PARAM_STR);
        $query->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
        $query->bindParam(':start_time', $start_time, PDO::PARAM_STR);
        $query->bindParam(':end_time', $end_time, PDO::PARAM_STR);
        
        if($query->execute()) {
            $msg = "Schedule Updated Successfully";
        } else {
            $error = "Something went wrong. Please try again";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <?php include 'asset.php';?>

</head>


<body>

<?php 
    include 'header.php';
    include 'sidebar.php';

    // Fetch schedule details for editing
    if(isset($_GET['id'])) {
        $schedule_id = $_GET['id'];
        $sql = "SELECT * FROM schedules WHERE id = :schedule_id";
        $query = $conn->prepare($sql);
        $query->bindParam(':schedule_id', $schedule_id, PDO::PARAM_INT);
        $query->execute();
        $schedule = $query->fetch(PDO::FETCH_ASSOC);
    }
?>

<main id="main" class="main">
    <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit Schedule</h5>

                <form class="row g-3"  method="post" name="edit_schedule">
                    <?php if(isset($error)){?>
                        <div class="alert alert-danger" role="alert">
                            <strong>ERROR</strong>: <?php echo htmlentities($error); ?>
                        </div>
                    <?php } else if(isset($msg)){?>
                        <div class="alert alert-success" role="alert">
                            <strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?>
                        </div>
                    <?php }?>
                    <input type="hidden" name="schedule_id" value="<?php echo $schedule['id']; ?>">
                    <div class="col-md-12">
                        <input type="text" class="form-control" placeholder="Grade Level" name="grade_level" value="<?php echo $schedule['grade_level']; ?>">
                    </div>
                    <div class="col-md-12">
                        <input type="text" class="form-control" placeholder="Subject Name" name="subject_name" value="<?php echo $schedule['subject_name']; ?>">
                    </div>
                    <div class="col-md-12">
                        <select id="teacher" class="form-select" name="teacher_id" required>
                            <option selected>Select Teacher</option>
                            <?php
                                // Assuming you have a table named 'users' with 'role' column as 'teacher'
                                $sql = "SELECT * FROM users WHERE role = 'teacher'";
                                $result = $conn->query($sql);
                                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = ($row['id'] == $schedule['teacher_id']) ? "selected" : "";
                                    echo "<option value='" . $row['id'] . "' $selected>" . $row['first_name'] . " " . $row['last_name'] . "</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" value="<?php echo $schedule['start_time']; ?>" required>
                    </div>
                    <div class="col-md-12">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" value="<?php echo $schedule['end_time']; ?>" required>
                    </div>
                    
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" name="edit_schedule">Update</button>
                        <a href="schedule.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            
                </div>
        </div>
            </div>
        </div>
    </div>
</main><!-- End #main -->


<?php
    include 'footer.php';
    include 'script.php';
?>

</body>

</html>
<?php } ?>
