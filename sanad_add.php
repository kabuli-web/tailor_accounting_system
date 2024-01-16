<?php
    include 'includes/session.php';
    include 'services/insert_sanad.php';
    
    if(isset($_POST['add'])){
        $fatoora_id = $_POST['fatoora_id'];
        $amount = $_POST['amount'];
        $account_id = $_POST['account_id'];

        $sql = "SELECT * FROM fatoora WHERE id = '$fatoora_id'";
        $query = $conn->query($sql);

        if($query->num_rows < 1){
            $_SESSION['error'] = 'لا توجد فاتورة بهذا الرقم';
        }
        else{
            $fatoora = $query->fetch_assoc();
            $fatoora_id = $fatoora['id'];

            $res = insert_sanad($conn,$fatoora_id,$amount,$account_id);

            if( $res['success']){
                $_SESSION['success'] = 'تم اضافة سند القبض';
            }
            else{
                $_SESSION['error'] = $res['error'];
            }
        }
    }   
    else{
        $_SESSION['error'] = 'يرجى تعبئة الخانات المطلوبة';
    }
        header('location: sanad.php');
?>
