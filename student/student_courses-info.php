<!-- PHP -->
<?php
session_start();

include '../connection.php';

// Check if the session variable is set
if (isset($_SESSION['student_email'])) {
    $student_email = $_SESSION['student_email'];
    // Now you can use $student_email in your HTML or PHP code
} else {
    // Redirect to the login page if the session variable is not set
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="view-transition" content="same-origin"/>
        <!-- styles -->
        <link href="../css/fontawesome.min.css" rel="stylesheet">
        <link href="../css/adminstyle.min.css" rel="stylesheet">
        <link href="../css/adminstyle.css" rel="stylesheet">
        <link href="../css/studentstyle.css" rel="stylesheet">
        
        <link rel="icon" type="image/x-icon" href="../images/UniSched USM text logo.ico">
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

        <title>UniSched USM: Course Information</title>
    </head>
    <body id="page-top">
        <div id="wrapper">
            <!-- side bar -->
            <ul class="navbar-nav bg-white sidebar" id="accordionSidebar">
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="student_dashboard.php">
                    <div class="mt-3 mb-4">
                        <img src="../images/login_textlogo.png" class="img-fluid">
                    </div>
                </a>
                <!-- nav 1 -->
                <li class="nav-item">
                    <a class="nav-link ml-1" href="../student/student_dashboard.php">
                        <i class="fa fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>
                <hr class="sidebar-divider">
                <!-- nav 2 -->
                <li class="nav-item">
                    <a class="nav-link ml-1" href="../student/student_timetable.php">
                        <i class="fa fa-fw fa-calendar"></i>
                        <span>Class Timetable</span></a>
                </li>
                <hr class="sidebar-divider">
                <!-- nav 3 -->
                <li class="nav-item active">
                    <a class="nav-link ml-1" href="../student/student_courses-info.php">
                        <i class="fa fa-fw fa-book-open"></i>
                        <span>Courses Information</span></a>
                </li>
                <hr class="sidebar-divider">
                <!-- nav 4 -->
                <li class="nav-item">
                    <a class="nav-link ml-1 collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseMap"
                    aria-expanded="true" aria-controls="collapseMap">
                        <i class="fas fa-fw fa-map-marker-alt"></i>
                        <span>Campus Map</span></a>
                    <div id="collapseMap" class="collapse" aria-labelledby="headingMap" data-bs-parent="#accordionSidebar">
                    <div class="bg-primary py-2 collapse-inner rounded">
                        <a class="collapse-item text-white" href="../student/map_main-campus.php">Main Campus</a>
                        <a class="collapse-item text-white" href="../student/map_eng-campus.php">Engineering Campus</a>
                        <a class="collapse-item text-white" href="../student/map_health-campus.php">Health Campus</a>
                    </div>
                </div>
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
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 medium">Welcome, <?php echo $student_email; ?>!</span>
                                    <img class="img-profile rounded-circle" src="../images/profile_icon.png">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </nav>

                    <!-- Begin page content -->
                    <div class="container-fluid">
                        <div class="d-sm-flex align-items-center justify-content-between ml-4">
                            <h1 class="h3 mb-0 text-gray-900">Courses Information</h1>
                        </div>
                        <div class="d-flex flex-row-reverse mb-2">
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filter">
                                <i class="fa-xs fa-solid fa-filter"></i>
                            </a>
                        </div>

                        <!--rows of cards-->
                        <div class="row">
                            <?php

                                // check connection
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // read all row from database table
                                $count = 0;
                                $sql = "SELECT * FROM course_mgmt";

                                if (isset($_GET['filter'])) {
                                    // Initialize variables to hold selected options
                                    $selectedSchool = isset($_GET['school']) ? $_GET['school'] : "";
                                    $selectedSemester = isset($_GET['semester']) ? $_GET['semester'] : "";

                                    $sql .= " WHERE 1";

                                    if (!empty($selectedSchool)) {
                                        $sql .= " AND school = '$selectedSchool'";
                                    }

                                    if (!empty($selectedSemester)) {
                                        $sql .= " AND semester = '$selectedSemester'";
                                    }
                                }

                                 // Check if Clear Filter is requested
                                 if (isset($_GET['clearfilter'])) {
                                    $sql;
                                }

                                $result = $conn->query($sql);
                                if (!$result) {
                                    die("Invalid query: " . $conn->connect_error); 
                                }


                                while ($row = $result->fetch_assoc()):
                                    if ($count % 3 == 0 && $count != 0) {
                                        echo '</div><div class="row">'; // Start a new row every third course
                                    }
                                
                            ?>
                            <div class="col-xl-4 col-md-6 mb-3">
                                <div class="card shadow mb-3">
                                    <a href="#" class="card-header text-decoration-none d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#collapseCard<?= $row["course_code"] ?>"
                                        role="button" aria-expanded="true" aria-controls="collapseCard<?= $row["course_code"] ?>">
                                        <div>
                                            <h5 class="m-0 font-weight-bold text-primary"><?= $row["course_code"] ?></h5>
                                            <h6 class="m-0 pt-3 font-weight-bold text-primary"><?= $row["course_name"] ?></h6>
                                        </div>
                                    </a>
                                    <div class="collapse" id="collapseCard<?= $row["course_code"] ?>">
                                        <div class="card-body">
                                            <?= $row["course_overview"] ?><br><br>
                                            <p class="my-1">Offered by: <?= $row["school"] ?></p>
                                            <p class="my-1">Offered in Semester: <?= $row["semester"] ?></p>
                                            <p class="my-0">Lecturers:</p>
                                            <span><?= $row["lecturername"]?>, <?= $row["lectureremail"] ?>, Room <?= $row["lecturerroom"] ?></span><br>
                                            <?php if (!empty($row["lecturername_1"]) && !empty($row["lectureremail_1"]) && !empty($row["lecturerroom_1"])): ?>
                                                <span><?= $row["lecturername_1"] ?>, <?= $row["lectureremail_1"] ?>, Room <?= $row["lecturerroom_1"] ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
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
                        <a class="btn btn-primary" href="../logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter modal -->
        <div class="modal fade" id="filter" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Filter by:</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="GET">
                            <div class="form-group text-gray-800">
                                <label for="school">School</label>
                                <select class="form-control" name="school" id="school">
                                    <option></option>
                                    <?php
                                    // Retrieve course codes from the database and populate the dropdown
                                    // check connection
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    $filterSchool = "SELECT DISTINCT school FROM course_mgmt";
                                    $resultSchool = $conn->query($filterSchool);
                                    if (!$resultSchool) {
                                        die("Invalid query: " . $conn->connect_error); 
                                    }
                                    while ($rowSchool = $resultSchool->fetch_assoc()): ?>
                                    <option><?= $rowSchool["school"] ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <br>
                                <label for="semester">Semester</label>
                                <select class="form-control" name="semester" id="semester">
                                    <option></option>
                                    <?php
                                    // Retrieve course codes from the database and populate the dropdown
                                    // check connection
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }

                                    $filterSem = "SELECT DISTINCT semester FROM course_mgmt";
                                    $resultSem = $conn->query($filterSem);
                                    if (!$resultSem) {
                                        die("Invalid query: " . $conn->connect_error); 
                                    }
                                    while ($rowSem = $resultSem->fetch_assoc()): ?>
                                    <option><?= $rowSem["semester"] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary" name="clearfilter" value="Clear">Clear</button>
                                <button type="submit" class="btn btn-primary" name="filter" value="Filter">Apply</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </body>

</html>