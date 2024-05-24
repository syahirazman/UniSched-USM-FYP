<!--php-->
<?php

    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login-student'])) {

        include("connection.php");

        // Retrieve data from the POST request
        $email = $_POST['inputEmail'];
        $password = $_POST['inputPassword'];
        $emailFound = null;
        $passwordError = null;
        $domain = explode('@', $email)[1];
       

        if ($domain === 'student.usm.my'){
            // Check if it's the first time login
            $sqlStudent = "SELECT * FROM student_login WHERE student_email = '$email'";
            $resultStudent = $conn->query($sqlStudent);

            if ($resultStudent->num_rows > 0) {
                // User is an existing student, check password
                $emailFound = true;
                $rowStudent = $resultStudent->fetch_assoc();
                if ($rowStudent['student_pw'] === $password) {
                    $passwordError = false;
                    // Set session variable for student email
                    $_SESSION['student_email'] = $rowStudent['student_email'];
                    header('Location: ./student/student_dashboard.php');
                    exit;
                } else {
                    $passwordError = true;
                }
            } else {
                $emailFound = false;
            }
        }
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
    
        <title>UniSched USM: Student Login</title>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row no-gutter">
                <!-- The image half -->
                <div class="col-md-6 d-none d-md-flex bg-image"></div>
        
        
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
                                    <p class="mb-4 fs-5">Login with USM ID:</p>
                                    <form class="main-form needs-validation" action="" method="POST" novalidate>
                                        <div class="form-group mb-3">
                                            <label for="inputEmail" class="fw-bold">Email address</label>
                                            <input id="inputEmail" name="inputEmail" type="email" class="form-control px-4" required>
                                            <div class="invalid-email invalid-feedback">
                                                Please provide your registered email address.
                                            </div>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="inputPassword" class="fw-bold">Password</label>
                                            <input id="inputPassword" name="inputPassword" type="password" class="form-control px-4" required>
                                            <div class="invalid-feedback invalid-pw">
                                                Please provide your password.
                                            </div>
                                        </div>   
                                        <button type="submit" name="login-student" id="login-student" class="btn btn-block mt-4 shadow-sm fw-bolder text-center">Log in</button>
                                        <p class="pt-4 text-center fs-6">New to UniSched USM? <a class="text-decoration-none font-weight-bold" href="register.php">Register</a></p>
                                    </form>
                                </div>
                            </div>
                        </div><!-- End -->
                    </div>
                </div><!-- End -->
        
            </div>
        </div>

        <!--script-->
        
        <script>
            (function () {
                'use strict'

                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.querySelectorAll('.needs-validation')

                // Loop over them and prevent submission
                Array.prototype.slice.call(forms)
                    .forEach(function (form) {
                        form.addEventListener('submit', function (event) {
                            var isValid = true;
                            var passwordInput = form.querySelector('#inputPassword');
                            var passwordError =document.querySelector('.invalid-pw');
                            var emailInput = form.querySelector('#inputEmail');
                            var invalidFeedback = document.querySelector('.invalid-email');
                            var emailPattern = /^[a-zA-Z0-9._%+-]+@student\.usm\.my$/;

                            
                            if (!emailPattern.test(emailInput.value)) {
                                emailInput.classList.remove('is-valid');
                                emailInput.classList.add('is-invalid');
                                isValid = false;
                                invalidFeedback.textContent = '';
                                invalidFeedback.textContent = 'Invalid email address. Please provide USM student email address.';
                                invalidFeedback.style.display = 'block';
                            }

                            <?php if (isset($emailFound) && $emailFound === false): ?>
                                emailInput.classList.remove('is-valid');
                                emailInput.classList.add('is-invalid');
                                isValid = false;
                                invalidFeedback.textContent = '';
                                invalidFeedback.textContent = 'No user found for this email address. Please try again.';
                                invalidFeedback.style.display = 'block';
                            <?php endif; ?>
                            
                            <?php if ($passwordError === true): ?>
                                passwordInput.classList.remove('is-valid');
                                passwordInput.classList.add('is-invalid');
                                isValid = false;
                                passwordError.textContent = '';
                                passwordError.textContent = 'Incorrect password. Please try again.';
                                passwordError.style.display = 'block';
                            <?php endif; ?>

                            if (isValid === false || !form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }

                            form.classList.add('was-validated')
                        }, false);

                        
                    });
                })();
        </script>
    </body>
</html>