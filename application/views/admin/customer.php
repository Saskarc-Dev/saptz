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
                    <a class="dropdown-item" href="#">Work Shifts</a>
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
                                    Customers (Active)
                                </div>
                                <div class="card-body">
                                    <article class="container-fluid" style="display:block; position: relative; height: 650px; overflow: auto;">
                                        <div class="row">
                                            <div class="col">
                                                <a href="#" class="btn btn-primary mb-2" name="newCust" data-toggle="modal" data-target="#modCust"><i class="far fa-plus-square"></i> &nbsp;New Customer</a>
                                            </div>
                                            <div class="col">
                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-1">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="ao-findemp">Find</span>
                                                    </div>
                                                    <input id="findcust" type="text" class="form-control" placeholder="Find Customer" aria-label="FindCust" aria-describedby="ao-findcust">
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table table-bordered table-striped table-sm" style="font-size:12px;">
                                            <thead>
                                                <tr>
                                                    <td style="width:10%;"></td>
                                                    <td style="width:15%;">Customer Code</td>
                                                    <td style="width:65%;">Name</td>
                                                    <td style="width:10%;text-align:center;">Status</td>
                                                </tr>
                                            </thead>
                                            <tbody id="tCust">
                                                <!-- <tr><td colspan="4" align="center"> - No data available -</td></tr> -->
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="6" name="custCnt">Total Customer Count : 0</td>
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

    <!-- Modal Confirmation (Customer)-->
    <div class="modal fade" id="modCust" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modCustTitle">[Title]</h5>
                <input type="text" id="custid" style="visibility: hidden;" value="0">
            </div>
            <div class="modal-body">
                <div class="input-group mb-1 mt-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-custcode" style="width:150px;">Customer Code</span>
                    </div>
                    <input id="custcode" type="text" class="form-control" placeholder="Customer Code" aria-label="CustCode" aria-describedby="ao-custname">
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-custname" style="width:150px;">Customer Name</span>
                    </div>
                    <input id="custname" type="text" class="form-control" placeholder="Customer name" aria-label="CustName" aria-describedby="ao-custname">
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-addr1" style="width:150px;">Address 1</span>
                    </div>
                    <input id="addr1" type="text" class="form-control" placeholder="Address 1" aria-label="Addr1" aria-describedby="ao-addr1">
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-addr2" style="width:150px;">Address 2</span>
                    </div>
                    <input id="addr2" type="text" class="form-control" placeholder="Address 2" aria-label="Addr1" aria-describedby="ao-addr2">
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-city" style="width:150px;">City</span>
                    </div>
                    <input id="city" type="text" class="form-control" placeholder="City" aria-label="City" aria-describedby="ao-city">
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-state" style="width:150px;">State</span>
                    </div>
                    <input id="state" type="text" class="form-control" placeholder="State" aria-label="State" aria-describedby="ao-state">
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-zipcode" style="width:150px;">Zip Code</span>
                    </div>
                    <input id="zipcode" type="text" class="form-control" placeholder="Zip Code" aria-label="ZipCode" aria-describedby="ao-zipcode">
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-country" style="width:150px;">Country</span>
                    </div>
                    <input id="country" type="text" class="form-control" placeholder="Country" aria-label="Country" aria-describedby="ao-country">
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-phone" style="width:150px;">Phone Number</span>
                    </div>
                    <input id="phone" type="text" class="form-control" placeholder="Phone Number" aria-label="PhoneNumber" aria-describedby="ao-phone">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" name="cancelCust" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" name="saveCust" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal Notification-->
    <div class="modal fade" id="modCustNotify" tabindex="-1" role="dialog" aria-labelledby="modCustNotifyTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modNotifyCustTitle">[Title]</h5>
            </div>
            <div class="modal-body" id="modCustNotifyBody">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
