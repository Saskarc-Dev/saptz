<div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="/">SAPTZ</a>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dpMy" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user-circle"></i> My</a>
                    <div class="dropdown-menu" aria-labelledby="dpMy">
                        <a class="dropdown-item" href="/jobtracker/myinfo"><i class="far fa-address-card" style="color: #DA8573;"></i> &nbsp; Account Information</a>
                        <!-- <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/jobtracker/mytimesheet"><i class="fas fa-user-clock" style="color: #DA8573;"></i> &nbsp; Timesheet</a>
                        <a class="dropdown-item" href="/jobtracker/myjobsheet"><i class="fas fa-business-time" style="color: #DA8573;"></i> &nbsp; Activity Timesheet</a> -->
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/jobtracker/myjobs"><i class="fas fa-user-cog" style="color: #DA8573;"></i> &nbsp; Activity</a>
                        <?php
                            if($_SESSION['userdata']['access2'] > 0){
                                echo '<a class="dropdown-item" href="/jobtracker/mygroupjobs"><i class="fas fa-people-carry mr-2" style="color: #DA8573;"></i>Group Activity</a>
                                      <div class="dropdown-divider"></div>
                                      <a class="dropdown-item" href="/jobtracker/shiftchange"><i class="fas fa-user-clock mr-2" style="color: #DA8573;"></i>Shift Change</a>
                                      <a class="dropdown-item" href="/jobtracker/#"><i class="fas fa-users-cog mr-2" style="color: #DA8573;"></i>Group Change</a>
                                      <div class="dropdown-divider"></div>
                                      <a class="dropdown-item" href="/jobtracker/myreports"><i class="far fa-file-alt mr-2" style="color: #DA8573;"></i>Log Report</a>';
                            } 
                        ?> 
                    </div>
                </li>
                <li class="nav-item dropdown" style="display:none;">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardp1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Reports
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbardp1">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
            </ul>
            <label id="lblTime" class="btn btn-outline-light my-2 my-sm-0" style="margin-top: 10%;" onload="showTime();"></label>
            <button id="logout" class="btn btn-outline-light my-2 my-sm-0" style="margin-left: 2px;">Log out</button>
        </div>
    </nav>
    <div class="card mt-1" name="chngShift">
        <div class="card-header">Group Assignment</div>
        <div class="card-body" style="min-height: 820px; max-height:920px; overflow-y:auto;">
            <!-- <h6 class="text-danger">Parameters</h6> -->
            <div class="row">
                <div class="col-2 align-content-center align-content-lg-between">
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modcgroup">New Group Change Application</button>
                </div>
                <div class="col align-content-center align-content-lg-between">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="dt" style="width: 150px;">Workdate Range</label>
                        </div>
                        <input type="text" id="wddtfrom" class="form-control mr-1">
                        <input type="text" id="wddtto" class="form-control">
                    </div>
                </div>
                <div class="col align-content-center align-content-lg-between">
                    <button name="csload" type="button" class="btn btn-primary">Load Data</button>
                    <button name="csreset" type="button" class="btn btn-primary">Reset</button>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-9" name="groupsnm">Applied Group Change</div>
                                <!-- <div class="col text-right"><a name="prclear" href="#" class="badge badge-pill badge-warning">Clear Logs</a></div> -->
                            </div>
                        </div>
                        <div class="card-body" style="min-height: 650px; max-height:610px; overflow-y:scroll;">
                            <table class="table table-sm" style="font-size:12px;">
                                <thead>
                                    <tr class="border-bottom bg-secondary fa-inverse">
                                        <td rowspan="2" class="border-right">&nbsp;</td>
                                        <td rowspan="2" class="border-right align-middle text-center">Work Date</td>
                                        <td rowspan="2" class="border-right align-middle text-center">Employee</td>
                                        <td colspan="2" class="border-right align-middle text-center">Group Change</td>
                                        <td rowspan="2" class="align-middle text-center">Date Filed</td>
                                    </tr>
                                    <tr class="border-bottom bg-secondary fa-inverse">
                                        <td class="border-right align-middle text-center">Old Group</td>
                                        <td class="border-right align-middle text-center">New Group</td>
                                    </tr>
                                </thead>
                                <tbody name="GCLogs">
                                </tbody>
                            </table>                                
                        </div>
                        <div class="card-footer">
                            <!-- <div class="row">
                                <div class="col-9 align-content-md-between" name="ttlCS">Total Exceptions: 1</div>
                            </div> -->
                        </div>
                    </div>                  
                </div>
            </div>                   
        </div>
    </div>
</div>

<div class="modal fade" id="modcgroup" tabindex="-1" role="dialog" aria-labelledby="modcghifttitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modcghifttitle">Change Group Information</h5>
            </div>
            <div class="modal-body" style="min-height:650px !important;">
                <div class="row">
                    <div class="col">
                        <h6>Select change group effectivity period (range)</h6>
                        <div class="input-group mt-2 mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="dt" style="width: 150px;">Period</label>
                            </div>
                            <input type="text" id="dtfrom" class="form-control mr-1">
                            <input type="text" id="dtto" class="form-control">
                        </div>
                        <h6>Team/Employee selection information</h6>                    
                        <div class="input-group mt-2 mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="selgrpfrom" style="width: 150px;">From group</label>
                            </div>
                            <select class="custom-select" id="selgrpfrom">
                                <!-- <option value="0" selected> - Choose a Job Order- </option> -->
                            </select>
                        </div>
                        <h6>Select members from list below</h6>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col border-right">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="modgrplist">Find</label>
                                                    </div>
                                                    <input type="text" class="form-control mr-2" name="gmsearch">
                                                    <button class="btn btn-primary" name="gmsfindcancel">Clear</button>                                                
                                                </div>
                                            </div>
                                            <div class="col-2 text-center">
                                                <button class="btn btn-primary" name="gcselall">Select All</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="min-height: 370px; max-height: 370px; overflow-y: auto;">
                                        <div class="list-group" name="gcelist">
                                        </div>
                                    </div>
                                </div>    
                            </div>
                        </div>

                        <h6>Select a group to move to</h6>                    
                        <div class="input-group mt-2 mb-1">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="selgrpto" style="width: 150px;">To group</label>
                            </div>
                            <select class="custom-select" id="selgrpto">
                                <!-- <option value="0" selected> - Choose a Job Order- </option> -->
                            </select>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button name="cgNew" type="button" class="btn btn-primary">Send Request</button>
                <button name="cgCancel" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div name="cgnotify" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 name="cgnotifytitle" class="modal-title">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div name="cgnotifybody" class="modal-body">
            <p>Modal body text goes here.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
        </div>
        </div>
    </div>
</div>