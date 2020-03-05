    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
        <a class="navbar-brand mr-1" href="index.html">SAPTZ - Admin</a>
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
        </ul>
        <div id="content-wrapper">
            <div class="container-fluid">
                <article class="container-fluid" style="norder">
                    <article class="row mb-3">
                        <article class="col">
                            <div class="card">
                                <div class="card-header">
                                    Departments (Active)
                                </div>
                                <div class="card-body">
                                    <article class="container-fluid" >
                                        <div class="row">
                                            <div class="col">
                                                <a href="#" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modDept"><i class="far fa-plus-square"></i> &nbsp;New Department</a>
                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="ao-search">Find</span>
                                                    </div>
                                                    <input name="findDept" type="text" class="form-control mr-1" placeholder="Search" aria-label="Search" aria-describedby="ao-search">
                                                    <button class="btn btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </article> 
                                    <div class="container-fluid" style="display:block; position: relative; height: 600px; overflow: auto;">
                                        <table class="table table-sm" style="font-size:14px;">
                                            <thead>
                                                <tr class="bg-secondary fa-inverse text-align-middle" style="height: 35px;">
                                                    <td style="width:20%;">&nbsp;</td>
                                                    <td style="width:15%;">Code</td>
                                                    <td style="width:40%;">Name/Description</td>
                                                    <td style="width:25%;">Lead/Manager</td>
                                                </tr>
                                            </thead>
                                            <tbody id="tDepts">
                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>                                        
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col" id="deptCount">Total Department Count : 0</div>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <article class="col-4">
                            <div class="card">
                                <div class="card-header">
                                    Linked Work Centers
                                </div>
                                <div class="card-body">
                                    <article class="container-fluid mb-2">
                                        <a href="#" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modDeptWC"><i class="fas fa-link"></i>&nbsp;Link a Workcenter</a>
                                    </article> 
                                    <div class="container-fluid" style="display:block; position: relative; height: 600px; overflow: auto;"> 
                                        <table class="table table-sm" style="font-size: 14px;">
                                            <thead>
                                                <tr class="bg-secondary fa-inverse text-align-middle" style="height: 35px;">
                                                    <td style="width:7%;">&nbsp;</td>
                                                    <td>Workcenter</td>
                                                </tr>
                                            </thead>
                                            <tbody id="tDWC">
                                                <tr><td colspan="2" align="center"> - No data available -</td></tr>
                                            </tbody>
                                        </table>
                                    </div>                      
                                </div>
                                <div class="card-footer text-muted">
                                    <div class="col" id="DWCCount">Linked Workcenter(s) : 0</div>
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

    <!-- Modal Confirmation (Departments)-->
    <div class="modal fade" id="modDept" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modDeptTitle">New Department</h5>
                <button name="cancel" type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" id="deptid" style="visibility: hidden;" value="0">
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-depcode" style="width:150px;">Code</span>
                    </div>
                    <input id="deptcode" type="text" class="form-control" placeholder="Department Code" aria-label="DeptCode" aria-describedby="ao-depcode">
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-depdesc" style="width:150px;">Description</span>
                    </div>
                    <input id="deptdesc" type="text" class="form-control" placeholder="Description" aria-label="DeptDescr" aria-describedby="ao-depdesc">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01" style="width:150px;">Lead/Manager</label>
                    </div>
                    <select class="custom-select" id="deptleads">
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button name="cancel" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button name="save" type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmation (Departments-Workcenter link)-->
    <div class="modal fade" id="modDeptWC" tabindex="-1" role="dialog" aria-labelledby="modDWCTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modDWCTitle">Add Workcenter to Department</h5>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="" style="width:150px;">Department</label>
                    </div>
                    <select class="custom-select" id="depts">
                    </select>
                </div>
                <!-- <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01" style="width:150px;">Work Center</label>
                    </div>
                    <select class="custom-select" id="workcenters">
                    </select>
                </div> -->
                <h6>Select workcenter(s) to link</h6>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col border-right">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="dwclist">Find</label>
                                            </div>
                                            <input type="text" class="form-control mr-2" name="findDWC">
                                            <button class="btn btn-primary" name="dwcfindcancel">Clear</button>                                                
                                        </div>
                                    </div>
                                    <div class="col-2 text-center">
                                        <button class="btn btn-primary" name="dwcselall">Select All</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="min-height: 510px; max-height: 510px; overflow-y: auto;">
                                <div class="list-group" name="dwclist">
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button name="wccancel" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button name="wcsave" type="button" class="btn btn-primary">Add Workcenter</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal Notification-->
    <div class="modal fade" id="modNotify" tabindex="-1" role="dialog" aria-labelledby="modNotifyTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modNotifyTitle">[Title]</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="notifymsg">
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