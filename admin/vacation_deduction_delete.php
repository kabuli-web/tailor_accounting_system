<?php
include 'includes/session.php';

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Fetch the attendance_id associated with the vacation entry
    $fetchAttendanceIdSql = "SELECT attendance_id FROM vacation_deductions WHERE id = '$id'";
    $result = $conn->query($fetchAttendanceIdSql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $attendanceId = $row['attendance_id'];

        // Now, delete the vacation entry
        $deleteVacationSql = "DELETE FROM vacation_deductions WHERE id = '$id'";
        
        if ($conn->query($deleteVacationSql)) {
            // If vacation entry is deleted successfully, delete the corresponding attendance record
            $deleteAttendanceSql = "DELETE FROM attendance WHERE id = '$attendanceId'";
            
            if ($conn->query($deleteAttendanceSql)) {
                $_SESSION['success'] = 'Vacation entry and corresponding attendance deleted successfully';
            } else {
                $_SESSION['error'] = 'Error deleting attendance record: ' . $conn->error;
            }
        } else {
            $_SESSION['error'] = 'Error deleting vacation entry: ' . $conn->error;
        }
    } else {
        $_SESSION['error'] = 'Error fetching attendance ID';
    }
} else {
    $_SESSION['error'] = 'Select item to delete first';
}

header('location: vacation.php');
?>
