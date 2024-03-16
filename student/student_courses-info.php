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
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- styles -->
        <link href="../css/fontawesome.min.css" rel="stylesheet">
        <link href="../css/adminstyle.min.css" rel="stylesheet">
        <link href="../css/adminstyle.css" rel="stylesheet">
        <link rel="icon" type="image/x-icon" href="../images/UniSched USM text logo.ico">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

        <title>UniSched USM: Student Information</title>
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

                        <!-- Topbar Search -->
                        <form
                            class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                    aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Topbar Profile-->
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 medium">Welcome, <?php echo $student_email; ?>!</span>
                                    <img class="img-profile rounded-circle" src="../images/profile_icon.png">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </nav>

                    <!-- Begin page content -->
                    <div class="container-fluid">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4 ml-4">
                            <h1 class="h3 mb-0 text-gray-900">Courses Information</h1>
                        </div>
                        <div class="d-sm-flex align-items-center justify-content-between mb-4 ml-4">
                            <form>
                                <p class="text-gray-900">Filter by:</p>
                                <div class="form-inline text-gray-700">
                                    <label for="school">School</label>
                                    <select class="form-control ml-sm-2 mr-sm-4" name="school" id="school">
                                        <option></option>
                                        <option value="CS">School of CS</option>
                                        <option value="Bio">School of Bio</option>
                                        <option value="Etc">School of etc</option>
                                    </select>
                                    <label for="semester">Semester</label>
                                    <select class="form-control ml-sm-2" name="semester" id="semester">
                                        <option></option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="1 & 2">1 & 2</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <!--rows of cards-->
                        <div class="row">
                            <div class="col-xl-4 col-md-6 mb-4">
                                <!-- Collapsable Card Example -->
                                    <div class="card shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse"
                                        role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                        <h6 class="m-0 font-weight-bold text-primary">Collapsable Card Example</h6>
                                    </a>
                                    <!-- Card Content - Collapse -->
                                    <div class="collapse show" id="collapseCardExample">
                                        <div class="card-body">
                                            This is a collapsable card example using Bootstrap's built in collapse
                                            functionality. <strong>Click on the card header</strong> to see the card body
                                            collapse and expand!
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 mb-4">
                                <!-- Collapsable Card Example -->
                                    <div class="card shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse"
                                        role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                        <h6 class="m-0 font-weight-bold text-primary">Collapsable Card Example</h6>
                                    </a>
                                    <!-- Card Content - Collapse -->
                                    <div class="collapse show" id="collapseCardExample">
                                        <div class="card-body">
                                            This is a collapsable card example using Bootstrap's built in collapse
                                            functionality. <strong>Click on the card header</strong> to see the card body
                                            collapse and expand!
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 mb-4">
                                <!-- Collapsable Card Example -->
                                    <div class="card shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse"
                                        role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                        <h6 class="m-0 font-weight-bold text-primary">Collapsable Card Example</h6>
                                    </a>
                                    <!-- Card Content - Collapse -->
                                    <div class="collapse show" id="collapseCardExample">
                                        <div class="card-body">
                                            This is a collapsable card example using Bootstrap's built in collapse
                                            functionality. <strong>Click on the card header</strong> to see the card body
                                            collapse and expand!
                                        </div>
                                    </div>
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
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="../logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery Core JS -->
        <script src="https://code.jquery.com/jquery.min.js"></script>
        <!-- BootStrap JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
        <!-- jQuery Easing JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- Custom Theme JS -->
        <script src="../custom-js/script-all.min.js"></script>

    </body>

</html>