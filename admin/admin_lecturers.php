<!-- PHP -->
<?php
session_start();

// Check if the session variable is set
if (isset($_SESSION['admin_email'])) {
    $admin_email = $_SESSION['admin_email'];
    // Now you can use $admin_email in your HTML or PHP code
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
        
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

        <title>UniSched USM: Lecturers Management</title>
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
                <li class="nav-item">
                    <a class="nav-link ml-1" href="../admin/admin_dashboard.php">
                        <i class="fa fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>
                <hr class="sidebar-divider">
                <!-- nav 2 -->
                <li class="nav-item">
                    <a class="nav-link ml-1" href="">
                        <i class="fa fa-fw fa-calendar"></i>
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
                <!-- nav 4 -->
                <li class="nav-item active">
                    <a class="nav-link ml-1" href="../admin/admin_lecturers.php">
                        <i class="fa fa-fw fa-person-chalkboard"></i>
                        <span>Lecturers</span></a>
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
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 medium">Welcome, <?php echo $admin_email; ?>!</span>
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
                    <!-- End of Topbar -->

                    <!-- Begin page content -->
                    <div class="container-fluid">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4 ml-4">
                            <h1 class="h3 mb-0 text-gray-900">Lecturers Management</h1>
                        </div>
    
                        <!-- Table for CRUD -->

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <a href="#addLecturerModal" class="btn btn-success float-right" data-toggle="modal">
                                    <i class="fa-solid fa-plus"></i>
                                    <span>Add Lecturer Profile</span>
                                </a>						
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered hover text-gray-900 mt-3 mb-3" id="lecturerTable" width="100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Lecturer Name</th>
                                                <th>Title</th>
                                                <th>Email</th>
                                                <th>Room</th>
                                                <th>School</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>001</td>
                                                <td class="lecturer_name">Anusha Achutan</td>
                                                <td class="lecturer_title">Ts. Dr.</td>
                                                <td>anusha@usm.my</td>
                                                <td>Room 606</td>
                                                <td>School of Computer Sciences</td>
                                                <td class="action d-flex text-center justify-content-sm-around">
                                                    <a><i class="fa fa-pencil text-primary" aria-hidden="true"></i></a>
                                                    <a href="#deleteLecturerModal" data-toggle="modal"><i class="fa fa-trash text-danger" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>002</td>
                                                <td class="lecturer_name">Ahmad Sufril Azlan Mohamed</td>
                                                <td class="lecturer_overview">Associate Professor Dr.</td>
                                                <td>sufril@usm.my</td>
                                                <td>Room 520</td>
                                                <td>School of Computer Sciences</td>
                                                <td class="action d-flex text-center justify-content-sm-around">
                                                    <a><i class="fa fa-pencil text-primary" aria-hidden="true"></i></a>
                                                    <a href="#deleteLecturerModal" data-toggle="modal"><i class="fa fa-trash text-danger" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Course Modal HTML -->
        <div id="addLecturerModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">						
                            <h4 class="modal-title font-weight-bold text-gray-900">Add Lecturer</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body text-gray-900">					
                            <div class="form-group">
                                <label>ID</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Lecturer Name</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Room</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>School</label>
                                <input type="text" class="form-control" required>
                            </div>					
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                            <input type="submit" class="btn btn-success" value="Add">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Modal HTML -->
        <div id="deleteLecturerModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">						
                            <h4 class="modal-title font-weight-bold text-gray-900">Delete Lecturer</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body text-gray-900">					
                            <p>Are you sure you want to delete this lecturer profile?</p>
                            <p class="text-danger"><small>This action cannot be undone.</small></p>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                            <input type="submit" class="btn btn-danger" value="Delete">
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

        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script>
            new DataTable('#lecturerTable');
        </script>

    </body>
</html>