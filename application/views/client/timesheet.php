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
                        <a class="dropdown-item" href="/jobtracker/mygroupjobs"><i class="fas fa-people-carry" style="color: #DA8573;"></i> &nbsp; Group Activity</a>
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
    <div class="container pb-2" style="background-image: url('../assets/img/gradient-3.jpg'); background-size:cover; background-repeat: no-repeat; height: auto;">
        <h5>
            <span class="fa-stack fa-2x mt-2" >
                <i class="fas fa-square fa-stack-2x fa-inverse"></i>
                <i class="fas fa-user-clock fa-stack-1x"></i>
            </span>
            <label style="color:whitesmoke;">My Timesheet</label> 
        </h5>
        <div class="container-fluid mb-1" style="border: 1px solid whitesmoke; border-radius: 10px;">
            <h5 class="mt-2" style="color:whitesmoke;">Report Range</h5>
            <div class="row mb-2">
                <div class="col-sm mb-1">
                    <div class="input-group input-group-sm mb-1 mt-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Start Date</span>
                        </div>
                        <input id="tsstart" name="tsstart" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" style="width:90px !important;">
                    </div>
                </div>
                <div class="col-sm mb-1">
                    <div class="input-group input-group-sm mb-1 mt-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-sm">End Date</span>
                        </div>
                        <input id="tsend" name="tsend" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" style="width:90px !important;">
                    </div>
                </div>
                <div class="col-sm mb-1">
                    <button id="btntsload" class="btn btn-md btn-outline-light">Load</button>
                </div>
                <div class="col-sm mb-1"></div>
            </div>           
        </div>
        <div class="container-fluid" style="border: 1px solid whitesmoke; border-radius: 10px;">
            <h5 class="mt-2" style="color:whitesmoke;">Time Logs</h5>
            <table id="myts" class="table table-bordered" style="width:100%; height: inherit; font-size: 12px !important; color:white; height: 90%;">
                <thead>
                    <tr>
                        <td align="center" style="font-size: 12px !important; font-weight:bold !important;">Work Date</th>
                        <td align="center" style="font-size: 12px !important; font-weight:bold !important;">Shift</th>
                        <td align="center" style="font-size: 12px !important; font-weight:bold !important;">Time In</th>
                        <td align="center" style="font-size: 12px !important; font-weight:bold !important;">OFL</th>
                        <td align="center" style="font-size: 12px !important; font-weight:bold !important;">BFL</th>
                        <td align="center" style="font-size: 12px !important; font-weight:bold !important;">Time Out</th>
                        <td align="center" style="font-size: 12px !important; font-weight:bold !important;">Tardy</th>
                        <td align="center" style="font-size: 12px !important; font-weight:bold !important;">UT</th>
                        <td align="center" style="font-size: 12px !important; font-weight:bold !important;">OT</th>
                        <td align="center" style="font-size: 12px !important; font-weight:bold !important;">Worked Hrs</th>
                    </tr>
                </thead>
                <tbody id="mytsdata">
                    <tr><td colspan="10" style="text-align:center; font-size: 14px;">- No data available -</td></tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" style="font-size: 12px !important; font-weight:bold !important;">Timesheet Totals (Hours)</th>
                        <td align="right" style="font-size: 12px !important; font-weight:bold !important;">.00</th>
                        <td align="right" style="font-size: 12px !important; font-weight:bold !important;">.00</th>
                        <td align="right" style="font-size: 12px !important; font-weight:bold !important;">.00</th>
                        <td align="right" style="font-size: 12px !important; font-weight:bold !important;">.00</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>