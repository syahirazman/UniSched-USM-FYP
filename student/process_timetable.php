<?php

require_once "../connection.php";

// display class slots of selected courses
$slots = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['coursecode']) && isset($_SESSION['student_email'])) {
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
                    $conflictingCourses[] = [
                        'course1' => $slot1['course_code'],
                        'course2' => $slot2['course_code'],
                        'day' => $slot1['class_day'],
                        'start_time' => $slot1['start_time'],
                        'end_time' => $slot1['end_time']
                    ];
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
                    
                    $conflictingCourses[] = [
                        'course1' => $slot1['course_code'],
                        'course2' => $savedSlot['course_code'],
                        'day' => $slot1['class_day'],
                        'start_time' => $slot1['start_time'],
                        'end_time' => $slot1['end_time']
                    ];
                    break;
                }
            }
        }
    }
    return $conflictingCourses;
}

?>