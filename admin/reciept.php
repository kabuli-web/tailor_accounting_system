<?php include 'includes/session.php'; ?>
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
        Recipts
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Recipts</li>
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
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
            </div>
            <div class="box-body">
            <table id="example1" class="table table-bordered">
                <thead>
                  <th>Invoice No.</th>
                  <th>Reciept No.</th>
                  <th>Amount</th>
                  <th>Division Id</th>
                  <th>Client</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT r.*, i.customer_name AS client, d.name AS division_name
                    FROM reciepts AS r
                    INNER JOIN invoices AS i ON r.invoice_id = i.id
                    INNER JOIN division AS d ON r.division_id = d.id
                    WHERE r.division_id = '" . $user['division_id'] . "'";
            
            
                    $query = $conn->query($sql);
                    if (!$query) {
                      echo 'Query failed: ' . mysqli_error($conn);
                      // Add more debugging output as needed
                  }
                    while($row = $query->fetch_assoc()){
                      echo "
                        <tr>
                          <td>".$row['invoice_id']."</td>
                          <td>".$row['reciept_no']."</td>
                          <td>".number_format($row['amount'], 2)."</td>
                          <td>".$row['division_name']."</td>
                          <td>".$row['client']."</td>

                          <td>
                           <a href='reciept_pdf.php?id=".$row['id']."' class='btn btn-success'>View</a>
                            <button  disabled class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['id']."'><i class='fa fa-trash'></i> Delete</button>
                          </td>
                        </tr>
                      ";
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
  <?php include 'includes/reciept_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>


<script>

$("select[name='invoice']").change(function () {

  // Get the selected option and its price
  var selectedOption = $("select[name='invoice'] option:selected");
  var id = selectedOption.val();
  getInvoiceAmount(id)
});

$(document).ready(()=>{

  var selectedOption = $("select[name='invoice'] option:selected");
  var id = selectedOption.val();
  getInvoiceAmount(id)

})

function getInvoiceAmount(id){
  $.ajax({
    type: 'GET',
    url: 'get_invoice_items.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      console.log(response)
      let invoice_amount = 0;
      $("#edit-invoice-items-body").empty();

      response.forEach(item => {
      total = ((item.price*0.15)+item.price) * item.quantity;
      invoice_amount = invoice_amount + total;
      getDueAmount(id,invoice_amount)
    
      });
    }
  });
}



function getDueAmount(id,invoice_amount){
  $.ajax({
    type: 'GET',
    url: 'get_invoice_all_reciepts_amount.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){

      $("#due-amount").val(response-invoice_amount);
    }
  });
}


</script>
</body>
</html>
