<?php
include $_SERVER['DOCUMENT_ROOT'] . '/conn.php';

if (isset($_GET["id"])) {
    $id = $_GET['id'];
    $sql = "SELECT *, fatoora.id AS fatid, customer.name AS customer_name, customer.phone_number AS customer_phone FROM fatoora LEFT JOIN customer ON customer.id = fatoora.customer_id WHERE fatoora.id='$id'";
    $query = $conn->query($sql);
    $fatoora = $query->fetch_assoc();

    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اناقة اوشن للخيـــاطة الرجالية</title>
    <style>
        body{
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
            background-color:#A3C3C8;
        }
        img{
            width:300px;
        }
    </style>
</head>
<body>
    <h1 > 
        <?php 
            if($fatoora['ready'] == "1"){
                echo "ثوبك جاهز";
            }else{
                echo "جاري تجهيز الثوب";
            }
        ?>
    </h1>
    <?php 
            if($fatoora['ready'] == "1"){
                echo "<img src='./images/ready.png' >";
            }else{
                echo "<img src='./images/not_ready.png' >";
            }
        ?>
    <h4>
    <?php 
            if($fatoora['ready'] == "1"){
                echo "تقدر تستلم ثوبك و تتكشخ فيه";
            }else{
                echo "<h5>المدينة المنورة - شارع الملك عبدالعزيز - مقابل مطعم الرومانسية</h5>
                <h4 style='margin:0px;'>
                    جوال: 0530637494
                </h4>";
            }
        ?>

    </h4>
</body>
</html>

<?php

}else{
    echo "please pass a fatoora id";
}