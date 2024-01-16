<?php

function insert_transaction($conn, $account_id, $foreign_id, $amount, $transaction_type)
{
    // Get the last transaction made with the same account_id
    $lastTransactionSql = "SELECT * FROM transactions WHERE account_id = '$account_id' ORDER BY id DESC LIMIT 1";
    $lastTransactionResult = $conn->query($lastTransactionSql);

    if ($lastTransactionResult->num_rows > 0) {
        $lastTransaction = $lastTransactionResult->fetch_assoc();
        $current_balance = $lastTransaction['balance'];
    } else {
        return array("success" => false, "error" => "Cant find last transcation hence cant find balance.");
    }
    $detail = "";
    // Insert the transaction based on transaction type
    if ($transaction_type == 'sanad' || $transaction_type == 'expense') {
        // Adjust the balance based on transaction type
        $balance_adjustment = ($transaction_type == 'sanad') ? $amount : (-$amount);
       
       switch(){
        case "sanad":
            $detail = 'ايداع من المبيعات';
            break;

        case "expense":
            $detail = 'خصم للمصاريف ';
            break;
            
        }
        // Calculate the new balance
        $new_balance = $current_balance + $balance_adjustment;

        // Insert the transaction
        $sql = "INSERT INTO transactions (details, account_id, amount, transaction_type, balance, foreign_id) 
                VALUES ('$detail','$account_id', '$amount', '$transaction_type', '$new_balance', '$foreign_id')";

    } elseif ($transaction_type == 'transfer') {
        // Get the last transaction made with the same account_id
        $transactionIds = array("from_id" => null, "to_id" => null);
        $from_accounts_last_TransactionSql = "SELECT * FROM transactions WHERE account_id = '$foreign' ORDER BY id DESC LIMIT 1";
        $from_accounts_last_TransactionResult = $conn->query($from_accounts_last_TransactionSql);

        if ($from_accounts_last_TransactionResult->num_rows > 0) {
            $from_accounts_last_Transaction = $from_accounts_last_TransactionResult->fetch_assoc();
            $from_accounts_current_balance = $from_accounts_last_Transaction['balance'];
        } else {
            return array("success" => false, "error" => "Cant find last transcation for the account being transfered from hence cant find balance.");
        }

        // Check if the from account has sufficient balance for the transfer
        if ($from_accounts_current_balance >= $amount) {
            $detail = 'خصم لتحويل الى حساب اخر':
            
            // Insert the transaction for the account being transferred from (foreign_id)
            $from_balance = $from_accounts_current_balance - $amount;
            $sql_from = "INSERT INTO transactions (detailsوaccount_id, amount, transaction_type, balance, foreign_id) 
                         VALUES ('$detail','$foreign_id', '$amount', 'transfer', '$from_balance', '$account_id')";

            // Insert the transaction for the account being transferred to (account_id)
            $to_lastTransactionSql = "SELECT * FROM transactions WHERE account_id = '$account_id' ORDER BY id DESC LIMIT 1";
            $to_lastTransactionResult = $conn->query($to_lastTransactionSql);

            if ($to_lastTransactionResult->num_rows > 0) {
                $to_lastTransaction = $to_lastTransactionResult->fetch_assoc();
                $to_current_balance = $to_lastTransaction['balance'];
            } else {
                return array("success" => false, "error" => "Cant find last transcation for the account being transfered to hence cant find balance.");
            }

            $detail = 'ايداع لتحويل من حساب اخر':
            $to_balance = $to_current_balance + $amount;
            $sql_to = "INSERT INTO transactions (details, account_id, amount, transaction_type, balance, foreign_id) 
                       VALUES ('$detail','$account_id', '$amount', 'transfer', '$to_balance', '$foreign_id')";

            // Execute both queries
            $conn->begin_transaction();
            $conn->query($sql_from);
            $conn->query($sql_to);

            if ($conn->commit()) {
                
                $transactionIds['from_id'] = $conn->insert_id;
                $transactionIds['to_id'] = $conn->insert_id;
                return array("success" => true, "transaction_ids"=> $transactionIds);
            } else {
                return array("success" => false, "error" => $conn->error);
            }
        } else {
            return array("success" => false, "error" => "Insufficient balance for the transfer.");
        }
    }

    // Execute the query
    if ($conn->query($sql)) {
        return array("success" => true, "transaction_id" => $conn->insert_id);
    } else {
        return array("success" => false, "error" => $conn->error);
    }
}


?>
