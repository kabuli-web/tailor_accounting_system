<?php 
	include 'includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$sql = "SELECT *, fatoora.id AS fatid, customer.name AS customer_name, customer.phone_number AS customer_phone FROM fatoora LEFT JOIN customer ON customer.id = fatoora.customer_id WHERE fatoora.id='$id'";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		echo json_encode($row);
	}
?>
