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
                                    Activity - Work Center (Active)
                                </div>
                                <div class="card-body">
                                    <article class="container-fluid" style="display:block; position: relative; height: 650px; overflow: auto;">
                                        <div class="row mb-2">
                                            <div class="col-1">
                                                <a href="#" name="newActivity" class="btn btn-primary mb-3 mr-3" data-toggle="modal" data-target="#modAct"><i class="far fa-plus-square"></i> &nbsp;New Activity</a>                                          
                                            </div>
                                            <div class="col">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="awcselect" style="width:150px;">Work Center</label>
                                                    </div>
                                                    <select class="custom-select" id="selawc" style="width:250px !important;">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col"></div>
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="ao-search">Find</span>
                                                    </div>
                                                    <input name="findAct" type="text" class="form-control mr-1" placeholder="Search" aria-label="Search" aria-describedby="ao-search">
                                                    <button name="cancelFindAct" class="btn btn-outline-secondary" type="button">Clear</i></button>
                                                </div>
                                            </div>
                                        </div>

                                        <table class="table table-sm" style="font-size:14px;">
                                            <thead>
                                                <tr class="bg-secondary fa-inverse text-align-middle" style="height: 35px;">
                                                    <td style="width:10%;"></td>
                                                    <td style="width:10%;">Code</td>
                                                    <td style="width:45%;">Description</td>
                                                    <td style="width:35%;">Work Center</td>
                                                </tr>
                                            </thead>
                                            <tbody id="tActivity">
                                                <!-- <tr><td colspan="4" align="center"> - No data available -</td></tr> -->
                                            </tbody>
                                        </table>
                                    </article> 
                                </div>
                                <div class="card-footer">
                                    <div name="actCount">Total Registered Activity : 0</div>
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

    <!-- Modal Confirmation (Activity)-->
    <div class="modal fade" id="modAct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modActTitle">[Title]</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" id="actid" style="visibility: hidden;" value="0">
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="selawcreg" style="width:150px;">Work Center</label>
                    </div>
                    <select class="custom-select" id="selawcreg">
                    </select>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-acode" style="width:150px;">Code</span>
                    </div>
                    <input id="acode" type="text" class="form-control" placeholder="Activity Code" aria-label="ACode" aria-describedby="ao-acode">
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-adesc" style="width:150px;">Description</span>
                    </div>
                    <input id="adesc" type="text" class="form-control" placeholder="Description" aria-label="ADesc" aria-describedby="ao-adesc">
                </div>
            </div>
            <div class="modal-footer">
                <button name="cancelAct" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button name="saveAct" type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal Notification-->
    <div class="modal fade" id="modActNotify" tabindex="-1" role="dialog" aria-labelledby="modActNotifyTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modActNotifyTitle">[Title]</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modActNotifyBody">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>