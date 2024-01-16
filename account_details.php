<?php include 'includes/session.php'; ?>


<?php

if(isset($_GET['id'])){
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Payroll
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Payroll</li>
      </ol>
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
                  <button type="button" class="btn btn-success btn-sm btn-flat" id="payroll"><span class="glyphicon glyphicon-print"></span> Payroll</button>
                  <button type="button" class="btn btn-primary btn-sm btn-flat" id="payslip"><span class="glyphicon glyphicon-print"></span> Payslip</button>
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
                  
                    
                    $to = date('Y-m-d');
                    $from = date('Y-m-d', strtotime('-30 day', strtotime($to)));

                    if(isset($_GET['range'])){
                      $range = $_GET['range'];
                      $ex = explode(' - ', $range);
                      $from = date('Y-m-d', strtotime($ex[0]));
                      $to = date('Y-m-d', strtotime($ex[1]));
                    }


                      $transaction_sql = "SELECT * FROM transactions WHERE created_at BETWEEN '$from 00:01:00' AND '$to 23:59:59'";
                      
                      $transactions = $conn->query($transaction_sql);
                      $last_transaction = null;
                     while($transaction = $transactions->fetch_assoc()){
                     
                      $source = "";
                      $color = "green";
                      $type = "";
                      switch($transaction['transaction_type']){
                        case "sanad":
                          $source = "سند قبض رقم: ".$transaction['foreign_id']."";
                          break;

                        case "expense":
                          $source = " صرف لمصروفية رقم: ".$transaction['foreign_id']."";
                          break;

                        case "transfer":
                          $source = " حوالة من حساب رقم: ".$transaction['foreign_id']."";
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
                        <tr>
                          <td>".$transaction['created_at']."</td>
                          <td>".$source."</td>
                          <td>".$transaction['amount']."</td>
                          <td>".$type."</td>
                          <td>".$transaction['balance']."</td>


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
