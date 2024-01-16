<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo (!empty($user['photo'])) ? './images/'.$user['photo'] : './images/profile.jpg'; ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $user['firstname'].' '.$user['lastname']; ?></p>
          <a><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <!-- <li class="header">REPORTS</li> -->
        <li class=""><a href="home.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
     
        <li class=""><a href="fatoora.php"><i class="fa fa-dashboard"></i> <span>الفواتير</span></a></li>

        <li class=""><a href="sanad.php"><i class="fa fa-dashboard"></i> <span>سندات القبض</span></a></li>

        <li class=""><a href="account.php"><i class="fa fa-dashboard"></i> <span> الحسابات</span></a></li>


        <!-- <li class="treeview">
          <a href="#"><i class="fa fa-usd"></i>
          <span> Accounting</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
              </a>
          <ul class="treeview-menu">
            <li><a href="invoice.php"><i class="fa fa-clock-o"></i> <span>Invoices</span></a></li>
            <li><a href="product.php"><i class="fa fa-clock-o"></i> <span>Products</span></a></li>
            <li><a href="reciept.php"><i class="fa fa-clock-o"></i> <span>Reciepts</span></a></li>


          </ul>
        </li> -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>