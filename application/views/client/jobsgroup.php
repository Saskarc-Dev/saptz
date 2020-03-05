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
    <div class="card mt-1" name="mygroups">
        <h6 class="card-header">
            <i class="fas fa-business-time fa-2x" style="vertical-align: middle;"></i> &nbsp;
            My Group Jobs
        </h6>
        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    <div class="row">
                        <div class="col">
                            <div class="card mb-1">
                                <h6 class="card-header">
                                    <div class="row">
                                        <div class="col">My Groups</div>
                                        <div class="col text-right"><a name="grefresh" href="#" class="badge badge-pill badge-warning">Refresh</a></div>
                                    </div>
                                </h6>
                                <div class="card-body" style="min-height: 320px; max-height: 320px; overflow-y: auto;">
                                    <div class="list-group" name="grouplist">
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <h6 class="card-header">
                                    <div class="row">
                                        <div class="col-9" name="groupsnm">(Members List)</div>
                                        <div class="col text-right"><a name="gmclear" href="#" class="badge badge-pill badge-warning">Clear List</a></div>
                                    </div>
                                </h6>
                                <div class="card-body" style="min-height: 385px; max-height: 385px; overflow-y: auto;">
                                    <div class="list-group" name="gmlist">
                                    </div>
                                </div>
                            </div>
                        </div>          
                    </div>
                </div>
                <div class="col">
                    <div class="card" style="min-height: 803px;">
                        <h6 class="card-header">
                            My Group's Job Sheet
                        </h6>
                        <div class="card-body">
                            <a href="#" class="btn btn-primary mb-2" data-toggle="modal" data-target="#gjobnew">Create a Group Job</a>
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body" style="background-image: url('../assets/img/gradient-3.jpg'); background-size:cover; background-repeat: no-repeat; min-height: 612px; max-height: 612px; overflow-y: auto;" >
                                                <table id="mygjobs" class="table border-right border-left" style="font-size: 12px;">
                                                <thead>
                                                    <tr>
                                                        <td class="border-right fa-inverse font-weight-bold text-center">&nbsp;</td>
                                                        <td class="border-right fa-inverse font-weight-bold text-center">Work Date</td>
                                                        <td class="border-right fa-inverse font-weight-bold text-center">Work Center</td>
                                                        <td class="border-right fa-inverse font-weight-bold text-center">Activity</td>
                                                        <td class="border-right fa-inverse font-weight-bold text-center">Job No.</td>
                                                        <td class="border-right fa-inverse font-weight-bold text-center">Charge Ctr</td>
                                                        <td class="border-right fa-inverse font-weight-bold text-center">Time Start</td>
                                                        <td class="border-right fa-inverse font-weight-bold text-center">Time End</td>
                                                        <td class="border-right fa-inverse font-weight-bold text-center">Cycle Hrs.</td>
                                                    </tr>
                                                </thead>
                                                <tbody id="mygjobdata">
                                                    <tr class="border-bottom">
                                                        <td colspan="9" class="fa-inverse">- No registered jobs -</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col border-right">Total hours worked by group(s)</div>
                                                <div class="col-2 text-right font-weight-bold" name="gjstotals" style="color: green;">0.00</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="card">
                                        <div class="card-header">                                            
                                            <div class="row">
                                                <div class="col text-right"><a name="amclear" href="#" class="badge badge-pill badge-warning">Clear List</a></div>
                                            </div>
                                        </div>
                                        <div class="card-body" style="min-height: 563px; max-height: 563px; overflow-y: auto;">
                                            <div class="list-group" name="jmlist">
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col border-right">Member(s) in Job</div>
                                                <div class="col-2 text-right font-weight-bold" name="gmtotals" style="color: green;">0</div>
                                            </div>                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="gjobnew" tabindex="-1" role="dialog" aria-labelledby="gjobnewlabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gjobnewlabel">Clock-in Group Job</h5>
            </div>
            <div class="modal-body" style="min-height:650px !important;">
                <div class="row">
                    <div class="col">
                        <h6>Job Information</h6>
                        <div class="input-group mt-2 mb-1">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="mygjobord" style="width: 150px;">Job No</label>
                            </div>
                            <select class="custom-select" id="mygjobord">
                                <!-- <option value="0" selected> - Choose a Job Order- </option> -->
                            </select>
                        </div>
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="mygjobjob" style="width: 150px;">Charge Center</label>
                            </div>
                            <select class="custom-select" id="mygjobjob">
                                <!-- <option value="0" selected> - Choose a Job (optional) - </option> -->
                            </select>
                        </div>                    
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="mygjobwc" style="width: 150px;">Workcenter</label>
                            </div>
                            <select class="custom-select" id="mygjobwc">

                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="mygjobact" style="width: 150px;">Activity</label>
                            </div>
                            <select class="custom-select" id="mygjobact">
                                <!-- <option value="0" selected> - Choose an Activity - </option> -->
                            </select>
                        </div>
                        <h6>Select a group to load its members</h6>
                        <div class="input-group mt-2 mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="modgrplist" style="width: 150px;">Groups</label>
                            </div>
                            <select class="custom-select" id="modgrplist">
                                <!-- <option value="0" selected> - Choose a Job Order- </option> -->
                            </select>
                        </div>
                        <h6>Select members from list below</h6>
                        <div class="row">
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
                                                <button class="btn btn-primary" name="gmsselall">Select All</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="min-height: 370px; max-height: 370px; overflow-y: auto;">
                                        <div class="list-group" name="gmslist">
                                        </div>
                                    </div>
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button name="gjNew" type="button" class="btn btn-primary">Clock-in Job</button>
                <button name="gjCancel" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="jgNotify" tabindex="-1" role="dialog" aria-labelledby="jgNotifyTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="jgNotifyTitle">[Title]</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="jgNotifyBody">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="width: 70px;">Ok</button>
      </div>
    </div>
  </div>
</div>