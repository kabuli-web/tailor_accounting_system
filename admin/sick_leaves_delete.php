<?php
include 'includes/session.php';

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Fetch the attendance_id associated with the sick leave entry
    $fetchAttendanceIdSql = "SELECT attendance_id FROM sickleaves WHERE id = '$id'";
    $result = $conn->query($fetchAttendanceIdSql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $attendanceId = $row['attendance_id'];

        // Now, delete the sick leave entry
        $deleteSickLeaveSql = "DELETE FROM sickleaves WHERE id = '$id'";
        
        if ($conn->query($deleteSickLeaveSql)) {
            // If sick leave entry is deleted successfully, delete the corresponding attendance record
            $deleteAttendanceSql = "DELETE FROM attendance WHERE id = '$attendanceId'";
            
            if ($conn->query($deleteAttendanceSql)) {
                $_SESSION['success'] = 'Sick leave and corresponding attendance deleted successfully';
            } else {
                $_SESSION['error'] = 'Error deleting attendance record: ' . $conn->error;
            }
        } else {
            $_SESSION['error'] = 'Error deleting sick leave entry: ' . $conn->error;
        }
    } else {
        $_SESSION['error'] = 'Error fetching attendance ID';
    }
} else {
    $_SESSION['error'] = 'Select item to delete first';
}

header('location: sick_leaves.php');
?>
