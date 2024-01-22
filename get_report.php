<?php
include 'includes/session.php';

if (isset($_POST['start']) && isset($_POST['end'])) {
    $start = $_POST['start'] . ' 00:00:00';
    $end = $_POST['end'] . ' 23:59:59';
    $type = $_GET["type"];

    $sanad_sql = "SELECT * FROM sanad WHERE created_at BETWEEN '$start' AND '$end'";
    $sanads = $conn->query($sanad_sql);
    $sanads_array = [];

    while ($sanad = $sanads->fetch_assoc()) {
        $sanad['created_at'] = date('Y-m-d', strtotime($sanad['created_at']));
        $sanads_array[] = $sanad;
    }

    $expenses_sql = "SELECT * FROM expenses WHERE created_at BETWEEN '$start' AND '$end'";
    $expenses = $conn->query($expenses_sql);
    $expenses_array = [];

    while ($expense = $expenses->fetch_assoc()) {
        $expense['created_at'] = date('Y-m-d', strtotime($expense['created_at']));
        $expenses_array[] = $expense;
    }

    // Initialize $startDate and $endDate here
    $startDate = new DateTime($_POST['start']);
    $endDate = new DateTime($_POST['end']);

    $currentDate = clone $startDate;

 

    $report_data = [];

    while ($currentDate <= $endDate) {
        $total_expenses = 0;
        $formattedCurrentDate = ($type == 'monthly') ? $currentDate->format('Y-m') : $currentDate->format('Y-m-d');
    
        foreach ($expenses_array as $exp) {
            $dateTime = new DateTime($exp['created_at']);
            $formattedExpDate = ($type == 'monthly') ? $dateTime->format('Y-m') : $dateTime->format('Y-m-d');
            if ($formattedExpDate == $formattedCurrentDate) {
                $total_expenses += $exp['amount'];
            }
        }
    
        $total_sanads = 0;
        foreach ($sanads_array as $snd) {
            $dateTime = new DateTime($snd['created_at']);
            $formattedSndDate = ($type == 'monthly') ? $dateTime->format('Y-m') : $dateTime->format('Y-m-d');
          
            if ($formattedSndDate == $formattedCurrentDate) {
                $total_sanads += $snd['amount'];
            }
        }
    
        $report_data[] = array("date" => $formattedCurrentDate, "expenses" => $total_expenses, "sanads" => $total_sanads);
    
        if ($type == 'monthly') {
            $currentDate->modify('first day of next month');
        } else {
            $currentDate->modify('+1 day');
        }
    }
    
    echo json_encode($report_data);
}
?>
