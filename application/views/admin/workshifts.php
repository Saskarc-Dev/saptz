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
    <div id="content-wrapper">
        <div class="container-fluid">
            <article class="container-fluid" style="norder">
                <article class="row mb-3">
                    <article class="col">
                        <div class="card">
                            <div class="card-header">
                                Work Shifts (Active)
                            </div>
                            <div class="card-body">
                                <article class="container-fluid" style="display:block; position: relative; height: 600px; overflow: auto;">
                                    <a href="#" class="btn btn-primary mb-2" name="newShift" data-toggle="modal" data-target="#modShifts"><i class="far fa-plus-square"></i> &nbsp;New Work Shift</a>
                                    <table class="table table-sm" style="font-size:12px;">
                                        <thead>
                                            <tr class="bg-secondary fa-inverse text-align-middle" style="height: 35px;">
                                                <td style="width:10%; vertical-align: middle;" rowspan="2"></td>
                                                <td style="width:10%; vertical-align: middle;" rowspan="2">Code</td>
                                                <td style="width:15%; vertical-align: middle;" rowspan="2">Description</td>
                                                <td style="width:25%; text-align: center; vertical-align: middle;" colspan="4">Shift Setup</td>
                                                <td style="width:25%; text-align: center; vertical-align: middle;" colspan="7">Shift Schedule</td>
                                                <td style="width:15%; text-align: center; vertical-align: middle;" colspan="3">Breaks Setup</td>
                                            </tr>
                                            <tr class="bg-secondary fa-inverse text-align-middle" style="height: 35px;">
                                                <td class="border-left" style="text-align: center; vertical-align: middle;">Time Start</td>
                                                <td style="text-align: center; vertical-align: middle;">Time End</td>
                                                <td style="text-align: center; vertical-align: middle;">Work Hrs/Wk</td>
                                                <td class="border-right" style="text-align: center; vertical-align: middle;">Work Hrs/Day</td>

                                                <td style="text-align: center; vertical-align: middle;">Mon</td>
                                                <td style="text-align: center; vertical-align: middle;">Tue</td>
                                                <td style="text-align: center; vertical-align: middle;">Wed</td>
                                                <td style="text-align: center; vertical-align: middle;">Thu</td>
                                                <td style="text-align: center; vertical-align: middle;">Fri</td>
                                                <td style="text-align: center; vertical-align: middle;">Sat</td>
                                                <td class="border-right" style="text-align: center; vertical-align: middle;">Sun</td>

                                                <td style="text-align: center; vertical-align: middle;">Lunch</td>
                                                <td style="text-align: center; vertical-align: middle;">CB 1</td>
                                                <td style="text-align: center; vertical-align: middle;">CB 2</td>
                                            </tr>
                                        </thead>
                                        <tbody id="tShifts">
                                            <!-- <tr><td colspan="4" align="center"> - No data available -</td></tr> -->
                                        </tbody>
                                    </table>
                                </article> 
                            </div>
                            <div class="card-footer">
                                <div name="shiftCnt">Total Registered Shifts : 0</div>
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

<!-- Modal Confirmation (Shifts)-->
<div class="modal fade" id="modShifts" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modShiftTitle">[Title]</h5>
        </div>
        <div class="modal-body">
            <input type="text" id="shiftid" style="visibility: hidden;" value="0">
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-shiftcode" style="width:150px;">Code</span>
                </div>
                <input id="shiftcode" type="text" class="form-control" placeholder="Shift Code" aria-label="ShiftCode" aria-describedby="ao-shiftcode">
            </div>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-shiftdesc" style="width:150px;">Description</span>
                </div>
                <input id="shiftdesc" type="text" class="form-control" placeholder="Description" aria-label="ShiftDescr" aria-describedby="ao-shiftdesc">
            </div>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <div class="input-group-text" style="width:150px;">
                        <span id="ao-shifttype">Shift Type</span>
                    </div>
                </div>
                <select class="custom-select" id="selShiftType">
                    <option value="0" selected>Choose Shift Type</option>
                    <option value="1">Time Based</option>
                    <option value="2">Flexible (Day)</option>
                    <option value="3">Flexible (Week)</option>
                </select>
            </div>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <div class="input-group-text" style="width:150px;">
                        <span id="ao-shifttype">Shift Schedule</span>
                    </div>
                </div>
                <select class="custom-select mr-1" id="selTimeFrom">
                    <option value="0" selected>Choose Start Time</option>
                    <option value="01:00:00.0000000">1:00 AM</option>
                    <option value="01:30:00.0000000">1:30 AM</option>
                    <option value="02:00:00.0000000">2:00 AM</option>
                    <option value="02:30:00.0000000">2:30 AM</option>
                    <option value="03:00:00.0000000">3:00 AM</option>
                    <option value="03:30:00.0000000">3:30 AM</option>
                    <option value="04:00:00.0000000">4:00 AM</option>
                    <option value="04:30:00.0000000">4:30 AM</option>
                    <option value="05:00:00.0000000">5:00 AM</option>
                    <option value="05:30:00.0000000">5:30 AM</option>
                    <option value="06:00:00.0000000">6:00 AM</option>
                    <option value="06:30:00.0000000">6:30 AM</option>
                    <option value="07:00:00.0000000">7:00 AM</option>
                    <option value="07:30:00.0000000">7:30 AM</option>
                    <option value="08:00:00.0000000">8:00 AM</option>
                    <option value="08:30:00.0000000">8:30 AM</option>
                    <option value="09:00:00.0000000">9:00 AM</option>
                    <option value="09:30:00.0000000">9:30 AM</option>
                    <option value="10:00:00.0000000">10:00 AM</option>
                    <option value="10:30:00.0000000">10:30 AM</option>
                    <option value="11:00:00.0000000">11:00 AM</option>
                    <option value="11:30:00.0000000">11:30 AM</option>
                    <option value="12:00:00.0000000">12:00 NN</option>
                    <option value="12:30:00.0000000">12:30 PM</option>
                    <option value="13:00:00.0000000">1:00 PM</option>
                    <option value="13:30:00.0000000">1:30 PM</option>
                    <option value="14:00:00.0000000">2:00 PM</option>
                    <option value="14:30:00.0000000">2:30 PM</option>
                    <option value="15:00:00.0000000">3:00 PM</option>
                    <option value="15:30:00.0000000">3:30 PM</option>
                    <option value="16:00:00.0000000">4:00 PM</option>
                    <option value="16:30:00.0000000">4:30 PM</option>
                    <option value="17:00:00.0000000">5:00 PM</option>
                    <option value="17:30:00.0000000">5:30 PM</option>
                    <option value="18:00:00.0000000">6:00 PM</option>
                    <option value="18:30:00.0000000">6:30 PM</option>
                    <option value="19:00:00.0000000">7:00 PM</option>
                    <option value="19:30:00.0000000">7:30 PM</option>
                    <option value="20:00:00.0000000">8:00 PM</option>
                    <option value="20:30:00.0000000">8:30 PM</option>
                    <option value="21:00:00.0000000">9:00 PM</option>
                    <option value="21:30:00.0000000">9:30 PM</option>
                    <option value="22:00:00.0000000">10:00 PM</option>
                    <option value="22:30:00.0000000">10:30 PM</option>
                    <option value="23:00:00.0000000">11:00 PM</option>
                    <option value="23:30:00.0000000">11:30 PM</option>
                    <option value="00:00:00.0000000">12:00 MN</option>
                    <option value="00:30:00.0000000">12:30 AM</option>
                </select>
                <select class="custom-select" id="selTimeTo">
                    <option value="0" selected>Choose End Time</option>
                    <option value="01:00:00.0000000">1:00 AM</option>
                    <option value="01:30:00.0000000">1:30 AM</option>
                    <option value="02:00:00.0000000">2:00 AM</option>
                    <option value="02:30:00.0000000">2:30 AM</option>
                    <option value="03:00:00.0000000">3:00 AM</option>
                    <option value="03:30:00.0000000">3:30 AM</option>
                    <option value="04:00:00.0000000">4:00 AM</option>
                    <option value="04:30:00.0000000">4:30 AM</option>
                    <option value="05:00:00.0000000">5:00 AM</option>
                    <option value="05:30:00.0000000">5:30 AM</option>
                    <option value="06:00:00.0000000">6:00 AM</option>
                    <option value="06:30:00.0000000">6:30 AM</option>
                    <option value="07:00:00.0000000">7:00 AM</option>
                    <option value="07:30:00.0000000">7:30 AM</option>
                    <option value="08:00:00.0000000">8:00 AM</option>
                    <option value="08:30:00.0000000">8:30 AM</option>
                    <option value="09:00:00.0000000">9:00 AM</option>
                    <option value="09:30:00.0000000">9:30 AM</option>
                    <option value="10:00:00.0000000">10:00 AM</option>
                    <option value="10:30:00.0000000">10:30 AM</option>
                    <option value="11:00:00.0000000">11:00 AM</option>
                    <option value="11:30:00.0000000">11:30 AM</option>
                    <option value="12:00:00.0000000">12:00 NN</option>
                    <option value="12:30:00.0000000">12:30 PM</option>
                    <option value="13:00:00.0000000">1:00 PM</option>
                    <option value="13:30:00.0000000">1:30 PM</option>
                    <option value="14:00:00.0000000">2:00 PM</option>
                    <option value="14:30:00.0000000">2:30 PM</option>
                    <option value="15:00:00.0000000">3:00 PM</option>
                    <option value="15:30:00.0000000">3:30 PM</option>
                    <option value="16:00:00.0000000">4:00 PM</option>
                    <option value="16:30:00.0000000">4:30 PM</option>
                    <option value="17:00:00.0000000">5:00 PM</option>
                    <option value="17:30:00.0000000">5:30 PM</option>
                    <option value="18:00:00.0000000">6:00 PM</option>
                    <option value="18:30:00.0000000">6:30 PM</option>
                    <option value="19:00:00.0000000">7:00 PM</option>
                    <option value="19:30:00.0000000">7:30 PM</option>
                    <option value="20:00:00.0000000">8:00 PM</option>
                    <option value="20:30:00.0000000">8:30 PM</option>
                    <option value="21:00:00.0000000">9:00 PM</option>
                    <option value="21:30:00.0000000">9:30 PM</option>
                    <option value="22:00:00.0000000">10:00 PM</option>
                    <option value="22:30:00.0000000">10:30 PM</option>
                    <option value="23:00:00.0000000">11:00 PM</option>
                    <option value="23:30:00.0000000">11:30 PM</option>
                    <option value="00:00:00.0000000">12:00 MN</option>
                    <option value="00:30:00.0000000">12:30 AM</option>
                </select>
            </div>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-shiftdesc" style="width:150px;">Work Hours</span>
                </div>
                <input id="workhrs" type="text" class="form-control col-2 text-md-right" placeholder="0" aria-label="WorkHours" aria-describedby="ao-workhours">
            </div>
            <h6 class="dropdown-header">Shift Schedule</h6>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-mon" style="width:150px;">Monday</span>
                </div>
                <select class="custom-select" id="selmon">
                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-tues" style="width:150px;">Tuesday</span>
                </div>
                <select class="custom-select" id="seltues">
                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-wed" style="width:150px;">Wednesday</span>
                </div>
                <select class="custom-select" id="selwed">
                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-thu" style="width:150px;">Thursday</span>
                </div>
                <select class="custom-select" id="selthu">
                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-fri" style="width:150px;">Friday</span>
                </div>
                <select class="custom-select" id="selfri">
                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-sat" style="width:150px;">Saturday</span>
                </div>
                <select class="custom-select" id="selsat">
                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-sun" style="width:150px;">Sunday</span>
                </div>
                <select class="custom-select" id="selsun">
                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            <h6 class="dropdown-header">Breaks Setup</h6>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-sun" style="width:150px;">Lunch Break</span>
                </div>
                <select class="custom-select" id="sellb">
                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>
                </select>
                <input id="lb" type="text" class="form-control" value="60" placeholder="Break in Minutes" aria-label="Lunch Break" aria-describedby="ao-lb">
            </div>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-sun" style="width:150px;">Coffee Break 1</span>
                </div>
                <select class="custom-select" id="selcb1">
                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>
                </select>
                <input id="cb1" type="text" class="form-control" value="0" placeholder="Break in Minutes" aria-label="Coffee Break 1" aria-describedby="ao-cb1">
            </div>
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="ao-sun" style="width:150px;">Coffee Break 2</span>
                </div>
                <select class="custom-select" id="selcb2">
                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>
                </select>
                <input id="cb2" type="text" class="form-control" value="0" placeholder="Break in Minutes" aria-label="Coffee Break 2" aria-describedby="ao-cb2">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" name="cancelShift" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" name="saveShift" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
</div>

<!-- Modal Notification-->
<div class="modal fade" id="modShiftNotify" tabindex="-1" role="dialog" aria-labelledby="modNotifyTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modNotifyShiftTitle">[Title]</h5>
        </div>
        <div class="modal-body" id="modShiftNotifyBody">
            ...
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>
