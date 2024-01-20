<?php include 'includes/session.php'; ?>


<?php

if(isset($_GET['id'])){
  $account_id = $_GET['id'];
  $transaction_sql = "SELECT * FROM account WHERE id = '".$account_id."'";
  
  $account_query = $conn->query($transaction_sql);

  $account_result = $account_query->fetch_assoc();

  ?>
  <?php
  include './timezone.php';
  $range_to = date('m/d/Y');
  $range_from = date('m/d/Y', strtotime('-30 day', strtotime($range_to)));
?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>
  <?php 

    $to = date('Y-m-d');
    $from = date('Y-m-d', strtotime('-30 day', strtotime($to)));

    if(isset($_GET['range'])){
      $range = $_GET['range'];
      $ex = explode(' - ', $range);
      $from = date('Y-m-d', strtotime($ex[0]));
      $to = date('Y-m-d', strtotime($ex[1]));
    }
    $account = $_GET['id'];
    $transaction_sql = "SELECT * FROM transactions WHERE account_id = '".$account."' AND  created_at BETWEEN '$from 00:02:00' AND '$to 23:59:59'";
     
    $transactions = $conn->query($transaction_sql);
    $opening_balance = null;
    $current_balance = 0;
    
    while ($transaction = $transactions->fetch_assoc()) {
        // Update the current balance for each transaction
        $current_balance = $transaction['balance'];
    
        // Set the opening balance if it's the first transaction
        if ($opening_balance === null) {
            $opening_balance = $transaction['balance'];
        }
        
        // Process the rest of the transaction data as needed
        $transactionAmount = $transaction['amount'];
        $transactionType = $transaction['transaction_type'];
    
        // Your logic for processing each transaction goes here
    }
     

  
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="font-weight:bold;">
      تفاصيل حساب: <?php echo $account_result['name']; ?>  
      </h1>
      <div class="balance_wrapper">
        <div class="balance_content_wrapper">
            <h3> رصيد الاستفتاح</h3>
            <h2> <?php echo $opening_balance; ?> ريال</h2>
        </div>
        <div class="balance_content_wrapper">
            <h3> الرصيد الحالي</h3>
            <h2> <?php echo $current_balance; ?> ريال</h2>
        </div>
      </div>
     
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <div class="pull-right">
                <form method="POST" class="form-inline" id="payForm">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right col-sm-8" id="reservation" name="date_range" value="<?php echo (isset($_GET['range'])) ? $_GET['range'] : $range_from.' - '.$range_to; ?>">
                  </div>
                  <!-- <button type="button" class="btn btn-success btn-sm btn-flat" id="payroll"><span class="glyphicon glyphicon-print"></span> Payroll</button>
                  <button type="button" class="btn btn-primary btn-sm btn-flat" id="payslip"><span class="glyphicon glyphicon-print"></span> Payslip</button> -->
                </form>
              </div>
            </div>
            <div class="box-body">
              <table id="arabic_table" class="table table-bordered">
                <thead>
                  <th>وقت الحوالة</th>
                  <th>المصدر</th>
                  <th>المبلغ</th>
                  <th>نوع العملية</th>
                  <th>الرصيد بعد الحوالة</th>
                </thead>
                <tbody>
                  <?php

                   
                      $account = $_GET['id'];
                      $transaction_sql = "SELECT * FROM transactions WHERE account_id = '".$account."' AND  created_at BETWEEN '$from 00:02:00' AND '$to 23:59:59'";
                      
                      $transactions = $conn->query($transaction_sql);
                      $last_transaction = null;
                     while($transaction = $transactions->fetch_assoc()){
                     
                      $source = "";
                      $color = "green";
                      $type = "";
                      switch($transaction['transaction_type']){
                        case "sanad":
                          $source = "الايصال رقم: ".$transaction['foreign_id']."";
                          break;

                        case "expense":
                          $source = " صرف لمصروفية رقم: ".$transaction['foreign_id']."";
                          break;

                        case "transfer":
                          $source = " حوالة من حساب رقم: ".$transaction['foreign_id']."";
                          break;

                        case "refund":
                          $source = $transaction['details'];
                          break;
                      }

                      switch($transaction['transaction_type']){
                        case "sanad":
                          $type = "ايداع";
                          break;

                        case "expense":
                          $type = "صرف";
                          $color = "red";
                          break;
                        
                        case "refund":
                          $type = "استرجاع";
                          $color = "blue";
                          break;
                        
                        case "transfer":
                          if($transaction['balance'] > $last_transaction['balance']){
                            $type = "حوالة من حساب اخر";
                          }else{
                            $type = "حوالة الى حساب اخر";
                            $color = "red";
                          }
                          break;
                        case "open":
                          if($transaction['balance'] > 0){
                            $type = "فتح حساب ";
                          }else{
                            $type = "فتح حساب ";
                            $color = "black";
                          }
                          break;

                      }

                      echo "
                        <tr >
                          <td>".$transaction['created_at']."</td>
                          <td>".$source."</td>
                          <td style = 'font-weight:bold; color:".$color."'>".$transaction['amount'] ." ريال </td>
                          <td style = 'font-weight:bold; color:".$color."'>".$type."</td>
                          <td style = 'font-weight:bold; color:".$color."'>".$transaction['balance']." ريال </td>
                        </tr>
                      ";
                      $last_transaction = $transaction;
                     }
                      

                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
    
  <?php include 'includes/footer.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?> 
<script>
$(function(){

  $("#reservation").on('change', function(){
    var range = encodeURI($(this).val());
    window.location = 'account_details.php?id='+<?php echo $_GET['id']; ?>+'&range='+range;
  });

  $('#payroll').click(function(e){
    e.preventDefault();
    $('#payForm').attr('action', 'payroll_generate.php');
    $('#payForm').submit();
  });

  $('#payslip').click(function(e){
    e.preventDefault();
    $('#payForm').attr('action', 'payslip_generate.php');
    $('#payForm').submit();
  });

});


</script>
</body>
</html>

<?php
}else{
  echo "اختار حساب اولاً";
}
