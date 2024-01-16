<?php
    include 'includes/session.php';

    if(isset($_POST['delete'])){
        $id = $_POST['sanad_id'];
        $fatoora_id = $_POST['fatoora_id'];
        
        $sql = "DELETE FROM sanad WHERE id = '$id'";
        if($conn->query($sql)){

            // Get the total amount for the given fatoora_id
            $sql = "SELECT SUM(amount) as total_amount FROM sanad WHERE fatoora_id = '$fatoora_id'";
            $result = $conn->query($sql);

            if ($result) {
                $row = $result->fetch_assoc();
                $totalAmount = $row['total_amount'];

                // Update the total_paid field in the fatoora table
                $updateSql = "UPDATE fatoora SET total_paid = '$totalAmount' WHERE id = '$fatoora_id'";
                $conn->query($updateSql);
            } else {
                // If there are no more sanad entries, set total_paid to 0
                $updateSql = "UPDATE fatoora SET total_paid = 0 WHERE id = '$fatoora_id'";
                $conn->query($updateSql);
            }

            $_SESSION['success'] = 'تم حذف سند القبض';
        }
        else{
            $_SESSION['error'] = $conn->error;
        }
    }
    else{
        $_SESSION['error'] = 'اختار سند القبض';
    }

    header('location: sanad.php');
?>
