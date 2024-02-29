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
        echo '<script>
            alert("Course information is inserted successfully");
            document.location="admin_courses.php";
        </script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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
    $course_id = $_POST['course_id'];

    // SQL INSERT query to course_mgmt table
    $sql = "UPDATE course_mgmt SET course_code = '$course_code', 
                                    course_name = '$course_name', 
                                    course_overview = '$course_overview', 
                                    semester = '$semester',
                                    school = '$school',
                                    lecturername = '$lecturer_name',
                                    lectureremail = '$lecturer_email',
                                    lecturerroom = '$lecturer_room',
                                    lecturername_1 = '$lecturer_name1',
                                    lectureremail_1 = '$lecturer_email1',
                                    lecturerroom_1 = '$lecturer_room1'
                                WHERE course_id = '$course_id'";

    if ($conn->query($sql)) {
        echo "<script>alert('Successfully updated course information!');window.location.href = 'admin_courses.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// delete course information
if (isset($_POST['delete'])) {
    $course_id = $_POST['course_id'];

    // SQL INSERT query to course_mgmt table
    $sql = "DELETE FROM course_mgmt WHERE course_id = '$course_id'";

    if ($conn->query($sql)) {
        echo "<script>alert('Successfully deleted course information!');window.location.href = 'admin_courses.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>