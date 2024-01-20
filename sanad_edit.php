<?php
    include 'includes/session.php';

    if(isset($_POST['edit'])){
		$sanad_id = $_POST['sanad_id'];
		$fatoora_id = $_POST['fatoora_id'];
        $amount = $_POST['amount'];
        $payment_method = $_POST['payment_method'];
            // Corrected UPDATE statement
            $sql = "UPDATE sanad SET payment_method = '$payment_method', amount = '$amount' WHERE id = '$sanad_id'";

            if($conn->query($sql)){

                // Get all receipts for the given fatoora_id
                $sql = "SELECT SUM(amount) as total_amount FROM sanad WHERE fatoora_id = '$fatoora_id'";
                $result = $conn->query($sql);

                if ($result) {
                    $row = $result->fetch_assoc();
                    $totalAmount = $row['total_amount'];

                    // Update the total_paid field in the fatoora table
                    $updateSql = "UPDATE fatoora SET total_paid = '$totalAmount' WHERE id = '$fatoora_id'";
                    $conn->query($updateSql);
                }

                $_SESSION['success'] = 'تم تحديث الايصال  بنجاح';
            }
            else{
                $_SESSION['error'] = $conn->error;
            }
        }
    
    else{
        $_SESSION['error'] = 'يرجى تعبئة الخانات المطلوبة';
    }

    header('location: sanad.php');
?>
