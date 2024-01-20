<?php
include 'includes/session.php';
include 'services/insert_sanad.php';

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
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
    $dd = $_POST['dd'];
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
    $account_id = $_POST["account_id"];
    $created_by = $user['username'];
    $note = $_POST["note"];
    
    
    function creat_fatoora($account_id,$conn,$customer_id,$name,$phone_number,$length,$shoulder,$sleeve,$chest,$waist,$neck,$hand_loosing_left,$hand_loosing_right,$expand_down,$thob_type,$dd,$tatriz,$buttons_type,$addons,$middle_design,$side_pocket_design,$pocket_design,$sleeve_design,$neck_design,$neck_design_size,$total,$total_paid,$created_by,$note){
         // Insert Fatoora information with customer_id
         $insertFatoora = "INSERT INTO fatoora (note,created_by, total, total_paid, customer_id, length, dd, shoulder, sleeve, chest, waist, neck, hand_loosing_left, hand_loosing_right, expand_down, thob_type, tatriz, buttons_type, addons, middle_design, side_pocket_design, pocket_design, sleeve_design, neck_design, neck_design_size) VALUES ( '$note','$created_by','$total','$total_paid','$customer_id', '$length','$dd', '$shoulder', '$sleeve', '$chest', '$waist', '$neck', '$hand_loosing_left', '$hand_loosing_right', '$expand_down', '$thob_type', '$tatriz', '$buttons_type', '$addons', '$middle_design', '$side_pocket_design', '$pocket_design', '$sleeve_design', '$neck_design', '$neck_design_size')";

         if ($conn->query($insertFatoora)) {
             $fatoora_id = $conn->insert_id; // Get the ID of the newly inserted fatoora


             $res = insert_sanad($conn,$fatoora_id,$total_paid,$account_id);

            if( $res['success']){
                $_SESSION['success'] = 'تم اضافة الفاتورة و الايصال ';
            }
            else{
                $_SESSION['error'] = $res['error'];
            }

         } else {
             $_SESSION['error'] = $conn->error;
         }
    }
    
    
        if (isset($_POST['add'])) {
        // Check if the customer already exists
        $sqlCustomer = "SELECT * FROM customer WHERE phone_number = '$phone_number'";
        $queryCustomer = $conn->query($sqlCustomer);

        if ($queryCustomer->num_rows < 1) {
            // Customer not found, insert new customer
            $insertCustomer = "INSERT INTO customer (name, phone_number) VALUES ('$name', '$phone_number')";
            if ($conn->query($insertCustomer)) {
                // Get the customer ID
                $customer_id = $conn->insert_id;

                creat_fatoora($account_id,$conn,$customer_id,$name,$phone_number,$length,$shoulder,$sleeve,$chest,$waist,$neck,$hand_loosing_left,$hand_loosing_right,$expand_down,$thob_type,$dd,$tatriz,$buttons_type,$addons,$middle_design,$side_pocket_design,$pocket_design,$sleeve_design,$neck_design,$neck_design_size,$total,$total_paid,$created_by,$note);
            }
            } else {
            // Customer already exists, use existing customer_id
            $rowCustomer = $queryCustomer->fetch_assoc();
            $customer_id = $rowCustomer['id'];

            creat_fatoora($account_id,$conn,$customer_id,$name,$phone_number,$length,$shoulder,$sleeve,$chest,$waist,$neck,$hand_loosing_left,$hand_loosing_right,$expand_down,$thob_type,$dd,$tatriz,$buttons_type,$addons,$middle_design,$side_pocket_design,$pocket_design,$sleeve_design,$neck_design,$neck_design_size,$total,$total_paid,$created_by,$note);
        }

        } else {
            $_SESSION['error'] = 'Fill up add form first';
        }
}
header('location: fatoora.php');
?>
