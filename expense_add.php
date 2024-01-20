<?php
    include 'includes/session.php';
    include 'services/insert_expense.php';
    
    if(isset($_POST['add'])){
        $description = $_POST['description'];
        $amount = $_POST['amount'];
        $account_id = $_POST['account_id'];

        $res = insert_expense($conn,$description,$amount,$account_id);

        if( $res['success']){
            $_SESSION['success'] = 'تم اضافة الايصال ';
        }
        else{
            $_SESSION['error'] = $res['error'];
        }
    }
    else{
        $_SESSION['error'] = 'يرجى تعبئة الخانات المطلوبة';
    }
    header('location: expense.php');
?>
