<?php
// Your database connection logic
include 'config.php';

// Start session and error reporting
session_start();
error_reporting(E_ALL);

// Check if the user is logged in
$parent_id = $_SESSION['parent_id'];
if (!isset($parent_id)) {
    header('location:login.php');
    exit; // Stop further execution
}
else {
    $error = ""; // Initialize $error variable
    $msg = ""; // Initialize $error variable
    // Check if the form is submitted
    if (isset($_POST['add_registration'])) {
        // Retrieve form data
        $sname = $_POST['sname'];
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
        $grade_level = $_POST['grade_level']; // Add this line to retrieve grade level
        $requirements = $_FILES['requirements']; // Add this line to retrieve requirements

        // File upload handling
        $uploaded_files = [];
        $file_count = count($_FILES['requirements']['name']);
        for ($i = 0; $i < $file_count; $i++) {
            $file_name = $_FILES['requirements']['name'][$i];
            $file_tmp = $_FILES['requirements']['tmp_name'][$i];
            $destination = '../uploads/' . $file_name;
            if (move_uploaded_file($file_tmp, $destination)) {
                $uploaded_files[] = $destination;
            } else {
                $error = "Failed to move uploaded file: $file_name";
            }
        }

        // Prepare and execute SQL query
        $sql = "INSERT INTO student (userId, name, dob, pob, age, father_name, business_address_father, telephone_father, mother_name, business_address_mother, telephone_mother, guardian, previous_school, school_address, grade_level, requirements, isVerified) 
        VALUES (:parent_id, :sname, :dob, :pob, :age, :father_name, :business_address_father, :telephone_father, :mother_name, :business_address_mother, :telephone_mother, :guardian, :previous_school, :school_address, :grade_level, :requirements, 0)";
        $query = $conn->prepare($sql);
        $query->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);
        $query->bindParam(':sname', $sname, PDO::PARAM_STR);
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
        $query->bindParam(':grade_level', $grade_level, PDO::PARAM_STR); // Bind grade level
        $query->bindParam(':requirements', json_encode($uploaded_files), PDO::PARAM_STR);

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
                        <div class="container mt-5">
                        <?php if($error){?>
                                <div class="alert alert-danger" role="alert">
                                    <strong>ERROR</strong>: <?php echo htmlentities($error); ?>
                                </div>
                                <?php } else if($msg){?>
                                <div class="alert alert-success" role="alert">
                                    <strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?>
                                </div>
                                <?php }?>
                                <?php
                                $query = $conn->prepare("SELECT * FROM student WHERE userId = :parent_id");
                                $query->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);
                                $query->execute();
                                $count = $query->rowCount();
                                $result = $query->fetch(PDO::FETCH_ASSOC);
                                if ($count > 0) {
                                    if ($result['isVerified'] == 0) {
                                    // User is already registered but not verified, show the message card
                                    ?>
                                        <div class="alert alert-info text-center" style="font-size: 22px;">
                                        Thank you for your submission. We have received your registration.<br> 
                                        Please be patient as our registrar verifies your information.<br>Once your registration is verified, 
                                        you will receive a confirmation email.<br> If you have any further questions or concerns, please don't hesitate to reach out to us.
                                        </div>


                                        <?php
    } elseif ($result['isVerified'] == 1) {
        // Student is already enrolled
        echo "<div class='alert alert-success text-center' style='font-size: 22px;'>ENROLLED</div>";
    }
} else {
    // User is not registered yet, show the registration form
?>
                                <form method="post" name="add_registration" onSubmit="return valid();" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-9">
            <label for="sname" class="form-label">Name</label>
            <input type="text" class="form-control" id="sname" name="sname">
        </div>
        <div class="col-md-3">
            <label for="image" class="form-label">Upload Image</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="dob" class="form-label">Date of Birth</label>
            <input type="date" class="form-control" id="dob" name="dob">
        </div>
        <div class="col-md-6">
            <label for="pob" class="form-label">Place of Birth</label>
            <input type="text" class="form-control" id="pob" name="pob">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="age" class="form-label">Age</label>
            <input type="text" class="form-control" id="age" name="age" readonly>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="father_name" class="form-label">Name of Father</label>
            <input type="text" class="form-control" id="father_name" name="father_name">
        </div>
        <div class="col-md-6">
            <label for="business_address_father" class="form-label">Business Address (Father)</label>
            <input type="text" class="form-control" id="business_address_father" name="business_address_father">
        </div>
        <div class="col-md-6">
            <label for="telephone_father" class="form-label">Telephone (Father)</label>
            <input type="tel" class="form-control" id="telephone_father" name="telephone_father">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="mother_name" class="form-label">Name of Mother</label>
            <input type="text" class="form-control" id="mother_name" name="mother_name">
        </div>
        <div class="col-md-6">
            <label for="business_address_mother" class="form-label">Business Address (Mother)</label>
            <input type="text" class="form-control" id="business_address_mother" name="business_address_mother">
        </div>
        <div class="col-md-6">
            <label for="telephone_mother" class="form-label">Telephone (Mother)</label>
            <input type="tel" class="form-control" id="telephone_mother" name="telephone_mother">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="guardian" class="form-label">Guardian (for absent parent/s)</label>
            <input type="text" class="form-control" id="guardian" name="guardian">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="previous_school" class="form-label">Previous School Attended</label>
            <input type="text" class="form-control" id="previous_school" name="previous_school">
        </div>
        <div class="col-md-6">
            <label for="school_address" class="form-label">Address of School</label>
            <input type="text" class="form-control" id="school_address" name="school_address">
        </div>
    </div>
    <hr size=8 noshade>
    <div class="row mb-3">
    <div class="col-md-6">
        <label for="grade_level" class="form-label">Grade Level</label>
        <select class="form-select" id="grade_level" name="grade_level">
            <option value="1">Grade 1</option>
            <option value="2">Grade 2</option>
            <!-- Add more options for other grade levels -->
        </select>
    </div>
    <div class="col-md-6">
        <label for="requirements" class="form-label">Requirements</label>
        <input type="file" class="form-control" id="requirements" name="requirements[]" multiple>
        <!-- Allow multiple file uploads for requirements -->
    </div>
</div>
<center>
    <button type="submit" class="btn btn-primary" name="add_registration">Submit</button>
</center>
</form>
<?php}?>

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
<?php }} ?>