<nav class="navbar navbar-expand navbar-dark bg-dark static-top">
        <a class="navbar-brand mr-1" href="index.html">SAPTZ - Admin</a>
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
                                    Employees (Active)
                                </div>
                                <div class="card-body">
                                    <article class="container-fluid" style="display:block; position: relative; height: 650px; overflow: auto;"> 
                                        <div class="row">
                                            <div class="col">
                                                <a href="#" class="btn btn-primary mb-2" name="newEmp" data-toggle="modal" data-target="#modEmp"><i class="far fa-plus-square"></i> &nbsp;New Employee</a>
                                            </div>
                                            <div class="col">
                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-1">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="ao-findemp">Find</span>
                                                    </div>
                                                    <input id="findemp" type="text" class="form-control mr-1" placeholder="" aria-label="FindEmp" aria-describedby="ao-findemp">
                                                    <button name="cancelFindEmp" class="btn btn-outline-secondary" type="button">Clear</i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table table-sm" style="font-size:14px;">
                                            <thead>
                                                <tr class="bg-secondary fa-inverse text-align-middle" style="height: 35px;">
                                                    <td style="width:10%;"></td>
                                                    <td style="width:15%;">Employee Code</td>
                                                    <td style="width:25%;">Name</td>
                                                    <td style="width:15%;text-align:center;">Job Position</td>
                                                    <td style="width:15%;text-align:center;">Department</td>
                                                    <td style="width:10%;text-align:center;">Status</td>
                                                </tr>
                                            </thead>
                                            <tbody id="tEmp">
                                                <!-- <tr><td colspan="4" align="center"> - No data available -</td></tr> -->
                                            </tbody>
                                        </table>
                                    </article> 
                                </div>
                                <div class="card-footer">
                                    <div name="empCnt">Total Employee Count : 0</div>
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

    <!-- Modal Confirmation (Employee)-->
    <div class="modal fade" id="modEmp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modEmpTitle">[Title]</h5>
                <input type="text" id="empid" style="visibility: hidden;" value="0">
            </div>
            <div class="modal-body" style="height:650px !important;">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="acct-tab" data-toggle="tab" href="#acct" role="tab" aria-controls="home" aria-selected="true">Account Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="emp-tab" data-toggle="tab" href="#emp" role="tab" aria-controls="profile" aria-selected="false">Employment Information</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="acct" role="tabpanel" aria-labelledby="acct-tab">
                        <div class="input-group mb-1 mt-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="ao-empcode" style="width:150px;">Employee Code</span>
                            </div>
                            <input id="empcode" type="text" class="form-control" placeholder="Employee Code" aria-label="EmpCode" aria-describedby="ao-empcode">
                        </div>
                        <!-- <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="ao-emppwd" style="width:150px;">Password</span>
                            </div>
                            <input id="emppwd" type="password" class="form-control" placeholder="Password (6 - 10 Alphanumeric characters)" aria-label="EmpPassword" aria-describedby="ao-emppwd">
                        </div>
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="ao-empcpwd" style="width:150px;">Confirm Password</span>
                            </div>
                            <input id="empcpwd" type="password" class="form-control" placeholder="Confirm Password" aria-label="EmpCPassword" aria-describedby="ao-empcpwd">
                        </div> -->
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="ao-role" style="width:150px;">User Role</span>
                            </div>
                            <select class="custom-select" id="selrole">
                                <option value="0">Choose an option</option>
                            </select>
                        </div> 
                        <h6 class="dropdown-header">Account and Contact Information</h6>
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="ao-empln" style="width:150px;">Last Name</span>
                            </div>
                            <input id="empln" type="text" class="form-control" placeholder="Last Name" aria-label="EmpLN" aria-describedby="ao-empln">
                        </div>
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="ao-empfn" style="width:150px;">First Name</span>
                            </div>
                            <input id="empfn" type="text" class="form-control" placeholder="First Name" aria-label="EmpFN" aria-describedby="ao-empfn">
                        </div>
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="ao-empmn" style="width:150px;">Middle Name</span>
                            </div>
                            <input id="empmn" type="text" class="form-control" placeholder="Middle/Second Name" aria-label="EmpMN" aria-describedby="ao-empmn">
                        </div>
                        <!-- <div class="dropdown-divider"></div> -->
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="ao-addr" style="width:150px;">Address</span>
                            </div>
                            <input id="addr" type="text" class="form-control" placeholder="Address" aria-label="Addr" aria-describedby="ao-addr">
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
                                <span class="input-group-text" id="ao-phone" style="width:150px;">Phone No</span>
                            </div>
                            <input id="phone" type="text" class="form-control" placeholder="Phone Number" aria-label="PhoneNo" aria-describedby="ao-phone">
                        </div>
                    </div>
                    <div class="tab-pane" id="emp" role="tabpanel" aria-labelledby="emp-tab">
                        <div class="input-group mb-1 mt-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="ao-dept" style="width:150px;">Department</span>
                            </div>
                            <select class="custom-select" id="seldept">
                                <option value="0" selected>Choose a Department</option>
                            </select>
                        </div>
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="ao-isexec" style="width:150px;">Manager/Lead</span>
                            </div>
                            <select class="custom-select" id="selisexec">
                                <option value="0" selected>No</option>
                                <option value="1" selected>Yes</option>
                            </select>
                        </div>
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="ao-jobpost" style="width:150px;">Job Position</span>
                            </div>
                            <input id="jobpost" type="text" class="form-control" placeholder="Job Position" aria-label="JobPost" aria-describedby="ao-jobpost">
                        </div>
                        <!-- <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="ao-hrrate" style="width:150px;">Rate per Hour</span>
                            </div>
                            <input id="hrrate" type="text" class="form-control" value="0" placeholder="0.00" aria-label="HourRate" aria-describedby="ao-hrrate">
                        </div> -->
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="ao-shift" style="width:150px;">Work Shift</span>
                            </div>
                            <select class="custom-select" id="selshift">
                                <option value="0" selected>Choose a Work Shift</option>
                            </select>
                        </div>
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="ao-dthired" style="width:150px;">Date Hired</span>
                            </div>
                            <input id="dthired" type="text" class="form-control" placeholder="Date Hired" aria-label="DateHired" aria-describedby="ao-dthired">
                        </div>
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="ao-dthired" style="width:150px;">Date Left</span>
                            </div>
                            <input id="dtleft" type="text" class="form-control" placeholder="Date Left" aria-label="DateLeft" aria-describedby="ao-dtleft">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" name="cancelEmp" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" name="saveEmp" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal Notification-->
    <div class="modal fade" id="modEmpNotify" tabindex="-1" role="dialog" aria-labelledby="modEmpNotifyTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modNotifyEmpTitle">[Title]</h5>
            </div>
            <div class="modal-body" id="modEmpNotifyBody">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
