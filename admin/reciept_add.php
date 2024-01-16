<?php
include 'includes/session.php';

if (isset($_POST['add'])) {
    $invoice_id = $_POST['invoice'];
    $amount_paid = $_POST['amount'];
    $payment_method = $_POST['payment_method'];

    // Validate input data (you can add more validation as needed)
    if (empty($invoice_id) || empty($amount_paid) || empty($payment_method)) {
        $_SESSION['error'] = 'Fill up the add form properly';
    } else {
        // Insert the receipt into the database
        $sql = "INSERT INTO reciepts (invoice_id, amount, payment_type, division_id, issued_by) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die('Error preparing statement: ' . $conn->error);
        }

        if (!$stmt->bind_param('sdsii', $invoice_id, $amount_paid, $payment_method, $user["division_id"], $user["id"])) {
            die('Error binding parameters: ' . $stmt->error);
        }

        if ($stmt->execute()) {
            // Calculate paid_amount
            $sql_paid_amount = "SELECT SUM(amount) AS paid_amount FROM reciepts WHERE invoice_id = ?";
            $stmt_paid_amount = $conn->prepare($sql_paid_amount);
            $stmt_paid_amount->bind_param('s', $invoice_id);
            $stmt_paid_amount->execute();
            $result_paid_amount = $stmt_paid_amount->get_result();
            $row_paid_amount = $result_paid_amount->fetch_assoc();
            $paid_amount = $row_paid_amount['paid_amount'];
            $stmt_paid_amount->close();

            // Calculate invoice_amount
            $sql_invoice_amount = "SELECT SUM((price * 0.15 + price) * quantity) AS invoice_amount FROM invoice_items WHERE invoice_id = ?";
            $stmt_invoice_amount = $conn->prepare($sql_invoice_amount);
            $stmt_invoice_amount->bind_param('s', $invoice_id);
            $stmt_invoice_amount->execute();
            $result_invoice_amount = $stmt_invoice_amount->get_result();
            $row_invoice_amount = $result_invoice_amount->fetch_assoc();
            $invoice_amount = $row_invoice_amount['invoice_amount'];
            $stmt_invoice_amount->close();


			echo "outside if ";
			echo $invoice_amount -$paid_amount;
            // Update invoices table if invoice_amount - paid_amount = 0
            if ($invoice_amount - $paid_amount == 0) {
				echo "entered if ";
				echo $invoice_amount -$paid_amount;
                $sql_update_invoices = "UPDATE invoices SET closed = 1 WHERE id = ?";
                $stmt_update_invoices = $conn->prepare($sql_update_invoices);
				if (!$stmt_update_invoices) {
					die('Error preparing statement: ' . $conn->error);
				}
                $stmt_update_invoices->bind_param('s', $invoice_id);
                $stmt_update_invoices->execute();
                $stmt_update_invoices->close();
            }

            $_SESSION['success'] = 'Receipt added successfully   '.$invoice_amount - $paid_amount;
        } else {
            $_SESSION['error'] = 'Error adding receipt: ' . $stmt->error;
        }

        $stmt->close();
    }
} else {
    $_SESSION['error'] = 'Invalid request';
}

header('location: reciept.php'); // Replace with the appropriate redirect URL
?>
