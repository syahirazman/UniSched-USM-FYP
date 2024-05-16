<?php

require_once "../connection.php";

// display class slots of selected courses
$slots = [];
if (isset($_GET['coursecode']) && isset($_SESSION['student_email'])) {
    $courseCode = $_GET['coursecode'];
    $courseCodesStr = implode("','", $courseCode);


    $sql = "SELECT * FROM timetable_mgmt WHERE course_code IN ('$courseCodesStr')";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
         while ($row = $result->fetch_assoc()) {
            $slots[] = $row;
        }
    }

    $student_email = $_SESSION['student_email'];
    $idsql = "SELECT student_id FROM student_login WHERE student_email = '$student_email'";
    $resultid = $conn->query($idsql);
    if ($resultid && $resultid->num_rows > 0) {
        $rowStudent = $resultid->fetch_assoc();
        $student_id = $rowStudent['student_id'];
        $_SESSION['student_id'] = $student_id;
    }

    if (isset($_SESSION['student_id'])) {
        $student_id = $_SESSION['student_id'];

        $conflictingCourses = detectConflicts($conn, $slots, $student_id);
        $conflictingCourses = array_unique($conflictingCourses);
        if (!empty($conflictingCourses)) {
            $_SESSION['conflicting_courses'] = $conflictingCourses;
            $slots=[];
        }
    }
}

// save selected class slots to database
if (isset($_POST['saveSelectedSlot'])) {
    if (isset($_POST['student_email'])) {
        $student_email = $_POST['student_email'];
        $emailsql = "SELECT student_id FROM student_login WHERE student_email = '$student_email'";
        $result = $conn->query($emailsql);
        if ($result && $result->num_rows > 0) {
            $rowStudent = $result->fetch_assoc();
            $student_id = $rowStudent['student_id'];
        }
        if (isset($_POST['slot_id'])) {
            $savedSlots = $_POST['slot_id'];
            foreach ($savedSlots as $slot_id) {
                $insertSql = "INSERT INTO student_timetable (student_id, slot_id) VALUES ('$student_id', '$slot_id')";
                if (!$conn->query($insertSql)) {
                    echo "Error: " . $insertSql . "<br>" . $conn->error;
                } 
            }
            header("Location: student_timetable.php");
            exit();
        }
    }
}


// function to detect conflicting classes by checking overlapping timeslots between classes in the array, and also the saved class slots
function detectConflicts ($conn, $slots, $student_id) {
    $conflictingCourses = [];

    // detect conflicts between classes within the array
    foreach ($slots as $slot1) {
        foreach ($slots as $slot2) {
            if ($slot1['slot_id'] != $slot2['slot_id']) {
                if ($slot1['class_day'] == $slot2['class_day'] && (($slot1['start_time'] == $slot2['start_time'] 
                || $slot1['end_time'] == $slot2['end_time'])) ) {
                    
                    // Store conflicting course codes
                    $conflictingCourses[] = $slot1['course_code'];
                    $conflictingCourses[] = $slot2['course_code'];
                    break; 
                }
            }
        }
    }

    // detect conflicts between class in array and saved class in student_timetable table
    $sql = "SELECT tm.course_code, tm.class_day, tm.start_time, tm.end_time
            FROM student_timetable st
            JOIN timetable_mgmt tm ON st.slot_id = tm.slot_id
            WHERE st.student_id = '$student_id'";
    $results = $conn->query($sql);
    if ($results && $results->num_rows > 0) {
        while ($savedSlot = $results->fetch_assoc()) {
            foreach ($slots as $slot1) {
                if ($slot1['class_day'] == $savedSlot['class_day'] && 
                (($slot1['start_time'] == $savedSlot['start_time'] || $slot1['end_time'] == $savedSlot['end_time'])) ) {
                    
                    $conflictingCourses[] = $slot1['course_code'];
                    $conflictingCourses[] = $savedSlot['course_code'];
                    break;
                }
            }
        }
    }
    return $conflictingCourses;
}


// clear all class slots of selected courses from the array
if (isset($_POST['clearSelectedSlot'])) {
    $slots = [];
    header("Location: student_timetable.php");
    exit();
}

// delete saved class slots from database
if (isset($_POST['deleteSavedSlot'])) {
    $slot_id = $_POST['slot_id'];
    $sql = "DELETE FROM student_timetable WHERE slot_id = '$slot_id'";

    if ($conn->query($sql)) {
        header("Location: student_timetable.php");
        exit();
    }
}



// add personal class slots to database
if (isset($_POST['add_personalSlot'])) {
    $pslot_title = $_POST['personalSlotTitle'];
    $pstart_time = $_POST['personalStartTime'];
    $pend_time = $_POST['personalEndTime'];
    $pclass_day = $_POST['personalClassDay'];
    $pclass_location = $_POST['personalClassLocation'];

    if (isset($_POST['student_email'])) {
        $pstudent_email = $_POST['student_email'];
        $emailsql = "SELECT student_id FROM student_login WHERE student_email = '$pstudent_email'";
        $result = $conn->query($emailsql);
        if ($result && $result->num_rows > 0) {
            $rowStudent = $result->fetch_assoc();
            $pstudent_id = $rowStudent['student_id'];
        }

        $sql = "INSERT INTO student_personalslot (pStudent_id, pSlot_title, pStart_time, pEnd_time, pClass_day, pClass_location)
        VALUES ('$pstudent_id', '$pslot_title', '$pstart_time', '$pend_time', '$pclass_day', '$pclass_location')";

        if ($conn->query($sql)) {
            header("Location: student_timetable.php?msg=Personal class slot is added successfully!");

        } else {
            header("Location: student_timetable.php?msg=Cannot perform your query, please try again.");
        }

    }
}

// update personal class slot
if (isset($_POST['update_personalslot'])) {
    $pslot_id = $_POST['personalslot_id'];
    $pslot_title = $_POST['personalSlotTitle'];
    $pstart_time = $_POST['personalStartTime'];
    $pend_time = $_POST['personalEndTime'];
    $pclass_day = $_POST['personalClassDay'];
    $pclass_location = $_POST['personalClassLocation'];

    if (isset($_POST['student_email'])) {
        $pstudent_email = $_POST['student_email'];
        $emailsql = "SELECT student_id FROM student_login WHERE student_email = '$pstudent_email'";
        $result = $conn->query($emailsql);
        if ($result && $result->num_rows > 0) {
            $rowStudent = $result->fetch_assoc();
            $pstudent_id = $rowStudent['student_id'];
        }

        $sql = "UPDATE student_personalslot SET pSlot_title = '$pslot_title',
                                                pStart_time = '$pstart_time',
                                                pEnd_time = '$pend_time',
                                                pClass_day ='$pclass_day',
                                                pClass_location = '$pclass_location'
                                            WHERE pSlot_id = '$pslot_id' AND pStudent_id = '$pstudent_id'";
        
        if ($conn->query($sql)) {
            header("Location: student_timetable.php?msg=Personal class slot is updated successfully!");
        } else {
            header("Location: student_timetable.php?msg=Cannot perform your query, please try again.");
        }
    }
}

// delete personal class slot from database
if (isset($_POST['delete_personalslot'])) {
    $pslot_id = $_POST['personalslot_id'];
    if (isset($_POST['student_email'])) {
        $pstudent_email = $_POST['student_email'];
        $emailsql = "SELECT student_id FROM student_login WHERE student_email = '$pstudent_email'";
        $result = $conn->query($emailsql);
        if ($result && $result->num_rows > 0) {
            $rowStudent = $result->fetch_assoc();
            $pstudent_id = $rowStudent['student_id'];
        }

        $sql = "DELETE FROM student_personalslot WHERE pSlot_id = '$pslot_id' AND pStudent_id = '$pstudent_id'";
        if ($conn->query($sql)) {
            header("Location: student_timetable.php?msg=Personal class slot is deleted successfully!");
        } else {
            header("Location: student_timetable.php?msg=Cannot perform your query, please try again.");
        }
    }
}

?>