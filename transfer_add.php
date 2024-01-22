<?php

    include 'includes/session.php';
    include "services/insert_transaction.php";
    if(isset($_POST['add'])){
        $from_account_id = $_POST['from_account_id'];
        $to_account_id = $_POST['to_account_id'];
        $amount = $_POST['amount'];
        // Check if there is enough balance for the expense
        if ($from_account_id != $to_account_id) {
                $transaction_result = insert_transaction($conn, $to_account_id, $from_account_id, $amount, "transfer");
                if ($transaction_result['success']) {
                    $_SESSION['success'] = 'تم التحويـــــــل ';
                } else {
                    $_SESSION['error'] = $transaction_result['error'];
                }
        } else {
            $_SESSION['error'] = "لا يمكنك التحويل الى نفس الحساب";
        }
    }
    
    else{
        $_SESSION['error'] = 'يرجى تعبئة الخانات المطلوبة';
    }
    header('location: account.php');
?>
