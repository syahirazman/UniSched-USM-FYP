<!--php-->
<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register-student'])) {

    // Include database connection
    include("connection.php");
    
    // Retrieve data from the POST request
    $email = $_POST['inputEmail'];
    $password = $_POST['inputPassword'];
    $emailFound = true;

    $domain = explode('@', $email)[1];

    if ($domain === 'student.usm.my'){

        if (strlen($password) <= 15) {
            // Check if it's the first time login
            $sqlStudent = "SELECT * FROM student_login WHERE student_email = '$email'";
            $resultStudent = $conn->query($sqlStudent);

            // If there is no result / row not exists in table
            if ($resultStudent->num_rows == 0) {
                $sqlStudent = "INSERT INTO student_login (student_email, student_pw) VALUES ('$email', '$password')";
                $resultStudent = $conn->query($sqlStudent);
                if ($resultStudent) {
                    $_SESSION['student_email'] = $email;
                    $errorMessage = "Register successful!";
                }
            } else {
                $errorMessage = "Email address already exists. Please use another email address.";
            }
        } else {
            $errorMessage = "Password length should not exceed 15 characters.";
        }
    } else {
        $errorMessage = "Invalid email address. Please provide USM email address.";
    }
    header("Location: ./register.php?msg=" . urlencode($errorMessage));
    exit;
}

?>

<!--html-->
<!DOCTYPE html>
<html lang="en">
    <head>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="view-transition" content="same-origin"/>
        <!-- styles -->
        <link rel="stylesheet" href="./css/mainstyle.css">
        <link rel="icon" type="image/x-icon" href="./images/UniSched USM text logo.ico">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

        <!-- jQuery Core JS -->
        <script src="https://code.jquery.com/jquery.min.js"></script>
        <!-- BootStrap JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <!-- jQuery Easing JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- Custom Theme JS -->
        <script src="../custom-js/script-all.min.js"></script>
    
        <title>UniSched USM: Student Register</title>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row no-gutter">
                <!-- The image half -->
                <div class="col-md-6 d-none d-md-flex bg-image-reg"></div>
        
        
                <!-- The content half -->
                <div class="col-md-6 bg-white">
                    <div class="login d-flex align-items-center py-4">
        
                        <!-- Demo content-->
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-10 col-xl-7 mx-auto">
                                    <div class="text-center mb-4 pb-3">
                                        <img src="./images/login_usmlogo.png" class="img-fluid w-50" alt="USM Logo">
                                        <img src="./images/login_textlogo.png" class="img-fluid w-75">
                                    </div>
                                    <p class="mb-4 fs-5">Register with USM ID:</p>
                                    <?php
                                    if (isset($_GET['msg'])){
                                        $msg = $_GET['msg'];
                                        if ($msg != '') {
                                            if ($msg == 'Register successful!') {
                                                echo '<div class="alert alert-success fade show d-flex align-items-center" role="alert" style="font-size: 14px !important;">
                                                    '.$msg.'
                                                    <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
                                                </div>';
                                                echo "<script>
                                                        setTimeout(function() {
                                                            window.location.href = './student/student_dashboard.php';
                                                        }, 2000); // 3000 milliseconds = 3 seconds
                                                    </script>";
                                                exit;
                                            } else {
                                                echo '<div class="alert alert-danger fade show" role="alert" style="font-size: 12px !important;">
                                                    '.$msg.'
                                                </div>';
                                            }
                                        }
                                    }
                                    ?>
                                    <form class="main-form" action="" method="POST">
                                        <div class="form-group mb-3">
                                            <label for="inputEmail" class="fw-bold">Email address</label>
                                            <input id="inputEmail" name="inputEmail" type="email" class="form-control px-4" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="inputPassword" class="fw-bold">Password</label>
                                            <input id="inputPassword" name="inputPassword" type="password" pattern="^.{1,15}$" class="form-control px-4" required>
                                        </div>   
                                        <button type="submit"  name="register-student" id="register-student" class="btn btn-block mt-4 shadow-sm fw-bolder text-center">Register</button>
                                        <p class="pt-4 text-center fs-6">Already have an account? <a class="text-decoration-none font-weight-bold" href="login.php">Login</a></p>
                                    </form>
                                </div>
                            </div>
                        </div><!-- End -->
                    </div>
                </div><!-- End -->
        
            </div>
        </div>

        
    </body>
</html>