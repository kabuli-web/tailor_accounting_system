<?php
include 'includes/session.php';

if (isset($_GET["id"])) {
    $id = $_GET['id'];
    $sql = "SELECT *, fatoora.id AS fatid, customer.name AS customer_name, customer.phone_number AS customer_phone FROM fatoora LEFT JOIN customer ON customer.id = fatoora.customer_id WHERE fatoora.id='$id'";
    $query = $conn->query($sql);
    $fatoora = $query->fetch_assoc();
    $thob_type = $fatoora['thob_type'];
    $buttons_type = $fatoora['buttons_type'];
    $addonsArray = explode(',', $fatoora['addons']);
    $thob_type_arabic = "";
    switch ($thob_type){
        case "saudi":
            $thob_type_arabic = "سعودي | Saudi";
            break;
        case "qatari":
            $thob_type_arabic = "قطري | Qatari";
            break;
        case "kuwait":
            $thob_type_arabic = "قطري | kuwaiti";
            break;
    }

    $buttons_type_arabic = "";
    switch ($buttons_type){
        case "plastick":
            $buttons_type_arabic = "تك تك بلاستيك";
            break;
        case "iron_sadaf":
            $buttons_type_arabic = "تك تك مخفي حديد صدف";
            break;
        case "killer_iron":
            $buttons_type_arabic = "كف كلر حديد";
            break;
        case "iron":
            $buttons_type_arabic = "تك تك حديد";
            break;
        case "tarkebea":
            $buttons_type_arabic = "تركيبة";
            break;
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>فاتورة اناقة اوشن للخياطة الرجالية</title>

        <link rel="stylesheet"  href="fatoora_pdf.css">
    </head>
    <body>
        <div class="fatoora_head">
            <div class="logo">
                أوشن 
            </div>
            <div class="customer_logo">
            اناقـــة </br>اوشـــن للخيـــاطة الرجاليــــة 
            <h6 style="font-size:12px; margin:0px;">س.ت:4650249901</h6>
            <div class="customer_details">
                <div class="details">
                    الاسم: <?php echo $fatoora['customer_name']; ?>
                </div>
                <div class="details">
                    الجوال: <?php echo $fatoora['customer_phone']; ?>
                </div>
            </div>
            </div>
            <div class="date_id">
                <div class="id">
                    رقم الفاتورة: <?php echo $fatoora['fatid']; ?>
                </div>
                <div class="id">
                    التاريخ <?php echo date('d/m/Y', strtotime($fatoora['created_at'])); ?>
                </div>
            </div>
        </div>
        <div class="sizes">
            <table >
                    <tr class="header-row"><th colspan="8"><h4>المقاسات</h4></th></tr>
                    <tr>
                        <th>
                            الطول </br> Length 
                        </th>
                        <th>
                            اكتاف </br> Shoulder 
                        </th>
                        <th>
                            حلول كم </br> Sleeves 
                        </th>
                        <th>
                            وسع الصدر </br> Chest 
                        </th>
                        <th>
                            وسع الوسط </br> Waist 
                        </th>
                        <th>
                            الرقبة </br> Neck 
                        </th>
                        <th>
                            وسع اليـــد </br> hand Loosing 
                        </th>
                        <th>
                            وسع الاسفل </br> hand Loosing 
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $fatoora['length']; ?> cm
                        </td>
                        <td>
                            <?php echo $fatoora['shoulder']; ?> cm
                        </td>
                        <td>
                            <?php echo $fatoora['sleeve']; ?> cm
                        </td>
                        <td>
                            <?php echo $fatoora['chest']; ?> cm
                        </td>
                        <td>
                            <?php echo $fatoora['waist']; ?> cm
                        </td>
                        <td>
                            <?php echo $fatoora['neck']; ?> cm
                        </td>
                        <td>
                            L:<?php echo $fatoora['hand_loosing_left']; ?> cm | R:<?php echo $fatoora['hand_loosing_right']; ?>  cm
                        </td>
                        <td>
                            <?php echo $fatoora['expand_down']; ?> cm
                        </td>

                    </tr>
                    <tr class="header-row"><th colspan="8"><h4>التصميم</h4></th></tr>
                    <tr>
                        <th>
                            خياطة دبـــل </br> DD 
                        </th>
                        <th colspan="2">
                            رقــم التطريز</br> Tatriz No.
                        </th>
                        <th>
                            نوع الثوب</br> Type 
                        </th>
                        <th colspan="2">
                            نوع الازرار</br> Botton Type
                        </th>
                        <th colspan="2">
                            الاضافــات</br> Addons
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $fatoora['dd']==1 ? "نعم | yes" : "لا | NO";  ?>
                        </td>
                        <td colspan="2">
                            <?php echo $fatoora['tatriz']; ?>
                        </td>
                        <td>
                            <?php echo $thob_type_arabic ?>
                        </td>
                        <td colspan="2">
                            <?php echo $buttons_type_arabic ?>
                        </td>
                        <td colspan="3">
                            <?php 
                                foreach($addonsArray as $addon){
                                    echo $addon == "mobile_pocket"? "جيب جوال | mobile pocket":"جيب قبم | Pen pocket";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            تصميم الوسط</br> Middle Design
                        </th>
                        <th colspan="2">
                            تصميم الجيوب الامامية</br> Pocket Design.
                        </th>
                        <th colspan="2">
                            تصميم الجيوب الجانبية</br> Side Pocket Design 
                        </th>
                        <th colspan="2">
                            تصميم الرقبة</br> Neck Design
                        </th>
                        <th colspan="2">
                            تصميم الكبك</br> sleeve Design
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <img class="long_image" src="./images/<?php echo $fatoora['middle_design']; ?>.png" alt="">
                        </td>
                        <td colspan="2">
                            <img class="square_image" src="./images/<?php echo $fatoora['pocket_design']; ?>.png" alt="">
                        </td>
                        <td colspan="2">
                            <img class="long_image" src="./images/<?php echo $fatoora['side_pocket_design']; ?>.png" alt="">
                        </td>
                        <td colspan="2">
                            <h5>
                            مقاس تصميم الرقبة: <?php echo $fatoora['neck_design_size']; ?>
                            </h5>
                            <img class="square_image" src="./images/<?php echo $fatoora['neck_design']; ?>.png" alt="">
                        </td>
                        <td colspan="2">
                            <img class="square_image" src="./images/<?php echo $fatoora['sleeve_design']; ?>.png" alt="">
                        </td>
                    </tr>
            </table>
        </div>
        <div  class="note">
            <h4>ملاحظة | Note</h4>
            <textarea> <?php echo $fatoora['note']; ?></textarea>            
        </div>
        <div style="height:1px; border:1px dotted black; width:100%;"> </div>
        <div class="receipt">
        <table>
            <tr>
                <td>
                    
                    <h5>التاريخ: <?php echo date('d/m/Y', strtotime($fatoora['created_at'])); ?></h5>
                </td>
                <td>
                    <h5> اناقـــة  اوشـــن للخيـــاطة الرجاليــــة </h5>
                   
                </td>
                <td>
                    <h5>سند قبض</h5>
                    <h5>س.ت: 4650249901</h5>
                </td>
            </tr>
            <tr>
                <td>
                    <h5>الاسم: <?php echo $fatoora['customer_name']; ?></h5>
                </td>
                <td>
                <h5>رقم الجوال: <?php echo $fatoora['customer_phone']; ?></h5>
                </td>
                <td>
                <h5>رقم الفاتورة: <?php echo $fatoora['fatid']; ?></h5>
                </td>
            </tr>
            <tr>
                <td>
                    <h5>الاجمالي: <?php echo $fatoora['total']; ?> ريال</h5>
                </td>
                <td colspan="2" rowspan="3">
                    <ul style="direction:rtl;">
                        <li>المحل غير مسؤول عن الملابس التي يتأخر صاحبها لمدة شهرين دون المطالبة بها من تاريخ الفاتورة</li>
                        <li>دفع الأجرة المتراضي عليها من الطرفين عند الاتسلام كاملة</li>
                        <li>يجب دفع 50% مقدماً من اجمالي القيمة لتأكيد موعد الاستلام</li>
                        <li>في حالة الاتفاق على المبلغ و قص القماش لا يحق للزبون المطالبة باسترجاع المبلغ المدفوع ( العربون) و استلام الثياب و دفع القيمة</li>
                    </ul>
                </td>
            </tr>
            <tr >
                <td>
                <h5>المدفوع: <?php echo $fatoora['total_paid']; ?> ريال</h5>
                </td>
               
            </tr>
            <tr>
                <td>
                <h5>المتبقي: <?php echo $fatoora['total_paid'] - $fatoora['total']; ?> ريال</h5>
                </td>
                
            </tr>
            <tr >
                <td >
                    <div id="qr">

                    </div>
                </td>
                <td>
                    <h4 style="text-align:right;">امسح الباركود و تابع حالة الطلب</h4>
                </td>
                <td >
                <h5>المدينة المنورة - شارع الملك عبدالعزيز - مقابل مطعم الرومانسية</h5>
                <h4 style="margin:0px;">
                    جوال: 0530637494
                </h4>
                </td>
                
                
            </tr>
        </table>
        </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="base64_array_buffer.js"></script>
  <script>     
          function generateTLVStrings(){
            //   const seller =  "اناقة اوشن للخياطة الرجالية";
            //   const taxNo = "none"
            //   const dateTime = new Date("<?php echo $fatoora['created_at'] ?>")
            //   // dateTime.setDate("2023-12-19T01:31:57.000+03:00")
            //   const total = "<?php echo $fatoora['total']; ?>" 
            //   const tax = "0"


            //   let result = new TLVCls(seller,taxNo,dateTime,total,tax);
            //   console.log(result.toBase64());
            //   console.log(result.decodeBase64());
            //   // const targetElement = document.getElementById('base64Display');
            //   // targetElement.innerHTML = `encoded:   ${result.toBase64()}`;


              var qrcode = new QRCode(document.getElementById("qr"), {
              text: "google.com",
              width: 90,
              height: 90,
              colorDark: "#000000",
              colorLight: "#ffffff",
              correctLevel: QRCode.CorrectLevel.H
              });
          }

          class TLVCls {
              constructor(seller, taxNo, dateTime, total, tax) {
                  this.seller = seller;
                  this.taxNo = taxNo;
                  this.dateTime = dateTime.toISOString();
                  this.total = total.toString();
                  this.tax = tax.toString();
              }

              getasText(tag, value) {
                  const hexTag = tag.toString(16).padStart(2, '0');
                  const hexLength = value.length.toString(16).padStart(2, '0');
                  const hexValue = Array.from(new Uint8Array(value))
                  .map((byte) => byte.toString(16).padStart(2, '0'))
                  .join('');
                  return hexTag + hexLength + hexValue;
              }

              getBytes(id, value) {
                  const idByte = id & 0xff;
                  const lengthByte = value.length & 0xff;
                  const result = new Uint8Array(2 + value.length);
                  result[0] = idByte;
                  result[1] = lengthByte;
                  result.set(value, 2);
                  return result;
              }

              getString() {
                  let tlvText = '';
                  tlvText += this.getasText(1, new TextEncoder('utf-8').encode(this.seller));
                  tlvText += this.getasText(2, new TextEncoder('utf-8').encode(this.taxNo));
                  tlvText += this.getasText(3, new TextEncoder('utf-8').encode(this.dateTime));
                  tlvText += this.getasText(4, new TextEncoder('utf-8').encode(this.total));
                  tlvText += this.getasText(5, new TextEncoder('utf-8').encode(this.tax));
                  return tlvText;
              }

              toString() {
                  return this.getString();
              }

              toBase64() {
                const tlvBytes = [];
                tlvBytes.push(...Array.from(this.getBytes(1, new TextEncoder('utf-8').encode(this.seller))));
                tlvBytes.push(...Array.from(this.getBytes(2, new TextEncoder('utf-8').encode(this.taxNo))));
                tlvBytes.push(...Array.from(this.getBytes(3, new TextEncoder('utf-8').encode(this.dateTime))));
                tlvBytes.push(...Array.from(this.getBytes(4, new TextEncoder('utf-8').encode(this.total))));
                tlvBytes.push(...Array.from(this.getBytes(5, new TextEncoder('utf-8').encode(this.tax))));
                const tlvData = new Uint8Array(tlvBytes);

                // Encode the binary data manually as base64
                const base64TLV = this.base64Encode(tlvData);

                return base64TLV;
              }

              // Base64 encode function (manual)
              base64Encode(arrayBuffer) {
                  const bytes = new Uint8Array(arrayBuffer);
                  let base64 = '';

                  for (let i = 0; i < bytes.byteLength; i += 3) {
                      const chunk = (bytes[i] << 16) | (bytes[i + 1] << 8) | bytes[i + 2];
                      base64 += chars[(chunk >> 18) & 0x3F];
                      base64 += chars[(chunk >> 12) & 0x3F];
                      base64 += chars[(chunk >> 6) & 0x3F];
                      base64 += chars[chunk & 0x3F];
                  }

                  const padding = bytes.byteLength % 3;
                  if (padding === 1) {
                      base64 = base64.slice(0, -2) + '==';
                  } else if (padding === 2) {
                      base64 = base64.slice(0, -1) + '=';
                  }

                  return base64;
              }


              toQrCode(width = 250, height = 250) {
                  const qr = qrcode(0, 'L'); // Level: L (Low)
                  qr.addData(this.toBase64());
                  qr.make();
                  const qrCode = qr.createDataURL(width, height);
                  return qrCode;
              }

              decodeBase64() {
                  // Manually decode the base64 string
                  const base64String = this.toBase64();
                  const base64Bytes = new Uint8Array(atob(base64String).split('').map(char => char.charCodeAt(0)));
                  const textDecoder = new TextDecoder('utf-8');
                  const decodedString = textDecoder.decode(base64Bytes);
                  return decodedString;
              }
            }
          $(document).ready(()=>{


            generateTLVStrings();
            
          
          })
    </script>

    </body>
    </html>


    <?php

}else{
    echo "error no id passed";
}