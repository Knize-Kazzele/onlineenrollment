<?php
// Your database connection logic
include 'config.php';

// Start session and error reporting
session_start();
error_reporting(E_ALL);

// Check if the user is logged in
$student_id = $_SESSION['student_id'];
if (!isset($student_id)) {
    header('location:login.php');
    exit; // Stop further execution
}
else {
    $error = ""; // Initialize $error variable
    $msg = ""; // Initialize $error variable
    // Fetch user information from the 'users' table
    $query = $conn->prepare("SELECT * FROM users WHERE id = :student_id");
    $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    $full_name = isset($user['first_name']) ? $user['first_name'] : '';
    $full_name .= isset($user['last_name']) ? ' ' . $user['last_name'] : '';

    if ($user['role'] == 'student') {
        $student_email = isset($user['email']) ? $user['email'] : '';
    } else {
        // No action needed in this case
        echo ""; // Blank echo
    }

    // Check if the form is submitted
    if (isset($_POST['add_registration'])) {
        // Retrieve form data
        $sname = $_POST['sname'];
        $dob = $_POST['dob'];
        $pob = $_POST['pob'];
        $email = $_POST['email'];        
        $age = $_POST['age'];
        $address = $_POST['address'];
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
        $image = $_FILES['image']; // Retrieve uploaded image

        // File upload handling for image
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_destination = '../uploads/images/' . $image_name;
        if (move_uploaded_file($image_tmp, $image_destination)) {
            $uploaded_image_path = $image_destination;
        } else {
            $error = "Failed to move uploaded image file: $image_name";
        }

        // File upload handling
        $uploaded_files = [];
        $file_count = count($_FILES['requirements']['name']);
        $allowed_extensions = array('pdf'); // Specify allowed file extensions
        for ($i = 0; $i < $file_count; $i++) {
            $file_name = $_FILES['requirements']['name'][$i];
            $file_tmp = $_FILES['requirements']['tmp_name'][$i];
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION)); // Get the file extension
            $destination = '../uploads/' . $file_name;
            if (in_array($file_extension, $allowed_extensions)) {
                if (move_uploaded_file($file_tmp, $destination)) {
                    $uploaded_files[] = $destination;
                } else {
                    $error = "Failed to move uploaded file: $file_name";
                }
            } else {
                $error = "File type not allowed for $file_name. Only PDF files are allowed.";
            }
        }

        // Prepare and execute SQL query
        $sql = "INSERT INTO student (userId, name, dob, pob, email, age, address, father_name, business_address_father, telephone_father, mother_name, business_address_mother, telephone_mother, guardian, previous_school, school_address, grade_level, requirements, image_path, isVerified) 
        VALUES (:student_id, :sname, :dob, :pob, :email, :age, :address, :father_name, :business_address_father, :telephone_father, :mother_name, :business_address_mother, :telephone_mother, :guardian, :previous_school, :school_address, :grade_level, :requirements, :image_path, 0)";
        $query = $conn->prepare($sql);
        $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $query->bindParam(':sname', $sname, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query->bindParam(':pob', $pob, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':age', $age, PDO::PARAM_INT);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
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
        $query->bindParam(':image_path', $uploaded_image_path, PDO::PARAM_STR); // Add this line to bind image path

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
                                $query = $conn->prepare("SELECT * FROM student WHERE userId = :student_id");
                                $query->bindParam(':student_id', $student_id, PDO::PARAM_INT);
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
        echo "<div class='alert alert-success text-center' style='font-size: 22px;'>Verified. <br><a href='school_fees.php'>Click here to proceed to payment.</a></div>";
    }
} else {
    // User is not registered yet, show the registration form
?>
                                <form method="post" name="add_registration" onSubmit="return valid();" enctype="multipart/form-data">
                                <div class="row mb-3">
                                <div class="col-md-9" style="margin-top: 120px;">
    <label for="sname" class="form-label">Name</label>
    <input type="text" class="form-control" id="sname" name="sname" value="<?php echo htmlentities($full_name); ?>" style="pointer-events: none;">
</div>
<div class="col-md-3 text-center">
    <img id="preview" src="../images/profile.jpg" alt="Profile Picture" class="mx-auto d-block" style="width: 200px; height: 200px; cursor: pointer;" onclick="triggerFileUpload()">
    <input type="file" accept="image/*"  class="form-control" id="image" name="image" onchange="previewImage(event)" style="display: none;">
    <label for="image" class="form-label">Upload Image (2x2)</label>
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
        <div class="col-md-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($student_email) ? htmlspecialchars($student_email) : ''; ?>">
        </div>
        <div class="col-md-1">
            <label for="age" class="form-label">Age</label>
            <input type="text" class="form-control" id="age" name="age" readonly>
        </div>
        <div class="col-md-8">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="father_name" class="form-label">Name of Father</label>
            <input type="text" class="form-control" id="father_name" name="father_name">
        </div>
        <div class="col-md-6">
            <label for="business_address_father" class="form-label">Address (Father)</label>
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
            <label for="business_address_mother" class="form-label">Address (Mother)</label>
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
    <div class="col-md-6" style="margin-top: 20px;">
    <label for="requirements" class="form-label">Requirements:</label>
    <ul>
        <li>F138 (CARD)</li>
        <li>Birth Certificate Xerox</li>
        <li>Good moral Certificate</li>
    </ul>
    <input type="file" class="form-control" id="requirements" accept="application/pdf" name="requirements[]" multiple>
    <!-- Allow multiple file uploads for requirements -->
    <small><i>Only PDF files are allowed.</i></small>
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

  <script>
    function triggerFileUpload() {
    document.getElementById('image').click();
}

    function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('preview');
        output.src = reader.result;
        output.style.display = 'block';
    }
    reader.readAsDataURL(event.target.files[0]);
}

  </script>


    <?php
    include 'footer.php';
    include 'script.php';
  ?>

</body>

</html>
<?php }} ?>