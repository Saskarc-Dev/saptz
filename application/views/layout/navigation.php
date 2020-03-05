    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="/jobtracker/home">SAPTZ</a>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dpMy" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My</a>
                        <div class="dropdown-menu" aria-labelledby="dpMy">
                            <a class="dropdown-item" href="/jobtracker/myinfo">Account Information</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/jobtracker/mytimesheet">Timesheet</a>
                            <a class="dropdown-item" href="/jobtracker/myjobsheet">Activity Timesheet</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardp1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Jobs
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbardp1">
                        <a class="dropdown-item" href="/jobtracker/jobs">New Activity</a>
                        <a class="dropdown-item" href="/jobtracker/groupjobs">New Group Activity</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
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
                <button class="btn btn-outline-light my-2 my-sm-0" style="margin-left: 2px;">Log out</button>
            </div>
        </nav>
    </div>