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
        المصاريف
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> المصاريف</li>
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
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> اضافة الايصال جديد</a>
            </div>
            <div class="box-body">
              <table id="arabic_table" class="table table-bordered">
                <thead>
                  <th class="hidden"></th>
                  <th>التاريخ</th>
                  <th>رقم الصرف</th>
                  
                  <th>المبلغ</th>
                  <th>التفاصيل</th>
                  <th>من حساب</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT * FROM expenses ORDER BY created_at DESC";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      $id = $row['account_id'];
                      $acount_sql = "SELECT * FROM account WHERE id='$id'";
                      $acount_query = $conn->query($acount_sql);
                      $acount = $acount_query->fetch_assoc();
                      
                      echo "
                            <tr>
                                <td class='hidden'></td>
                                <td>" . date('M d, Y', strtotime($row['created_at'])) . "</td>
                                <td>" . $row['id'] . "</td>
                               
                                <td>" . $row['amount'] . "</td>
                                <td>" . $row['description'] . "</td>
                                <td><a href='account_details.php?id=" . $id . "'>" . $acount['name'] . "</a></td>
                                <td>
                                    <button class='btn btn-success btn-sm btn-flat edit' data-id='" . $row['id'] . "'><i class='fa fa-edit'></i> تعديل</button>
                                    <button class='btn btn-danger btn-sm btn-flat delete' data-id='" . $row['id'] . "'><i class='fa fa-trash'></i> حذف</button>
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
  <?php include 'includes/expense_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>

$(document).ready(function () {

  $('.select2').select2();


});

$(function(){
  $('.edit').click(function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $('.delete').click(function(e){
    e.preventDefault();
  
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });
});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'expense_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){

      // Additional code to fill in fields in the "edit" modal
    
      $('#edit input[name="amount"]').val(response.amount);
      $('#edit input[name="account_id"]').val(response.account_id);
      $('#edit input[name="expense_id"]').val(response.id);
      $('#edit input[name="description"]').val(response.description);
      $('#delete input[name="expense_id"]').val(response.id);
      $('#delete input[name="description"]').val(response.description);
    }
  });
}
</script>
</body>
</html>
