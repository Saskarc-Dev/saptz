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
                                    Work Groups (Active)
                                </div>
                                <div class="card-body">
                                    <article class="container-fluid">
                                        <div class="row">
                                            <div class="col">
                                                <a href="#" name="btnNewGrp" class="btn btn-primary mb-2 mr-2" data-toggle="modal" data-target="#modGroup">New Group/Team</a>
                                                <a href="#" name="btnApprover" class="btn btn-secondary mb-2" data-toggle="modal" data-target="#modApprover">Set Approvers</a>
                                            </div>
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="ao-search">Find</span>
                                                    </div>
                                                    <input name="findGroup" type="text" class="form-control mr-1" placeholder="Search" aria-label="Search" aria-describedby="ao-search">
                                                    <button name="cancelFindGrp" class="btn btn-outline-secondary" type="button">Clear</i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </article> 
                                    <div class="container-fluid" style="display:block; position: relative; height: 600px; overflow: auto;"> 
                                        <table class="table table-sm" style="font-size:14px;">
                                            <thead>
                                                <tr class="bg-secondary fa-inverse text-align-middle" style="height: 35px;">
                                                    <td style="width:20%;"></td>
                                                    <td style="width:15%;">Code</td>
                                                    <td style="width:40%;">Name/Description</td>
                                                    <td style="width:25%;">Lead/Manager</td>
                                                </tr>
                                            </thead>
                                            <tbody id="tGroups">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div id="grpCount">Total Group Count : 0</div>
                                </div>
                            </div>
                        </article>
                        <article class="col-4">
                            <div class="card">
                                <div class="card-header">
                                    Group Members
                                </div>
                                <div class="card-body">
                                    <article class="container-fluid mb-2">
                                        <a href="#" name="btnNewMember" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modGroupMember"><i class="fas fa-user-plus"></i></i>&nbsp;Add a Member</a>
                                    </article>
                                    <div class="container-fluid" style="display:block; position: relative; height: 600px; overflow: auto;">       
                                        <table class="table table-sm" style="font-size: 14px;">
                                            <thead>
                                                <tr class="bg-secondary fa-inverse text-align-middle" style="height: 35px;">
                                                    <td style="width:7%;"></td>
                                                    <td>Member</td>
                                                </tr>
                                            </thead>
                                            <tbody id="tMembers">
                                                <tr><td colspan="2" align="center"> - No data available -</td></tr>
                                            </tbody>
                                        </table>
                                    </div>                       
                                </div>
                                <div class="card-footer">
                                    <div id="memCount"> Member Count : 0</div>
                                </div>
                            </div>
                        </article>
                    </article>
                </article>
            </div>


        </div>
    </div>

    <!-- Modal Confirmation (Workgroup)-->
    <div class="modal fade" id="modGroup" tabindex="-1" role="dialog" aria-labelledby="modGroupTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modGroupTitle">[Title]</h5>
            </div>
            <div class="modal-body">
                <input type="text" id="grpid" style="visibility: hidden;" value="0">
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-grpcode" style="width:150px;">Code</span>
                    </div>
                    <input id="grpcode" type="text" class="form-control" placeholder="Workgroup Code" aria-label="GrpCode" aria-describedby="ao-grpcode">
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="ao-depdesc" style="width:150px;">Description</span>
                    </div>
                    <input id="grpdesc" type="text" class="form-control" placeholder="Description" aria-label="GrpDescr" aria-describedby="ao-grpdesc">
                </div>
                <!-- <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="grplead" style="width:150px;">Lead/Manager</label>
                    </div>
                    <select class="custom-select" id="grplead">
                    </select>
                </div> -->
            </div>
            <div class="modal-footer">
                <button name="grpcancel" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button name="grpsave" type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmation (Workgroup-Members link)-->
    <div class="modal fade" id="modGroupMember" tabindex="-1" role="dialog" aria-labelledby="modGroupMemberTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modGroupMemberTitle">[Title]</h5>
            </div>
            <div class="modal-body">
                <input type="text" id="memid" style="visibility: hidden;" value="0">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="workgroup" style="width:150px;">Workgroup</label>
                    </div>
                    <select class="custom-select" id="workgroup">
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
            <div class="modal-footer">
                <button name="membercancel" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button name="membersave" type="button" class="btn btn-primary">Add as Member</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal for assigning approvers -->
    <div class="modal fade" id="modApprover" tabindex="-1" role="dialog" aria-labelledby="modApproverTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modApproverTitle">Setup Approver</h5>
            </div>
            <div class="modal-body">
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1" style="width: 150px;">Select Approver</span>
                    </div>
                    <select class="custom-select" id="appEid"></select>
                </div>
                <div class="input-group mb-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1" style="width: 150px;">Priority Level</span>
                    </div>
                    <select class="custom-select" id="appPriority">
                        <option value="0" selected>First Approver</option>
                        <option value="1">Last Approver</option>
                        <option value="2">First/Last Approver</option>
                    </select>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1" style="width: 150px;">Org Approver</span>
                    </div>
                    <select class="custom-select" id="appOrgApp">
                        <option value="0" selected> No </option>
                        <option value="1"> Yes </option>
                    </select>
                </div>
                <div class="card">
                    <div class="card-header"> Registered Approvers</div>
                    <div class="card-body" style="min-height:300px; max-height:300px; overflow-y: scroll;">
                        <div class="list-group" name="lstApprovers">
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-1"><i class="fas fa-trash-alt text-danger"></i></div>
                                    <div class="col">John Doe</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" name="addApprover">Add Approver</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal Notification-->
    <div class="modal fade" id="modGrpNotify" tabindex="-1" role="dialog" aria-labelledby="modGrpNotifyTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modGrpNotifyTitle">[Title]</h5>
            </div>
            <div class="modal-body" id="modGrpMsg">
                [Message]
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
