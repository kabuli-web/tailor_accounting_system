<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<?php
  include '../timezone.php';
  $range_to = date('m/d/Y');
  $range_from = date('m/d/Y', strtotime('-30 day', strtotime($range_to)));
?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Invoices
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Invoices</li>
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
            <div style="display: flex;justify-content: space-between; margin:10px;">
              <a href="#addNewInvoice" data-toggle="modal" data-target=".bd-example-modal-xl" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
              <div style="display: flex;align-items: center;">
                <i class="fa fa-calendar"></i>
                <input type="text" class="form-control pull-right col-sm-8" id="reservation" name="date_range" value="<?php echo (isset($_GET['range'])) ? $_GET['range'] : $range_from.' - '.$range_to; ?>">
              </div>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Issue Date</th>
                  <th>Invoices No</th>
                  <th>Customer Name</th>
                  <th>Total/Paid</th>
                  <th>Status</th>
                  <th>Invoice Type</th>
                  <th>Division</th>
                  <th>Issued By</th>
                  <th>options</th>

                </thead>
                <tbody>
                  <?php
                if (isset($_GET['range'])) {
                  $range = $_GET['range'];
                  $ex = explode(' - ', $range);
                  $from = date('Y-m-d', strtotime($ex[0]));
                  $to = date('Y-m-d', strtotime($ex[1]));
              }
              
              // Your existing SQL query
              $sql = "SELECT 
              invoices.*,
              admin.username AS issued_by_admin,
              division.name AS division_name,
              COALESCE(total_paid.total_amount, 0) AS total_paid,
              COALESCE(SUM((((invoice_items.price * 0.15) + invoice_items.price) * invoice_items.quantity)), 0) AS invoice_amount,
              COALESCE(total_paid.total_amount, 0) - COALESCE(SUM((((invoice_items.price * 0.15) + invoice_items.price) * invoice_items.quantity)), 0) AS due_amount 
                FROM 
                    invoices 
                JOIN 
                    admin ON invoices.issued_by = admin.id 
                JOIN 
                    division ON invoices.division_id = division.id 
                LEFT JOIN 
                    invoice_items ON invoices.id = invoice_items.invoice_id 
                LEFT JOIN 
                    (SELECT 
                        invoice_id, 
                        COALESCE(SUM(amount), 0) AS total_amount 
                    FROM 
                        reciepts 
                    GROUP BY 
                        invoice_id) AS total_paid ON invoices.id = total_paid.invoice_id 
                WHERE 
                    1=1";
        
                if (isset($from) && isset($to)) {
                    $sql .= " AND invoices.issue_date BETWEEN '$from' AND '$to'";
                }
                
                $sql .= " GROUP BY 
                    invoices.id, admin.username, division.name, total_paid.total_amount";
              
              $query = $conn->query($sql);
              
              if (!$query) {
                  echo $sql;
                  die("Error executing query: " . $conn->error);
              }
              
              if ($query) {
                  while ($row = $query->fetch_assoc()) {
                      if ($row["closed"] == 1) {
                          $state = "Closed";
                          $state_color = "green";
                      } else {
                          $state = "Open";
                          $state_color = "red";
                      }
                      $result = $row["total_paid"] - $row["invoice_amount"];
                      if($result==0){
                        $result = $row["total_paid"];
                      }
                      // echo  $row["total_paid"] ."/". $row["invoice_amount"];
                      echo "<tr>
                              <td>" . $row["issue_date"] . "</td>
                              <td>" . $row["id"] . "</td>
                              <td>" . $row['customer_name'] . "</td>
                              <td style='color:" . $state_color . "'>" . $result . "</td>
                              <td style='color:" . $state_color . "'> " . $state . " </td>
                              <td> " . $row["invoice_type"] . " </td>
                              <td> " . $row["division_name"] . " </td>
                              <td> " . $row["issued_by_admin"] . " </td>
                              <td>
                                  <a href='pdf_invoice.php?id=".$row['id']."' class='btn btn-primary' target='_blank'>pdf</a>
                                  <button  class='btn btn-success btn-sm edit btn-flat' data-id='" . $row['id'] . "'><i class='fa fa-edit'></i> Edit</button>
                                  <button disabled class='btn btn-danger btn-sm delete btn-flat' data-id='" . $row['id'] . "'><i class='fa fa-trash'></i> Delete</button>
                              </td>
                          </tr>";
                  }
              } else {
                  echo "Error executing query: " . $conn->error;
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
  <div class="col"></div>
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/invoice_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<?php include 'includes/invoice_add_modal_scripts.php'; ?>
<?php include 'includes/invoice_edit_modal_scripts.php'; ?>

<script>
$(document).ready(function() {


  $('.select2').select2({
                placeholder: "Select a product",
                allowClear: true,
                minimumResultsForSearch: 0,
                width:"100%",
                height:"30px"
            });


  // Add other DataTable customization or specific logic for vacation.php if needed
  var selectedOption = $("select[name='product'] option:selected");
  var price = parseFloat(selectedOption.attr("price"));

  // Set the price input value
  $("input[name='product-price']").val(price);

  // Update the total input value (price * quantity)
  updateProductTotal();
   

});

$("#reservation").on('apply.daterangepicker', function(ev, picker){
    var start_date = picker.startDate.format('MM/DD/YYYY');
    var end_date = picker.endDate.format('MM/DD/YYYY');
    window.location = 'invoice.php?range=' + start_date + ' - ' + end_date;
});

$(function(){
  $('.edit').click(function(e){
    e.preventDefault();
    $('#editInvoice').modal('show');
    var id = $(this).data('id');
    getRow(id);
    getInvoiceItems(id);
    get_paid_amount(id)
  });

  $('.delete').click(function(e){
    e.preventDefault();
    $('#deleteInvoice').modal('show');
    var id = $(this).data('id');
    $(".delete-invoice-id").val(id);
  });

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'invoice_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('#edit-invoice-id').val(response.id);
      $('#edit_c_name').val(response.customer_name);
      $('#edit_c_phone').val(response.customer_phone);
      $('#edit_c_vat').val(response.customer_vat);
      $('#edit_c_address').val(response.customer_address);
      $('#edit_po_number').val(response.po_number);
      $('#datepicker_edit').val(response.due_date);
      $('#edit_description').val(response.description);
      
    }
  });
}

function get_paid_amount(id){
  $.ajax({
    type: 'GET',
    url: 'get_invoice_all_reciepts_amount.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('#edit-reciept-payment-amount').val(response);
      updateEditInvoiceTotals();
    }
  });
}

function getInvoiceItems(id){
  $.ajax({
    type: 'GET',
    url: 'get_invoice_items.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      console.log(response)
      let count = 0;
      $("#edit-invoice-items-body").empty();

      response.forEach(item => {
      total = item.price * item.quantity;

      var item_html = `
      <tr class="edit-invoice-item">
        <td><div><input type="hidden" value="${item.id}"  name="items[${count}][item-id]"><input type="hidden" hidden value="${item.product_id}" class="form-control edit-product-id" name="items[${count}][product-id]"><input type="text" value="${item.name}" class="form-control edit-item-name" name="items[${count}][item-name]"></div></td>
        <td><div><input type="number" value="${item.quantity}" class="form-control col-md-2 edit-item-quantity" min="0" name="items[${count}][item-quantity]"></div></td>
        <td><div><input type="number" value="${item.price}" class="form-control col-md-2 price-input edit-item-price" min="0" step="0.01" name="items[${count}][item-price]"></div></td>
        <td><div><input type="number" value="${total}" class="form-control col-md-2 edit-item-total" step="0.01" readonly name="items[${count}][item-total]"></div></td>
        <td><div><a class="remove-edit-invoice-item btn btn-danger form-control col-md-2"> <i class='fa fa-trash'></i> </a></div></td>
      </tr>`;

      count++;
      var newItem = $(item_html);

      $("#edit-invoice-items-body").append(newItem);
      updateEditInvoiceTotals();
      });
    }
  });
}
</script>
</body>
</html>
