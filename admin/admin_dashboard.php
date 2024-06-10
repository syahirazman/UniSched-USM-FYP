<!-- PHP -->
<?php
session_start();

include '../connection.php';

// Check if the session variable is set
if (isset($_SESSION['admin_email'])) {
    $admin_email = $_SESSION['admin_email'];
    // Now you can use $admin_email in your HTML or PHP code
} else {
    // Redirect to the login page if the session variable is not set
    header('Location: admin-login.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['add_admin'])) {
    // Retrieve data from the POST request
    $email = $_POST['inputEmail'];
    $password = $_POST['inputPassword'];
    $emailFound = true;
    $domain = explode('@', $email)[1];

    if ($domain === 'usm.my'){

        if (strlen($password) <= 15) {
            // Check if it's the first time login
            $sqlAdmin = "SELECT admin_email FROM admin_login WHERE admin_email = '$email'";
            $resultAdmin = $conn->query($sqlAdmin);

            // If there is no result / row not exists in table
            if ($resultAdmin->num_rows == 0) {
                $emailFound = false;
                $sqlAdmin = "INSERT INTO admin_login (admin_email, admin_pw) VALUES ('$email', '$password')";
                $resultAdmin = $conn->query($sqlAdmin);
                if ($resultAdmin) {
                    header('Location: admin_dashboard.php?msg=Admin is added successfully!');
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
    header("Location: admin_dashboard.php?errmsg=" . urlencode($errorMessage));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="view-transition" content="same-origin"/>
        <!-- styles -->
        <link href="../css/fontawesome.min.css" rel="stylesheet">
        <link href="../css/adminstyle.min.css" rel="stylesheet">
        <link href="../css/adminstyle.css" rel="stylesheet">
        <link rel="icon" type="image/x-icon" href="../images/UniSched USM text logo.ico">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

        <!-- jQuery Core JS -->
        <script src="https://code.jquery.com/jquery.min.js"></script>
        <!-- BootStrap JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <!-- jQuery Easing JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- Custom Theme JS -->
        <script src="../custom-js/script-all.min.js"></script>
        <!-- Script to generate table using DataTable-->
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

        <title>UniSched USM: Admin Dashboard</title>
    </head>
    <body id="page-top">
        <div id="wrapper">
            <!-- side bar -->
            <ul class="navbar-nav bg-white sidebar" id="accordionSidebar">
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin_dashboard.html">
                    <div class="mt-3 mb-4">
                        <img src="../images/login_textlogo.png" class="img-fluid">
                    </div>
                </a>
                <!-- nav 1 -->
                <li class="nav-item active">
                    <a class="nav-link ml-1" href="../admin/admin_dashboard.php">
                        <i class="fa fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>
                <hr class="sidebar-divider">
                <!-- nav 2 -->
                <li class="nav-item">
                    <a class="nav-link ml-1" href="../admin/admin_class-slots.php">
                        <i class="fa fa-fw fa-clipboard-list"></i>
                        <span>Class slots</span></a>
                </li>
                <hr class="sidebar-divider">
                <!-- nav 3 -->
                <li class="nav-item">
                    <a class="nav-link ml-1" href="../admin/admin_courses.php">
                        <i class="fa fa-fw fa-book-open"></i>
                        <span>Courses</span></a>
                </li>
                <hr class="sidebar-divider">
                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>
            </ul>
            <!-- end of sidebar-->

            <!-- content wrapper -->
            <div id="content-wrapper"  class="d-flex flex-column">
                <!-- main content -->
                <div id="content">
                    <!-- top bar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                        <!-- Sidebar Toggle (Topbar) -->
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>


                        <!-- Topbar Profile-->
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 medium">Welcome, <?php echo $admin_email; ?>!</span>
                                    <img class="img-profile rounded-circle" src="../images/profile_icon.png">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                                        <i class="fas fa-solid fa-plus fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Add new admin
                                    </a>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                    
                                </div>
                            </li>
                        </ul>
                    </nav>

                    <!-- begin page content -->
                    <div class="container-fluid">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4 ml-4">
                            <h1 class="h3 mb-0 text-gray-900">Admin Dashboard</h1>
                        </div>
                        <!-- display success alert if new admin is added successfully -->
                        <?php
                        if (isset($_GET['msg'])) {
                            $msg = $_GET['msg'];
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                       ' .$msg. '
                                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close" onclick="reloadPage()">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                        }
                        ?>
                        <!-- script to reload page back to URL without GET parameter after closing alert -->
                        <script>
                            function reloadPage() {
                                window.location.href = 'admin_dashboard.php';
                            }
                        </script>

                        <div class="row">
                            <!-- Registered Student Account Card  -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bolder text-primary text-uppercase mb-1">
                                                    Student Accounts</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?php
                                                        $studCount = "SELECT student_id FROM student_login";
                                                        $studCount_run = mysqli_query($conn, $studCount);
                                                        $studCount_row = mysqli_num_rows($studCount_run);
                                                        echo $studCount_row; 
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fa-solid fa-users fa-3x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Created Student Timetable Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Student Timetables</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?php
                                                        $tableCount = "SELECT DISTINCT student_id FROM student_timetable";
                                                        $tableCount_run = mysqli_query($conn, $tableCount);
                                                        $tableCount_row = mysqli_num_rows($tableCount_run);
                                                        echo $tableCount_row; 
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fa-solid fa-calendar fa-3x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Courses Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Created Courses </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?php
                                                        $courseCount = "SELECT course_code FROM course_mgmt";
                                                        $courseCount_run = mysqli_query($conn, $courseCount);
                                                        $courseCount_row = mysqli_num_rows($courseCount_run);
                                                        echo $courseCount_row; 
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fa fa-book-open fa-3x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Class Slots Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Created Class Slots</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?php
                                                        $slotCount = "SELECT slot_id FROM timetable_mgmt";
                                                        $slotCount_run = mysqli_query($conn, $slotCount);
                                                        $slotCount_row = mysqli_num_rows($slotCount_run);
                                                        echo $slotCount_row; 
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-clipboard-list fa-3x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card border-left-secondary shadow py-2 w-45">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered hover text-gray-900 mt-3 mb-3" id="courseCountTable" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>School</th>
                                                        <th>Courses in system</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($conn->connect_error) {
                                                        die("Connection failed: " . $conn->connect_error);
                                                    }
                                                    $querySql = "SELECT school, COUNT(course_code) AS course_count FROM course_mgmt GROUP BY school";
                                                    $queryResult = $conn->query($querySql);
                                                    if (!$queryResult) {
                                                        die("Invalid query: " . $conn->connect_error); 
                                                    }
                                                    while ($queryRow = $queryResult->fetch_assoc()): ?>
                                                    <tr>
                                                        <td><?= $queryRow["school"] ?></td>
                                                        <td class="text-center"><?= $queryRow["course_count"] ?></td>
                                                    </tr>
                                                    <?php endwhile; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card border-left-secondary shadow py-2 w-45">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered hover text-gray-900 mt-3 mb-3" id="slotCountTable" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Course code</th>
                                                        <th>Class slots in system</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($conn->connect_error) {
                                                        die("Connection failed: " . $conn->connect_error);
                                                    }
                                                    $querysql = "SELECT course_code, COUNT(slot_id) AS slot_count FROM timetable_mgmt GROUP BY course_code";
                                                    $queryresult = $conn->query($querysql);
                                                    if (!$queryresult) {
                                                        die("Invalid query: " . $conn->connect_error); 
                                                    }
                                                    while ($queryrow = $queryresult->fetch_assoc()): ?>
                                                    <tr>
                                                        <td class="text-center"><?= $queryrow["course_code"] ?></td>
                                                        <td class="text-center"><?= $queryrow["slot_count"] ?></td>
                                                    </tr>
                                                    <?php endwhile; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>

        <!-- Add Admin Modal-->
        <div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="" method="POST">
                        <div class="modal-header">						
                            <h4 class="modal-title font-weight-bold text-gray-900" id="exampleModalLabel">Register New Admin</h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body text-gray-900">
                            <?php
                                if (isset($_GET['errmsg'])){
                                     $errmsg = $_GET['errmsg'];
                                    if ($errmsg != '') {
                                        echo '<div class="alert alert-danger fade show" role="alert" style="font-size: 14px !important;">
                                                '.$errmsg.'
                                            </div>';
                                    }
                                }
                            ?>
                            <div class="form-group mb-3">
                                <label for="inputEmail" class="fw-bold">Email address</label>
                                <input id="inputEmail" name="inputEmail" type="email" class="form-control px-4" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="inputPassword" class="fw-bold">Password</label>
                                <input id="inputPassword" name="inputPassword" type="password"  pattern="^.{1,15}$" class="form-control px-4" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel">
                            <input type="submit" class="btn btn-success" value="Add admin" name="add_admin">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Log Out?</h5>
                        <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="../admin-logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>


        <script>
            new DataTable('#courseCountTable');
        </script>

        <script>
            new DataTable('#slotCountTable');
        </script>


    </body>

</html>