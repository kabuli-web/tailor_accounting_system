<?php
    include 'includes/session.php';

    if(isset($_POST['add'])){
        $name = $_POST['name'];
        $current_balance = $_POST['current_balance'];

        // Check if an account with the same name already exists
        $checkSql = "SELECT id FROM account WHERE name = '$name'";
        $checkResult = $conn->query($checkSql);

        if($checkResult->num_rows > 0){
            $_SESSION['error'] = 'An account with the same name already exists.';
        } else {
            // Insert the new account
            $insertAccountSql = "INSERT INTO account (name) VALUES ('$name')";

            if($conn->query($insertAccountSql)){
                // Get the ID of the newly inserted account
                $accountId = $conn->insert_id;
                $detail = 'فتح حساب ':
                // Insert a corresponding entry into the transactions table
                $insertTransactionSql = "INSERT INTO transactions (details,account_id, transaction_type, balance, foreign_id) VALUES ('$detail','$accountId', 'open', '$current_balance', 0)";

                if($conn->query($insertTransactionSql)){
                    $_SESSION['success'] = 'Account added successfully, and a corresponding transaction entry created.';
                } else {
                    $_SESSION['error'] = 'Error creating transaction entry: ' . $conn->error;
                }
            } else {
                $_SESSION['error'] = 'Error adding account: ' . $conn->error;
            }
        }
    } else {
        $_SESSION['error'] = 'Fill up add form first';
    }

    header('location: account.php');
?>
