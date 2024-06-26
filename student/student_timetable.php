<!-- PHP -->
<?php

session_start();

require_once '../connection.php';
include_once 'process_timetable.php';

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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" >
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

        <!-- jQuery Core JS -->
        <script src="https://code.jquery.com/jquery.min.js"></script>
        <!-- BootStrap JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> 
        <!-- jQuery Easing JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- Custom Theme JS -->
        <script src="../custom-js/script-all.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        
        <title>UniSched USM: Class Timetable</title>
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
                <li class="nav-item active">
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
                        <span>Campus Map</span>
                    </a>
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

                    <div class="container-fluid" id="timetableCard">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4 ml-4">
                            <h1 class="h3 mb-0 text-gray-900">Class Timetable</h1>
                        </div>

                        <!-- display conflict alert showing a list of conflicting courses -->
                        <?php
                        
                        if (isset($_SESSION['conflicting_courses'])) {
                            $conflictingCourses = $_SESSION['conflicting_courses'];
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Scheduling conflict is found! <br>';
                            foreach ($conflictingCourses as $conflict) {
                                echo '<strong>' . $conflict['course1'] . ' and ' . $conflict['course2'] . ' on ' . $conflict['day'] . ' at ' . date('H:i', strtotime($conflict['start_time'])) . ' - ' . date('H:i', strtotime($conflict['end_time'])) . '</strong><br>';
                            }         
                            echo '  Please add another courses.
                                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close" onclick="reloadPage()">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                            unset($_SESSION['conflicting_courses']);
                            
                        }
                        
                        // display alerts related to personal class slots
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
                        <!-- script to reload page back to URL after closing alert -->
                        <script>
                            function reloadPage() {
                                window.location.href = 'student_timetable.php';
                            }
                        </script>

                        <div class="card shadow mb-2">
                            <form action="" method="GET" id="timetableForm">
                                <!-- select course code -->
                                <div class="card-header py-3">
                                    <div class="d-sm-flex align-items-center justify-content-between mb-2">
                                        <h5 class="text-gray-900">Draft your timetable: <i class="fas fa-xs fa-question-circle text-info pl-1 pr-1 opacity-50" data-bs-toggle="tooltip" data-bs-placement="right" title="Add course code to check class conflicts and insert to draft table"></i> </h5>
                                    </div>
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-md-4 mt-1">
                                            <select name="coursecode[]" id="coursecode" multiple="multiple" class="form-control" data-placeholder="Choose courses" required>
                                                <option></option>
                                                <?php
                                                    if ($conn->connect_error) {
                                                        die("Connection failed: " . $conn->connect_error);
                                                    }

                                                    $sql = "SELECT DISTINCT course_code FROM timetable_mgmt";
                                                    $result = $conn->query($sql);
                                                    if (!$result) {
                                                        die("Invalid query: " . $conn->connect_error); 
                                                    }
                                                    while ($row = $result->fetch_assoc()): ?>
                                                    <option value="<?= $row["course_code"] ?>"><?= $row["course_code"] ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary form-control" name="addClass" id="addClassBtn" value="Add">
                                        </div>
                                        			
                                    </div>
                                </div>
                            </form>
                            <!-- table to display class slots of selected courses in the array -->
                            <form action="student-crud.php" method="POST">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-gray-900 mt-3 mb-3" id="slotTable" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Course Code</th>
                                                    <th>Time from</th>
                                                    <th>Time until</th>
                                                    <th>Day</th>
                                                    <th>Location</th>      
                                                </tr>
                                            </thead>
                                            <tbody id="selectedSlotList">
                                                <?php
                                                $no = 1;
                                                foreach ($slots as $slotInfo):
                                                ?>
                                                 <tr class="text-center">
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $slotInfo["course_code"] ?></td>
                                                    <td><?= date('H:i', strtotime($slotInfo['start_time'])) ?></td>
                                                    <td><?= date('H:i', strtotime($slotInfo['end_time'])) ?></td>
                                                    <td><?= $slotInfo["class_day"] ?></td>
                                                    <td><?= $slotInfo["class_location"] ?></td>
                                                    <input type="hidden" name="slot_id[]" value="<?= $slotInfo['slot_id'] ?>">
                                                </tr>
                                                <?php
                                                endforeach; // Close the outer foreach loop
                                                ?>
                                            </tbody>
                                            
                                        </table>
                                    </div>	
                                </div>
                                <div class="card-footer d-flex justify-content-end">
                                    <input type="hidden" name="student_email" value="<?= $_SESSION['student_email'] ?>">
                                    <button type="submit" class="btn btn-success mr-2" name="saveSelectedSlot" data-bs-toggle="tooltip" data-bs-placement="left" title="Save and insert all courses to timetable"><i class="fas fa-save pr-2"></i>Save</button>
                                    <button type="submit" class="btn btn-danger" name="clearSelectedSlot" id="clearSelectedSlot" data-bs-toggle="tooltip" data-bs-placement="left" title="Remove all courses from draft selection."><i class="fa fa-trash fa-sm pr-2"></i>Clear</button>
                                </div>
                            </form>
                        </div>

                        <!-- table to display saved class slots of selected courses from the database -->
                        <div class="card border-left-info shadow mb-5" id="savedCourseTable">
                            <div class="card-body">
                                <div class="d-sm-flex align-items-center justify-content-between mb-2">
                                    <h5 class="text-gray-900">Your courses in current timetable: <i class="fas fa-xs fa-question-circle text-info pl-1 pr-1 opacity-50" data-bs-toggle="tooltip" data-bs-placement="right" title="These courses are confirmed to be displayed in your timetable"></i></h5>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-hover mb-3 text-dark" width="100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No.</th>
                                                <th>Course Code</th>
                                                <th>Time from</th>
                                                <th>Time until</th>
                                                <th>Day</th>
                                                <th>Location</th>
                                                <th>Action</th>      
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no=1;
                                            if (isset($student_email)):
                                                $emailsql = "SELECT student_id FROM student_login WHERE student_email = '$student_email'";
                                                $results = $conn->query($emailsql);
                                                if ($results && $results->num_rows > 0) {
                                                    $rowStudent = $results->fetch_assoc();
                                                    $student_id = $rowStudent['student_id'];
                                                }
                                                // Prepare the SQL query
                                                $joinsql = "SELECT st.slot_id, tm.course_code, tm.start_time, tm.end_time, tm.class_day, tm.class_location
                                                FROM student_timetable st
                                                JOIN timetable_mgmt tm ON st.slot_id = tm.slot_id
                                                WHERE st.student_id = '$student_id'";
                                                // Execute the query
                                                $slotresult = $conn->query($joinsql);
                                                
                                                while ($slotrow = $slotresult->fetch_assoc()):
                                            ?>
                                                <tr class="text-center">
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $slotrow["course_code"]?></td>
                                                    <td><?= date('H:i', strtotime($slotrow['start_time']))?></td>
                                                    <td><?= date('H:i', strtotime($slotrow['end_time']))?></td>
                                                    <td><?= $slotrow["class_day"]?></td>
                                                    <td><?= $slotrow["class_location"]?></td>
                                                    <td class="action d-flex text-center justify-content-sm-around">
                                                        <a href='' data-bs-toggle='modal' data-bs-target='#deleteClassModal<?= $no ?>'><i class='fa fa-trash text-danger' aria-hidden='true'></i></a>
                                                    </td>
                                                </tr>
                                                <!-- Delete Modal HTML -->
                                                <div id="deleteClassModal<?= $no ?>" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="process_timetable.php" method="POST">
                                                                <div class="modal-header">						
                                                                    <h4 class="modal-title font-weight-bold text-gray-900" id="staticBackdropLabel">Delete Class Slot</h4>
                                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                                                                </div>
                                                                <div class="modal-body text-gray-900">
                                                                    <input type="hidden" name="slot_id" value="<?= $slotrow['slot_id'] ?>">			
                                                                    <p>Are you sure you want to delete the class slot of this course? <br>
                                                                        <span class="text-danger font-weight-bold"><?= $slotrow["course_code"]?>:</span>
                                                                        <span class="text-danger font-weight-bold"><?= $slotrow["class_day"]?>, <?=  date('H:i', strtotime($slotrow['start_time']))?> - <?=  date('H:i', strtotime($slotrow['end_time']))?></span>
                                                                    </p>
                                                                    <p><small>This action cannot be undone. Make sure to delete all class slots of the same course.</small></p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel">
                                                                    <input type="submit" class="btn btn-danger" name="deleteSavedSlot" value="Delete">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>   
                                            <?php 
                                                endwhile;
                                            endif; 
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Add personal slots -->
                        <div class="card border-left-secondary shadow mb-4">
                            <div class="card-header py-3">
                                <div class="d-sm-flex align-items-center justify-content-between">
                                    <h5 class="text-gray-900">Your tutorial/lab/other slots: <i class="fas fa-xs fa-question-circle text-info pl-1 pr-1 opacity-50" data-bs-toggle="tooltip" data-bs-placement="right" title="Click button to add your personal slot or session"></i></h5> 
                                    <a href="#addPersonalSlotModal" class="btn btn-primary float-right" data-bs-toggle="modal">
                                        <i class="fa-solid fa-plus"></i>
                                        <span>Add Slot</span>
                                    </a>	
                                </div>
                                					
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-hover mb-3 text-dark" width="100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No.</th>
                                                <th>Slot title</th>
                                                <th>Time from</th>
                                                <th>Time until</th>
                                                <th>Day</th>
                                                <th>Location</th>
                                                <th>Action</th>      
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no=1;
                                            if (isset($student_email)):
                                                $emailsql = "SELECT student_id FROM student_login WHERE student_email = '$student_email'";
                                                $results = $conn->query($emailsql);
                                                if ($results && $results->num_rows > 0) {
                                                    $rowStudent = $results->fetch_assoc();
                                                    $student_id = $rowStudent['student_id'];
                                                }
                                                // Prepare the SQL query
                                                $sql = "SELECT * FROM student_personalslot WHERE pStudent_id = '$student_id'";
                                                // Execute the query
                                                $pslotresult = $conn->query($sql);
                                                
                                                while ($pslot = $pslotresult->fetch_assoc()):
                                            ?>
                                                <tr class="text-center">
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $pslot['pSlot_title']?></td>
                                                    <td><?= date('H:i', strtotime($pslot['pStart_time']))?></td>
                                                    <td><?= date('H:i', strtotime($pslot['pEnd_time']))?></td>
                                                    <td><?= $pslot["pClass_day"]?></td>
                                                    <td><?= $pslot["pClass_location"]?></td>
                                                    <td class="action d-flex text-center justify-content-sm-around">
                                                        <a href='' data-bs-toggle='modal' data-bs-target='#updatePersonalClassModal<?= $no ?>'><i class='fa fa-pencil text-primary' aria-hidden='true'></i></a>
                                                        <a href='' data-bs-toggle='modal' data-bs-target='#deletePersonalClassModal<?= $no ?>'><i class='fa fa-trash text-danger' aria-hidden='true'></i></a>
                                                    </td>
                                                </tr>

                                                <!-- Update Personal Class Modal -->
                                                <div id="updatePersonalClassModal<?= $no ?>" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <form action="student-crud.php" method="POST">
                                                                <div class="modal-header">						
                                                                    <h4 class="modal-title font-weight-bold text-gray-900" id="staticBackdropLabel">Update Personal Slot</h4>
                                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                                                                </div>
                                                                <div class="modal-body text-gray-900">
                                                                    <input type="hidden" name="personalslot_id" value="<?= $pslot['pSlot_id'] ?>">	
                                                                    <div class="form-group">
                                                                        <label for="personalSlotTitle">Slot Title:</label>
                                                                        <input type="text" class="form-control" name="personalSlotTitle" id="personalSlotTitle" placeholder="Enter your slot title" value="<?= $pslot["pSlot_title"] ?>" required>
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            <label for="personalStartTime">Start time:</label>
                                                                            <input type="time" name="personalStartTime" id="personalStartTime" min="08:00" max="18:00" class="form-control" value="<?= $pslot["pStart_time"] ?>" required>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="personalEndTime">End time:</label>
                                                                            <input type="time" name="personalEndTime" id="personalEndTime" min="08:00" max="18:00" class="form-control" value="<?= $pslot["pEnd_time"] ?>" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            <label for="personalClassDay">Day:</label>
                                                                            <select class="form-control" name="personalClassDay" id="personalClassDay" required>
                                                                                <option value="<?= $pslot["pClass_day"] ?>"><?= $pslot["pClass_day"] ?></option>
                                                                                <option value="Monday">Monday</option>
                                                                                <option value="Tuesday">Tuesday</option>
                                                                                <option value="Wednesday">Wednesday</option>
                                                                                <option value="Thursday">Thursday</option>
                                                                                <option value="Friday">Friday</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="personalClassLocation">Location:</label>
                                                                            <input type="text" class="form-control" name="personalClassLocation" id="personalClassLocation" placeholder="Enter location" value="<?= $pslot["pClass_location"] ?>" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <input type="hidden" name="student_email" value="<?= $_SESSION['student_email']?>">
                                                                    <input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel">
                                                                    <input type="submit" class="btn btn-success" value="Update" name="update_personalslot">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Delete Personal Class Modal HTML -->
                                                <div id="deletePersonalClassModal<?= $no ?>" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="student-crud.php" method="POST">
                                                                <div class="modal-header">						
                                                                    <h4 class="modal-title font-weight-bold text-gray-900" id="staticBackdropLabel">Delete Personal Slot</h4>
                                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                                                                </div>
                                                                <div class="modal-body text-gray-900">
                                                                    <input type="hidden" name="personalslot_id" value="<?= $pslot['pSlot_id'] ?>">			
                                                                    <p>Are you sure you want to delete this personal slot? <br>
                                                                        <span class="text-danger font-weight-bold"><?= $pslot["pSlot_title"]?>:</span>
                                                                        <span class="text-danger font-weight-bold"><?= $pslot["pClass_day"]?>, <?=  date('H:i', strtotime($pslot['pStart_time']))?> - <?=  date('H:i', strtotime($pslot['pEnd_time']))?></span>
                                                                    </p>
                                                                    <p><small>This action cannot be undone.</small></p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <input type="hidden" name="student_email" value="<?= $_SESSION['student_email']?>">
                                                                    <input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel">
                                                                    <input type="submit" class="btn btn-danger" name="delete_personalslot" value="Delete">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>   
                                            <?php 
                                                endwhile;
                                            endif; 
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Add Class Modal HTML -->
        <div id="addPersonalSlotModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form class="needs-validation" action="student-crud.php" method="POST">
                        <div class="modal-header">						
                            <h4 class="modal-title font-weight-bold text-gray-900" id="staticBackdropLabel">Add Personal Class Slot</h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body text-gray-900">
                            <div class="form-group">
                                <label for="personalSlotTitle">Slot Title:</label>
                                <input type="text" class="form-control" pattern="^.+$" name="personalSlotTitle" id="personalSlotTitle" placeholder="Enter your slot title" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="personalStartTime">Start time:</label>
                                    <input type="time" name="personalStartTime" id="personalStartTime" min="08:00" max="18:00" class="form-control" required>
                                    <div class="invalid-feedback">
                                        Please provide start time of the slot.
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="personalEndTime">End time:</label> <i class="fas fa-xs fa-question-circle text-info pr-1 opacity-50" data-bs-toggle="tooltip" data-bs-placement="right" title="End time of a slot cannot be same as start time"></i>
                                    <input type="time" name="personalEndTime" id="personalEndTime" min="08:00" max="18:00" class="form-control" required>
                                    <div class="invalid-time invalid-feedback">
                                        Please provide end time of the slot.
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="personalClassDay">Day:</label>
                                    <select class="form-control" name="personalClassDay" id="personalClassDay" required>
                                        <option></option>
                                        <option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select day of the class.
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="personalClassLocation">Location:</label>
                                    <input type="text" class="form-control" pattern="^.+$" name="personalClassLocation" id="personalClassLocation" placeholder="Enter location" required>
                                    <div class="invalid-feedback">
                                        Please provide location of the slot.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="student_email" value="<?= $_SESSION['student_email']?>">
                            <input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel">
                            <input type="submit" class="btn btn-success" value="Add" name="add_personalSlot">
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
                        <a class="btn btn-primary" href="../logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>


        <!-- JS initialize multiple selection -->
        <script>
            var select = $.noConflict();
            select(document).ready(function() {
                select('#coursecode').select2();
            })
        </script>

        <!-- JS initialize multiple table -->
        <script>
            new DataTable('#slotTable');
        </script>

        <!-- Script to print the content of a div -->
        <script> 
            function printDiv() { 
                var divContents = document.getElementById("savedCourseTable").innerHTML; 
                var originalContents = document.body.innerHTML;
                var originalContents = document.body.innerHTML; // Save original body content

                // Replace body content with divContents
                document.body.innerHTML = '<html><head><title>Print</title></head><body>' + divContents + '</body></html>';

                // Print the page
                window.print();

                // Restore original body content
                document.body.innerHTML = originalContents;
            } 
        </script>

        <!-- Script to invoke Bootstrap tooltip -->
        <script>
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        </script>

        
    </body>

</html>