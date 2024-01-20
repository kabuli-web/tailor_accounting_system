<?php
include "insert_transaction.php";

function insert_expense($conn, $description, $amount, $account_id)
{
    // Get the last transaction made with the same account_id
    $lastTransactionSql = "SELECT * FROM transactions WHERE account_id = '$account_id' ORDER BY id DESC LIMIT 1";
    $lastTransactionResult = $conn->query($lastTransactionSql);

    if ($lastTransactionResult->num_rows > 0) {
        $lastTransaction = $lastTransactionResult->fetch_assoc();
        $current_balance = $lastTransaction['balance'];

        // Check if there is enough balance for the expense
        if ($amount <= $current_balance) {
            $sql = "INSERT INTO expenses (account_id, amount, description) VALUES ('$account_id', '$amount', '$description')";

            if ($conn->query($sql)) {
                $expense_id = $conn->insert_id;

                // Get all receipts for the given fatoora_id
                $transaction_result = insert_transaction($conn, $account_id, $expense_id, $amount, "expense");

                if ($transaction_result['success']) {
                    return array("success" => true);
                } else {
                    return array("success" => false, "error" => $transaction_result['error']);
                }
            } else {
                return array("success" => false, "error" => $conn->error);
            }
        } else {
            return array("success" => false, "error" => "Not enough balance for the expense.");
        }
    } else {
        return array("success" => false, "error" => "No previous transaction found for the account.");
    }
}
?>
