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
            <!-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="drpReport" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Reports</span></a>
                <div class="dropdown-menu" aria-labelledby="drpReport">            
                    <a class="dropdown-item" href="#">Department List</a>
                    <a class="dropdown-item" href="#">Audit Trail </a>
                </div>
            </li> -->
        </ul>
        <div id="content-wrapper">
            <div class="container-fluid">
                <article class="container-fluid" style="norder">
                    <article class="row mb-3">
                        <article class="col">
                            <div class="card">
                                <div class="card-header">
                                    Projects - Job Orders (Active)
                                </div>
                                <div class="card-body">
                                    <article class="container-fluid" >
                                        <div class="row">
                                            <div class="col">
                                                <a href="#" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modJO"><i class="far fa-plus-square"></i> &nbsp;New Job Order</a>
                                            </div>
                                            <div class="col">
                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-1">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="ao-findjo">Find</span>
                                                    </div>
                                                    <input id="findjo" type="text" class="form-control" placeholder="Project/JO" aria-label="FindJO" aria-describedby="ao-findjo">
                                                </div>
                                            </div>
                                        </div>
                                    </article> 
                                    <div class="container-fluid" style="display:block; position: relative; height: 650px; overflow: auto;">
                                        <table class="table table-bordered table-striped table-sm" style="font-size:12px;">
                                            <thead>
                                                <tr>
                                                    <td style="width:20%;"></td>
                                                    <td style="width:15%;">Order No.</td>
                                                    <td style="width:65%;">Description</td>
                                                </tr>
                                            </thead>
                                            <tbody id="tJO">
                                                <tr><td colspan="3" align="center"> - No data available -</td></tr>
                                            </tbody>
                                        </table>                                        
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div id="JOCount">Total Job Order(s) : 0</div>
                                </div>
                            </div>
                        </article>
                        <article class="col">
                            <div class="card">
                                <div class="card-header">
                                    Project - Order Item (Active)
                                </div>
                                <div class="card-body">
                                    <article class="container-fluid">
                                        <div class="row">
                                            <div class="col">
                                                <a href="#" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modJOD"><i class="fas fa-link"></i>&nbsp;New Order Item</a>
                                            </div>
                                            <div class="col">
                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-1">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="ao-findjod">Find</span>
                                                    </div>
                                                    <input id="findjod" type="text" class="form-control" placeholder="JO Item" aria-label="FindJOD" aria-describedby="ao-findjod">
                                                </div>
                                            </div>
                                        </div>
                                    </article> 
                                    <div class="container-fluid" style="display:block; position: relative; height: 650px; overflow: auto;"> 
                                        <table class="table table-bordered table-striped table-sm" style="font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <td style="width:15%;"></td>
                                                    <td style="width:15%;">Order No.</td>
                                                    <td style="width:15%;">Item No.</td>
                                                    <td style="width:55%;">Description</td>
                                                </tr>
                                            </thead>
                                            <tbody id="tJOD">
                                                <tr><td colspan="4" align="center"> - No data available -</td></tr>
                                            </tbody>
                                        </table>
                                    </div>                      
                                </div>
                                <div class="card-footer">
                                    <div id="JODCount">Order Item(s) : 0</div>
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

    <!-- Modal Confirmation (Job Orders)-->
    <div class="modal fade" id="modJO" tabindex="-1" role="dialog" aria-labelledby="modJOTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modJOTitle">[Title]</h5>
                <input type="text" id="joid" style="visibility: hidden;" value="0">
            </div>
            <div class="modal-body">
                <div class="input-group mb-3" style="display:none;">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01" style="width:150px;">Lead/Manager</label>
                    </div>
                    <select class="custom-select" id="jocust">
                    </select>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-jocode" style="width:150px;">Code</span>
                    </div>
                    <input id="jocode" type="text" class="form-control" placeholder="Job Order Code" aria-label="JOCode" aria-describedby="ao-jocode">
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-jodesc" style="width:150px;">Description</span>
                    </div>
                    <input id="jodesc" type="text" class="form-control" placeholder="Description" aria-label="JODescription" aria-describedby="ao-jodesc">
                </div>
            </div>
            <div class="modal-footer">
                <button name="JOCancel" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button name="JOSave" type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmation (Order Items)-->
    <div class="modal fade" id="modJOD" tabindex="-1" role="dialog" aria-labelledby="modJODTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modJODTitle">Add Items to Job Order</h5>
                <input type="text" id="jodid" style="visibility: hidden;" value="0">
            </div>
            <div class="modal-body">
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="jodjo" style="width:150px;">Job Order</label>
                    </div>
                    <select class="custom-select" id="jodjo">
                    </select>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-jodno" style="width:150px;">JO Item Code</span>
                    </div>
                    <input id="jodno" type="text" class="form-control" placeholder="JO Item No." aria-label="JODNo" aria-describedby="ao-jodno">
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-jodpno" style="width:150px;">Part Number</span>
                    </div>
                    <input id="jodpno" type="text" class="form-control" placeholder="Item No." aria-label="JODPNo" aria-describedby="ao-jodpno">
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-joddesc" style="width:150px;">Description</span>
                    </div>
                    <input id="joddesc" type="text" class="form-control" placeholder="Item Desc" aria-label="JODDesc" aria-describedby="ao-joddesc">
                </div>
            </div>
            <div class="modal-footer">
                <button name="JODCancel" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button name="JODSave" type="button" class="btn btn-primary">Save Changes</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal Notification-->
    <div class="modal fade" id="modJONotify" tabindex="-1" role="dialog" aria-labelledby="modJONotifyTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modJONotifyTitle">[Title]</h5>
            </div>
            <div class="modal-body" id="modJONotifyBody">
                ...
            </div>
            <div class="modal-footer">
                <button name="bnotify" type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmation for Delete -->
    <div class="modal fade" id="modDelete" tabindex="-1" role="dialog" aria-labelledby="modNotifyTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modNotifyTitle">Delete Department</h5>
            </div>
            <div class="modal-body" id="notifymsg">
                <div class="row">
                    <div class="col-3">
                    <i class="far fa-question-circle fa-7x" style="color:#EC2A2A;"></i>
                    </div>
                    <div class="col">
                        <p class="mt-4">
                            Are you sure you want to remove the selected department?
                            This cannot be undone, proceed?
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button name="cdeldept" type="button" class="btn btn-primary" data-dismiss="modal">Confirm</button>
            </div>
            </div>
        </div>
    </div>