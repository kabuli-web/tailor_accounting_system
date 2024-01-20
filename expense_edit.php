<?php
    include 'includes/session.php';

    if(isset($_POST['edit'])){
		$expense_id = $_POST['expense_id'];
		$description = $_POST['description'];

            
            $sql = "UPDATE expenses SET description = '$description' WHERE id = '$expense_id'";

            if($conn->query($sql)){
                $_SESSION['success'] = 'تم تحديث المصروف بنجاح';
            }
            else{
                $_SESSION['error'] = $conn->error;
            }
        }
    else{
        $_SESSION['error'] = 'يرجى تعبئة الخانات المطلوبة';
    }

    header('location: expense.php');
?>
