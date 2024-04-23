<?php

ob_start();

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
    //$conflicts = false;
    $conflictingCourses = [];

    // detect conflicts between classes within the array
    foreach ($slots as $slot1) {
        foreach ($slots as $slot2) {
            if ($slot1['slot_id'] != $slot2['slot_id']) {
                if ($slot1['class_day'] == $slot2['class_day'] && (($slot1['start_time'] == $slot2['start_time'] || $slot1['end_time'] == $slot2['end_time'])) ) {
                    //$conflicts = true;
                    // Store conflicting course codes
                    $conflictingCourses[] = $slot1['course_code'];
                    $conflictingCourses[] = $slot2['course_code'];

                    break; // exit loops when conflict is detected
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
                if ($slot1['class_day'] == $savedSlot['class_day'] && (($slot1['start_time'] == $savedSlot['start_time'] || $slot1['end_time'] == $savedSlot['end_time'])) ) {
                     //$conflicts = true;
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


/*if (isset($_POST['addClass'])) {
    // Get the selected courses from the form
    $selectedCourses = $_POST['coursecode'];

    // Time slots and days
    $time_slots = array("08:00:00", "09:00:00", "10:00:00", "11:00:00", "12:00:00", "13:00:00", "14:00:00", "15:00:00", "16:00:00", "17:00:00", "18:00:00");
    $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];

    // Fetch class slots for all selected courses outside the loop
    $classSlots = [];
    // Fetch class slots for selected courses only if $classSlots is empty or doesn't contain data for the selected courses
    foreach ($selectedCourses as $selectedCourse) {
            $classSlots[$selectedCourse] = getClassSlotsForCourse($selectedCourse); // array contains selected data    
    }
    

    echo "<thead style='background-color: #FFD580 !important; font-weight:600;'>";
    echo "<tr>";
    echo "<td>Time</td>";
    // Loop through the days of the week
    foreach ($days as $day) {
        echo "<td>$day</td>";
    }
    echo "</tr>";
    echo "</thead>";

    echo "<tbody>";

    // Loop through the time slots
    foreach ($time_slots as $time) {
        $formatted_time = date('H:i', strtotime($time));
        echo "<tr>";
        echo "<td>$formatted_time</td>";
        
        // Loop through the days of the week
        foreach ($days as $day) {
            echo "<td style='font-size: 14px; font-weight: 600;'>";

            // Initialize a variable to track if a class slot is found for this time and day
            $classSlotFound = false;

            // Loop through the selected courses
            foreach ($selectedCourses as $selectedCourse) {
                // Fetch class slots for the selected course
                $class_slots = $classSlots[$selectedCourse];

                foreach ($class_slots as $slot) {
                    $slot_formatted_time = date('H:i', strtotime($slot["start_time"]));
                    if ($slot_formatted_time == $formatted_time && $slot["class_day"] == $day) {
                        echo $slot['course_code'] . "<br> (" . $slot['slot_type'] . ") <br>" . $slot['class_location'];
                        $classSlotFound = true;
                        break; // Exit all loops
                    }
                }
            }
        }
        // If no class slot is found for this time and day, display an empty cell
        if (!$classSlotFound) {
            echo "&nbsp;";
        }
        
        echo "</td>";
        echo "</tr>";
    }
    echo "</tbody>";

}
function getClassSlotsForCourse($course) {
    
    global $conn; 
    $sql = "SELECT * FROM timetable_mgmt WHERE course_code = '$course'";
    $result = $conn->query($sql);
    // Fetch the results into an array
    $classSlots = [];
    while ($row = $result->fetch_assoc()) {
        $classSlots[] = $row;
    }

    return $classSlots;
}*/


?>