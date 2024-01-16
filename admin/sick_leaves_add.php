<?php
include 'includes/session.php';

if (isset($_POST['add'])) {
    // Input validation for sickleaves
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $days = isset($_POST['days']) ? intval($_POST['days']) : '';
    $employee_id = isset($_POST['employee']) ? intval($_POST['employee']) : 0; // Assuming employee_id is an integer
    $date = isset($_POST['date']) ? trim($_POST['date']) : '';

    // Validate input data for sickleaves
    if (empty($description) || $days <= 0 || $employee_id <= 0 || empty($date)) {
        $_SESSION['error'] = 'Fill up the add form properly';
    } else {
        // Initialize an array to store attendance IDs and dates
        $attendanceEntries = array();

        // Logic to create attendance records for each day of sick leave
        for ($i = 0; $i < $days; $i++) {
            $attendanceDate = date('Y-m-d', strtotime($date . " +$i day"));

            // Fetch scheduled in and out times from the schedule table
            $scheduleSql = "SELECT time_in, time_out FROM schedules WHERE id = (SELECT schedule_id FROM employees WHERE id = ?)";
            if (!$stmtSchedule = $conn->prepare($scheduleSql)) {
                die('Error preparing schedule statement: ' . $conn->error);
            }
            
            if (!$stmtSchedule->bind_param('i', $employee_id)) {
                die('Error binding parameters for schedule statement: ' . $stmtSchedule->error);
            }
            
            if (!$stmtSchedule->execute()) {
                die('Error executing schedule statement: ' . $stmtSchedule->error);
            }
            $stmtSchedule->bind_result($time_in, $time_out);
            $stmtSchedule->fetch();
            $stmtSchedule->close();

            $check_time_in = $time_in ? $time_in : '09:00:00'; // Default to 9 AM if not set in the schedule
            $check_time_out = $time_out ? $time_out : '17:00:00'; // Default to 5 PM if not set in the schedule

            // Prepared statement to prevent SQL injection for attendance
            $sqlAttendance = "INSERT INTO attendance (employee_id, date, time_in, time_out, status) VALUES (?, ?, ?, ?, 'Present')";
            $stmtAttendance = $conn->prepare($sqlAttendance);
            $stmtAttendance->bind_param('isss', $employee_id, $attendanceDate, $check_time_in, $check_time_out);

            // Validate and insert attendance record
            if ($stmtAttendance->execute()) {
                // Retrieve the auto-generated ID and date of the attendance record
                $attendanceEntries[] = array('id' => $stmtAttendance->insert_id, 'date' => $attendanceDate);
            } else {
                $_SESSION['error'] = 'Error creating attendance records: ' . $stmtAttendance->error;
                break; // Stop loop if an error occurs
            }

            $stmtAttendance->close();
        }

        // Prepared statement to prevent SQL injection for sickleaves
        $sqlSickLeave = "INSERT INTO sickleaves (description, days, employee_id, date, attendance_id) VALUES (?, ?, ?, ?, ?)";
        $stmtSickLeave = $conn->prepare($sqlSickLeave);
        $s_day =1.0;
        // Insert sick leave records and link them to the corresponding attendance records
        foreach ($attendanceEntries as $attendance) {
            $stmtSickLeave->bind_param('sdisi', $description, $s_day, $employee_id, $attendance['date'], $attendance['id']);

            if ($stmtSickLeave->execute()) {
                $_SESSION['success'] = 'Sick leave added successfully';
            } else {
                $_SESSION['error'] = 'Error creating sick leave record: ' . $stmtSickLeave->error;
                break; // Stop loop if an error occurs
            }
        }

        $stmtSickLeave->close();
    }
} else {
    $_SESSION['error'] = 'Fill up add form first';
}

header('location: sick_leaves.php');
?>
