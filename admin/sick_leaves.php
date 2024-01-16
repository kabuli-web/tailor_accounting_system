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
        Sick Leaves
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Sick Leaves</li>
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
              <a href="#addNewVac" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Date</th>
                  <th>Employee Name</th>
                  <th>Description</th>
                  <th>sick leave Days</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                <?php
                    $sql = "SELECT
                                sl.*,
                                e.firstname,
                                e.lastname,
                                e.id AS employee_id
                            FROM
                                sickleaves sl
                            LEFT JOIN employees e ON sl.employee_id = e.id
                            ORDER BY
                                e.lastname ASC, e.firstname ASC;";

                    $query = $conn->query($sql);

                    if ($query) {
                        while ($row = $query->fetch_assoc()) {
                            $employeeName = !empty($row['firstname']) && !empty($row['lastname'])
                                ? $row['firstname'] . ' ' . $row['lastname']
                                : 'Unknown';

                            // Calculate the deduction based on total_hr * 0.01420455

                            echo "
                                <tr>
                                    <td>" . $row["date"] . "</td>
                                    <td>" . $employeeName . "</td>
                                    <td>" . $row['description'] . "</td>
                                    <td>" . number_format($row['days'], 2) . "</td>
                                    <td>
                                        <button class='btn btn-success btn-sm edit btn-flat' data-id='" . $row['id'] . "'><i class='fa fa-edit'></i> Edit</button>
                                        <button class='btn btn-danger btn-sm delete btn-flat' data-id='" . $row['id'] . "'><i class='fa fa-trash'></i> Delete</button>
                                    </td>
                                </tr>
                            ";
                        }
                    } else {
                        // Handle the case where the query was not successful
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
    
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/sick_leaves_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>

$(document).ready(function() {
        // Initialize DataTable
        var table = $('#example1');

        // Add an event listener to the built-in search input
        $('#example1_filter label input').on('input', function() {
            var searchValue = $(this).val().toLowerCase();
            // Use DataTables Column Search API for the "Employee Name" column (index 1)
            table.column(1).search(searchValue).draw();
        });

        // Add other DataTable customization or specific logic for vacation.php if needed
    });
$(function(){
  $('.edit').click(function(e){
    e.preventDefault();
    $('#editVac').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $('.delete').click(function(e){
    e.preventDefault();
    $('#deleteVac').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });
});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'sick_leaves_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.decid').val(response.id);
      $('#edit_description').val(response.description);
      $('#edit_days').val(response.days);
      $('#del_deduction').html(response.description);
    }
  });
}
</script>
</body>
</html>
