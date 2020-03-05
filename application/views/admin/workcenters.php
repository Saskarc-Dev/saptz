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
                    <a class="dropdown-item" href="#">Work Centers</a>
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
                                    Work Centers (Active)
                                </div>
                                <div class="card-body">
                                    <article class="container-fluid " style="display:block; position: relative; height: 650px; overflow: auto;">
                                        <div class="row">
                                            <div class="col">
                                                <a href="#" name="newWC" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modWC"><i class="far fa-plus-square"></i> &nbsp;New Work Center</a>
                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="ao-search">Find</span>
                                                    </div>
                                                    <input name="findWC" type="text" class="form-control mr-1" placeholder="Search" aria-label="Search" aria-describedby="ao-search">
                                                    <button name="cancelFindWC" class="btn btn-outline-secondary" type="button">Clear</i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table table-bordered table-striped table-sm" style="font-size:12px;">
                                            <thead>
                                                <tr>
                                                    <td style="width:10%;"></td>
                                                    <td style="width:15%;">Code</td>
                                                    <td style="width:75%;">Description</td>
                                                </tr>
                                            </thead>
                                            <tbody id="tWorkcenter">
                                            </tbody>
                                        </table>
                                    </article> 
                                </div>
                                <div class="card-footer">
                                    <div id ="tWCTotal">Total Group Count : 0</div>
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

    <!-- Modal Confirmation (Work Centers)-->
    <div class="modal fade" id="modWC" tabindex="-1" role="dialog" aria-labelledby="modWCTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modWCTitle">[Title]</h5>
            </div>
            <div class="modal-body">
                <input type="text" id="wcid" style="visibility: hidden;" value="0">
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-wccode" style="width:150px;">Code</span>
                    </div>
                    <input id="wccode" type="text" class="form-control" placeholder="Workcenter Code" aria-label="WCCode" aria-describedby="ao-wccode">
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-wcdesc" style="width:150px;">Description</span>
                    </div>
                    <input id="wcdesc" type="text" class="form-control" placeholder="Description" aria-label="WCDesc" aria-describedby="ao-wcdesc">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" name="cancelWC" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" name="saveWC" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal Notification-->
    <div class="modal fade" id="modWCNotify" tabindex="-1" role="dialog" aria-labelledby="modWCNotifyTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modWCNotifyTitle">[Title]</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" name="modWCNotifyBody">
                ...
            </div>
            <div class="modal-footer">
                <button name="closeNotify" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>