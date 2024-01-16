<?php
include 'includes/session.php';

// Check if ID is provided
if (isset($_GET['id'])) {
    $invoice_id = $_GET['id'];

    // Prepare SQL query to fetch invoice items
    $sql = "SELECT * FROM invoice_items WHERE invoice_id = ?";
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
    $items = [];

    // Fetch the items
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    // Close the statement
    $stmt->close();

    // You can now use $items array to display or process data
    // For example, you can return it as a JSON response
    echo json_encode($items);

} else {
    echo "No invoice ID provided";
}
?>
