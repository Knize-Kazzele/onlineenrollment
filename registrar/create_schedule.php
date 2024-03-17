<?php

include 'config.php';

session_start();
error_reporting(0);
$registrar_id = $_SESSION['registrar_id'];

if(!isset($registrar_id)){
   header('location:login.php');
}
else{
    if(isset($_POST['add_schedule'])) {
        // You should add your database connection logic here
        // Assuming $conn is your database connection object

        $grade_level = $_POST['grade_level'];
        $subject_name = $_POST['subject_name'];
        $teacher_id = $_POST['teacher']; // Assuming 'teacher' is the value of teacher's ID
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];

        $sql = "INSERT INTO schedules (grade_level, subject_name, teacher_id, start_time, end_time) 
                VALUES (:grade_level, :subject_name, :teacher_id, :start_time, :end_time)";
        $query = $conn->prepare($sql);
        $query->bindParam(':grade_level', $grade_level, PDO::PARAM_STR);
        $query->bindParam(':subject_name', $subject_name, PDO::PARAM_STR);
        $query->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
        $query->bindParam(':start_time', $start_time, PDO::PARAM_STR);
        $query->bindParam(':end_time', $end_time, PDO::PARAM_STR);
        
        if($query->execute()) {
            $msg = "Schedule Added Successfully";
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
?>

<main id="main" class="main">

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Create Schedule</h5>

            <form class="row g-3" method="post" name="add_schedule">
              <?php if($error){?>
                <div class="alert alert-danger" role="alert">
                  <strong>ERROR</strong>: <?php echo htmlentities($error); ?>
                </div>
              <?php } else if($msg){?>
                <div class="alert alert-success" role="alert">
                  <strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?>
                </div>
              <?php }?>
              <div class="col-md-12">
                <input type="text" class="form-control" placeholder="Grade Level" name="grade_level" required>
              </div>
              <div class="col-md-12">
                <input type="text" class="form-control" placeholder="Subject Name" name="subject_name" required>
              </div>
              <div class="col-md-12">
                <select id="teacher" class="form-select" name="teacher" required>
                  <option selected>Select Teacher</option>
                  <?php
                    // Assuming you have a table named 'users' with 'role' column as 'teacher'
                    $sql = "SELECT * FROM users WHERE role = 'teacher'";
                    $result = $conn->query($sql);
                    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['first_name'] . " " . $row['last_name'] . "</option>";
                    }
                  ?>
                </select>
              </div>
              <div class="col-md-12">
                <label for="start_time" class="form-label">Start Time</label>
                <input type="time" class="form-control" id="start_time" name="start_time" required>
              </div>
              <div class="col-md-12">
                <label for="end_time" class="form-label">End Time</label>
                <input type="time" class="form-control" id="end_time" name="end_time" required>
              </div>

              <div class="text-center">
                <button type="submit" class="btn btn-primary" name="add_schedule">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

</main>

<?php
    include 'footer.php';
    include 'script.php';
?>

</body>

</html>
<?php } ?>
