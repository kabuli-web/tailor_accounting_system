<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$description = $_POST['description'];
		$days = $_POST['days'];

		$sql = "UPDATE vacation_deductions SET description = '$description', days = '$days' WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Deduction updated successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Fill up edit form first';
	}

	header('location:vacation.php');

?>