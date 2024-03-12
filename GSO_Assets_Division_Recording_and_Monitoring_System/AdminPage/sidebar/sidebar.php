<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU</li>
        <!-- ========================== Dashboard ==========================-->
        <li><a href="dashboard.php"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a></li>
        <!-- ========================== Registry of ARE and ICS ==========================-->
        <li class="treeview">
          <a href="#"><i class="fa fa-edit"></i> <span>Registry</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="ARE_registry.php">Registry of ARE-Issued PPE</a></li>
            <li><a href="ICS_registry.php">Registry of ICS-Issued PPE</a></li>
          </ul>
        </li>
        <!-- ========================== Inventory Reports ==========================-->
        <li class="treeview">
          <a href="#"><i class="fa fa-archive"></i> <span>Inventory Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="activePPE.php">Active PPE</a></li>
            <li><a href="activeSemiPPE.php">Active Semi-Expendable Properties</a></li>
            <li><a href="inactivePPE.php">Inactive PPE</a></li>
            <li><a href="inactiveSemiPPE.php">Inactive Semi-Expendable Properties</a></li>
            <li><a href="allPPE.php">All Categories</a></li>
          </ul>
        </li>
        <!-- ========================== Unserviceable Properties ==========================-->
        <li class="treeview">
          <a href="#"><i class="fa fa-times"></i> <span>Unserviceable Properties</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="PRS.php">Property Return Slip(PRS)</a></li>
            <li><a href="WMR.php">Waster Material Report(WMR)</a></li>
          </ul>
        </li>
        <!-- ========================== Clearance ==========================-->
        <li class="treeview">
          <a href="#"><i class="fa fa-graduation-cap"></i> <span>Clearance</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="addClearance.php">New Clearance</a></li>
            <li><a href="clearance.php">Clearance Master List</a></li>
          </ul>
        </li>
        <!-- ========================== Data List ==========================-->
        <li><a href="dataList.php"><i class="fa fa-plus"></i> <span>Data List</span></a></li>
        <!-- ========================== Print Reports ==========================-->
        <li class="treeview">
          <a href="#"><i class="fa fa-file-text"></i> <span>Print Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="AREreports.php">ARE Reports</a></li>
            <li><a href="ICSreports.php">ICS Reports</a></li>
            <li><a href="PRSreports.php">PRS Master Lists</a></li>
            <li><a href="WMRreports.php">WMR Master List</a></li>
            <li><a href="clearanceReport.php">Clearance Master List</a></li>
          </ul>
        </li>

        <!-- ========================== Downloadables ==========================-->
        <li><a href="downloadables.php"><i class="fa fa-cloud-download"></i> <span>Downloadables</span></a></li>
        <!-- ========================== Logs ==========================-->
        <li><a href="activityLog.php"><i class="fa fa-book"></i> <span>Logs</span></a></li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>