<?php
include 'includes/session.php';

if (isset($_POST['edit']) && isset($_POST['invoice_id'])) {
    $invoice_id = $_POST['invoice_id'];

    // Check if the invoice exists
    $sql_check_invoice = "SELECT * FROM invoices WHERE id = ?";
    $stmt_check_invoice = $conn->prepare($sql_check_invoice);

    if (!$stmt_check_invoice) {
        die('Error preparing statement to check invoice: ' . $conn->error);
    }

    if (!$stmt_check_invoice->bind_param('s', $invoice_id)) {
        die('Error binding parameters to check invoice: ' . $stmt_check_invoice->error);
    }

    if ($stmt_check_invoice->execute()) {
        $result = $stmt_check_invoice->get_result();
        if ($result->num_rows === 1) {
            // Invoice exists, update it
            $row = $result->fetch_assoc();

            // Input validation (similar to your add_invoice.php)
            $c_name = isset($_POST['edit_c_name']) ? trim($_POST['edit_c_name']) : $row['edit_customer_name'];
            $c_address = isset($_POST['edit_c_address']) ? trim($_POST['edit_c_address']) : $row['edit_customer_address'];
            $c_phone = isset($_POST['edit_c_phone']) ? trim($_POST['edit_c_phone']) : $row['edit_customer_phone'];
            $c_vat = isset($_POST['edit_c_vat']) ? trim($_POST['edit_c_vat']) : $row['edit_customer_vat'];
            $po_number = isset($_POST['edit_po_number']) ? trim($_POST['edit_po_number']) : $row['po_number'];
            $items = isset($_POST['items']) && is_array($_POST['items']) ? $_POST['items'] : '';
            $description = isset($_POST['edit_description']) ? trim($_POST['edit_description']) : $row['description'];
            $due_date = isset($_POST['edi_due_date']) ? $_POST['edi_due_date'] : $row['due_date'];

            $invoice_sub_total = 0;
            $invoice_vat = 0;
            $invoice_total = 0;
    
            foreach ($items as $item) {
                $invoice_sub_total += $item["item-total"];
            }
            

            // Update invoice fields if they changed
            if ($c_name != $row['customer_name'] || $c_address != $row['customer_address'] || $c_phone != $row['customer_phone'] || $c_vat != $row['customer_vat'] || $po_number != $row['po_number'] || $description != $row['description'] || $due_date != $row['due_date']) {
                $sql_update_invoice = "UPDATE invoices SET total = ?, customer_name = ?, customer_address = ?, customer_phone = ?, customer_vat = ?, po_number = ?, description = ?, due_date = ? WHERE id = ?";

                $stmt_update_invoice = $conn->prepare($sql_update_invoice);

                if (!$stmt_update_invoice) {
                    die('Error preparing statement to update invoice: ' . $conn->error);
                }

                if (!$stmt_update_invoice->bind_param('dssssssss', $invoice_total, $c_name, $c_address, $c_phone, $c_vat, $po_number, $description, $due_date, $invoice_id)) {
                    die('Error binding parameters to update invoice: ' . $stmt_update_invoice->error);
                }

                if ($stmt_update_invoice->execute()) {
                    $_SESSION['success'] = 'Invoice updated successfully ' . $invoice_id;
                } else {
                    $_SESSION['error'] = 'Error updating invoice: ' . $stmt_update_invoice->error;
                }

                $stmt_update_invoice->close();
            }

            // Check and update invoice items
            if (isset($items) && is_array($items)) {
                $existing_items = [];

                // Get existing items for this invoice
                $sql_existing_items = "SELECT * FROM invoice_items WHERE invoice_id = ?";
                $stmt_existing_items = $conn->prepare($sql_existing_items);

                if (!$stmt_existing_items) {
                    die('Error preparing statement to fetch existing items: ' . $conn->error);
                }

                if (!$stmt_existing_items->bind_param('s', $invoice_id)) {
                    die('Error binding parameters to fetch existing items: ' . $stmt_existing_items->error);
                }

                if ($stmt_existing_items->execute()) {
                    $existing_result = $stmt_existing_items->get_result();

                    while ($existing_item = $existing_result->fetch_assoc()) {
                        $existing_items[$existing_item['id']] = $existing_item;
                    }
                    $invoice_total = 0;
                    // Loop through submitted items
                    foreach ($items as $item) {
                        $item_id = $item['item-id'];
                        $item_price = $item['item-price'];
                        $item_quantity = $item['item-quantity'];
                        $item_name = $item['item-name'];
                        $invoice_total = $invoice_total + ($item['item-total'] * 0.15);
                        if (array_key_exists($item_id, $existing_items)) {
                            // Item exists, check if values have changed
                            $existing_item = $existing_items[$item_id];

                            if ($item_price != $existing_item['price'] || $item_quantity != $existing_item['quantity'] || $item_name != $existing_item['name']) {
                                // Update the item
                                $sql_update_item = "UPDATE invoice_items SET price = ?, quantity = ?, name = ? WHERE id = ?";
                                $stmt_update_item = $conn->prepare($sql_update_item);

                                if (!$stmt_update_item) {
                                    die('Error preparing statement to update item: ' . $conn->error);
                                }

                                if (!$stmt_update_item->bind_param('dssi', $item_price, $item_quantity, $item_name, $item_id)) {
                                    die('Error binding parameters to update item: ' . $stmt_update_item->error);
                                }

                                if ($stmt_update_item->execute()) {
                                    $_SESSION['success'] = 'Invoice and items updated successfully ' . $invoice_id;
                                } else {
                                    $_SESSION['error'] = 'Error updating item: ' . $stmt_update_item->error;
                                }

                                $stmt_update_item->close();
                            }
                        } else {
                            // Item does not exist, insert it
                            $sql_insert_item = "INSERT INTO invoice_items (invoice_id, price, quantity, name) VALUES (?, ?, ?, ?)";
                            $stmt_insert_item = $conn->prepare($sql_insert_item);

                            if (!$stmt_insert_item) {
                                die('Error preparing statement to insert item: ' . $conn->error);
                            }

                            if (!$stmt_insert_item->bind_param('sdss', $invoice_id, $item_price, $item_quantity, $item_name)) {
                                die('Error binding parameters to insert item: ' . $stmt_insert_item->error);
                            }

                            if ($stmt_insert_item->execute()) {
                                $_SESSION['success'] = 'Invoice and items updated successfully ' . $invoice_id;
                            } else {
                                $_SESSION['error'] = 'Error inserting item: ' . $stmt_insert_item->error;
                            }

                            $stmt_insert_item->close();
                        }
                    }

                   
                    // Delete items that are no longer present
                    foreach ($existing_items as $existing_item) {
                        if (!in_array($existing_item['id'], array_column($items, 'item-id'))) {
                            $sql_delete_item = "DELETE FROM invoice_items WHERE id = ?";
                            $stmt_delete_item = $conn->prepare($sql_delete_item);

                            if (!$stmt_delete_item) {
                                die('Error preparing statement to delete item: ' . $conn->error);
                            }

                            if (!$stmt_delete_item->bind_param('i', $existing_item['id'])) {
                                die('Error binding parameters to delete item: ' . $stmt_delete_item->error);
                            }

                            if ($stmt_delete_item->execute()) {
                                $_SESSION['success'] = 'Invoice and items updated successfully ' . $invoice_id;
                            } else {
                                $_SESSION['error'] = 'Error deleting item: ' . $stmt_delete_item->error;
                            }

                            $stmt_delete_item->close();
                        }
                    }

                    
                }
            }
        } else {
            $_SESSION['error'] = 'Invoice does not exist: ' . $invoice_id;
        }
    } else {
        $_SESSION['error'] = 'Error checking invoice: ' . $stmt_check_invoice->error;
    }

    $stmt_check_invoice->close();
} else {
    $_SESSION['error'] = 'Invalid request';
}

header('location: invoice.php');
?>
