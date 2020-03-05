    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
        <a class="navbar-brand mr-1" href="/admin">SAPTZ - Admin</a>
        </form> -->

        <!-- Navbar -->
        <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle fa-fw"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" name="logout" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="sidebar navbar-nav toggled">
            <!-- <li class="nav-item active">
                <a class="nav-link" href="/admin">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
                </a>
            </li> -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="drpSetup" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-cogs"></i>
                <span>Manage</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="drpSetup">
                    <?php 
                        $html = '';

                        if($_SESSION['admindata']['a2'] > 0 && $_SESSION['admindata']['a3'] > 0 && 
                            $_SESSION['admindata']['a4'] > 0 && $_SESSION['admindata']['a5'] > 0 && $_SESSION['admindata']['a6'] > 0) {
                                $html .= '<h6 class="dropdown-header text-danger">Company</h6>            
                                          <a class="dropdown-item" href="/admin/department">Department</a>
                                          <a class="dropdown-item" href="/admin/groups">Groups/Teams</a>
                                          <a class="dropdown-item" href="/admin/shifts">Work Shifts</a>    
                                          <a class="dropdown-item" href="/admin/workcenters">Work Centers</a>
                                          <a class="dropdown-item" href="/admin/activity">Activity</a>
                                          <!-- <div class="dropdown-divider"></div> -->';
                        } else {
                            if($_SESSION['admindata']['a2'] > 0 || $_SESSION['admindata']['a3'] > 0 || 
                               $_SESSION['admindata']['a4'] > 0 || $_SESSION['admindata']['a5'] > 0 || $_SESSION['admindata']['a6'] > 0) {
                                $html .= '<h6 class="dropdown-header text-danger">Company</h6>';    
                            }

                            $html .= $_SESSION['admindata']['a2'] > 0  ? '<a class="dropdown-item" href="/admin/department">Department</a>' : '';
                            $html .= $_SESSION['admindata']['a3'] > 0  ? '<a class="dropdown-item" href="/admin/groups">Groups/Teams</a>' : '';
                            $html .= $_SESSION['admindata']['a4'] > 0  ? '<a class="dropdown-item" href="/admin/shifts">Work Shifts</a>' : '';
                            $html .= $_SESSION['admindata']['a5'] > 0  ? '<a class="dropdown-item" href="/admin/workcenters">Work Centers</a>' : '';
                            $html .= $_SESSION['admindata']['a6'] > 0  ? '<a class="dropdown-item" href="/admin/activity">Activity</a>' : '';
                            
                            if($_SESSION['admindata']['a2'] > 0 || $_SESSION['admindata']['a3'] > 0 || 
                               $_SESSION['admindata']['a4'] > 0 || $_SESSION['admindata']['a5'] > 0 || $_SESSION['admindata']['a6'] > 0) {
                                $html .= '<!-- <div class="dropdown-divider"></div> -->';    
                            }
                        }

                        if($_SESSION['admindata']['a8'] > 0){
                            $html .= '  <h6 class="dropdown-header text-danger mt-2">Projects</h6>
                                        <!-- <a class="dropdown-item" href="/admin/customers">Customers</a> -->
                                        <a class="dropdown-item" href="/admin/joborders">Job Orders</a>
                                        <!-- <div class="dropdown-divider"></div> -->';
                        }

                        if($_SESSION['admindata']['a9'] > 0 && $_SESSION['admindata']['a9'] > 0){
                            $html .= '  <h6 class="dropdown-header text-danger mt-2">Accounts</h6>
                                        <a class="dropdown-item" href="/admin/employee">Employee</a>
                                        <a class="dropdown-item" href="/admin/roles">Roles</a>';
                        } else {
                            $html .= $_SESSION['admindata']['a9'] > 0 ? '<h6 class="dropdown-header">Accounts</h6> <a class="dropdown-item" href="/admin/employee">Employee</a>' : '';
                            $html .= $_SESSION['admindata']['a10'] > 0 ? '<a class="dropdown-item" href="/admin/roles">Roles</a>' : '';
                        }

                        echo $html;
                    ?>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="drpSetup" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-universal-access"></i>
                <span>Accessibility</span></a>
                <?php
                    $html = "";
                    if($_SESSION['admindata']['a11'] > 0 || $_SESSION['admindata']['a13'] > 0){
                        $html .= '<div class="dropdown-menu" aria-labelledby="drpAccessibility">';

                        if($_SESSION['admindata']['a11'] > 0){
                            $html .= "<a class='dropdown-item' href='#'>Remote Login</a>";
                        }
                        if($_SESSION['admindata']['a13'] > 0){
                            $html .= "<a class='dropdown-item' href='#'>Export Data</a>";
                            $html .= "<a class='dropdown-item' href='#'>Import Data</a>";
                        }
                        
                        $html .= '</div>';
                    }

                    echo $html;
                ?>  
            </li>
            <?php
                $html = "";
                if($_SESSION['admindata']['a12'] > 0){
                    $html = '<li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="drpReport" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-file-download"></i>
                                <span>Reports</span></a>
                                    <div class="dropdown-menu" aria-labelledby="drpReport">
                                        <a class="dropdown-item" href="/admin/reportviewer">Log Exceptions</a>
                                    </div>
                            </li>';

                    echo $html;
                }
            ?>
            <!-- <li class="nav-item">
                <a class="nav-link" href="tables.html">
                <i class="fas fa-fw fa-table"></i>
                <span>Tables</span></a>
            </li> -->
        </ul>
        <div id="content-wrapper">
            <div class="container-fluid">
                <!-- Icon Cards-->
                <!-- <div class="row">
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card text-white bg-primary o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                            <i class="fas fa-fw fa-comments"></i>
                            </div>
                            <div class="mr-5">26 New Messages!</div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="#">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                            <i class="fas fa-angle-right"></i>
                            </span>
                        </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card text-white bg-warning o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                            <i class="fas fa-fw fa-list"></i>
                            </div>
                            <div class="mr-5">11 New Tasks!</div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="#">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                            <i class="fas fa-angle-right"></i>
                            </span>
                        </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card text-white bg-success o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                            <i class="fas fa-fw fa-shopping-cart"></i>
                            </div>
                            <div class="mr-5">123 New Orders!</div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="#">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                            <i class="fas fa-angle-right"></i>
                            </span>
                        </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card text-white bg-danger o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                            <i class="fas fa-fw fa-life-ring"></i>
                            </div>
                            <div class="mr-5">13 New Tickets!</div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="#">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                            <i class="fas fa-angle-right"></i>
                            </span>
                        </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card text-white bg-danger o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                            <i class="fas fa-fw fa-life-ring"></i>
                            </div>
                            <div class="mr-5">13 New Tickets!</div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="#">
                            <span class="float-left">View Details</span>
                            <span class="float-right">
                            <i class="fas fa-angle-right"></i>
                            </span>
                        </a>
                        </div>
                    </div>
                </div> -->
            </div>
        <!-- /.container-fluid -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- /#wrapper -->
