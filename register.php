<!--php-->
<?php

session_start();

$exist = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Include database connection
    include("connection.php");
    
    // Retrieve data from the POST request
    $email = $_POST['inputEmail'];
    $password = $_POST['inputPassword'];

    $domain = explode('@', $email)[1];

    if ($domain === 'student.usm.my'){
        // Check if it's the first time login
        $sqlStudent = "SELECT * FROM student_login WHERE student_email = '$email'";
        $resultStudent = $conn->query($sqlStudent);

        // If there is no result / row not exists in table
        if ($resultStudent->num_rows == 0) {
            $sqlStudent = "INSERT INTO student_login (student_email, student_pw) VALUES ('$email', '$password')";
            $resultStudent = $conn->query($sqlStudent);
            if ($resultStudent) {
                $_SESSION['student_email'] = $_POST['inputEmail'];
                header('Location:./student/student_dashboard.php');
                exit();
            }
        } else {
            $exist = true;
            echo '<script type="application/javascript">alert("Account is already registered. Please login again."); window.location.href="login.php";</script>';
            exit();
        }
    } else {
        echo '<script type="application/javascript">alert("Invalid email domain.");</script>';
        exit();
    }
}
?>

<!--html-->
<!DOCTYPE html>
<html lang="en">
    <head>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- styles -->
        <link rel="stylesheet" href="./css/mainstyle.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    
        <title>UniSched USM: USM Student Timetable Management</title>
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
                                    <form class="main-form" action="" method="POST">
                                        <div class="form-group mb-3">
                                            <label for="inputEmail" class="fw-bold">Email address</label>
                                            <input id="inputEmail" name="inputEmail" type="email" placeholder="Email address" required="" autofocus="" class="form-control border-dark px-4 invalid">
                                            <span class="toast-msg invalid" id="invalid-toast">
                                                <i class="fa-solid fa-circle-exclamation"></i>
                                                <p>Please enter the correct email format!</p>
                                            </span>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="inputPassword" class="fw-bold">Password</label>
                                            <input id="inputPassword" name="inputPassword" type="password" placeholder="Password" required="" class="form-control border-dark px-4">
                                        </div>   
                                        <button type="submit" onclick="validateEmail()" class="btn btn-block mt-4 shadow-sm fw-bolder text-center">Register</button>
                                        <p class="pt-4 text-center fs-6">Already have an account? <a href="login.php">Login</a></p>
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
            function validateEmail() {
                var emailInput = document.getElementById("inputEmail");
                var invalidMsg = document.getElementById("invalid-toast");

                // Regular expression for validating email with specified domains
                var emailRegex = /^[a-zA-Z0-9._-]+@(student\.usm\.my|usm\.my)$/;
                
                if(emailRegex.test(emailInput.value)) {
                    inputValue.setCustomValidity(" ");
                    invalidMsg.classList.add("active")
                    this.classList.add("invalid")
                }
            }
        </script>
        
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    </body>
</html>