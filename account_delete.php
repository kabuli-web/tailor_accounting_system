<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		$sql = "DELETE FROM account WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'تم حذف الحساب';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'ااختار الحساب اولاً';
	}

	header('location: account.php');
	
?>