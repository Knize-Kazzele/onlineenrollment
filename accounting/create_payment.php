<?php
include 'config.php';

session_start();
error_reporting(0);
$accounting_id = $_SESSION['accounting_id'];

if(!isset($accounting_id)) {
    header('location:login.php');
} else {
    if(isset($_POST['add_payment'])) {
        // Database connection assumed to be established in config.php
        $grade_level = $_POST['grade_level'];
        $upon_enrollment = $_POST['upon_enrollment'];
        $tuition_june_to_march = $_POST['tuition_june_to_march'];
        $partial_upon = $_POST['partial_upon'];
        $total_whole_year = $_POST['total_whole_year'];
        $pe_uniform = $_POST['pe_uniform'];
        $books = $_POST['books'];
        $school_uniform = $_POST['school_uniform'];
        
        $sql = "INSERT INTO payments (grade_level, upon_enrollment, tuition_june_to_march, partial_upon, total_whole_year, pe_uniform, books, school_uniform) 
                VALUES (:grade_level, :upon_enrollment, :tuition_june_to_march, :partial_upon, :total_whole_year, :pe_uniform, :books, :school_uniform)";
        $query = $conn->prepare($sql);
        $query->bindParam(':grade_level', $grade_level, PDO::PARAM_STR);
        $query->bindParam(':upon_enrollment', $upon_enrollment, PDO::PARAM_STR);
        $query->bindParam(':tuition_june_to_march', $tuition_june_to_march, PDO::PARAM_STR);
        $query->bindParam(':partial_upon', $partial_upon, PDO::PARAM_STR);
        $query->bindParam(':total_whole_year', $total_whole_year, PDO::PARAM_STR);
        $query->bindParam(':pe_uniform', $pe_uniform, PDO::PARAM_STR);
        $query->bindParam(':books', $books, PDO::PARAM_STR);
        $query->bindParam(':school_uniform', $school_uniform, PDO::PARAM_STR);
        
        if($query->execute()) {
            $msg = "Payment Added Successfully";
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

<div class="card">
            <div class="card-body">
              <h5 class="card-title"></h5>

              <form class="row g-3"  method="post" name="add_payment" onSubmit="return valid();">
              <?php if($error){?>
                                <div class="alert alert-danger" role="alert">
                                    <strong>ERROR</strong>: <?php echo htmlentities($error); ?>
                                </div>
                                <?php } else if($msg){?>
                                <div class="alert alert-success" role="alert">
                                    <strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?>
                                </div>
                                <?php }?>
                                <div class="row mb-3">
    <label for="grade_level" class="col-sm-2 col-form-label">Grade Level</label>
    <div class="col-md-4">
        <select class="form-select" id="grade_level" name="grade_level">
            <option value="1">Grade 1</option>
            <option value="2">Grade 2</option>
            <!-- Add more options for other grade levels -->
        </select>
    </div>
    <label for="upon_enrollment" class="col-sm-2 col-form-label">Upon Enrollment</label>
    <div class="col-md-4">
        <input type="number" class="form-control" id="upon_enrollment" name="upon_enrollment">
        <ul>
  <li>Miscellaneous</li>
  <li>ID / Test Paper</li>
  <li>Card</li>
  <li>Developmental</li>
  <li>Computer Basic</li>
  <li>Laboratory / Library</li>
</ul>  
    </div>
</div>

                                <div class="row mb-3">
    <label for="tuition_june_to_march" class="col-sm-2 col-form-label">Tuition June to March</label>
    <div class="col-md-4">
        <input type="number" class="form-control" id="tuition_june_to_march" name="tuition_june_to_march">
    </div>
    <label for="partial_upon" class="col-sm-2 col-form-label">Partial Upon</label>
    <div class="col-md-4">
        <input type="number" class="form-control" id="partial_upon" name="partial_upon">
    </div>
</div>

<div class="row mb-3">
    <label for="total_whole_year" class="col-sm-2 col-form-label">Total Whole Year w/o Books</label>
    <div class="col-md-4">
        <input type="number" class="form-control" id="total_whole_year" name="total_whole_year">
    </div>
    <label for="pe_uniform" class="col-sm-2 col-form-label">P.E Uniform</label>
    <div class="col-md-4">
        <input type="number" class="form-control" id="pe_uniform" name="pe_uniform">
    </div>
</div>

<div class="row mb-3">
    <label for="books" class="col-sm-2 col-form-label">Books</label>
    <div class="col-md-4">
        <input type="number" class="form-control" id="books" name="books">
    </div>
    <label for="school_uniform" class="col-sm-2 col-form-label">School Uniform</label>
    <div class="col-md-4">
        <input type="number" class="form-control" id="school_uniform" name="school_uniform">
    </div>
</div>
<div class="text-center">
                        <button type="submit" class="btn btn-primary" name="add_payment">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
              </form><!-- End Horizontal Form -->

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