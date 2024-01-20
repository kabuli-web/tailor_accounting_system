<?php
    include 'includes/session.php';

    if(isset($_POST['delete'])){
        $id = $_POST['expense_id'];
        
        $sql = "DELETE FROM expenses WHERE id = '$id'";
        if($conn->query($sql)){

            $_SESSION['success'] = 'تم حذف الايصال ';
        }
        else{
            $_SESSION['error'] = $conn->error;
        }
    }
    else{
        $_SESSION['error'] = 'اختار الايصال ';
    }

    header('location: expense.php');
?>
