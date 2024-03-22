<?php

if (isset($_POST['addClass'])) {
    // Get the selected courses from the form
    $selectedCourses = $_POST['coursecode'];
    // Time slots and days
    $time_slots = array("08:00:00", "09:00:00", "10:00:00", "11:00:00", "12:00:00", "13:00:00", "14:00:00", "15:00:00", "16:00:00", "17:00:00", "18:00:00");
    $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];

     // Fetch class slots for all selected courses outside the loop
    $classSlots = [];
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
        echo "<tr>";
        echo "<td>$time</td>";
        
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
                    if ($slot["start_time"] == $time && $slot["class_day"] == $day) {
                        echo $slot['course_code'] . "<br> (" . $slot['slot_type'] . ") <br>" . $slot['class_location'];
                        break; // Exit all loops
                    }
                }
            }
            $classSlotFound = true;
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
}


/*function displayClassSlots($class_slots) {
    // Time slots and days
    $time_slots = array("08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00");
    $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];
    
    // Display time slots and class slots
    foreach ($time_slots as $time) {
        echo "<tr>";
        echo "<td>$time</td>";
        // Display class slots for each day
        for ($i = 1; $i <= 5; $i++) {
            echo "<td>";
            // Check if there is a class slot at this time and day
            if (isset($class_slots[$time]) && isset($class_slots[$time][$days[$i]])) {
                foreach ($class_slots[$time] as $slot) {
                    // Check if the class slot spans multiple time slots
                    if ($slot['start_time'] == $time && $slot['class_day'] == $days[$i]) {
                        // Calculate the duration in time slots
                        $duration = (strtotime($slot['end_time']) - strtotime($slot['start_time'])) / (60 * 50);
                        // Display the class slot
                        echo $slot['course_code'] . " (" . $slot['slot_type'] . ") <br>" . $slot['class_location'] . " <br>";
                        // Adjust column span for the next time slots
                        echo "<td colspan='$duration'></td>";
                        // Skip the remaining time slots covered by this class slot
                        $i += $duration - 1;
                    }
                }
            }
            echo "</td>";
        }
        echo "</tr>";
    }
}*/
?>