

<?php
include 'includes/session.php';

if (isset($_GET["id"])) {
    // Get invoice by ID
    $invoice_id = $_GET["id"];
    $sql_invoice = "SELECT * FROM invoices WHERE id = ?";
    $stmt_invoice = $conn->prepare($sql_invoice);
    $stmt_invoice->bind_param('s', $invoice_id);
    $stmt_invoice->execute();
    $result_invoice = $stmt_invoice->get_result();
    $invoice = $result_invoice->fetch_assoc();
    $stmt_invoice->close();

    // Get division where invoice_id = $invoice['id']
    $sql_invoice_division = "SELECT * FROM division WHERE id = ?";
    $stmt_invoice_division = $conn->prepare($sql_invoice_division);
    if(!$stmt_invoice_division){
        die("Error executing query: " . $conn->error);
    };
    $stmt_invoice_division->bind_param('s', $invoice['division_id']);
    $stmt_invoice_division->execute();
    $result_invoice_division = $stmt_invoice_division->get_result();
    $invoice_division = $result_invoice_division->fetch_assoc();
    $stmt_invoice_division->close();

    // Get invoice_items where invoice_id = $invoice['id']
    $sql_invoice_items = "SELECT * FROM invoice_items WHERE invoice_id = ?";
    $stmt_invoice_items = $conn->prepare($sql_invoice_items);
    $stmt_invoice_items->bind_param('s', $invoice_id);
    $stmt_invoice_items->execute();
    $result_invoice_items = $stmt_invoice_items->get_result();
    $invoice_items = [];
    while ($row = $result_invoice_items->fetch_assoc()) {
        $invoice_items[] = $row;
    }
    $stmt_invoice_items->close();

    // Get reciepts where invoice_id = $invoice['id']
    $sql_invoice_reciepts = "SELECT * FROM reciepts WHERE invoice_id = ?";
    $stmt_invoice_reciepts = $conn->prepare($sql_invoice_reciepts);
    $stmt_invoice_reciepts->bind_param('s', $invoice_id);
    $stmt_invoice_reciepts->execute();
    $result_invoice_reciepts = $stmt_invoice_reciepts->get_result();
    $invoice_reciepts = [];
    $total_paid = 0;
    while ($row = $result_invoice_reciepts->fetch_assoc()) {
        $invoice_reciepts[] = $row;
        $total_paid = $total_paid + $row['amount'];
    }


    $stmt_invoice_reciepts->close();


    ?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo "" . $invoice_id; ?></title>
  <link rel="icon" type="image/png" href="https://dashboard.alraee.group/images/raee.png">
    <style>

      body { font-family: Arial, sans-serif; }
      .invoice-container { max-width: 700px; margin: auto; }

      .info-table { width: 100%; border-collapse: collapse; margin-top: 10px; min-height: 10px; }

      .info-table tr td:nth-child(1) { text-align: left; min-width: 10px;}
      .info-table tr td:nth-child(2) { text-align: center; min-width: 100px;}
      .info-table tr td:nth-child(3) { text-align: right; min-width: 10px;}

      .info-table th { border: 1px solid #ddd; padding: 3px; }
      .info-table th { text-align: left; background-color: #f2f2f2; }
      .info-table th { border: 1px solid #ddd; }

      .info-table td { border: 1px solid #ddd; }
      .info-table td { border: 1px solid #ddd; padding: 3px; }

      .header { text-align: center; display: flex; justify-content: space-between; align-items: center; }
      .header img { max-width: 100px; }
      .invoice-title { margin-top: 20px; }
      .totals-table td, .totals-table th { border: 1px solid #ddd; padding: 3px; }
      .items-table { width: 100%; border-collapse: collapse; margin-top: 20px; margin-bottom: 20px; }
      .items-table th { border: 1px solid #ddd; padding: 8px 0px; text-align: center;}
      .items-table td { border: 1px solid #ddd; padding: 8px 8px; text-align: center;}
      .items-table th { background-color: #f2f2f2; width: 25px; }
      .totals-table { min-width: 45%; margin-left: 3px; border-collapse: collapse; height: 20px; }
      .company-details-table { min-width: 45%; margin-right: 10%; height: 20px; }
      .right-align { text-align: right; }
      .items-table th { font-size: 10px; }
      .items-table th:nth-child(2) { width: 40%; }
      .items-table th:nth-child(2), .items-table td:nth-child(2) { text-align: left; }
      .items-table th:nth-child(1) { width: 10%; }
      td { font-size: 11px; }
      
      .reciepts { margin-top: 20px; margin-bottom: 20px; }
      .reciepts table { width: 50%; }
      .reciepts table th { font-size: 9px; text-align: left; }
      .totals-table tr td:nth-child(3), .company-details-table tr td:nth-child(3) { text-align: right; }
      .totals-table tr td:nth-child(2), .company-details-table tr td:nth-child(2) { text-align: center; }
      .totals-table tr td:nth-child(1), .company-details-table tr td:nth-child(1) { text-align: left; }
      .head-middle-content p { margin: 0px; }
      
      .footer { display: flex; justify-content: space-between; }

    </style>
</head>
<body>
  <div class="invoice-container">
    <div class="header">
    <img  style="width:100px;" src="<?php echo $invoice_division['logo'] ?>" alt="">
      <div class="head-middle-content">
        <p style="font-weight: bold; font-size:23px;">Tax Invoice - فاتورة ضريبية</p>
        <p style="font-size: 10px;">VAT:    <?php echo $invoice_division["vat"] ?>   :الرقم الضريبي </p>
      </div>
      <div id="qrcode">

      </div>
    
    </div>
    
    <div class="footer" style="padding-top: 10px;">
        <table class="info-table">
          <tr style="text-align: left; background-color: #ebe8e8;">
            <td style="text-align: left;">Customer Name <span style="float: right;">اسم العميل</span></td>
          </tr>
          <tr>
            <td style="text-align: center;"><?php echo $invoice["customer_name"] ?> </td>
          </tr>
          <tr style="text-align: left; background-color: #ebe8e8;">
            <td style="text-align: left;">Customer Address <span style="float: right;">عنوان العميبل</span></td>
          </tr>
          <tr>
            <td style="text-align: center;"><?php echo $invoice["customer_address"] ?> </td>
          </tr>
        </table>
        <table class="info-table">
          <tr>
            <td style="text-align: left; background-color: #ebe8e8;">Invoice Number:</td>
            <td><?php echo $invoice["id"] ?></td>
            <td style="text-align: left; background-color: #ebe8e8;"> رقم الفاتورة </td>
          </tr>
          <tr>
            <td style="text-align: left; background-color: #ebe8e8;">Invoice Date:</td>
            <td><?php echo $invoice["issue_date"] ?> </td>
            <td style="text-align: left; background-color: #ebe8e8;">تاريخ الفاتورة </td>
          </tr>
          <tr>
            <td style="text-align: left; background-color: #ebe8e8;">Due Date:</td>
            <td><?php echo $invoice["due_date"] ?> </td>
            <td style="text-align: left; background-color: #ebe8e8;">ترايخ الاستحقاق</td>
          </tr>
          <tr>
            <td style="text-align: left; background-color: #ebe8e8;">Customer VAT Number:</td>
            <td><?php echo $invoice["customer_vat"] ?>  </td>
            <td style="text-align: left; background-color: #ebe8e8;">:الرقم الضريبي للعميل </td>
          </tr>
          <tr>
            <td style="text-align: left; background-color: #ebe8e8;">Purchase Order: </td>
            <td><?php echo $invoice["po_number"] ?>  </td>
            <td style="text-align: left; background-color: #ebe8e8;">:أمر شراء</td>
          </tr>
        </table>
      </div>

    <table class="items-table" style="margin-bottom: 0px;">
      <tr>
        <th style="vertical-align: middle; text-align: center;">
            Seq<br/><p style="margin-top: 2px;">رقم</p>
        </th>
        <th style="vertical-align: middle; text-align: center;">
            Goods or Services Description<br style="margin-bottom: 2px;"/>
            <p style="margin-top: 2px;">وصف السلعة او الخدمة</p>
        </th>
        <th style="vertical-align: middle; text-align: center;">
            Quantity<br/><p style="margin-top: 2px;">الكمية</p>
        </th>
        <th style="vertical-align: middle; text-align: center;">
            Unit Price<br/><p style="margin-top: 2px;">سعر الوحدة</p>
        </th>
        <th style="vertical-align: middle; text-align: center;">
            <span style="font-size: 10px;">Total Amount</span><br/>
            <p style="margin-top: 2px; font-size: 8px;">مجموع القيمة الاجمالية</p>
        </th>
        <th style="vertical-align: middle; text-align: center;">
            VAT 15%<br/><p style="margin-top: 2px;">قيمة الضريبة</p>
        </th>
        <th style="vertical-align: middle; text-align: center;">
            Net Amount<br/><p style="margin-top: 2px; font-size: 7px;">القيمة الاجمالية مع الضريبة</p>
        </th>

      </tr>
      <?php
                  $count = 1;
                  $sub_total = 0;

                      foreach($invoice_items as $item){
                          $item_total =$item['price'] * $item['quantity'];
                          $item_total_vat = $item_total * 0.15;
                          $item_total_with_vat = $item_total_vat + $item_total;
                          $sub_total = $sub_total + $item_total;
                          ?>
                            <tr>
                                  <td><?php echo $count; ?></td>
                                  <td><?php echo $item['name']; ?></td>
                                  <td><?php echo $item['quantity']; ?></td>
                                  <td style="text-align: left;">SAR <span style="float: right;"><?php echo $item['price']; ?></span></td>
                                  <td style="text-align: left;">SAR <span style="float: right;"><?php echo $item_total; ?></span></td>
                                  <td style="text-align: left;">SAR <span style="float: right;"><?php echo  $item_total_vat;  ?></span></td>
                                  <td style="text-align: left;">SAR <span style="float: right;"><?php echo $item_total_with_vat; ?></span></td>
                            </tr>
                          <?php
                          $count++;
                      }
                  ?>
    </table>
    
    <table class="totals-table" style="padding-top: 0px; float: right; font-weight: bold;">
        <tr>
          <td style="text-align: left;">Total Amount <span style="float: right;">المجموع</span></td>
          <td style="text-align: left;">SAR <span style="float: right;"><?php echo $sub_total; ?></span></td>
          
        </tr>
        <tr>
          <td style="text-align: left;">Total Tax <span style="float: right;">مجموع الضريبة</span></td>
          <td style="text-align: left;">SAR <span style="float: right;"><?php echo $sub_total * 0.15; ?></span></td>
        </tr>
        <tr>
          <td style="text-align: left;">Net Total <span style="float: right;">مجموع الفاتورة</span></td>
          <td style="text-align: left;">SAR <span style="float: right;"><?php echo ($sub_total * 0.15) + $sub_total; ?></span></td>
        </tr>
        <tr>
          <td style="text-align: left;">Due amount  <span style="float: right;">:المبلغ المستحق</span></td>
          <td style="text-align: left;">SAR <span style="float: right; color: red;"><?php echo $total_paid - (($sub_total * 0.15) + $sub_total); ?></span></td>
        </tr>

    </table>

    <div class="reciepts">
      <table>
        <thead>
          <th>
            Reciept No.
          </th>
          <th>
            Amount
          </th>
          <th>
            Date
          </th>
          <th>
            Payment Method
          </th>
        </thead>
        <tbody>
        <?php 
        foreach($invoice_reciepts as $reciept) {
          $formated_date = "date";
          if (!empty($reciept['issue_date'])) {
            $date = new DateTime($reciept['issue_date']);
            $formated_date =  $date->format('d-m-Y'); // Formats as Day-Month-Year
        }
            ?>

              <tr>
                <td>
                  <?php echo !empty($reciept['reciept_no'])? $reciept['reciept_no']:$reciept['id'] ;?>
                </td>
                <td>
                <?php echo "SAR " . $reciept['amount'] ;?>
                </td>
                <td>
                <?php echo  $formated_date ;?>
                </td>
                <td>
                <?php echo $reciept['payment_type'] ;?>
                </td>
              </tr>

            <?php
        }

          ?>
        </tbody>
      </table>
    </div>

    <div class="footer" style="padding-top: 10px;">
      <table class="company-details-table">
        <tr>
          <td>
          Company Name: 
          </td>
          <td class="right-align"> <?php echo $invoice_division['name']; ?> </td>
          <!-- <td>:اسم المنشاة</td> -->
        </tr>
        <tr>
          <td>Contact: </td>
          <td class="right-align"> <?php echo $invoice_division['contact']; ?> </td>
          <!-- <td>:رقم التواصل</td> -->
        </tr>
        <tr>
          <td>Company Address: </td>
          <td class="right-align"> <?php echo $invoice_division['address']; ?> </td>
          <!-- <td>:عنوان المنشاة</td> -->
        </tr>
      </table>
    </div>
    
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="base64_array_buffer.js"></script>
  <script>     
          function generateTLVStrings(){
              const seller =  "<?php echo $invoice_division['company_name'] ?>";
              const taxNo = "<?php echo $invoice_division['vat'] ?>"
              const dateTime = new Date("<?php echo $invoice['issue_date'] ?>")
              // dateTime.setDate("2023-12-19T01:31:57.000+03:00")
              const total = "<?php echo ($sub_total *0.15) + $sub_total; ?>" 
              const tax = "<?php echo $sub_total *0.15; ?>"


              let result = new TLVCls(seller,taxNo,dateTime,total,tax);
              console.log(result.toBase64());
              console.log(result.decodeBase64());
              // const targetElement = document.getElementById('base64Display');
              // targetElement.innerHTML = `encoded:   ${result.toBase64()}`;


              var qrcode = new QRCode(document.getElementById("qrcode"), {
              text: result.toBase64() ,
              width: 128,
              height: 128,
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


<?php
  } else {
      echo "NO invoice ID Provided";
  }
?>
</body>
</html>

