<?php

require_once "../connection.php";

// save selected class slots to database
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['saveSelectedSlot'])) {
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
            header("Location: student_timetable.php?msg=Courses are added to timetable successfully!");
            exit();
        }
    }
}

// clear all class slots of selected courses from the array
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clearSelectedSlot'])) {
    $slots = [];
    header("Location: student_timetable.php?msg=Courses are removed from draft timetable successfully!");
    exit();
}

// delete saved class slots from database
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteSavedSlot'])) {
    $slot_id = $_POST['slot_id'];
    $sql = "DELETE FROM student_timetable WHERE slot_id = '$slot_id'";

    if ($conn->query($sql)) {
        header("Location: student_timetable.php?msg=Courses are removed from timetable successfully!");
        exit();
    } else {
        header("Location: student_timetable.php?msg=Cannot perform your query, please try again.");
    }
}



// add personal class slots to database
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_personalSlot'])) {
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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_personalslot'])) {
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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_personalslot'])) {
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