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
    <div id="content-wrapper" name="logEx">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">Log Exceptions</div>
                <div class="card-body" style="min-height: 820px; max-height:920px; overflow-y:scroll;">
                    <h6 class="text-danger">Parameters</h6>
                    <div class="row pb-3 border-bottom">
                        <div class="col border-right">
                            <div class="input-group mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="ao-isexec" style="width:150px;">Group</span>
                                </div>
                                <select class="custom-select" id="selgroup">
                                    <option value="0" selected> - Select a group -</option>
                                    <option value="1"> Production Team 1</option>
                                    <option value="2"> Production Team 2</option>
                                </select>
                            </div>
                            <div class="input-group mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="ao-isexec" style="width:150px;">Members</span>
                                </div>
                                <select class="custom-select" id="selmember">
                                    <option value="0" selected>- Select All -</option>
                                    <option value="1">John Doe</option>
                                    <option value="2">Jane Doe</option>
                                </select>
                            </div>
                        </div>
                        <div class="col border-right">
                            <div class="input-group mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="ao-cutoffstart" style="width:150px;">Cut-off Start</span>
                                </div>
                                <input id="cutoffstart" type="text" class="form-control" placeholder="Cut-off Start" aria-label="Cut Off Start" aria-describedby="ao-cutoffstart">
                            </div>
                            <div class="input-group mb-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="ao-cutoffend" style="width:150px;">Cut-off End</span>
                                </div>
                                <input id="cutoffend" type="text" class="form-control" placeholder="Cut-off End" aria-label="Cut Off End" aria-describedby="ao-cutoffend">
                            </div>
                        </div>
                        <div class="col align-content-center align-content-lg-between">
                            <button type="button" class="btn btn-secondary">Load Data</button>
                            <button type="button" class="btn btn-secondary">Clear Fields</button> 
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-9" name="groupsnm">Timesheet Logs</div>
                                        <div class="col text-right"><a name="prclear" href="#" class="badge badge-pill badge-warning">Clear Logs</a></div>
                                    </div>
                                </div>
                                <div class="card-body" style="min-height: 580px; max-height:580px; overflow-y:scroll;">
                                    <table class="table table-sm" style="font-size:12px;">
                                        <thead>
                                            <tr class="border-bottom bg-secondary fa-inverse">
                                                <td>&nbsp;</td>
                                                <td>Work Date</td>
                                                <td>Employee</td>
                                                <td>Time-In</td>
                                                <td>Time-Out</td>
                                                <td>Hrs. Worked</td>
                                            </tr>
                                        </thead>
                                        <tbody name="tLogs">
                                            <tr class="border-bottom">
                                                <td>
                                                    <i class="fas fa-check mr-1 text-success" data-toggle="tooltip" data-placement="top" title="No Exceptions."></i>
                                                    <i class="fas fa-list" data-toggle="tooltip" data-placement="top" title="View Jobs"></i>
                                                </td>
                                                <td>2020-01-01</td>
                                                <td>John Doe</td>
                                                <td>08:00</td>
                                                <td>17:00</td>
                                                <td>8</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td>
                                                    <i class="far fa-edit mr-1 text-danger" data-toggle="tooltip" data-placement="top" title="Override Logs"></i>
                                                    <i class="fas fa-list text-success" data-toggle="tooltip" data-placement="top" title="View Jobs"></i>
                                                </td>
                                                <td>2020-01-02</td>
                                                <td>John Doe</td>
                                                <td>08:01</td>
                                                <td>--</td>
                                                <td>0</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td>
                                                    <i class="far fa-edit mr-1 text-danger" data-toggle="tooltip" data-placement="top" title="Override Logs"></i>
                                                    <i class="fas fa-list text-danger" data-toggle="tooltip" data-placement="top" title="View Jobs"></i>
                                                </td>
                                                <td>2020-01-03</td>
                                                <td>John Doe</td>
                                                <td>08:01</td>
                                                <td>--</td>
                                                <td>0</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-9" name="groupsnm">Total Exceptions: 2</div>
                                        <!-- <div class="col text-right"><a name="procJS" href="#" class="btn btn-primary btn-sm">Process Timesheet</a></div> -->
                                    </div>
                                </div>
                            </div>                
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-9" name="groupsnm">Jobsheet Logs</div>
                                        <div class="col text-right"><a name="prclear" href="#" class="badge badge-pill badge-warning">Clear Logs</a></div>
                                    </div>
                                </div>
                                <div class="card-body" style="min-height: 580px; max-height:580px; overflow-y:scroll;">
                                    <table class="table table-sm" style="font-size:12px;">
                                        <thead>
                                            <tr class="border-bottom bg-secondary fa-inverse">
                                                <td>&nbsp;</td>
                                                <td>Work Date</td>
                                                <td>Employee</td>
                                                <td class="text-center">Job</td>
                                                <td class="text-center">Order</td>
                                                <td class="text-center">Workcenter</td>
                                                <td class="text-center">Activity</td>
                                                <td class="text-center">Time-In</td>
                                                <td class="text-center">Time-Out</td>
                                                <td class="text-right">Cycle Hrs.</td>
                                            </tr>
                                        </thead>
                                        <tbody name="jLogs">
                                            <tr class="border-bottom">
                                                <td>
                                                    <i class="fas fa-check text-success" data-toggle="tooltip" data-placement="top" title="No Exceptions."></i>
                                                </td>
                                                <td>2020-01-02</td>
                                                <td>John Doe</td>
                                                <td class="text-center">W8639</td>
                                                <td class="text-center">W8639-1</td>
                                                <td class="text-center">1100</td>
                                                <td class="text-center">101</td>
                                                <td class="text-center">08:00</td>
                                                <td class="text-center">10:00</td>
                                                <td class="text-right">2.00</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td>
                                                    <i class="fas fa-check text-success" data-toggle="tooltip" data-placement="top" title="No Exceptions."></i>
                                                </td>
                                                <td>2020-01-02</td>
                                                <td>John Doe</td>
                                                <td class="text-center">W8639</td>
                                                <td class="text-center">W8639-1</td>
                                                <td class="text-center">1400</td>
                                                <td class="text-center">401</td>
                                                <td class="text-center">10:05</td>
                                                <td class="text-center">11:00</td>
                                                <td class="text-right">0.92</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td>
                                                    <i class="fas fa-check text-success" data-toggle="tooltip" data-placement="top" title="No Exceptions."></i>
                                                </td>
                                                <td>2020-01-02</td>
                                                <td>John Doe</td>
                                                <td class="text-center">W8639</td>
                                                <td class="text-center">W8639-1</td>
                                                <td class="text-center">1100</td>
                                                <td class="text-center">102</td>
                                                <td class="text-center">11:10</td>
                                                <td class="text-center">12:00</td>
                                                <td class="text-right">0.83</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td>
                                                    <i class="fas fa-check text-success" data-toggle="tooltip" data-placement="top" title="No Exceptions."></i>
                                                </td>
                                                <td>2020-01-02</td>
                                                <td>John Doe</td>
                                                <td class="text-center">W8639</td>
                                                <td class="text-center">W8639-1</td>
                                                <td class="text-center">1400</td>
                                                <td class="text-center">402</td>
                                                <td class="text-center">13:00</td>
                                                <td class="text-center">14:30</td>
                                                <td class="text-right">1.50</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td>
                                                    <i class="fas fa-check text-success" data-toggle="tooltip" data-placement="top" title="No Exceptions."></i>
                                                </td>
                                                <td>2020-01-02</td>
                                                <td>John Doe</td>
                                                <td class="text-center">W8639</td>
                                                <td class="text-center">W8639-1</td>
                                                <td class="text-center">1100</td>
                                                <td class="text-center">101</td>
                                                <td class="text-center">14:35</td>
                                                <td class="text-center">15:00</td>
                                                <td class="text-right">0.42</td>
                                            </tr>
                                            <tr class="border-bottom">
                                                <td>
                                                    <i class="far fa-edit mr-1 text-danger" data-toggle="tooltip" data-placement="top" title="Override Logs"></i>
                                                </td>
                                                <td>2020-01-02</td>
                                                <td>John Doe</td>
                                                <td class="text-center">W8639</td>
                                                <td class="text-center">W8639-1</td>
                                                <td class="text-center">1400</td>
                                                <td class="text-center">401</td>
                                                <td class="text-center">15:01</td>
                                                <td class="text-center">--</td>
                                                <td class="text-right">0</td>
                                            </tr>
                                        </tbody>
                                    </table>                                
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-9 align-content-md-between" name="groupsnm">Total Exceptions: 1</div>
                                        <div class="col text-right"><a name="procJS" href="#" class="btn btn-primary btn-sm">Process Jobsheet</a></div>
                                    </div>
                                </div>
                            </div>                  
                        </div>
                    </div>                   
                </div>
            </div>
        </div>
    <!-- /.container-fluid -->

    </div>
    <!-- /.content-wrapper -->
</div>
<!-- /#wrapper -->