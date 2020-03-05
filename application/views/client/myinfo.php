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
    <div class="container pb-5" style="background-image: url('../assets/img/gradient-3.jpg'); background-size:cover; background-repeat: no-repeat; height: auto; ">
        <h5>
            <span class="fa-stack fa-2x mt-2" >
                <i class="fas fa-square fa-stack-2x fa-inverse"></i>
                <i class="far fa-id-card fa-stack-1x"></i>
            </span>
            <label style="color:whitesmoke;">My Profile</label> 
        </h5>
        <div class="row mt-5">
            <div class="col"></div>
            <div class="col">
                <div class="card bg-dark border-light" style="width: 600px;">
                    <center>
                        <img src="https://picsum.photos/200/300" class="card-img-top rounded-circle mt-4" alt="..." style="width:200px; height:200px; border: 1px solid whitesmoke !important;">
                    </center>                 
                    <div class="card-body rounded">
                        <ul class="list-group list-group-flush" style="text-align:center;">
                            <li class="list-group-item">13</li>
                            <li class="list-group-item">Loren Drever</li>
                            <li class="list-group-item">Production Lead 1</li>
                            <li class="list-group-item">Mid-day Shift from 12NN - 9PM</li>
                        </ul>
                        <ul class="list-group list-group-flush mt-2" style="text-align:center;">
                            <li class="list-group-item">Box 266 212 Taylor Street Oxbow, Saskatchewan S0C 2B0</li>
                            <li class="list-group-item">306-483-2427</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>
</div>
