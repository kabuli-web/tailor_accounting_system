<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$name = $_POST['title'];


		$sql = "UPDATE account SET name = '$name' WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'تم تحديث الحساب';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'عبي النموذج اولاً';
	}

	header('location:account.php');

?>