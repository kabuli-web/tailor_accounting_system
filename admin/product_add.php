<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$name = $_POST['name'];
		$price = $_POST['price'];
		$stock = $_POST['stock'];
		$division_id = $user['division_id'];


		$sql = "INSERT INTO products (name, price, stock, division_id) VALUES ('$name', '$price', '$stock', '$division_id')";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Product added successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}	
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: product.php');

?>