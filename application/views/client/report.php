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
                                      <a class="dropdown-item" href="/jobtracker/groupchange"><i class="fas fa-users-cog mr-2" style="color: #DA8573;"></i>Group Change</a>
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
    <div class="card mt-1" name="logEx">
        <div class="card-header">Time Sheet Generation/Approvals</div>
        <div class="card-body" style="min-height: 780px; max-height:780px; overflow-y: scroll;">
            <div class="row pb-3 border-bottom">
                <div class="col border-right">
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="ao-isexec" style="width:130px;">For Approval</span>
                        </div>
                        <select class="custom-select" id="selTSCode">
                        </select>
                    </div>
                </div>
                <div class="col">
                    <button name="genData" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modTSGen">Generate Data</button>
                    <!-- <button name="rptCancel" type="button" class="btn btn-primary mr-3">Generate Report</button> -->
                    <button name="genCancel" type="button" class="btn btn-secondary ">Clear Display</button>   
                </div>
                <div class="col align-content-center align-content-lg-between">
  
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-3 mb-1">
                    <div class="card">
                        <div class="card-header">Members</div>
                        <div class="card-body" style="min-height: 600px; max-height:600px; overflow-y:scroll;">
                            <div class="list-group" name="tseList">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col mb-1">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-9" name="groupsnm">Timesheet Logs</div>
                                <div class="col text-right badge badge-pill badge-primary" name="TSTotal" style="font-size: 16px;">0.00</div>
                            </div>
                        </div>
                        <div class="card-body" style="min-height: 600px; max-height:600px; overflow-y:scroll;">
                            <table class="table table-sm" style="font-size:12px;">
                                <thead>
                                    <tr class="border-bottom bg-secondary fa-inverse">
                                        <td>&nbsp;</td>
                                        <td class="text-center">Work Date</td>
                                        <td class="text-center">Time-In</td>
                                        <td class="text-center">Time-Out</td>
                                        <td class="text-right">Hrs. Worked</td>
                                    </tr>
                                </thead>
                                <tbody name="tLogs">
                                </tbody>
                            </table>
                        </div>
                    </div>                
                </div>
                <div class="col mb-1">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-9" name="groupsnm">Jobsheet Logs</div>
                                <div class="col text-right badge badge-pill badge-primary" name="JSTotal" style="font-size: 16px;">0.00</div>
                            </div>
                        </div>
                        <div class="card-body" style="min-height: 600px; max-height:600px; overflow-y:scroll;">
                            <table class="table table-sm" style="font-size:12px;">
                                <thead>
                                    <tr class="border-bottom bg-secondary fa-inverse">
                                        <td>&nbsp;</td>
                                        <td>Work Date</td>
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
                                </tbody>
                            </table>                                
                        </div>
                    </div>                  
                </div>
            </div>                   
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col" name="appdecTS">
                    <button name="approveTS" type="button" class="btn btn-success btn-sm">Approve</button>
                    <button name="declineTS" type="button" class="btn btn-danger btn-sm">Decline</button>                  
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /#wrapper -->

<!-- Timesheet Generation -->
<div class="modal fade" id="modTSGen" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generate Time Sheet</h5>
            </div>
            <div class="modal-body">
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
            <div class="modal-footer">
                <button type="button" name="TSGen" class="btn btn-primary">Generate</button>
                <button type="button" name="TSCancel" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Timesheet Modal -->
<div class="modal" tabindex="-1" role="dialog" id="modUpdLog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Override Timesheet</h5>
        </div>
        <div class="modal-body">
            <input id="selTSId" type="hidden" value="0">
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-wd" style="width: 130px">Work Date</span>
                </div>
                <input id="twd" type="text" class="form-control" placeholder="Work Date" aria-label="Work Date" aria-describedby="ao-wd" readonly>
            </div>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-ti" style="width: 130px">Date/Time In</span>
                </div>
                <input id="tstidt" type="text" class="form-control" placeholder="Date In" aria-label="Date In" aria-describedby="ao-dtti" readonly>
                <input id="tsti" type="text" class="form-control" placeholder="Time In" aria-label="Time In" aria-describedby="ao-ti" readonly>
            </div>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-to" style="width: 130px">Date/Time Out</span>
                </div>
                <input id="tstodt" type="text" class="form-control" placeholder="Date Out" aria-label="Date Out" aria-describedby="ao-dtto" maxlength="10">
                <input id="tsto" type="text" class="form-control" placeholder="Time Out" aria-label="Time Out" aria-describedby="ao-to" maxlength="8">
            </div>
            <!-- <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-hrs" style="width: 130px">Total Hrs.</span>
                </div>
                <input id="thrs" type="text" class="form-control" placeholder="0.00" aria-label="0.00" aria-describedby="ao-hrs" readonly>
            </div> -->
        </div>
        <div class="modal-footer">
            <button name="bCUpdTS" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button name="bUpdTS" type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
</div>

<!-- Update Jobsheet Modal -->
<div class="modal" tabindex="-1" role="dialog" id="modUpdJob">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Override Jobsheet</h5>
        </div>
        <div class="modal-body">
            <input id="selJSId" type="hidden" value="0">
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-wd" style="width: 130px">Work Date</span>
                </div>
                <input id="jwd" type="text" class="form-control" placeholder="Work Date" aria-label="Work Date" aria-describedby="ao-wd" readonly>
            </div>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-job" style="width: 130px">Job Code</span>
                </div>
                <input id="jjob" type="text" class="form-control" placeholder="Job Code" aria-label="Job Code" aria-describedby="ao-job" readonly>
            </div>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-ord" style="width: 130px">Order No.</span>
                </div>
                <input id="jord" type="text" class="form-control" placeholder="Order Code" aria-label="Order Code" aria-describedby="ao-ord" readonly>
            </div>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-wc" style="width: 130px">Workcenter</span>
                </div>
                <input id="jwc" type="text" class="form-control" placeholder="WC Code" aria-label="WC Code" aria-describedby="ao-wc" readonly>
            </div>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-act" style="width: 130px">Activity</span>
                </div>
                <input id="jact" type="text" class="form-control" placeholder="Activity" aria-label="Activity" aria-describedby="ao-act" readonly>
            </div>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-ti" style="width: 130px">Time In</span>
                </div>
                <input id="jstidt" type="text" class="form-control" placeholder="Time In" aria-label="Time In" aria-describedby="ao-ti" readonly>
                <input id="jsti" type="text" class="form-control" placeholder="Time In" aria-label="Time In" aria-describedby="ao-ti" readonly>
            </div>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-to" style="width: 130px">Time Out</span>
                </div>
                <input id="jstodt" type="text" class="form-control" placeholder="Date Out" aria-label="Date Out" aria-describedby="ao-dtto" maxlength="10">
                <input id="jsto" type="text" class="form-control" placeholder="Time Out" aria-label="Time Out" aria-describedby="ao-to" maxlength="8">
            </div>
            <!-- <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-hrs" style="width: 130px">Total Hrs.</span>
                </div>
                <input id="jshrs" type="text" class="form-control" placeholder="0.00" aria-label="0.00" aria-describedby="ao-hrs" readonly>
            </div> -->
        </div>
        <div class="modal-footer">
            <button name="bCUpdJS" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button name="bUpdJS" type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
</div>


<!-- Notification modal -->
<div class="modal" tabindex="-1" role="dialog" name="modTS">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" name="modTSTitle">...</h5>
        </div>
        <div class="modal-body" name="modTSBody">
            ...
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
        </div>
        </div>
    </div>
</div>