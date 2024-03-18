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


        <title>UniSched USM: Courses Management</title>
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
                    <a class="nav-link ml-1" href="../admin/admin_class-slots.php">
                        <i class="fa fa-fw fa-calendar"></i>
                        <span>Class slots</span></a>
                </li>
                <hr class="sidebar-divider">
                <!-- nav 3 -->
                <li class="nav-item active">
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
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 medium">Welcome, <?php echo $admin_email; ?>!</span>
                                    <img class="img-profile rounded-circle" src="../images/profile_icon.png">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#">
                                        <i class="fas fa-solid fa-plus fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Add new admin
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </nav>
                    <!-- End of Topbar -->

                    <!-- Begin page content -->
                    <div class="container-fluid">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4 ml-4">
                            <h1 class="h3 mb-0 text-gray-900">Courses Management</h1>
                        </div>

                        <!-- display alerts -->
                        <?php
                        if (isset($_GET['msg'])){
                            $msg = $_GET['msg'];

                            if ($msg == 'Cannot perform your query, please try again.') {
                                // display fail alert if GET parameter is not present (fails to add/update/delete course)
                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        '.$msg.'
                                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close" onclick="reloadPage()">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                            } else {
                                //display success alert if GET parameter is present (successfully add/update/delete course)
                                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        '.$msg.'
                                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close" onclick="reloadPage()">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                            }
                        }
                        ?>
                        <!-- script to reload page back to URL without GET parameter after closing alert -->
                        <script>
                            function reloadPage() {
                                window.location.href = 'admin_courses.php';
                            }
                        </script>
    
                        <!-- Table for CRUD -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <a href="#addCourseModal" class="btn btn-success float-right" data-bs-toggle="modal">
                                    <i class="fa-solid fa-plus"></i>
                                    <span>Add New Course</span>
                                </a>						
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered hover text-gray-900 mt-3 mb-3" id="courseTable" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Code</th>
                                                <th>Course Name</th>
                                                <th>Course Overview</th>
                                                <th>Semester</th>
                                                <th>School</th>
                                                <th>Lecturers</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // check connection
                                            if ($conn->connect_error) {
                                                die("Connection failed: " . $conn->connect_error);
                                            }

                                            // read all row from database table
                                            $no=1;
                                            $sql = "SELECT * FROM course_mgmt";
                                            $result = $conn->query($sql);
                                            if (!$result) {
                                                die("Invalid query: " . $conn->connect_error); 
                                            }

                                            // read data of each row
                                            while ($row = $result->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $row["course_code"]?></td>
                                                    <td><?= $row["course_name"] ?></td>
                                                    <td><?= $row["course_overview"] ?></td>
                                                    <td><?= $row["semester"] ?></td>
                                                    <td><?= $row["school"] ?></td>
                                                    <td><?= $row["lecturername"]?> <br> <?= $row["lectureremail"] ?> <br> <?= $row["lecturerroom"] ?> <br><br>
                                                    <?= $row["lecturername_1"] ?> <br> <?= $row["lectureremail_1"] ?><br> <?= $row["lecturerroom_1"] ?></td>
                                                    <td class='action text-center'>
                                                        <a href='' data-bs-toggle='modal' data-bs-target='#updateCourseModal<?= $no ?>'><i class='fa fa-pencil text-primary' aria-hidden='true'></i></a>
                                                        <a href='' data-bs-toggle='modal' data-bs-target='#deleteCourseModal<?= $no ?>' class='ml-3'><i class='fa fa-trash text-danger' aria-hidden='true'></i></a>
                                                    </td>
                                                </tr>

                                                     <!-- Update Modal -->
                                                    <div id="updateCourseModal<?= $no ?>" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <form class="updateCourseForm" action="admin-crud.php" method="POST">
                                                                    <div class="modal-header">						
                                                                        <h4 class="modal-title font-weight-bold text-gray-900" id="staticBackdropLabel">Update Course</h4>
                                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                                                                        
                                                                    </div>
                                                                    <div class="modal-body text-gray-900">
                                                                        <!--<input type="hidden" name="course_id" value="">-->
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md-6">
                                                                                <label for="coursecode">Course Code:</label>
                                                                                <input type="text" name="coursecode" id="coursecode" class="form-control" value="<?= $row["course_code"] ?>">
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <label for="semester">Semester:</label>
                                                                                <select class="form-control" name="semester" id="semester">
                                                                                    <option value="<?=$row["semester"] ?>"><?= $row["semester"] ?></option>
                                                                                    <option value="1">1</option>
                                                                                    <option value="2">2</option>
                                                                                    <option value="1 & 2">1 & 2</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="coursename">Course Name:</label>
                                                                            <input type="text" name="coursename" id="coursename" class="form-control" value="<?= $row["course_name"] ?>">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="courseoverview">Course Overview:</label>
                                                                            <textarea rows="5" name="courseoverview" id="courseoverview" class="form-control"><?= $row["course_overview"] ?></textarea>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="school">School:</label>
                                                                            <input type="text" name="school" id="school" class="form-control" placeholder="School of..." value="<?= $row["school"] ?>">
                                                                        </div>
                                                                        <div class="form-row align-items-center">
                                                                            <div class="col-md-7">
                                                                                <label for="lecturername">Lecturers in charge:</label>
                                                                                <input type="text" name="lecturername" id="lecturername" class="form-control" value="<?= $row["lecturername"] ?>">
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <label for="lectureremail">Email:</label>
                                                                                <input type="email" name="lectureremail" id="lectureremail" class="form-control" value="<?= $row["lectureremail"] ?>">
                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <label for="lecturerroom">Room:</label>
                                                                                <input type="text" name="lecturerroom" id="lecturerroom" class="form-control" value="<?= $row["lecturerroom"] ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-row align-items-center mt-2">
                                                                            <div class="col-md-7">
                                                                                <input type="text" name="lecturername_1" id="lecturername_1" class="form-control" value="<?= $row["lecturername_1"] ?>">
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <input type="email" name="lectureremail_1" id="lectureremail_1" class="form-control" value="<?= $row["lectureremail_1"] ?>">
                                                                            </div>
                                                                            <div class="col-sm-1">
                                                                                <input type="text" name="lecturerroom_1" id="lecturerroom_1" class="form-control" value="<?= $row["lecturerroom_1"] ?>">
                                                                            </div>
                                                                        </div>					
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel">
                                                                        <input type="submit" class="btn btn-success" name="edit" value="Update">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Delete Modal HTML -->
                                                    <div id="deleteCourseModal<?= $no ?>" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form action="admin-crud.php" method="POST">
                                                                    <div class="modal-header">						
                                                                        <h4 class="modal-title font-weight-bold text-gray-900" id="staticBackdropLabel">Delete Course</h4>
                                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                                                                    </div>
                                                                    <div class="modal-body text-gray-900">
                                                                        <!--<input type="hidden" name="course_id" value="">	-->				
                                                                        <p>Are you sure you want to delete this course? <br>
                                                                            <span class="text-danger font-weight-bold"><?= $row["course_code"]?> - <?= $row["course_name"]?></span>
                                                                        </p>
                                                                        <p><small>This action cannot be undone.</small></p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel">
                                                                        <input type="submit" class="btn btn-danger" name="delete" value="Delete">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
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

        <!-- Add Course Modal HTML -->
        <div id="addCourseModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form class="addCourseForm" action="admin-crud.php" method="POST">
                        <div class="modal-header">						
                            <h4 class="modal-title font-weight-bold text-gray-900" id="staticBackdropLabel">Add Course</h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body text-gray-900">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="coursecode">Course Code:</label>
                                    <input type="text" name="coursecode" id="coursecode" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="semester">Semester:</label>
                                    <select class="form-control" name="semester" id="semester" required>
                                        <option></option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="1 & 2">1 & 2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="coursename">Course Name:</label>
                                <input type="text" name="coursename" id="coursename" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="courseoverview">Course Overview:</label>
                                <textarea rows="5" name="courseoverview" id="courseoverview" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="school">School:</label>
                                <input type="text" name="school" id="school" class="form-control" placeholder="School of..." required>
                            </div>
                            <div class="form-row align-items-center">
                                <div class="col-md-7">
                                    <label for="lecturername">Lecturers in charge:</label>
                                    <input type="text" name="lecturername" id="lecturername" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="lectureremail">Email:</label>
                                    <input type="email" name="lectureremail" id="lectureremail" class="form-control" required>
                                </div>
                                <div class="col-sm-1">
                                    <label for="lecturerroom">Room:</label>
                                    <input type="text" name="lecturerroom" id="lecturerroom" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-row align-items-center mt-2">
                                <div class="col-md-7">
                                    <input type="text" name="lecturername_1" id="lecturername_1" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <input type="email" name="lectureremail_1" id="lectureremail_1" class="form-control">
                                </div>
                                <div class="col-sm-1">
                                    <input type="text" name="lecturerroom_1" id="lecturerroom_1" class="form-control">
                                </div>
                            </div>					
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel">
                            <input type="submit" class="btn btn-success" name="save" value="Add">
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Ready to Log Out?</h5>
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
        <script>
            new DataTable('#courseTable');
        </script>
        
       
    </body>
</html>