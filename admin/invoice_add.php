<?php
include 'includes/session.php';
function generateInvoiceId() {
    // Get the current date and time in the format YYYYMMDDHHMMSS
    $currentDateTime = date('YmdHis');

    // Append a pseudo-random single-digit number (0-9)
    $randomDigit = mt_rand(0, 9);

    // Combine the parts to form the invoice ID
    $invoiceId = 'INV/' . $currentDateTime . $randomDigit;

    return $invoiceId;
}
$unique_invoice_id = generateInvoiceId();

if (isset($_POST['add'])) {
    // Input validation
    $c_name = isset($_POST['c_name']) ? trim($_POST['c_name']) : '';
    $c_address = isset($_POST['c_address']) ? trim($_POST['c_address']) : '';
    $c_phone = isset($_POST['c_phone']) ? trim($_POST['c_phone']) : '';
    $c_vat = isset($_POST['c_vat']) ? trim($_POST['c_vat']) : '';
    $po_number = isset($_POST['po_number']) ? trim($_POST['po_number']) : '';
    $items = isset($_POST['items']) && is_array($_POST['items']) ? $_POST['items'] : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $due_date = isset($_POST['due_date']) ? $_POST['due_date'] : '';
    $payment_amount = isset($_POST['payment-amount']) ? trim($_POST['payment-amount']) : '';
    $payment_type = isset($_POST['payment-type']) ? trim($_POST['payment-type']) : '';
    $is_invoice_closed = 0;

    // Validate input data (you can add more validation as needed)
    if (empty($c_phone) || empty($items)) {
        $_SESSION['error'] = 'Fill up the add form properly add phone number and add items to the invoice'. $due_date;
    } else {
        $invoice_sub_total = 0;
        $invoice_vat = 0;
        $invoice_total = 0;

        foreach ($items as $item) {
            $invoice_sub_total += $item["item-total"];
        }
        
        $invoice_type = !empty($c_vat) ? "B2B" : "B2C";
        $invoice_vat = $invoice_sub_total * 0.15;
        $invoice_total = $invoice_sub_total + $invoice_vat;
        if(!empty($payment_amount)){
            if($payment_amount >= $invoice_total){
                $is_invoice_closed = 1;
            }else{
                $is_invoice_closed = 0;
            }
        }
        $sql_invoice = "INSERT INTO invoices (id, total, closed, customer_name, customer_phone, customer_vat, customer_address, due_date, description, invoice_type, po_number, division_id, issued_by) VALUES (?,?,?,?,?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt_invoice = $conn->prepare($sql_invoice);
        if (!$stmt_invoice) {
            die('Error preparing invoice: ' . $conn->error);
        }

        if (!$stmt_invoice->bind_param('sdisissssssii', $unique_invoice_id,$invoice_total,$is_invoice_closed, $c_name, $c_phone, $c_vat, $c_address, $due_date, $description, $invoice_type, $po_number, $user['division_id'], $user['id'])) {
            die('Error binding parameters for invoice: ' . $stmt_invoice->error);
        }

        // Validate and insert invoice record
        if ($stmt_invoice->execute()) {
            $stmt_invoice->close();
            $inserted_items = [];
           
            foreach ($items as $item) {
                $i_product_id = isset($item['product-id']) ? trim($item['product-id']) : '';
                
                // Prepare the SQL INSERT statement for invoice_items
                $sql_items = "INSERT INTO invoice_items (invoice_id, price, quantity, name, description, product_id, division_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
                
                // Create a prepared statement for invoice_items
                $stmt_items = $conn->prepare($sql_items);
        
                if (!$stmt_items) {
                    die('Error preparing invoice_items: ' . $conn->error);
                }
                
                // Bind the item values to the placeholders
                if (!$stmt_items->bind_param('sdisssi', $unique_invoice_id, $item['item-price'], $item['item-quantity'], $item['item-name'], $item['item-name'], $i_product_id,$user['division_id'])) {
                    die('Error binding parameters for invoice_items: ' . $stmt_items->error);
                }
        
                // Execute the statement for invoice_items
                if (!$stmt_items->execute()) {
                    die('Error executing insert into invoice_items: ' . $stmt_items->error);
                }
                
                $inserted_items[] = $conn->insert_id;
                
            }
            $stmt_items->close();
            if (!empty($payment_amount) && !empty($payment_type)) {
                $sql_reciepts = "INSERT INTO reciepts (invoice_id, amount, payment_type, division_id, issued_by) VALUES (?, ?, ?, ?, ?)";
                
                // Create a prepared statement for invoice_items
                $stmt_reciepts = $conn->prepare($sql_reciepts);
        
                if (!$stmt_reciepts) {
                    die('Error preparing reciepts: ' . $conn->error);
                }
                
                // Bind the item values to the placeholders
                if (!$stmt_reciepts->bind_param('sdsii', $unique_invoice_id, $payment_amount, $payment_type, $user['division_id'], $user['id'])) {
                    die('Error binding parameters for reciepts: ' . $stmt_reciepts->error);
                }
        
                // Execute the statement for invoice_items
                if (!$stmt_reciepts->execute()) {
                    die('Error executing insert into reciepts: ' . $stmt_reciepts->error);
                }
                $last_inserted_reciept_id = $conn->insert_id;
                $stmt_reciepts->close();
            }

            
            $_SESSION['success'] = 'Invoice created successfully Invoice No;'. $unique_invoice_id. 'Reciept id:'. $last_inserted_reciept_id ."Invoice Items Count:".sizeof($inserted_items) ;
        } else {
            
            $_SESSION['error'] = 'Error creating invoice: ' . $stmt_invoice->error;
        }
        

        
    }
} else {
    $_SESSION['error'] = 'Fill up the add form first';
}

header('location: invoice.php');
?>
