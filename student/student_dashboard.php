<!-- PHP -->
<?php
session_start();

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

        <title>UniSched USM: Student Dashboard</title>
    </head>
    <body id="page-top stud-dashboard">
        <div id="wrapper">
            <!-- side bar -->
            <ul class="navbar-nav bg-white sidebar" id="accordionSidebar">
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="student_dashboard.php">
                    <div class="mt-3 mb-4">
                        <img src="../images/login_textlogo.png" class="img-fluid">
                    </div>
                </a>
                <!-- nav 1 -->
                <li class="nav-item active">
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
                <li class="nav-item">
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

                    <div class="container-fluid">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4 ml-4">
                            <h1 class="h3 mb-0 text-gray-900">Student Dashboard</h1>
                        </div>

                        <div id="timetable">
                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    <div class="d-sm-flex align-items-center justify-content-between">
                                        <h5 class="text-gray-900 ml-2">Current Semester Timetable</h5>
                                        <button class="btn btn-secondary d-print-none" onClick="printDiv()"><i class="fa-solid fa-print"></i></button>
                                    </div>				
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table text-gray-900 mt-3 mb-3 text-center" style="table-layout: fixed; border-bottom: 1px solid #dee2e6 !important; border-right: 1px solid #dee2e6 !important; border-collapse:collapse;">
                                            <?php
                                            require_once '../student/display_timetable.php';
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-left-info shadow mb-4 w-50">
                                <div class="card-body">
                                    <div class="d-sm-flex align-items-center justify-content-between mb-2">
                                        <h5 class="text-gray-900">Courses taken this semester:</h5>
                                    </div>
                                    <?php
                                    if (isset($_SESSION['$student_email'])) {
                                        $sqlStdID = "SELECT student_id FROM student_login WHERE student_email = '$student_email'";
                                        $resultStdID = $conn->query($sqlStdID);
                                        if ($resultStdID && $resultStdID->num_rows > 0) {
                                            $std = $resultStdID->fetch_assoc();
                                            $student_id = $std['student_id'];
                                        }
                                    }
                                    $sqlCourse = "SELECT DISTINCT cm.course_code, cm.course_name
                                                FROM student_timetable st
                                                JOIN timetable_mgmt tm ON st.slot_id = tm.slot_id
                                                JOIN course_mgmt cm ON tm.course_code = cm.course_code
                                                WHERE st.student_id = '$student_id'";
                                    $resultCourse = $conn->query($sqlCourse);
                                    while ($rowCourse = $resultCourse->fetch_assoc()):
                                    ?>
                                    <div class="btn btn-info p-2 m-1 text-white w-auto"><?= $rowCourse['course_code']?> - <?= $rowCourse['course_name']?></div><br>
                                    <?php endwhile; ?>
                                </div>
                            </div>
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


        <!-- Script to print the content of a div -->
        <script> 
            function printDiv() { 
                var divContents = document.getElementById("timetable").innerHTML; 
                var originalContents = document.body.innerHTML;
                var originalContents = document.body.innerHTML; // Save original body content

                // Replace body content with divContents
                document.body.innerHTML = '<html><head><title>Print</title><style type="text/css" media="print"> .print-content { width: 100%; height: 100%; overflow: hidden; margin-top: 100px; }</style></head><body><div class="print-content">' + divContents + '</div></body></html>';

                // Print the page
                window.print();

                // Restore original body content
                document.body.innerHTML = originalContents;
            } 
        </script>

    </body>

</html>