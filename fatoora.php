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
     
      <ol class="breadcrumb">
      <li class="active">فــواتــــبــر</li>
        <li><a href="home.php"> الرئيسية <i class="fa fa-dashboard"></i></a></li>
      </ol>
      <h1>
        فــواتــــبــر
      </h1>
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
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> اضافة فاتورة جديدة</a>
            </div>
            <div class="box-body">
            <table id="arabic_table" class="table table-bordered dataTable no-footer" role="grid" aria-describedby="fatoora_table_info" style="width: 100%;">
                <thead>
                    <th class="hidden"></th>
                    <th>رقم الفاتورة</th>
                    <th>التاريخ</th>
                    <th>امس العميل</th>
                    <th>رقم الجوال</th>
                    <th>نوع الثوب</th>
                    <th>الاجمالي</th>
                    <th>المبلغ المدفوع</th>
                    <th>جاهز؟</th>
                    <th>الادوات</th>
                </thead>
                <tbody>
                      <?php
                      $sql = "SELECT fatoora.id AS fatid, fatoora.created_at AS created_at, customer.name AS customer_name, customer.phone_number AS customer_phone, fatoora.thob_type, fatoora.total, fatoora.ready, fatoora.total_paid FROM fatoora LEFT JOIN customer ON customer.id=fatoora.customer_id ORDER BY fatoora.created_at DESC";
                      $query = $conn->query($sql);
                      if (!$query) {
                        // Handle the error gracefully, for example, you can use die() to stop execution and display the error.
                        die("Error: " . $conn->error);
                    }
                      while ($row = $query->fetch_assoc()) {
                        $ready = $row['ready'] =="1"? "نعم" : "لا";
                        $color = $row['ready'] == "1" ? "green":"red";
                          echo "
                              <tr>
                                  <td class='hidden'></td>
                                  <td>".$row['fatid']."</td>
                                  <td>" . date('M d, Y h:i', strtotime($row['created_at'])) . "</td>

                                  <td>" . $row['customer_name'] . "</td>
                                  <td>" . $row['customer_phone'] . "</td>
                                  <td>" . $row['thob_type'] . "</td>
                                  <td>" . $row['total'] . "</td>
                                  <td>" . $row['total_paid'] . "</td>
                                  <td style='color:".$color."'>".$ready."</td>
                                  <td>
                                      <a href='fatoora_pdf.php?id=" . $row['fatid'] . "' class='btn btn-dafault btn-sm btn-flat ' data-id='" . $row['fatid'] . "'><i class='fa fa-page'></i> pdf</a>
                                      <button class='btn btn-success btn-sm btn-flat edit' data-id='" . $row['fatid'] . "'><i class='fa fa-edit'></i> تعديل</button>
                                      <button class='btn btn-danger btn-sm btn-flat delete' data-id='" . $row['fatid'] . "'><i class='fa fa-trash'></i> حذف</button>
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
  <?php include 'includes/fatoora_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
  $(document).ready(function () {
    function updateTotalLeft() {
        var total = parseFloat($("#total").val()) || 0;
        var totalPaid = parseFloat($("#total_paid").val()) || 0;
        var totalLeft = total - totalPaid;
        $("#total_Left").text("المتبقي: " + totalLeft.toFixed(2) + " ريال");
    }

    // Trigger updateTotalLeft on changes in الاجمالي or عربوم
    $("#total, #total_paid").on("input", function() {
        updateTotalLeft();
    });

    // Initial calculation on page load
    updateTotalLeft();



  $('#fatoora_table').DataTable({
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json",
      "sEmptyTable": "لا تتوفر بيانات في الجدول",
     
      // Add more language-specific options as needed
    },
    "scrollX": true,
    "width":"100%",
    "responsive": false,
  });
});

$(function(){
  $('.edit').click(function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
    $('#edit').modal('show');
  });

  $('.delete').click(function(e){
    e.preventDefault();
    var id = $(this).data('id');
    console.log(id);
    getRow(id);
    $('#delete input[name="delete_fatoora_id"]').val(id);
    $('#delete').modal('show');
  });
});

function getRow(id) {
  $.ajax({
    type: 'POST',
    url: 'fatoora_row.php',
    data: { id: id },
    dataType: 'json',
    success: function (response) {
      // Fill in customer information
      $('#edit input[name="name"]').val(response.customer_name);
      $('#edit input[name="phone_number"]').val(response.customer_phone);
      $('#edit input[name="fatoora_id"]').val(response.fatid);
      // Fill in sizes information
      $('#edit input[name="length"]').val(response.length);
      $('#edit input[name="shoulder"]').val(response.shoulder);
      $('#edit input[name="sleeve"]').val(response.sleeve);
      $('#edit input[name="chest"]').val(response.chest);
      $('#edit input[name="waist"]').val(response.waist);
      $('#edit input[name="neck"]').val(response.neck);
      $('#edit input[name="hand_loosing_left"]').val(response.hand_loosing_left);
      $('#edit input[name="hand_loosing_right"]').val(response.hand_loosing_right);
      $('#edit input[name="expand_down"]').val(response.expand_down);

      // Fill in design information
      $('#edit input[name="thob_type"][value="' + response.thob_type + '"]').prop('checked', true);
      $('#edit input[name="dd"][value="' + response.dd + '"]').prop('checked', true);

      $('#edit input[name="tatriz"]').val(response.tatriz);
      $('#edit input[name="buttons_type"][value="' + response.buttons_type + '"]').prop('checked', true);
      // Split the addons string into an array
      var addonsArray = response.addons.split(',');

      // Check the checkboxes based on the addons array
      addonsArray.forEach(function(addon) {
        $('#edit input[name="addons[]"][value="' + addon + '"]').prop('checked', true);
      });

      $('#edit input[name="middle_design"][value="' + response.middle_design + '"]').prop('checked', true);
      $('#edit input[name="side_pocket_design"][value="' + response.side_pocket_design + '"]').prop('checked', true);
      $('#edit input[name="pocket_design"][value="' + response.pocket_design + '"]').prop('checked', true);
      $('#edit input[name="sleeve_design"][value="' + response.sleeve_design + '"]').prop('checked', true);
      $('#edit input[name="neck_design"][value="' + response.neck_design + '"]').prop('checked', true);
      $('#edit input[name="neck_design_size"]').val(response.neck_design_size);
      $('#edit textarea[name="note"]').val(response.note);
      $('#edit_modal_title').text('تعديل فاتورة رقم: '+ response.fatid);
        // let ready = response.ready == 1?true:false;
      $('#edit input[name="ready"][value="' + response.ready + '"]').prop('checked', true);
      
      // Fill in payments information
      $('#edit input[name="total"]').val(response.total);
      $('#edit input[name="total_paid"]').val(response.total_paid);

        return response.fatid;
      // Other fields...
      // ...

      // Show the modal
      // 
    }
  });
}

</script>
</body>
</html>
