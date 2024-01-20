<?php
include 'includes/session.php';

if (isset($_GET['type']) && isset($_POST['start']) && isset($_POST['end'])) {
    $start = $_POST['start'] . ' 00:00:00';
    $end = $_POST['end'] . ' 23:59:59';
	$type = $_GET['type'];
	$dateFormat = 'Y-m-d';
	if($type == "daily"){
		$dateFormat = "Y-m-d";
		if (!isset($_POST['start'])) {
			$startDate = new DateTime();
			$startDate->modify('-30 days');
			$startDate = $startDate->format('Y-m-d');
		
			$endDate = new DateTime();
			$endDate = $endDate->format('Y-m-d');
		}
	}else{
		$dateFormat = "Y-m";
		if (!isset($_POST['start'])) {
			$startDate = new DateTime();
			$startDate->modify('-12 months');
			$startDate = $startDate->format('Y-m');
		
			$endDate = new DateTime();
			$endDate = $endDate->format('Y-m');
		}
	}
    $sanad_sql = "SELECT * FROM sanad WHERE created_at BETWEEN '$start' AND '$end'";
    $sanads = $conn->query($sanad_sql);
    $sanads_array = [];

    while ($sanad = $sanads->fetch_assoc()) {
        $sanad['created_at'] = date($dateFormat, strtotime($sanad['created_at']));
        $sanads_array[] = $sanad;
    }

    $expenses_sql = "SELECT * FROM expenses WHERE created_at BETWEEN '$start' AND '$end'";
    $expenses = $conn->query($expenses_sql);
    $expenses_array = [];

    while ($expense = $expenses->fetch_assoc()) {
        $expense['created_at'] = date($dateFormat, strtotime($expense['created_at']));
        $expenses_array[] = $expense;
    }

    // Initialize $startDate and $endDate here
    $startDate = new DateTime($_POST['start']);
    $endDate = new DateTime($_POST['end']);

    $currentDate = clone $startDate;

    $report_data = [];
    // Loop through each day
	while ($currentDate <= $endDate) {
		$total_expenses = 0;
		$formattedCurrentDate = $currentDate->format($dateFormat);
	
		// echo "Current Date: $formattedCurrentDate\n";
	
		foreach ($expenses_array as $exp) {
			$dbexpDate = new DateTime($exp['created_at']);
			$formattedExpDate = $dbexpDate->format($dateFormat);
			// echo "Expense formatted Date: $formattedExpDate\n";
			$dbexpDateStr = $dbexpDate->format($dateFormat); // Get the database date as a string
			// echo "Expense database Date: $dbexpDateStr\n";
		
			if ($formattedExpDate == $formattedCurrentDate) {
				$total_expenses = $total_expenses + $exp['amount'];
			}
		}
		
		$total_sanads = 0;
		foreach ($sanads_array as $snd) {
			$dbsndDate = new DateTime($snd['created_at']);
			$formattedSndDate = $dbsndDate->format($dateFormat);
			// echo "Sanad formatted Date: $formattedSndDate\n";
			$dbsndDateStr = $dbsndDate->format($dateFormat); // Get the database date as a string
			// echo "Sanad database Date: $dbsndDateStr\n";
		
			if ($formattedSndDate == $formattedCurrentDate) {
				$total_sanads = $total_sanads + $snd['amount'];
			}
		}
		
	
		$report_data[] = array("date" => $formattedCurrentDate, "expenses" => $total_expenses, "sanads" => $total_sanads);
	
		if($type == "daily"){
			$currentDate->modify('+1 day');
		}else{
			$currentDate->modify('+1 month');
		}
	}
	

    echo json_encode($report_data);
}
?>
