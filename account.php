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
        الحسابات
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li class="active">الحسابات</li>
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
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> اضافة حساب جديد</a>
              <a href="#addnewtransfer" data-toggle="modal" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus"></i> تحويل من حساب الى اخر</a>
            </div>
            <div class="box-body">
              <table id="arabic_table" class="table table-bordered">
                <thead>
                  <th>اسم الحساب</th>
                  <th>الرصيد الحالي</th>
                  <th>الادوات</th>
                </thead>
                <tbody>
                  <?php


                    $sql = "SELECT * FROM account";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      $id =$row['id'];
                      $account_balance_sql = "SELECT * FROM transactions WHERE account_id = '$id' ORDER BY id DESC LIMIT 1";
                      $account_Result = $conn->query($account_balance_sql);
              
                      if ($account_Result->num_rows > 0) {
                          $account = $account_Result->fetch_assoc();
                          $account_balance = $account['balance'];
                      } else {
                        $account_balance = "لا يوجد";
                      }
                      echo "
                        <tr>
                          <td><a href='account_details.php?id=".$id."'>".$row['name']."</a></td>
                          <td>".$account_balance."</td>

                          <td>
                            <button class='btn btn-success btn-sm edit btn-flat' data-id='".$row['id']."'><i class='fa fa-edit'></i> التعديل</button>
                            <button disabled class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['id']."'><i class='fa fa-trash'></i> الحذف</button>
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
  <?php include 'includes/account_modal.php'; ?>
  <?php include 'includes/transfer_modal.php'; ?>

</div>
<?php include 'includes/scripts.php'; ?>
<script>
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
    url: 'account_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('#edit input[name="id"]').val(response.id);
      $('#edit input[name="name"]').val(response.name);
      // $('#edit input[name="current_balance"]').val(response.current_balance);

      $('#delete input[name="id"]').val(response.id);
      $('#del_account_name').html(response.name);
    }
  });
}
</script>
</body>
</html>
