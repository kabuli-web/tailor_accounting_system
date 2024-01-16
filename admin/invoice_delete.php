<?php
include 'includes/session.php';

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

  

    
    // If vacation entry is deleted successfully, delete the corresponding attendance record
    $deleteInvoiceSql = "DELETE FROM invoices WHERE id = '$id'";

    if ($conn->query($deleteInvoiceSql)) {
        $_SESSION['success'] = 'invoice deleted';
    } else {
        $_SESSION['error'] = 'Error deleting invoice record: ' . $conn->error;
    }
   
} else {
    $_SESSION['error'] = 'Select item to delete first';
}

header('location: invoice.php');
?>
