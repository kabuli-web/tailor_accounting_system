<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['delete_fatoora_id'];
		$sql = "DELETE FROM fatoora WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'fatoora deleted successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Select item to delete first';
	}

	header('location: fatoora.php');
	
?>