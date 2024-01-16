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
        Vacation
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Deducted Vacation Days</li>
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
              <a href="#addNewVac" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
              <div style="display: flex;align-items: center;">
                <i class="fa fa-calendar"></i>
                <input type="text" class="form-control pull-right col-sm-8" id="reservation" name="date_range" value="<?php echo (isset($_GET['range'])) ? $_GET['range'] : $range_from.' - '.$range_to; ?>">
              </div>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Date</th>
                  <th>Employee Name</th>
                  <th>Description</th>
                  <th>Days Deducted</th>
                  <th>Days collected</th>
                  <th>Days Left</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    // Your existing SQL query
                    $sql = "SELECT
                        vd.*,
                        e.firstname,
                        e.lastname,
                        e.id AS employee_id,
                        e.vacation_days_earned,
                        SUM(a.num_hr) AS total_hr,
                        SUM(vd.days) AS total_vacation_days
                    FROM vacation_deductions vd
                    LEFT JOIN employees e ON vd.employee_id = e.id
                    LEFT JOIN attendance a ON a.employee_id = e.id
                    WHERE vd.employee_id = e.id";
                if(isset($_GET['range'])){
                  $range = $_GET['range'];
                  $ex = explode(' - ', $range);
                  $from = date('Y-m-d', strtotime($ex[0]));
                  $to = date('Y-m-d', strtotime($ex[1]));
                }
                // Add a condition to filter based on the date range if provided
                if (isset($from) && isset($to)) {
                    $sql .= " AND vd.date BETWEEN '$from' AND '$to'";
                    $sql .= " AND a.date BETWEEN '$from' AND '$to'";
                }

                $sql .= " GROUP BY vd.id
                    ORDER BY e.lastname ASC, e.firstname ASC";
                  // echo $sql;
                  // echo "From: $from, To: $to";
                    $query = $conn->query($sql);
                   

                    if (!$query) {
                        die("Error executing query: " . $conn->error);
                    }
                    if ($query) {
                      while ($row = $query->fetch_assoc()) {
                        $employeeName = !empty($row['firstname']) && !empty($row['lastname'])
                        ? $row['firstname'] . ' ' . $row['lastname']
                        : 'Unknown';

                    // Calculate the deduction based on total_hr * 0.01420455
                    $days_collected = number_format($row['total_hr'] * 0.01420455, 2);

                   

                    echo "
                        <tr>
                            <td>" . $row["date"] . "</td>
                            <td>" . $employeeName . "</td>
                            <td>" . $row['description'] . "</td>
                            <td>" . number_format($row['days'], 2) . "</td>
                            <td> " . $days_collected . " </td>
                            <td> " . number_format($days_collected - $row['total_vacation_days'], 2) . " </td>
                            <td>
                                <button class='btn btn-success btn-sm edit btn-flat' data-id='" . $row['id'] . "'><i class='fa fa-edit'></i> Edit</button>
                                <button class='btn btn-danger btn-sm delete btn-flat' data-id='" . $row['id'] . "'><i class='fa fa-trash'></i> Delete</button>
                            </td>
                        </tr>
                    ";
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
    
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/vacation_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
$(document).ready(function() {
  var table = $('#example1');
  $('#example1_filter label input').on('input', function() {
    var searchValue = $(this).val().toLowerCase();
    table.column(1).search(searchValue).draw();
  });
  // Add other DataTable customization or specific logic for vacation.php if needed
});

$("#reservation").on('apply.daterangepicker', function(ev, picker){
    var start_date = picker.startDate.format('MM/DD/YYYY');
    var end_date = picker.endDate.format('MM/DD/YYYY');
    window.location = 'vacation.php?range=' + start_date + ' - ' + end_date;
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
    url: 'vacation_deduction_row.php',
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
