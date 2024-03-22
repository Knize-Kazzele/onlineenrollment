<?php
// Your database connection logic
include 'config.php';

// Start session and error reporting
session_start();
error_reporting(0);

// Check if the user is logged in
$student_id = $_SESSION['student_id'];
if (!isset($student_id)) {
    header('location:login.php');
    exit; // Stop further execution
}

// Check if the form is submitted
if (isset($_POST['add_registration'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $pob = $_POST['pob'];
    $age = $_POST['age'];
    $father_name = $_POST['father_name'];
    $business_address_father = $_POST['business_address_father'];
    $telephone_father = $_POST['telephone_father'];
    $mother_name = $_POST['mother_name'];
    $business_address_mother = $_POST['business_address_mother'];
    $telephone_mother = $_POST['telephone_mother'];
    $guardian = $_POST['guardian'];
    $previous_school = $_POST['previous_school'];
    $school_address = $_POST['school_address'];

    // Prepare and execute SQL query
    $sql = "INSERT INTO student (name, dob, pob, age, father_name, business_address_father, telephone_father, mother_name, business_address_mother, telephone_mother, guardian, previous_school, school_address) 
            VALUES (:name, :dob, :pob, :age, :father_name, :business_address_father, :telephone_father, :mother_name, :business_address_mother, :telephone_mother, :guardian, :previous_school, :school_address)";
    $query = $conn->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':dob', $dob, PDO::PARAM_STR);
    $query->bindParam(':pob', $pob, PDO::PARAM_STR);
    $query->bindParam(':age', $age, PDO::PARAM_INT);
    $query->bindParam(':father_name', $father_name, PDO::PARAM_STR);
    $query->bindParam(':business_address_father', $business_address_father, PDO::PARAM_STR);
    $query->bindParam(':telephone_father', $telephone_father, PDO::PARAM_STR);
    $query->bindParam(':mother_name', $mother_name, PDO::PARAM_STR);
    $query->bindParam(':business_address_mother', $business_address_mother, PDO::PARAM_STR);
    $query->bindParam(':telephone_mother', $telephone_mother, PDO::PARAM_STR);
    $query->bindParam(':guardian', $guardian, PDO::PARAM_STR);
    $query->bindParam(':previous_school', $previous_school, PDO::PARAM_STR);
    $query->bindParam(':school_address', $school_address, PDO::PARAM_STR);

    if ($query->execute()) {
        $msg = "Student Registered Successfully";
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

    <title>Student</title>
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
            <h1>Student Registration</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Student Registration</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                        <div class="card">
                        <div class="card-body">
                        <div class="container mt-5">
                            <form method="post" name="add_registration" onSubmit="return valid();">
                                <div class="row mb-3">
                                    <div class="col-md-9">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name">
                                    </div>
                                    <div class="col-md-3">
                                    <label for="image" class="form-label">Upload Image</label>
                                    <input type="file" class="form-control" id="image">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                    <label for="dob" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="dob">
                                    </div>
                                    <div class="col-md-6">
                                    <label for="pob" class="form-label">Place of Birth</label>
                                    <input type="text" class="form-control" id="pob">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                    <label for="age" class="form-label">Age</label>
                                    <input type="text" class="form-control" id="age" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                    <label for="father_name" class="form-label">Name of Father</label>
                                    <input type="text" class="form-control" id="father_name">
                                    </div>
                                    <div class="col-md-6">
                                    <label for="business_address_father" class="form-label">Business Address (Father)</label>
                                    <input type="text" class="form-control" id="business_address_father">
                                    </div>
                                    <div class="col-md-6">
                                    <label for="telephone_father" class="form-label">Telephone (Father)</label>
                                    <input type="tel" class="form-control" id="telephone_father">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                    <label for="mother_name" class="form-label">Name of Mother</label>
                                    <input type="text" class="form-control" id="mother_name">
                                    </div>
                                    <div class="col-md-6">
                                    <label for="business_address_mother" class="form-label">Business Address (Mother)</label>
                                    <input type="text" class="form-control" id="business_address_mother">
                                    </div>
                                    <div class="col-md-6">
                                    <label for="telephone_mother" class="form-label">Telephone (Mother)</label>
                                    <input type="tel" class="form-control" id="telephone_mother">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                    <label for="guardian" class="form-label">Guardian (for absent parent/s)</label>
                                    <input type="text" class="form-control" id="guardian">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                    <label for="previous_school" class="form-label">Previous School Attended</label>
                                    <input type="text" class="form-control" id="previous_school">
                                    </div>
                                    <div class="col-md-6">
                                    <label for="school_address" class="form-label">Address of School</label>
                                    <input type="text" class="form-control" id="school_address">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" name="add_registration">Submit</button>
                            </form>
                        </div>
                     </div>
                    </div>   
                        </div>
                     </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->
    <script>
    // Calculate age based on date of birth
    document.getElementById('dob').addEventListener('change', function() {
      var dob = new Date(this.value);
      var today = new Date();
      var age = today.getFullYear() - dob.getFullYear();
      var monthDiff = today.getMonth() - dob.getMonth();
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
        age--;
      }
      document.getElementById('age').value = age;
    });
  </script>


    <?php
    include 'footer.php';
    include 'script.php';
  ?>

</body>

</html>