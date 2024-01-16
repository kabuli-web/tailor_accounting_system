<?php
include 'includes/session.php';

if (isset($_POST['edit']) && isset($_POST['id'])) {
    $product_id = $_POST['id'];
    $name = $_POST['edit_name'];
    $price = $_POST['edit_price'];
    $stock = $_POST['edit_stock'];

    // Validate input data (you can add more validation as needed)
    if (empty($name) || empty($price) || empty($stock)) {
        $_SESSION['error'] = 'Fill up the edit form properly';
    } else {
        // Check if the product with the given ID exists
        $sql_check_product = "SELECT * FROM products WHERE id = ?";
        $stmt_check_product = $conn->prepare($sql_check_product);

        if (!$stmt_check_product) {
            die('Error preparing statement to check product: ' . $conn->error);
        }

        if (!$stmt_check_product->bind_param('i', $product_id)) {
            die('Error binding parameters to check product: ' . $stmt_check_product->error);
        }

        if ($stmt_check_product->execute()) {
            $result = $stmt_check_product->get_result();

            if ($result->num_rows === 1) {
                // Product exists, update it
                $sql_update_product = "UPDATE products SET name = ?, price = ?, stock = ? WHERE id = ?";
                $stmt_update_product = $conn->prepare($sql_update_product);

                if (!$stmt_update_product) {
                    die('Error preparing statement to update product: ' . $conn->error);
                }

                if (!$stmt_update_product->bind_param('sddi', $name, $price, $stock, $product_id)) {
                    die('Error binding parameters to update product: ' . $stmt_update_product->error);
                }

                if ($stmt_update_product->execute()) {
                    $_SESSION['success'] = 'Product updated successfully';
                } else {
                    $_SESSION['error'] = 'Error updating product: ' . $stmt_update_product->error;
                }

                $stmt_update_product->close();
            } else {
                $_SESSION['error'] = 'Product does not exist';
            }
        } else {
            $_SESSION['error'] = 'Error checking product: ' . $stmt_check_product->error;
        }

        $stmt_check_product->close();
    }
} else {
    $_SESSION['error'] = 'Invalid request';
}

header('location: product.php');
?>
