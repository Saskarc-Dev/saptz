<nav class="navbar navbar-expand navbar-dark bg-dark static-top">
        <a class="navbar-brand mr-1" href="index.html">SAPTZ - Admin</a>

        <!-- <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
        </button> -->

        <!-- Navbar Search -->
        <!-- <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form> -->

        <!-- Navbar -->
        <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <!-- <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger">9+</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <span class="badge badge-danger">7</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li> -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle fa-fw"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <!-- <a class="dropdown-item" href="#">Settings</a>
                <a class="dropdown-item" href="#">Activity Log</a>
                <div class="dropdown-divider"></div> -->
                <a class="dropdown-item" name="logout" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="sidebar navbar-nav toggled">
            <li class="nav-item active">
                <a class="nav-link" href="/admin">
                <i class="fas fa-home"></i>
                <span>Home</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="drpReport" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Reports</span></a>
                <div class="dropdown-menu" aria-labelledby="drpReport">            
                    <a class="dropdown-item" href="#">Activity</a>
                    <a class="dropdown-item" href="#">Audit Trail </a>
                </div>
            </li>
        </ul>
        <div id="content-wrapper">
            <div class="container-fluid">
                <article class="container-fluid" style="norder">
                    <article class="row mb-3">
                        <article class="col">
                            <div class="card">
                                <div class="card-header">
                                    User Roles (Active)
                                </div>
                                <div class="card-body">
                                    <article class="container-fluid">
                                        <a href="#" name="newRole" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modRoles"><i class="far fa-plus-square"></i> &nbsp;New Role</a>
                                        <table class="table table-bordered table-striped table-sm" style="font-size:12px;">
                                            <thead>
                                                <tr>
                                                    <td style="width:10%; vertical-align: middle;" rowspan="2"></td>
                                                    <td style="width:5%; vertical-align: middle;" rowspan="2">Code</td>
                                                    <td style="width:15%; vertical-align: middle;" rowspan="2">Description</td>
                                                    <td style="width:10%; text-align: center; vertical-align: middle;" colspan="2">CLIENT</td>
                                                    <td style="width:60%; text-align: center; vertical-align: middle;" colspan="13">ADMINISTRATION</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: center; vertical-align: middle;">Login</td>
                                                    <td style="text-align: center; vertical-align: middle;">Group Clock-In</td>
                                                    <td style="text-align: center; vertical-align: middle;">Login</td>
                                                    <td style="text-align: center; vertical-align: middle;">Department</td>
                                                    <td style="text-align: center; vertical-align: middle;">Workgroup</td>
                                                    <td style="text-align: center; vertical-align: middle;">Workshift</td>
                                                    <td style="text-align: center; vertical-align: middle;">Workcenter</td>
                                                    <td style="text-align: center; vertical-align: middle;">Activity</td>
                                                    <td style="text-align: center; vertical-align: middle;">Customers</td>
                                                    <td style="text-align: center; vertical-align: middle;">Job Orders</td>
                                                    <td style="text-align: center; vertical-align: middle;">Employees</td>
                                                    <td style="text-align: center; vertical-align: middle;">User Roles</td>
                                                    <td style="text-align: center; vertical-align: middle;">Reports</td>
                                                    <td style="text-align: center; vertical-align: middle;">Remote Access</td>
                                                    <td style="text-align: center; vertical-align: middle;">Data Ops</td>

                                                </tr>
                                            </thead>
                                            <tbody id="tRoles">
                                                <!-- <tr><td colspan="4" align="center"> - No data available -</td></tr> -->
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="18" id="roleCnt">Total Role Count : 0</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </article> 
                                       
                                </div>
                            </div>
                        </article>
                    </article>
                </article>
            </div>
        <!-- /.container-fluid -->

        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- Modal Confirmation (User Roles)-->
    <div class="modal fade" id="modRoles" tabindex="-1" role="dialog" aria-labelledby="modRoleTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modRoleTitle">[Title]</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" id="roleid" style="visibility: hidden;" value="0">
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-rcode" style="width:200px;">Code</span>
                    </div>
                    <input id="rcode" type="text" class="form-control" placeholder="Role Code" aria-label="RCode" aria-describedby="ao-rcode">
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-rdesc" style="width:200px;">Description</span>
                    </div>
                    <input id="rdesc" type="text" class="form-control" placeholder="Description" aria-label="RDesc" aria-describedby="ao-rdesc">
                </div>
                <h6 class="mt-2 mb-2">Access Rights - Client</h6>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="selclogin" style="width:200px;">Login</label>
                    </div>
                    <select class="custom-select" id="selclogin">
                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="selcgrplogin" style="width:200px;">Group Clock-in</label>
                    </div>
                    <select class="custom-select" id="selcgrplogin">
                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <h6 class="mt-2 mb-2">Access Rights - Administration</h6>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="seladmlogin" style="width:200px;">Login</label>
                    </div>
                    <select class="custom-select" id="seladmlogin">
                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="seladmdept" style="width:200px;">Manage Department</label>
                    </div>
                    <select class="custom-select" id="seladmdept">
                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="seladmwg" style="width:200px;">Manage Workgroup</label>
                    </div>
                    <select class="custom-select" id="seladmwg">
                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="seladmshift" style="width:200px;">Manage Workshift</label>
                    </div>
                    <select class="custom-select" id="seladmshift">
                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="seladmwc" style="width:200px;">Manage Workcenter</label>
                    </div>
                    <select class="custom-select" id="seladmwc">
                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="seladmact" style="width:200px;">Manage Activity</label>
                    </div>
                    <select class="custom-select" id="seladmact">
                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="seladmcust" style="width:200px;">Manage Customers</label>
                    </div>
                    <select class="custom-select" id="seladmcust">
                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="seladmjo" style="width:200px;">Manage Job Orders</label>
                    </div>
                    <select class="custom-select" id="seladmjo">
                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="seladmemp" style="width:200px;">Manage Employees</label>
                    </div>
                    <select class="custom-select" id="seladmemp">
                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="seladmroles" style="width:200px;">Manage User Roles</label>
                    </div>
                    <select class="custom-select" id="seladmroles">
                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="seladmrpt" style="width:200px;">Manage Reports</label>
                    </div>
                    <select class="custom-select" id="seladmrpt">
                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="seladmremote" style="width:200px;">Manage Remote Access</label>
                    </div>
                    <select class="custom-select" id="seladmremote">
                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="seladmdataops" style="width:200px;">Manage Data Operations</label>
                    </div>
                    <select class="custom-select" id="seladmdataops">
                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button name="cancelRole" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button name="saveRole" type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal Notification-->
    <div class="modal fade" id="modNotifyRole" tabindex="-1" role="dialog" aria-labelledby="modNotifyRoleTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modNotifyRoleTitle">[Title]</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modNotifyRoleBody">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>