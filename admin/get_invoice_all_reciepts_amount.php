<?php
include 'includes/session.php';

// Check if ID is provided
if (isset($_GET['id'])) {
    $invoice_id = $_GET['id'];

    // Prepare SQL query to fetch receipts for the provided invoice_id
    $sql = "SELECT * FROM reciepts WHERE invoice_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die('Error preparing statement: ' . $conn->error);
    }

    // Bind parameters and execute
    if (!$stmt->bind_param('s', $invoice_id)) {
        die('Error binding parameters: ' . $stmt->error);
    }

    if (!$stmt->execute()) {
        die('Error executing query: ' . $stmt->error);
    }

    $result = $stmt->get_result();
    $total_paid = 0;

    // Fetch the receipts and calculate the sum of the amount field
    while ($row = $result->fetch_assoc()) {
        $total_paid += $row['amount'];
    }

    // Close the statement
    $stmt->close();

    // Return the total_paid as JSON response
    echo json_encode($total_paid);

} else {
    echo "No invoice ID provided";
}
?>
