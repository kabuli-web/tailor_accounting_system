<?php
include 'includes/session.php';

if (isset($_POST['edit'])) {
    $fatoora_id = $_POST['fatoora_id'];
    // $name = $_POST['name'];
    // $phone_number = $_POST['phone_number'];
    $length = $_POST['length'];
    $shoulder = $_POST['shoulder'];
    $sleeve = $_POST['sleeve'];
    $chest = $_POST['chest'];
    $waist = $_POST['waist'];
    $neck = $_POST['neck'];
    $hand_loosing_left = $_POST['hand_loosing_left'];
    $hand_loosing_right = $_POST['hand_loosing_right'];
    $expand_down = $_POST['expand_down'];
    $thob_type = $_POST['thob_type'];
    $dd = isset($_POST['dd']) ? $_POST['dd'] : 0;
    $tatriz = $_POST['tatriz'];
    $buttons_type = $_POST['buttons_type'];
    $addons = isset($_POST['addons']) ? implode(",", $_POST['addons']) : '';
    $middle_design = $_POST['middle_design'];
    $side_pocket_design = $_POST['side_pocket_design'];
    $pocket_design = $_POST['pocket_design'];
    $sleeve_design = $_POST['sleeve_design'];
    $neck_design = $_POST['neck_design'];
    $neck_design_size = $_POST['neck_design_size'];
    $total = $_POST["total"];
    $total_paid = $_POST["total_paid"];
    $created_by = $user['username'];
    $ready = $_POST["ready"];


    // // Update customer details
    // $updateCustomer = "UPDATE customer SET name = '$name', phone_number = '$phone_number' WHERE id = (SELECT customer_id FROM fatoora WHERE id = '$fatoora_id')";
    // $conn->query($updateCustomer);

    // Update Fatoora details
    $updateFatoora = "UPDATE fatoora SET
        length = '$length', ready = '$ready',shoulder = '$shoulder', sleeve = '$sleeve', chest = '$chest', waist = '$waist', neck = '$neck',
        hand_loosing_left = '$hand_loosing_left', hand_loosing_right = '$hand_loosing_right', expand_down = '$expand_down',
        thob_type = '$thob_type', dd = '$dd', tatriz = '$tatriz', buttons_type = '$buttons_type', addons = '$addons',
        middle_design = '$middle_design', side_pocket_design = '$side_pocket_design', pocket_design = '$pocket_design',
        sleeve_design = '$sleeve_design', neck_design = '$neck_design', neck_design_size = '$neck_design_size',
        total = '$total', total_paid = '$total_paid'
        WHERE id = '$fatoora_id'";

    if ($conn->query($updateFatoora)) {
        $_SESSION['success'] = 'Fatoora entry updated successfully!';
    } else {
        $_SESSION['error'] = $conn->error;
    }
} else {
    $_SESSION['error'] = 'Invalid request.';
}

header('location: fatoora.php');
?>
