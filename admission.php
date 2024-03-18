<?php
          session_start();

          // Check for error message from the previous submission
          if (isset($_SESSION['error_message'])) {
              echo '<div class="alert alert-danger" role="alert">';
              echo $_SESSION['error_message'];
              echo '</div>';
              // Clear the error message from the session
              unset($_SESSION['error_message']);
          }
          ?>
<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Eastern Achiever Academy of Taguig</title>



  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <!-- progress barstle -->
  <link rel="stylesheet" href="css/css-circular-prog-bar.css">
  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
  <!-- font wesome stylesheet -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />




  <link rel="stylesheet" href="css/css-circular-prog-bar.css">


</head>

<body>
  <div class="top_container sub_pages">
    <!-- header section strats -->
    <header class="header_section">
      <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="index.html">
            <img src="images/logo.png" alt="">
            <span>
              E A A T I
            </span>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="d-flex ml-auto flex-column flex-lg-row align-items-center">
              <ul class="navbar-nav  ">
                <li class="nav-item active">
                  <a class="nav-link" href="index.html"> Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="about.html"> About </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="admission.php"> Admission </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="studentlife.html"> Student Life </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="contact.html">Contact Us</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link btn btn-primary btn-sm" href="login.php">
                      Login
                  </a>
                </li>
              </ul>
            </div>
        </nav>
      </div>
    </header>
  </div>
  <!-- end header section -->


  <!-- teacher section -->
  <section class="teacher_section layout_padding-bottom">
    <div class="container">
      <h2 class="main-heading">Admission</h2>
      <div id="accordion">
        <div class="card">
          <div class="card-header">
            <a class="card-link" data-toggle="collapse" href="#collapseOne">
              Admission Requirements
            </a>
          </div>
          <div id="collapseOne" class="collapse show" data-parent="#accordion">
            <div class="card-body">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
            Student/Parent Registration
          </a>
          </div>
          <div id="collapseTwo" class="collapse" data-parent="#accordion">
            <div class="card-body">
              <form method="post" action="insert.php">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Learner's Information</h3>
                        <div class="form-group">
                            <label for="lrn">LRN No.</label>
                            <input type="text" class="form-control" id="lrn" name="lrn" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="middle_name">Middle Name</label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name">
                        </div>
                        <div class="form-group">
                            <label for="extension_name">Extension Name</label>
                            <input type="text" class="form-control" id="extension_name" name="extension_name">
                        </div>
                        <div class="form-group">
                            <label for="birthday">Birthday</label>
                            <input type="date" class="form-control" id="birthday" name="birthday" required>
                        </div>
                        <div class="form-group">
                            <label for="place_of_birth">Place of Birth</label>
                            <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" required>
                        </div>
                        <div class="form-group">
                            <label for="sex">Sex</label>
                            <select class="form-control" id="sex" name="sex" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="number" class="form-control" id="age" name="age" required>
                        </div>
                        <div class="form-group">
                            <label for="mother_tongue">Mother Tongue</label>
                            <input type="text" class="form-control" id="mother_tongue" name="mother_tongue" required>
                        </div>
                        <div class="form-group">
                            <label for="grade_level">Grade Level</label>
                            <input type="text" class="form-control" id="grade_level" name="grade_level" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3>Address Information</h3>
                        <div class="form-group">
                            <label for="house_no">House No.</label>
                            <input type="text" class="form-control" id="house_no" name="house_no" required>
                        </div>
                        <div class="form-group">
                            <label for="street_name">Street Name</label>
                            <input type="text" class="form-control" id="street_name" name="street_name" required>
                        </div>
                        <div class="form-group">
                            <label for="barangay">Barangay</label>
                            <input type="text" class="form-control" id="barangay" name="barangay" required>
                        </div>
                        <div class="form-group">
                            <label for="municipality_city">Municipality/City</label>
                            <input type="text" class="form-control" id="municipality_city" name="municipality_city" required>
                        </div>
                        <div class="form-group">
                            <label for="province">Province</label>
                            <input type="text" class="form-control" id="province" name="province" required>
                        </div>
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" id="country" name="country" required>
                        </div>
                        <div class="form-group">
                            <label for="zip_code">Zip Code</label>
                            <input type="text" class="form-control" id="zip_code" name="zip_code" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h3>Parent's/Guardians Information</h3>
                        <!-- Father's Information -->
                        <h4>Father's Information:</h4>
                        <div class="form-group">
                            <label for="father_last_name">Last Name</label>
                            <input type="text" class="form-control" id="father_last_name" name="father_last_name" required>
                        </div>
                        <div class="form-group">
                            <label for="father_first_name">First Name</label>
                            <input type="text" class="form-control" id="father_first_name" name="father_first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="father_middle_name">Middle Name</label>
                            <input type="text" class="form-control" id="father_middle_name" name="father_middle_name">
                        </div>
                        <div class="form-group">
                            <label for="father_contact_number">Contact Number</label>
                            <input type="text" class="form-control" id="father_contact_number" name="father_contact_number" required>
                        </div>
                        <!-- Mother's Information -->
                        <h4>Mother's Information:</h4>
                        <div class="form-group">
                            <label for="mother_last_name">Last Name</label>
                            <input type="text" class="form-control" id="mother_last_name" name="mother_last_name" required>
                        </div>
                        <div class="form-group">
                            <label for="mother_first_name">First Name</label>
                            <input type="text" class="form-control" id="mother_first_name" name="mother_first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="mother_middle_name">Middle Name</label>
                            <input type="text" class="form-control" id="mother_middle_name" name="mother_middle_name">
                        </div>
                        <div class="form-group">
                            <label for="mother_contact_number">Contact Number</label>
                            <input type="text" class="form-control" id="mother_contact_number" name="mother_contact_number" required>
                        </div>
                        <!-- Guardian's Information -->
                        <h4>Guardian's Information:</h4>
                        <div class="form-group">
                            <label for="guardian_last_name">Last Name</label>
                            <input type="text" class="form-control" id="guardian_last_name" name="guardian_last_name" required>
                        </div>
                        <div class="form-group">
                            <label for="guardian_first_name">First Name</label>
                            <input type="text" class="form-control" id="guardian_first_name" name="guardian_first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="guardian_middle_name">Middle Name</label>
                            <input type="text" class="form-control" id="guardian_middle_name" name="guardian_middle_name">
                        </div>
                        <div class="form-group">
                            <label for="guardian_contact_number">Contact Number</label>
                            <input type="text" class="form-control" id="guardian_contact_number" name="guardian_contact_number" required>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
    
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
              Submission of Requirements
            </a>
          </div>
          <div id="collapseThree" class="collapse" data-parent="#accordion">
            <div class="card-body">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <a class="collapsed card-link" data-toggle="collapse" href="#collapseFour">
              Enrollment
            </a>
          </div>
          <div id="collapseFour" class="collapse" data-parent="#accordion">
            <div class="card-body">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- teacher section -->


  <!-- footer section -->
  <section class="container-fluid footer_section">
    <p>
      Copyright &copy; 2024 All Rights Reserved By
      <a href="https://web.facebook.com/eaati2005">Eastern Achiever Academy of Taguig Inc.</a>
    </p>
  </section>
  <!-- footer section -->

  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <!-- progreesbar script -->

  </script>
  <script>
    // This example adds a marker to indicate the position of Bondi Beach in Sydney,
    // Australia.
    function initMap() {
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 11,
        center: {
          lat: 40.645037,
          lng: -73.880224
        },
      });

      var image = 'images/maps-and-flags.png';
      var beachMarker = new google.maps.Marker({
        position: {
          lat: 40.645037,
          lng: -73.880224
        },
        map: map,
        icon: image
      });
    }
  </script>
  <!-- google map js -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8eaHt9Dh5H57Zh0xVTqxVdBFCvFMqFjQ&callback=initMap">
  </script>
  <!-- end google map js -->
</body>

</html>