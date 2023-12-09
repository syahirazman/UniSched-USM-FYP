<!--php-->
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        include("connection.php");

        // Retrieve data from the POST request
        $email = $_POST['inputEmail'];
        $password = $_POST['inputPassword'];

        // Check if it's the first time login
        $sqlStudent = "SELECT * FROM student_login WHERE student_email = '$email'";
        $resultStudent = $conn->query($sqlStudent);

        $sqlAdmin = "SELECT * FROM admin_login WHERE admin_email = '$email'";
        $resultAdmin = $conn->query($sqlAdmin);

        if ($resultStudent->num_rows > 0) {
            // User is a student, check password
            $rowStudent = $resultStudent->fetch_assoc();
            if ($rowStudent['student_pw'] == $password) {
                header('Location:student_dashboard.php?');
            } else {
                echo '<script>alert:("Login failed. Please check your credentials and login again")</script>';
            }
        } elseif ($resultAdmin->num_rows > 0) {
            // User is an admin, check password
            $rowAdmin = $resultAdmin->fetch_assoc();
            if ($rowAdmin['admin_pw'] == $password) {
                header('Location:student_dashboard.php?');
            } else {
                echo '<script>alert:("Login failed. Please check your credentials and login again")</script>';
            }
        } else {
            // First time login, determine if admin or student and save credentials
            $domain = explode('@', $email)[1];
            
            if ($domain === 'student.usm.my') {
                $sql = "INSERT INTO student_login (student_email, student_pw) VALUES ('$email', '$password')";
                $result = $conn->query($sql);
                if ($result) {
                    header('Location:student_dashboard.php?');
                } else {
                    echo '<script>alert:("Login failed. Please check your credentials and login again")</script>';
                }
            } elseif ($domain === 'usm.my') {
                $sql = "INSERT INTO admin_login (admin_email, admin_pw) VALUES ('$email', '$password')";
                $result = $conn->query($sql);
                if ($result) {
                    header('Location:student_dashboard.php?');
                } else {
                    echo 'failed';
                }
            } else {
                echo '<script>alert:("Login failed. Please check your credentials and login again")</script>';
            }
        }
    }

?>

<!--html-->
<!DOCTYPE html>
<html lang="en">
    <head>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- styles -->
        <link rel="stylesheet" href="../css/mainstyle.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    
        <title>UniSched USM: USM Student Timetable Management</title>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row no-gutter">
                <!-- The image half -->
                <div class="col-md-6 d-none d-md-flex bg-image"></div>
        
        
                <!-- The content half -->
                <div class="col-md-6 bg-white">
                    <div class="login d-flex align-items-center py-5">
        
                        <!-- Demo content-->
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-10 col-xl-7 mx-auto">
                                    <div class="text-center mb-5 pb-3">
                                        <img src="./images/login_usmlogo.png" class="img-fluid w-50" alt="USM Logo">
                                        <img src="./images/login_textlogo.png" class="img-fluid w-75">
                                    </div>
                                    <p class="mb-4 fs-5">Login with USM ID:</p>
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
                                        
                                        <button type="submit" onclick="validateEmail()" class="btn btn-block mt-4 mb-2 shadow-sm fw-bolder text-center">Log in</button>
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
           
        
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    </body>
</html>