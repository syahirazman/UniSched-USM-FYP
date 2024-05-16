<?php

require_once '../connection.php';

if (isset($_SESSION['student_email'])) {
    $student_email = $_SESSION['student_email'];
    $sqlStdID = "SELECT student_id FROM student_login WHERE student_email = '$student_email'";
    $resultStdID = $conn->query($sqlStdID);
    if ($resultStdID && $resultStdID->num_rows > 0) {
        $std = $resultStdID->fetch_assoc();
        $student_id = $std['student_id'];
    }

    $slotCourse = [];
    $slotPersonal = [];

    $sqlCourse = "SELECT st.slot_id, tm.course_code, tm.start_time, tm.end_time, tm.class_day, tm.class_location
                FROM student_timetable st
                JOIN timetable_mgmt tm ON st.slot_id = tm.slot_id
                WHERE st.student_id = '$student_id'";
    $resultCourse = $conn->query($sqlCourse);
    while ($rowCourse = $resultCourse->fetch_assoc()) {
        $slotCourse[] = $rowCourse;
    }

    $sqlPersonal = "SELECT * FROM student_personalslot WHERE pStudent_id = '$student_id'";
    $resultPersonal = $conn->query($sqlPersonal);
    while ($rowPersonal = $resultPersonal->fetch_assoc()) {
        $slotPersonal[] = $rowPersonal;
    }

    // Times and days
    $times = array("08:00:00", "09:00:00", "10:00:00", "11:00:00", "12:00:00", "13:00:00", "14:00:00", "15:00:00", "16:00:00", "17:00:00", "18:00:00", "19:00:00");
    $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");

    echo "<thead>";
    echo "<tr>";
    echo "<td style='width: 100px; background-color: #4e73df !important; font-weight:600; color: white;'>Time</td>";
    // Loop through the days of the week
    foreach ($days as $day) {
        echo "<td style='background-color: #4e73df !important; font-weight:600; color: white;'>$day</td>";
    }
    echo "</tr>";
    echo "</thead>";

    echo "<tbody>";

    // Initialize an array to track rowspans
    $rowspans = [];
    // Loop through the time slots
    foreach ($times as $time) {
        $format_time = date('H:i', strtotime($time));
        echo "<tr>";
        echo "<td style='background-color: #4e73df !important; font-weight:600; color: white;'>$format_time</td>";

        //display classes
        foreach ($days as $day) {
            if (isset($rowspans[$day][$format_time])) {
                // Skip this cell because it is covered by a rowspan
                continue;
            }
            $slotFound = false;
            foreach ($slotCourse as $slot1) {
                $slot1_time = date('H:i', strtotime($slot1["start_time"]));

                $startTime = new DateTime($slot1["start_time"]);
                $endTime = new DateTime($slot1["end_time"]);
                $interval = $startTime->diff($endTime);
                $durationInMinutes = $interval->h * 60 + $interval->i;
                $rowspan = ceil($durationInMinutes / 60);

                if ($slot1_time == $format_time && $slot1["class_day"] == $day) {
                    echo "<td rowspan='$rowspan' style='vertical-align:middle; background-color: rgba(78,115,223,0.1) !important; font-size: 16px; font-weight: 700;'>";
                    echo $slot1['course_code'] . "<br>" . $slot1['class_location'];
                    $slotFound = true;

                    // Mark the times that this rowspan will cover
                    for ($i = 1; $i < $rowspan; $i++) {
                        $next_time = date('H:i', strtotime("+$i hour", strtotime($format_time)));
                        $rowspans[$day][$next_time] = true;
                    }

                    break; // Exit all loops
                }
            }
            if (!empty($slotPersonal)) {
                foreach ($slotPersonal as $slot2){
                    $slot2_time = date('H:i', strtotime($slot2['pStart_time']));

                    $startTime = new DateTime($slot2["pStart_time"]);
                    $endTime = new DateTime($slot2["pEnd_time"]);
                    $interval = $startTime->diff($endTime);
                    $durationInMinutes = $interval->h * 60 + $interval->i;
                    $rowspan = ceil($durationInMinutes / 60);

                    if ($slot2_time == $format_time && $slot2["pClass_day"] == $day) {
                        echo "<td rowspan='$rowspan' style='vertical-align:middle; background-color: rgba(78,115,223,0.1) !important; font-size: 16px; font-weight: 700;'>";
                        echo $slot2['pSlot_title'] . "<br>" . $slot2['pClass_location'];
                        $slotFound = true;

                        for ($i = 1; $i < $rowspan; $i++) {
                            $next_time = date('H:i', strtotime("+$i hour", strtotime($format_time)));
                            $rowspans[$day][$next_time] = true;
                        }
                        
                        break; // Exit all loops
                    }
                }
            }
            if (!$slotFound) {
                echo "<td></td>";
            }

        }
        echo "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
}
?>