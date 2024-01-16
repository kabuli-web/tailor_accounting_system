<?php
include "insert_transaction.php";

function insert_sanad($conn,$fatoora_id,$amount,$account_id){
    $sql = "INSERT INTO sanad (account_id, amount, fatoora_id) VALUES ('$account_id', '$amount', '$fatoora_id')";

if($conn->query($sql)){
    $sanad_id = $conn->insert_id;
    // Get all receipts for the given fatoora_id
    $sql = "SELECT SUM(amount) as total_amount FROM sanad WHERE fatoora_id = '$fatoora_id'";
    $result = $conn->query($sql);
    if ($result) {
      
        insert_transaction($conn, $account_id, $sanad_id, $amount, "sanad");
        $row = $result->fetch_assoc();
        $totalAmount = $row['total_amount'];
        // Update the total_paid field in the fatoora table
        $updateSql = "UPDATE fatoora SET total_paid = '$totalAmount' WHERE id = '$fatoora_id'";
        $conn->query($updateSql);
    }

    return array("success"=>true);
}
else{
    return array("success"=>false,"error"=>$conn->error);
}
}