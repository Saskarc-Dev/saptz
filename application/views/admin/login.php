<div class="container" style="margin-top: 15%; margin-bottom: 0;">
	<div class="login-container">
        <input type="hidden" value="0">
        <div class="avatar" style="background-image:url('../assets/img/SAPTZ.png');"></div>
        <div class="form-box">
            <input type="text" name="empid" placeholder="Employee Id">
            <input type="password" name="emppw" placeholder="Password">
            <button name="btnlogin" class="btn btn-info btn-block login" type="submit">Login</button>
        </div>
    </div>
</div>

<!-- Modal Notification-->
<div class="modal fade" id="modLogNotify" tabindex="-1" role="dialog" aria-labelledby="modLogNotifyTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modLogNotifyTitle">[Title]</h5>
        </div>
        <div class="modal-body" id="modLogNotifyBody">
            ...
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>