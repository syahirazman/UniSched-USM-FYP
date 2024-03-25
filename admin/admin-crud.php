<?php
include "../connection.php";

// add course information
if (isset($_POST['save'])) {
    $course_code = $_POST['coursecode'];
    $course_name = $_POST['coursename'];
    $course_overview = $_POST['courseoverview'];
    $semester = $_POST['semester'];
    $school = $_POST['school'];
    $lecturer_name = $_POST['lecturername'];
    $lecturer_email = $_POST['lectureremail'];
    $lecturer_room = $_POST['lecturerroom'];
    $lecturer_name1 = $_POST['lecturername_1'];
    $lecturer_email1 = $_POST['lectureremail_1'];
    $lecturer_room1 = $_POST['lecturerroom_1'];

    // SQL INSERT query to course_mgmt table
    $sql = "INSERT INTO course_mgmt (course_code, course_name, course_overview, semester, school, lecturername, lectureremail, lecturerroom, lecturername_1, lectureremail_1, lecturerroom_1) 
    VALUES ('$course_code','$course_name','$course_overview','$semester','$school','$lecturer_name','$lecturer_email', '$lecturer_room', '$lecturer_name1', '$lecturer_email1', '$lecturer_room1')";

    if ($conn->query($sql)) {
        //echo '<script> alert("Course information is inserted successfully");document.location="admin_courses.php";</script>';
        header("Location: admin_courses.php?msg=Course information is added successfully!");

    } else {
        header("Location: admin_courses.php?msg=Cannot perform your query, please try again.");
        //echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// update course information
if (isset($_POST['edit'])) {
    $course_code = $_POST['coursecode'];
    $course_name = $_POST['coursename'];
    $course_overview = $_POST['courseoverview'];
    $semester = $_POST['semester'];
    $school = $_POST['school'];
    $lecturer_name = $_POST['lecturername'];
    $lecturer_email = $_POST['lectureremail'];
    $lecturer_room = $_POST['lecturerroom'];
    $lecturer_name1 = $_POST['lecturername_1'];
    $lecturer_email1 = $_POST['lectureremail_1'];
    $lecturer_room1 = $_POST['lecturerroom_1'];
    //$course_id = $_POST['course_id'];

    // SQL INSERT query to course_mgmt table
    $sql = "UPDATE course_mgmt SET course_name = '$course_name', 
                                    course_overview = '$course_overview', 
                                    semester = '$semester',
                                    school = '$school',
                                    lecturername = '$lecturer_name',
                                    lectureremail = '$lecturer_email',
                                    lecturerroom = '$lecturer_room',
                                    lecturername_1 = '$lecturer_name1',
                                    lectureremail_1 = '$lecturer_email1',
                                    lecturerroom_1 = '$lecturer_room1'
                                WHERE course_code = '$course_code'";

    if ($conn->query($sql)) {
        header("Location: admin_courses.php?msg=Course information is updated successfully!");
    } else {
        header("Location: admin_courses.php?msg=Cannot perform your query, please try again.");
    }
}

// delete course information
if (isset($_POST['delete'])) {
    $course_code = $_POST['coursecode'];

    // Check if there are associated records in timetable_mgmt
    $check_query = "SELECT * FROM timetable_mgmt WHERE course_code = '$course_code'";
    $check_result = $conn->query($check_query);

    if ($check_result && $check_result->num_rows == 0) {
        // No associated records found, proceed with deletion
        $delete_query = "DELETE FROM course_mgmt WHERE course_code = '$course_code'";
        if ($conn->query($delete_query)) {
            // Deletion successful
            header("Location: admin_courses.php?msg=Course information is deleted successfully!");
            exit(); // Add exit() to stop script execution after redirect
        } else {
            // Deletion failed
            header("Location: admin_courses.php?msg=Cannot perform your query, please try again.");
            exit(); // Add exit() to stop script execution after redirect
        }
    } else {
        // Associated records found, do not proceed with deletion
        header("Location: admin_courses.php?msg=Cannot delete course. Associated records found in timetable_mgmt.");
        exit(); // Add exit() to stop script execution after redirect
    }
}


// add class slot information
if (isset($_POST['add_class'])) {
    $course_code = $_POST['coursecode'];
    $slot_type = $_POST['slottype'];
    $start_time = $_POST['starttime'];
    $end_time = $_POST['endtime'];
    $classday = $_POST['classDay'];
    $classlocation = $_POST['classLocation'];

    // SQL INSERT query to timetable_mgmt table
    $sql = "INSERT INTO timetable_mgmt (course_code, slot_type, start_time, end_time, class_day, class_location) 
    VALUES ('$course_code','$slot_type','$$start_time','$$end_time','$classday','$classlocation')";

    if ($conn->query($sql)) {
        //echo '<script> alert("Course information is inserted successfully");document.location="admin_courses.php";</script>';
        header("Location: admin_class-slots.php?msg=Class slot information is added successfully!");

    } else {
        header("Location: admin_class-slots.php?msg=Cannot perform your query, please try again.");
        //echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// update class slot information
if (isset($_POST['update_class'])) {
    $course_code = $_POST['coursecode'];
    $slot_type = $_POST['slottype'];
    $start_time = $_POST['starttime'];
    $end_time = $_POST['endtime'];
    $classday = $_POST['classDay'];
    $classlocation = $_POST['classLocation'];
    $slot_id = $_POST['slot_id'];

    // SQL INSERT query to timetable_mgmt table
    $sql = "UPDATE timetable_mgmt SET course_code = '$course_code', 
                                    slot_type = '$slot_type', 
                                    start_time = '$start_time',
                                    end_time = '$end_time',
                                    class_day = '$classday',
                                    class_location = '$classlocation'
                                WHERE slot_id = '$slot_id' ";

    if ($conn->query($sql)) {
        // echo "<script>alert('Successfully updated course information!');window.location.href = 'admin_courses.php';</script>";
        header("Location: admin_class-slots.php?msg=Class slot information is updated successfully!");
    } else {
        header("Location: admin_class-slots.php?msg=Cannot perform your query, please try again.");
    }
}

// delete class slot information
if (isset($_POST['delete_class'])) {
    $slot_id = $_POST['slot_id'];

    // SQL INSERT query to course_mgmt table
    $sql = "DELETE FROM timetable_mgmt WHERE slot_id = '$slot_id'";

    if ($conn->query($sql)) {
        // echo "<script>alert('Successfully deleted course information!');window.location.href = 'admin_courses.php';</script>";
        header("Location: admin_class-slots.php?msg=Class slot information is deleted successfully!");
    } else {
        header("Location: admin_class-slots.php?msg=Cannot perform your query, please try again.");
    }
}

?>