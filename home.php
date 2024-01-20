<?php include 'includes/session.php'; ?>

<!DOCTYPE html>
<html lang="en">

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <?php include 'includes/navbar.php'; ?>
    <?php include 'includes/menubar.php'; ?>
    <?php include 'includes/header.php'; ?>

  
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <ol class="breadcrumb">
          <li class="active">Dashboard</li>
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        </ol>
        <h1>التقارير</h1>
      </section>
  
      <!-- Main content -->
      <section class="content">
      <form id="dateRangeForm">
          <label for="start">Start Date:</label>
          <input type="date" id="start" name="start" required>
          <label for="end">End Date:</label>
          <input type="date" id="end" name="end" required>
          <button type="button" id="loadChartsBtn">Load Charts</button>
        </form>

        

        <div class="row">
          <div class="col-sm-12 col-md-6 text-center">
          <h3 class="text-primary text-center">التقرير اليومي</h3>
            <!-- <label class="label label-success">التقرير اليومي</label> -->
            <div id="daily-chart"></div>
          </div>
          <div class="col-sm-12 col-md-6 text-center">
          <h3 class="text-primary text-center">التقرير الشهري</h3>
            <!-- <label class="label label-success">التقرير اليومي</label> -->
            <div id="monthly-chart"></div>
          </div>
        </div>

        
      </section>
    </div>
    
    <?php include 'includes/footer.php'; ?>
  </div>

  <?php include 'includes/scripts.php'; ?>
  <script>
    
    function loadCharts(defaultStart,defaultEnd) {
      // Fetch data based on the selected date range
      var startDate = $("#start").val();
      var endDate = $("#end").val();
      if(!startDate){
        startDate = new Date();
        startDate.setDate(startDate.getDate() - 30);
        startDate = startDate.toISOString().split('T')[0];
        endDate = new Date().toISOString().split('T')[0];
      }
      $("#daily-chart").empty();
      $("#monthly-chart").empty();

      $.ajax({
        url: 'get_report.php?type=daily', // Update with your PHP script
        method: 'POST',
        data: { start: startDate, end: endDate },
        success: function (data) {
          var parsedData = JSON.parse(data);

          // Morris.js configurations
          var config = {
            data: parsedData,
            xkey: 'date',
            ykeys: ['sanads', 'expenses'],
            labels: ['الدخل', 'الصرف'],
            fillOpacity: 0.6,
            hideHover: 'auto',
            behaveLikeLine: true,
            resize: true,
            pointFillColors: ['#ffffff'],
            pointStrokeColors: ['black'],
            lineColors: ['gray', 'red'],
            element: 'daily-chart'
          };

          // Render Morris.js charts
          Morris.Area(config);
        },
        error: function (error) {
          console.log('Error fetching data:', error);
        }
      });

      $.ajax({
        url: 'get_report.php?type=monthly-chart', // Update with your PHP script
        method: 'POST',
        data: { start: startDate, end: endDate },
        success: function (data) {
          var parsedData = JSON.parse(data);

          // Morris.js configurations
          var config = {
            data: parsedData,
            xkey: 'date',
            ykeys: ['sanads', 'expenses'],
            labels: ['الدخل', 'الصرف'],
            fillOpacity: 0.6,
            hideHover: 'auto',
            behaveLikeLine: true,
            resize: true,
            pointFillColors: ['#ffffff'],
            pointStrokeColors: ['black'],
            lineColors: ['gray', 'red'],
            element: 'monthly-chart'
          };

          // Render Morris.js charts
          Morris.Bar(config);
        },
        error: function (error) {
          console.log('Error fetching data:', error);
        }
      });
    }

   $(document).ready(function () {

    $("#loadChartsBtn").click(loadCharts);
    loadCharts();
   })
  </script>
</body>
</html>
