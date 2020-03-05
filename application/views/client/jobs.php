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
    <div class="card mt-1">
        <h6 class="card-header">
            <i class="fas fa-business-time fa-2x" style="vertical-align: middle;"></i> &nbsp;
            My Jobsheet
        </h6>
        <div class="card-body">
            <div id="CIOButtons">
            </div>
            <div class="card" style="min-height: 750px; max-height: 750px; overflow-y: auto;">
                <div class="card-body" style="background-image: url('../assets/img/gradient-3.jpg'); background-size:cover; background-repeat: no-repeat; height: auto;">
                    <table id="myjobs" class="table border-right border-left">
                        <thead>
                            <tr class="border-bottom">
                                <td class="border-right fa-inverse font-weight-bold text-center">Work Date</th>
                                <td class="border-right fa-inverse font-weight-bold text-center">Work Center</th>
                                <td class="border-right fa-inverse font-weight-bold text-center">Activity</th>
                                <td class="border-right fa-inverse font-weight-bold text-center">Job No.</th>
                                <td class="border-right fa-inverse font-weight-bold text-center">Charge Center</th>
                                <td class="border-right fa-inverse font-weight-bold text-center">Time Start</th>
                                <td class="border-right fa-inverse font-weight-bold text-center">Time End</th>
                                <td class="fa-inverse font-weight-bold text-center">Cycle Hrs.</th>
                            </tr>
                        </thead>
                        <tbody id="myjobdata"></tbody>
                    </table>
                </div> 
                <div class="card-footer">
                    <div class="row">
                        <div class="col font-weight-bold" id="totaljobhrs">Total hours worked on job(s) : <label style="color:red;">0.00</label></div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>

<!-- Clocking into a Job -->
<div class="modal fade" id="jmodnew" tabindex="-1" role="dialog" aria-labelledby="jmodnewlabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="jmodalnew">Clock-in to a Job</h5>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col">
                    <div class="input-group mt-2 mb-1">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="myjobord" style="width: 150px;">Job No</label>
                        </div>
                        <select class="custom-select" id="myjobord">
                            <!-- <option value="0" selected> - Choose a Job Order- </option> -->
                        </select>
                    </div>
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="myjobjob" style="width: 150px;">Charge Center</label>
                        </div>
                        <select class="custom-select" id="myjobjob">
                            <!-- <option value="0" selected> - Choose a Job (optional) - </option> -->
                        </select>
                    </div>                    
                    <div class="input-group mb-1">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="myjobwc" style="width: 150px;">Workcenter</label>
                        </div>
                        <select class="custom-select" id="myjobwc">

                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="myjobact" style="width: 150px;">Activity</label>
                        </div>
                        <select class="custom-select" id="myjobact">
                            <!-- <option value="0" selected> - Choose an Activity - </option> -->
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button id="jclockin" type="button" class="btn btn-primary">Clock In</button>
            <button id="jccancel" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
        </div>
    </div>
</div>


<!-- Confirmation modal -->
<div class="modal fade" id="jconfirm" tabindex="-1" role="dialog" aria-labelledby="jmodallabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="jmodallabel">Confirm Clock-in</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-3"><i class="fas fa-question-circle fa-5x" style="color:#2DC1F5;"></i></div>
            <div class="col" style="vertical-align: middle;"><p> Proceed in adding new job/task to selected
            members?</p></div>
        </div>
      </div>
      <div class="modal-footer">
        <button id="bgconfirm" type="button" class="btn btn-primary" data-dismiss="modal">Clock-in Job</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Notification modal -->
<div class="modal fade" id="jobNotify" tabindex="-1" role="dialog" aria-labelledby="jobNotifyTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="jobNotifyTitle">Error Clocking In</h5>
      </div>
      <div class="modal-body" id="jobNotifyBody">
      </div>
      <div class="modal-footer">
        <button name="nConfirm" type="button" class="btn btn-secondary" data-dismiss="modal" style="width: 70px;">Ok</button>
      </div>
    </div>
  </div>
</div>