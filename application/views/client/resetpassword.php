<div class="container-fluid" style="margin-top: 15%; margin-bottom: 0;">
	<div class="login-container">
        <input type="hidden" value="0">
        <div class="avatar" style="background-image:url('../assets/img/SAPTZ.png');"></div>
        <div class="form-box">
            <input name="opwd" class="mb-1 mt-2" type="password" placeholder="Old Password">
            <input name="npwd" class="mb-1" type="password" placeholder="New Password">
            <input name="cpwd" class="mb-1" type="password" placeholder="Re-Type Password">
            <button name="resetpwd" class="btn btn-info btn-block login" type="submit">Change Password</button>
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
            <button name="closeModal" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>