$(function(){
    var modLogN = $('#modLogNotify'), modLogNTitle = $('#modLogNotifyTitle', modLogNBody = $('#modLogNotifyBody'));
    var empId = $('[name="empid"]'), empPw = $('[name="emppw"]');
    var btnLogin = $('[name="btnlogin"]');

    // Login
    $(document).on("click", "[name='btnlogin']", function(e){
        e.preventDefault();

        if(empId.val().length === 0){
            modLogNTitle.empty().append('Error Logging In');
            modLogNBody.empty().append(getCustomMsgBody(0, "Please supply a valid login credentials to be able to use the system."));
            modLogN.modal('show');
            return;
        }

        if(empPw.val().length === 0){
            modLogNTitle.empty().append('Error Logging In');
            modLogNBody.empty().append(getCustomMsgBody(0, "Password cannot be empty. Please enter your password then try again."));
            modLogN.modal('show');
            return;
        }
        //console.log(empId.val() + '\n' + empPw.val());
        validateUser(empId.val(), empPw.val());
    });

    $(document).on("click", "[name='logout']", function(){
        $.ajax({
            url     : '/admin/logout',
            method  : 'POST',
            success : function(){
                console.log('Logged out');
                window.location.href = '/admin';
            },
            error   : function(jqXHR, textStatus, errorThrown){
                alert(errorThrown);
            }
        });
    });

    $(document).on("keydown", "[name='empid']", function(e){
        if(e.which === 13){
            btnLogin.trigger("click");
        }
    });

    $(document).on("keydown", "[name='emppw']", function(e){
        if(e.which === 13){
            btnLogin.trigger("click");
        }
    });

    function validateUser(lid, pwd){
        $.ajax({
            url: "/admin/login",
            data: {"data": {"lid": lid, "pwd": pwd}},
            method: "POST",
            success: function(res){
                var itm = JSON.parse(res);

                if(itm.flag === false){
                    modLogNTitle.empty().append('Error Logging In');
                    modLogNBody.empty().append(getCustomMsgBody(0, itm["message"]));
                    modLogN.modal('show');
                    return; 
                } else {
                    if(itm.sys === 1){
                        window.location.location = "/admin";
                        window.location.reload();
                    } else {
                        modLogNTitle.empty().append('Insufficient Access');
                        modLogNBody.empty().append(getCustomMsgBody(0, 'You have no access to use the system. Kindly coordinate with the system administrator to grant your account access.'));
                        modLogN.modal('show');
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
                alert(errorThrown);
            }

        })
    }

    $('[data-toggle="tooltip"]').tooltip();

    // Department
    var tblDept = $('#tDepts');
    var deptCtr = $('#deptCount');
    var tblDWC = $('#tDWC');
    var DWCCtr = $('#DWCCount');
    var deptId = $('#deptid');
    var deptCode = $('#deptcode');
    var deptDesc = $('#deptdesc');
    var selLeads = $('#deptleads');
    var selId = 0;

    $(document).on("keyup", "[name='findDept']", function(){
        var value = $(this).val().toLowerCase();
        $("#tDepts > tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $(document).on("keyup", "[name='findDWC']", function(){
        var value = $(this).val().toLowerCase();
        $("[name='dwclist'] > .list-group-item").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $(document).on("click", "[name='moddept']", function(){
        loadDeptInfo($(this).prop('id'));
    });

    $(document).on("click", "[name='deldept']", function(){
        if(confirm("Are you sure you want to remove department? Click Ok to confirm.") === true){
            selId = $(this).prop('id');
            if(tblDept.length > 0){
                $.ajax({
                    url: '/admin/regdepartment',
                    method: 'POST',
                    data: {"data": {"did": selId, "dcode": '', "dname" : '', "leadid" : 0, "dtype" : 0}},
                    success: function(res){
                        var itm = JSON.parse(res);
                        var html = '';

                        if(itm.length > 0){
                            $('#modNotifyTitle').empty().append('Delete Success');
                            $('#notifymsg').empty().append(getCustomMsgBody(itm[0]['flag'], itm[0]['msg']));
                            $('#modNotify').modal('show');
                        } else {
                            $('#modNotifyTitle').empty().append('Delete Success');
                            $('#notifymsg').empty().append(getCustomMsgBody(0, "Problem occurred while deleting department profile. Please contact your system administrator."));
                            $('#modNotify').modal('show');
                        }
                    },
                    error: function(){
                        console.log('failed');
                    }
                });
                loadDepartments();
            }            
        }
    });

    $(document).on("click", "[name='lnkwc']", function(){
        loadDeptWorkcenters($(this).prop('id'));
    });

    $(document).on("click", "[name='cancel']", function(){
        deptId.val('0')
        deptCode.val('');
        deptDesc.val('');
        selLeads.val('0');
    });

    $(document).on("click", "[name='save']", function(){
        var html = '';
        var saveOk = 0;

        if(deptCode.val().length == 0 || deptDesc.val().length == 0 || selLeads.val() == 0){
            saveOk = 0
        } else {
            saveOk = 1;
        }

        if(saveOk == 0){
            if(deptCode.val().length == 0){
                $('#modNotifyTitle').empty().append('Add/Update Failed');
                $('#notifymsg').empty().append(getCustomMsgBody(0, "Please enter a valid alphanumeric code for the Department."));
                $('#modNotify').modal('show');

            } else if(deptDesc.val().length == 0){
                $('#modNotifyTitle').empty().append('Add/Update Failed');
                $('#notifymsg').empty().append(getCustomMsgBody(0, "Please give the Department a valid name."));
                $('#modNotify').modal('show');
   
            } else if(selLeads.val() == 0){
                $('#modNotifyTitle').empty().append('Add/Update Failed');
                $('#notifymsg').empty().append(getCustomMsgBody(0, "Please select a team lead/manager for the Department."));
                $('#modNotify').modal('show');
   
            } else {
                html = 'unhandled result';
            }
        } else {
            i
            saveDepartment();
            loadDepartments();        
        }
    });

    $(document).on("click", "[name='bnotify']", function(){
        $('#modDelete').modal('dispose');
    });

    $(document).on("change", "[id='depts']", function(){
        loadDWCList($(this).val());
    });
    
    $(document).on("click", "[name='wccancel']", function(){
        $('#depts').val(0);
        $('#workcenters').empty();
    });

    $(document).on("click", "[name='wcsave']", function(){
        var selIds = [];

        if(confirm("Proceed in adding selected workcenters to department? Click Ok to confirm.") === true){
            $('[name="dwclist"] > .list-group-item > label > input:checkbox:checked').each(function(){
                selIds.push($(this).attr("id"));
            });

            if(selIds.length > 0){
                saveDeptWorkCenters(0, selIds);
                $('#depts').val(0);
                $('#workcenters').empty();
                loadDeptWorkcenters(0);
            } else {
                $('#modNotifyTitle').empty().append('Error : Department-Workcenter');
                $('#notifymsg').empty().append(getCustomMsgBody(0, "No Work center(s) have been selected. Please select at least 1 then try again."));
                $("#modNotify").modal('show');
            }            
        }
    });

    $(document).on("click", "[name='delwc']", function(){
        var selId = [];
        if(confirm("Are you sure you want to remove workcenter from department? Click Ok to confirm.") === true){
            selId.push($(this).prop('id'));
            saveDeptWorkCenters($(this).prop('id'));
            loadDeptWorkcenters(0);            
        }
    });

    function loadDepartments(){
        if(tblDept.length > 0){
            $.ajax({
                url: '/admin/loaddepartments',
                data: {"data" : 1},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        for(i = 0; i <= itm.length - 1; i++){
                            html += '<tr>' + 
                                        '<td align="center">' +
                                            '<a id="' + itm[i]['deptid'] + '" name="moddept" href="#" class="btn" data-toggle="modal" data-target="#modDept"><i class="far fa-edit" data-toggle="tooltip" data-placement="top" title="Modify Department"></i></a>' +
                                            '<a id="' + itm[i]['deptid'] + '" name="deldept" href="#" class="btn" data-toggle="modal" data-target="#modDelete"><i class="far fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Delete Department"></i></a>' +
                                            '<a id="' + itm[i]['deptid'] + '" name="lnkwc" href="#" class="btn"><i class="far fa-list-alt" data-toggle="tooltip" data-placement="top" title="View Linked Workcenters"></i></a>' +
                                        '</td>' +
                                        '<td style="vertical-align:middle;">' + itm[i]['code'] + '</td>' +
                                        '<td style="vertical-align:middle;">' + itm[i]['deptname'] + '</td>' +
                                        '<td style="vertical-align:middle;">' + itm[i]['deptlead'] + '</td>' +
                                    '</tr>';
                        }                        
                    } else {
                        html = '<tr><td colspan="4" align="center"> - No data available -</td></tr>';
                    }

                    tblDept.empty().append(html);
                    deptCtr.empty().append('Total Department Count : ' + itm.length); 
                    
                },
                error: function(){
                    console.log('failed');
                }
            });
        }
    }

    function loadDeptInfo(id){
        if(tblDept.length > 0){
            $.ajax({
                url: '/admin/loaddeptinfo',
                data: {"lt" : 2, "dept": id},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        deptId.val(itm[0]['id'])
                        deptCode.val(itm[0]['deptcode']);
                        deptDesc.val(itm[0]['deptname']);
                        selLeads.val(itm[0]['deptleadid']);
                        $('#modDeptTitle').empty().append('Update Department');
                    } else {
                        $('#notifymsg').empty().append('No data available');
                        $('#modNotify').modal.show();
                    }

                },
                error: function(){
                    console.log('failed');
                }
            });
        }        
    }

    function loadDeptLeads(){
        if(tblDept.length > 0){
            $.ajax({
                url: '/admin/loadleads',
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        html += '<option value="0" selected="selected">- Assign a Department Lead -</option>';

                        for(i = 0; i < itm.length; i++){
                            html += '<option value="' + itm[i]['empid'] + '">' + itm[i]['empnm'] + '</option>';
                        }
                    } else {
                        html += '<option value="0" selected="selected">- No options available -</option>';
                    }
                    selLeads.empty().append(html);
                },
                error: function(){
                    console.log('failed');
                }
            });
        }         
    }

    function loadDeptWorkcenters(id = 0){
        if(tblDWC.length > 0){
            $.ajax({
                url: '/admin/loaddeptworkcenters',
                data: {"data" : {"lt": 3, "dept" : id}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        for(i = 0; i <= itm.length - 1; i++){
                            html += '<tr>' +
                                        '<td align="center">' +
                                            '<a id="' + itm[i]['wcid'] + '" name="delwc" href="#" class="btn"><i id="' + itm[i]['wcid'] + '" name="delwc" class="far fa-trash-alt"></i></a>' +
                                        '</td>' +
                                        '<td style="vertical-align:middle;">' +
                                            itm[i]['wc']
                                        '</td>' +
                                    '</tr>';
                        }                        
                    } else {
                        html = '<tr><td colspan="2" align="center"> - No data available -</td></tr>';
                    }

                    tblDWC.empty().append(html);
                    DWCCtr.empty().append('Linked Workcenter(s) : ' + itm.length);
                    
                },
                error: function(){
                    console.log('failed');
                }
            });
        }
    }

    function saveDepartment(){
        if(tblDept.length > 0){
            $.ajax({
                url: '/admin/regdepartment',
                method: 'POST',
                data: {"data": {"did": deptId.val(), "dcode": deptCode.val(), "dname" : deptDesc.val(), "leadid" : selLeads.val(), "dtype" : 1}},
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';

                    if(itm.length > 0){
                        $('#modNotifyTitle').empty().append('Add/Update Failed');
                        $('#notifymsg').empty().append(getCustomMsgBody(itm[0]['flag'], itm[0]['msg']));
                        $('#modNotify').modal('show');
                    } else {
                        $('#modNotifyTitle').empty().append('Add/Update Failed');
                        $('#notifymsg').empty().append(getCustomMsgBody(0, "Operation failed, please contact your system administrator."));
                        $('#modNotify').modal('show');
                    }
                },
                error: function(){
                    console.log('failed');
                }
            });
            loadDepartments();
        }
    }
    
    function loadDeptToDropdown(){
        if(tblDept.length > 0){
            $.ajax({
                url: '/admin/loaddepartments',
                data: {"data" : 0},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        html += '<option value="0" selected="selected">- Select a Department -</option>';
                        for(i = 0; i <= itm.length - 1; i++){
                            html += '<option value="' + itm[i]['deptid'] + '">' + itm[i]['dept'] + '</option>';
                        }                        
                    } else {
                        html = '<option value="0" selected="selected">- No Available options -</option>';
                    }

                    $('#depts').empty().append(html);
                },
                error: function(){
                    console.log('failed');
                }
            });
        }
    }

    function loadDWCList(did = 0){
        if(tblDept.length > 0){
            $.ajax({
                url: '/admin/loaddrpworkcenters',
                data: {"data":{"lt": 3, "wcid": 0, "did": did}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(did > 0) {
                        if(itm.length > 0){
                            for(i = 0; i <= (itm.length -1); i++){
                                html += '<div class="list-group-item checkbox mb-1" style="height:50px;">' +
                                            '<label>' +
                                                '<input id="' + itm[i]['wcid'] + '" type="checkbox" class="mr-2"> ' + itm[i]['wc'] +
                                            '</label>' +
                                        '</div>';
                            }
                        } else {
                            html += '<div class="list-group-item mb-1">- Please select a department -</div>';
                        }
                    } else {
                        html += '<div class="list-group-item mb-1">- Please select a department -</div>';
                    }
                    
                    $('[name="dwclist"]').empty().append(html);
                },
                error: function(){
                    console.log('failed');
                }
            });
        }

    }

    function saveDeptWorkCenters(id = 0, wcids = []){
        var arrMsg = [];
        var toDelete = (id > 0) ? 0 : 1 ;

        if(tblDept.length > 0){
            if(id > 0) {
                $.ajax({
                    url: '/admin/regworkcentertodept',
                    data: {"data":{"id": id, "did": $('#depts').val(), "wcid": wcids[i] , "isactive": toDelete}},
                    method: 'POST',
                    success: function(res){
                        var itm = JSON.parse(res);

                        (itm[0]['flag'] === 0) ? $("#modNotifyTitle").empty().append('Error : Department Workcenter') : $("#modNotifyTitle").empty().append("Success : Department Workcenter");
                        $("#notifymsg").empty().append(getCustomMsgBody(itm[0]['flag'], itm[0]['msg']));
                        $("#modNotify").modal('show');

                    },
                    error: function(){
                        console.log('failed');
                    }
                });

            } 
            else {
                if(wcids.length > 0){
                    for(i=0; i <= (wcids.length -1); i++){
                        $.ajax({
                            url: '/admin/regworkcentertodept',
                            data: {"data":{"id": id, "did": $('#depts').val(), "wcid": wcids[i] , "isactive": toDelete}},
                            method: 'POST',
                            success: function(res){
                                var itm = JSON.parse(res);
                                arrMsg.push([itm[0]['flag'], itm[0]['msg']]);
                            },
                            error: function(){
                                console.log('failed');
                            }
                        });
                    }

                    var Ecnt = 0;
                    for(i=0; i <= (arrMsg.length - 1); i++){
                        (arrMsg[i][0] === 0) ? Ecnt += 1 : Ecnt = Ecnt;
                    }

                    if(Ecnt === 0) {
                        $("#modNotifyTitle").empty().append("Success : Department-Workcenter");
                        $("#notifymsg").empty().append(getCustomMsgBody(1, "Selected workcenter(s) have been linked to ["+ $('#depts option:selected').text() +"]"));
                        $("#modNotify").modal("show");
                    } else {
                        $("#modNotifyTitle").empty().append("Error : Department-Workcenter");
                        $("#notifymsg").empty().append(getCustomMsgBody(0, "Selected ["+ Ecnt +"] workcenter(s) failed to linked to ["+ $('#depts option:selected').text() +"]"));
                        $("#modNotify").modal("show");
                    }
    
                } else {                        
                    $("#modNotifyTitle").empty().append("Error : Department-Workcenter");
                    $("#notifymsg").empty().appent(getCustomMsgBody(0, "There is a problem in linking Workcenter to department. Please check then try again."));
                    $("#modNotify").modal("show");
                }
            }

            loadDeptWorkcenters();
            $("[name='dwclist']").empty();
        }
    }

    // End Department

    // Workgroups and Members

    var tblWG = $('#tGroups');
    var tblWM = $('#tMembers');
    var grpCtr = $('#grpCount');
    var memCtr = $('#memCount');
    var grpId = $('#grpid');
    var memId = $('#memid');
    var grpCode = $('#grpcode');
    var grpName = $('#grpdesc');
    var drpGrpLead = $('#grplead');
    var drpWG = $('#workgroup');
    var drpEmp = $('#members');
    var msgGrpTitle = $('#modGrpNotifyTitle');
    var msgGrpMsg = $('#modGrpMsg');
    var msgObj = $('#modGrpNotify');
    var selGrp = 0;


    $(document).on("keyup", "[name='findGroup']", function(){
        var value = $(this).val().toLowerCase();
        $("#tGroups > tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $(document).on("click", "[name='cancelFindGrp']", function(){
        selGrp = 0;
        loadWorkGroups();
        loadWorkGroupMembers(0);
    });

    $(document).on("keyup", "[name='gmsearch']", function(){
        var value = $(this).val().toLowerCase();
        $("[name='gmslist'] > .list-group-item").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $(document).on("click", "[name='gmsfindcancel']", function(){
        $("[name='gmsearch']").val("");
    });

    $(document).on("click", "[name='gmsselall']", function(){
        if($(this).text() === 'Select All'){
            $("[name='gmslist'] > .list-group-item > label > input[type='checkbox']").each(function(){
                if($(this).prop("checked") === false){
                    $(this).prop("checked", true);
                }
            });
            $(this).text("De-select All");
        } else {
            $("[name='gmslist'] > .list-group-item > label > input[type='checkbox']").each(function(){
                if($(this).prop("checked") === true){
                    $(this).prop("checked", false);
                }
            });
            $(this).text("Select All");
        }
    });

    $(document).on("change","input[type='checkbox']", function(){
        var elCnt = $("[name='gmslist'] > .list-group-item > label > input[type='checkbox']").length;
        var chkCnt = $("[name='gmslist'] > .list-group-item > label > input[type='checkbox']:checked").length;
        
        if(elCnt === chkCnt){
            $("[name='gmsselall']").text("De-select All");
        } else {
            $("[name='gmsselall']").text("Select All");
        }
    });

    $(document).on("click", "[name='btnNewGrp']", function(){
        $('#modGroupTitle').empty().append('New Workgroup');
    });

    $(document).on("click", "[name='btnNewMember']", function(){
        $('#modGroupMemberTitle').empty().append('Add Member');
    });

    $(document).on("click", "[name='modgrp']", function(){
        $('#modGroupTitle').empty().append('Update Workgroup');
        loadWorkGroupInfo($( this ).prop('id'));
    });

    $(document).on("click", "[name='delgrp']", function(){
        if(confirm("Are you sure you want to remove this group information? Click Ok to confirm.") === true){
            grpId.val($(this).prop('id'));
            DeRegisterWorkgroup(0);
            grpId.val(0);            
        }
    });

    $(document).on("click", "[name='lnkmem']", function(){
        loadWorkGroupMembers($( this ).prop('id'));
        selGrp = parseInt($( this ).prop('id'));
    });

    $(document).on("click", "[name='grpsave']", function(){
        if(confirm("Proceed in Adding/Updating group information? Click Ok to confirm.") === true){
            DeRegisterWorkgroup(1);
        }
    });

    $(document).on("click", "[name='grpcancel']", function(){
        grpId.val('0');
        grpCode.val('');
        grpName.val('');
        drpGrpLead.val(0);
    });

    $(document).on("click", "[name='membersave']", function(){
        if(confirm("Proceed in adding selected members to chosen group?") === true){
            //DeRegisterWGMember(0, 1);
            addMembersToWG();            
        }
    });

    $(document).on("click", "[name='delmem']", function(){
        if(confirm("Are you sure you want to remove member to group?") === true){
            DeRegisterWGMember($( this ).prop('id'), 0);    
        }
    });

    $(document).on("click", "[name='addApprover']", function(){
        if(confirm("Proceed adding selected employee as approver? Click Ok to confirm.") === true){
            DeRegisterApprovers();
        }
    });

    $(document).on("click", "[name='delApprover']", function(){
        if(confirm("Are you sure you want to remove the selected employee from the approver list? Click Ok to confirm.") ===  true){
            DeRegisterApprovers($(this).attr("id"));
        }
    });

    function loadWorkGroups(){
        if(tblWG.length > 0){
            $.ajax({
                url: '/admin/loadworkgroup',
                data: {"data" : {"lt" : 1, "gid" : 0}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        for(i = 0; i <= itm.length - 1; i++){
                            html += '<tr>' + 
                                        '<td align="center">' +
                                            '<a id="' + itm[i]['grpid'] + '" name="modgrp" href="#" class="btn" data-toggle="modal" data-target="#modGroup"><i class="far fa-edit" data-toggle="tooltip" data-placement="top" title="Modify Workgroup"></i></a>' +
                                            '<a id="' + itm[i]['grpid'] + '" name="delgrp" href="#" class="btn" ><i class="far fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Delete Workgroup"></i></a>' +
                                            '<a id="' + itm[i]['grpid'] + '" name="lnkmem" href="#" class="btn"><i class="fas fa-users" data-toggle="tooltip" data-placement="top" title="View Group Members"></i></a>' +
                                        '</td>' +
                                        '<td style="vertical-align:middle;">' + itm[i]['code'] + '</td>' +
                                        '<td style="vertical-align:middle;">' + itm[i]['nm'] + '</td>' +
                                        '<td style="vertical-align:middle;">' + itm[i]['deptlead'] + '</td>' +
                                    '</tr>';
                        }                        
                    } else {
                        html = '<tr><td colspan="4" align="center"> - No data available -</td></tr>';
                    }

                    tblWG.empty().append(html);
                    grpCtr.empty().append('Total Workgroup Count : ' + itm.length); 
                    
                },
                error: function(){
                    console.log('failed');
                }
            });
        }        
    }

    function loadWorkGroupInfo(id = 0){
        if(tblWG.length > 0){
            $.ajax({
                url: '/admin/loadworkgroup',
                data: {"data" : {"lt" : 2, "gid" : id}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        grpId.val(itm[0]['id']);
                        grpCode.val(itm[0]['grpcode']);
                        grpName.val(itm[0]['grpname']);
                        drpGrpLead.val(itm[0]['id']);
                    } else {
                        html = '<div class="row">' +
                                        '<div class="col-3">' +
                                        '<i class="fas fa-exclamation-triangle fa-7x" style="color: #EC2A2A;"></i>' +
                                        '</div>' +
                                        '<div class="col">' +
                                            '<p class="mt-4">' +  itm[0]['msg'] + '</p>' +
                                        '</div>' +
                                    '</div>';
                            msgGrpTitle.empty().append('Add/Update Failed');
                            msgGrpMsg.empty().append(html);
                            msgObj.modal('show');
                    }
                },
                error: function(){
                    console.log('failed');
                }
            });
        }  
    }

    function loadWorkGroupMembers(workgroupId = 0){
        if(tblWM.length > 0){
            $.ajax({
                url: '/admin/loadworkgroup',
                data: {"data" : {"lt" : 3, "gid" : workgroupId}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        for(i = 0; i <= itm.length - 1; i++){
                            html += '<tr>' +
                                        '<td align="center">' +
                                            '<a id="' + itm[i]['memid'] + '" href="#" class="btn" name="delmem"><i class="far fa-trash-alt"></i></a>' +
                                        '</td>' +
                                        '<td style="vertical-align:middle;">' +
                                            itm[i]['empnm'] +
                                        '</td>' +
                                    '</tr>';
                        }                        
                    } else {
                        html = '<tr><td colspan="2" align="center"> - No data available -</td></tr>';
                    }

                    tblWM.empty().append(html);
                    memCtr.empty().append('Total Member Count : ' + itm.length); 
                    
                },
                error: function(){
                    console.log('failed');
                }
            });

            loadEmployeesToAddToWG();
        }
    }

    function loadWorkgrouptoDropdown(){
        if(tblWG.length > 0){
            $.ajax({
                url: '/admin/loadworkgroup',
                data: {"data" : {"lt" : 0, "gid" : 0}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        if(itm.length === 1){
                            html += '<option value="' + itm[0]['wgid'] + '" selected> ' + itm[0]['grp'] + ' </option>';
                        } else {
                            html += '<option value="0" selected> - Select a Workgroup - </option>';
                            for(i = 0; i <= itm.length - 1; i++){
                                html += '<option value="' + itm[i]['wgid'] + '"> ' + itm[i]['grp'] + ' </option>';
                            }                            
                        }
                        
                    } else {
                        html = '<option value="0"> - No available option - </option>';
                    }

                    drpWG.empty().append(html);
                    
                },
                error: function(){
                    console.log('failed');
                }
            });
        }          
    }

    function loadEmployeesToWGDropdown(){
        if(tblWG.length > 0){
            $.ajax({
                url: '/admin/loadleads',
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        html += '<option value="0"> - Select a Team Lead - </option>';
                        for(i = 0; i <= itm.length - 1; i++){
                            html += '<option value="' + itm[i]['empid'] + '"> ' + itm[i]['empnm'] + ' </option>';
                        }                        
                    } else {
                        html = '<option value="0"> - No available option - </option>';
                    }

                    drpGrpLead.empty().append(html);
                    
                },
                error: function(){
                    console.log('failed');
                }
            });
        }  
    }

    function loadEmployeesToAddToWG(){
        if(tblWG.length > 0){
            $.ajax({
                url: '/admin/loadwgemployees',
                data: {"data" : {"lt" : 4, "gid" : 0}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        for(i = 0; i <= itm.length - 1; i++){
                            html += '<div class="list-group-item checkbox mb-1">' +
                                        '<label>' +
                                            '<input id="' + itm[i]['empid'] + '" type="checkbox" class="mr-2"> ' + itm[i]['empnm'] +
                                        '</label>' +
                                    '</div>';
                        }                        
                    } else {
                        html += '<div class="list-group-item mb-1">' +
                                    '<label>No available members to add to work group.</label>' +
                                '</div>';
                    }

                    $("[name='gmslist']").empty().append(html);
                    
                },
                error: function(){
                    console.log('failed');
                }
            });
        }         
    }

    function DeRegisterWorkgroup(setToActive = 1){
        if(tblWM.length > 0){
            $.ajax({
                url: '/admin/regworkgroup',
                data: {"data" : {"gid" : grpId.val(), "gc" : grpCode.val(), "gn" : grpName.val(), "gl" : drpGrpLead.val(), "ia" : setToActive}},
                method: 'POST',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        msgGrpTitle.empty().append((itm[0]['flag'] === 0) ? 'Error : Workgroup' : 'Success : Workgroup');
                        msgGrpMsg.empty().append(getCustomMsgBody(itm[0]['flag'], itm[0]['msg']));
                        grpId.val(0);
                        grpCode.val('');
                        grpName.val('');
                        selLeads.val(0);

                        loadWorkGroups();
                        loadWorkgrouptoDropdown();
                     
                    } else {
                        msgGrpTitle.empty().append('Error : Workgroup');
                        msgGrpMsg.empty().append(getCustomMsgBody(0, 'Application did not get a response from the server. Please contact your system administrator.'));
                    }

                    msgObj.modal('show');
                    
                },
                error: function(){
                    console.log('failed');
                }
            });
        }
    }

    function addMembersToWG(){
        var elCnt = $("input[type='checkbox']").length;
        var chkCnt = $("input[type='checkbox']:not(:checked)").length;
        var selIds = [];
        
        
        if(drpWG.val() === 0){
            $("#modGrpNotifyTitle").empty().append("Error : Workgroup-Members");
            $("#modGrpMsg").empty().append(getCustomMsgBody(0, "Please select a valid work group from the dropdown list then try again."));
            $("#modGrpNotify").modal('show');
            return;
        }

        if(elCnt === chkCnt) {
            $("#modGrpNotifyTitle").empty().append("Error : Workgroup-Members");
            $("#modGrpMsg").empty().append(getCustomMsgBody(0, "Please select at least 1 (one) employee to be added as member to the selected workgroup then try again."));
            $("#modGrpNotify").modal('show');
            return;
        }

        $("input[type='checkbox']:checked").each(function(){
           selIds.push(parseInt($(this).prop("id"))); 
        });

        $.ajax({
            url: '/admin/regwgmember',
            data: {"data" : {"mid" : 0, "gid" : $("#workgroup").val(), "eid" : selIds , "ia" : 1}},
            method: 'POST',
            success: function(res){
                var itm = JSON.parse(res);
                var errCnt = 0;

                for(i=0; i <= (itm.length -1); i++){
                    if(itm[i]['result'][0]['flag'] === 0){
                        errCnt += 1;
                    }
                }

                if(errCnt > 0){
                    $("#modGrpNotifyTitle").empty().append("Error : Workgroup Members");
                    $("#modGrpMsg").empty().append(getCustomMsgBody(0, "Error occurred while adding [" + errCnt + "] members to group. Try again or contact your system administrator."));
                    $("#modGrpNotify").modal('show');
                } else {
                    $("#modGrpNotifyTitle").empty().append("Success : Workgroup Members");
                    $("#modGrpMsg").empty().append(getCustomMsgBody(1, "Successfully added members to the group."));
                    $("#modGrpNotify").modal('show');
                }

                drpEmp.val(0);
                loadEmployeesToAddToWG();
                loadWorkGroupMembers();

            },
            error: function(jqXHR, textStatus, errorThrown){
                alert(errorThrown);
            }
        });
    }

    function DeRegisterWGMember(id = 0, setToActive = 1){
        if(tblWM.length > 0){
            $.ajax({
                url: '/admin/regwgmember',
                data: {"data" : {"mid" : id, "gid" : drpWG.val(), "eid" : [0] , "ia" : 0}},
                method: 'POST',
                success: function(res){
                    var itm = JSON.parse(res);
        
                    msgGrpTitle.empty().append((itm[0]['result'][0]['flag'] === 0) ? "Error : Workgroup-Member" : "Success : Workgroup-Member");
                    msgGrpMsg.empty().append(getCustomMsgBody(itm[0]['result'][0]['flag'], itm[0]['result'][0]['msg']));
                    msgObj.modal('show');
                    drpEmp.val(0);
                    loadEmployeesToAddToWG();
                    loadWorkGroupMembers((selGrp > 0) ? selGrp : 0);
                    
                },
                error: function(jqXHR, textStatus, errorThrown){
                    alert(errorThrown + '\n' + textStatus);
                }
            });

            loadWorkGroups();
        }
    }

    function loadApprovers(){
        $.ajax({
            url     : '/admin/loadapprovers',
            method  : 'GET',
            success : function(res){
                var itm = JSON.parse(res);
                var html = '';

                for(i=0; i <= (itm.length - 1); i++) {
                    html += '<div class="list-group-item">' +
                                '<div class="row">' +
                                    '<div class="col-1"><a href="#" class="btn btn-sm active" role="button" id="'+ itm[i]['eid'] +'" name="delApprover"><i class="fas fa-trash-alt text-danger"></i></a></div>' +
                                    '<div class="col">'+ itm[i]['enm'] +'</div>' +
                                '</div>' +
                            '</div>';
                }

                $('[name="lstApprovers"]').empty().append(html);
            },
            error   : function(jqXHR, textStatus, errorThrown){
                alert(errorThrown);
            }
        });
    }

    function loadDeptApprovers(){
        $.ajax({
            url     : '/admin/loaddeptapprovers',
            method  : 'GET',
            success : function(res){
                var itm = JSON.parse(res);
                var html = '';

                html += '<option value="0" selected>- Select an Employee -</option>';
                for(i=0; i <= (itm.length - 1); i++) {
                    html += '<option value="'+ itm[i]['eid'] +'">'+ itm[i]['enm'] +'</option>';
                }

                $('#appEid').empty().append(html);
            },
            error   : function(jqXHR, textStatus, errorThrown){
                alert(errorThrown);
            }
        });
    }

    function DeRegisterApprovers(id = 0){
        $.ajax({
            url     : '/admin/deregapprover',
            data    : {'data' : {'id': id, 'eid' : $('#appEid').val(), 'pl' : $('#appPriority').val(), 'oa' : $('#appOrgApp').val()}},
            method  : 'POST',
            success : function(res) {
                var itm = JSON.parse(res);

                msgGrpTitle.empty().append("Success : Workgroup-Approver");
                if(id === 0) {
                    msgGrpMsg.empty().append(getCustomMsgBody(1, "Selected employee has been added as an approver."));
                } else {
                    msgGrpMsg.empty().append(getCustomMsgBody(1, "Approver has been removed."));
                }
                
                msgObj.modal('show');

            },
            error   : function(jqXHR, textStatus, errorThrown){
                alert(errorThrown + '\n' + textStatus);
            }
        });
        loadApprovers();
        loadDeptApprovers();
    }

    // End Workgroup and Members

    // Work Shifts

    var tblWS = $('#tShifts');
    var modWS = $('#modShifts');
    var modWSTitle = $('#modShiftTitle');
    var modWSNotify = $('#modShiftNotify');
    var modWSNotifyTitle = $('#modNotifyShiftTitle');
    var modWSNotifyBody = $('#modShiftNotifyBody');
    var shiftId = $('#shiftid');
    var shiftCode = $('#shiftcode');
    var shiftDesc = $('#shiftdesc');
    var shiftType = $('#selShiftType');
    var shiftTS = $('#selTimeFrom');
    var shiftTE = $('#selTimeTo');
    var shiftHrs = $('#workhrs');
    var shiftCnt = $('[name="shiftCnt"]');
    var mon = $('#selmon');
    var tue = $('#seltues');
    var wed = $('#selwed');
    var thu = $('#selthu');
    var fri = $('#selfri');
    var sat = $('#selsat');
    var sun = $('#selsun');
    var lb  = $('#lb');
    var sellb = $('#sellb');
    var cb1 = $('#cb1');
    var selcb1 = $('#selcb1');
    var cb2 = $('#cb2');
    var selcb2 = $('#selcb2');

    var btnShiftSave = $('[name="saveShift"]');

    var btnShiftCancel = $('[name="cancelShift"]');

    $(document).on("click", "[name='newShift']", function(){
        modWSTitle.empty().append('New Shift');
        shiftId.val("0");
        shiftCode.val("");
        shiftDesc.val("");
        shiftType.val(0);
        shiftTS.val(0);
        shiftTE.val(0);
        shiftHrs.val("");
        mon.val(0);
        tue.val(0);
        wed.val(0);
        thu.val(0);
        fri.val(0);
        sat.val(0);
        sun.val(0);
        cb1.val("");
        selcb1.val(0);
        cb2.val("");
        selcb2.val(0);
        lb.val("");
        sellb.val(1);
    });

    $(document).on("click", "[name='modifyShift']", function(){
        loadShiftInfo($(this).prop('id'));
    });

    $(document).on("click", "[name='deleteShift']", function(){
        if(confirm("Are you sure your want to remove this shift profile? Click Ok to confirm.") === true){
            shiftId.val($(this).prop('id'));
            DeRegisterShifts(0);            
        }
    });

    $(document).on("click", "[name='saveShift']", function(){
        if(shiftCode.val() === ""){
            modWSNotifyTitle.empty().append("Error [Shift Code]");
            modWSNotifyBody.empty().append(getCustomMsgBody(0, "[Shift Code] is a mandatory field. Please enter a valid (alphanumeric) value then try again."));
            modWSNotify.modal('show');
            shiftCode.focus();
            return;
        }

        if(shiftDesc.val() === ""){
            modWSNotifyTitle.empty().append("Error [Shift Description]");
            modWSNotifyBody.empty().append(getCustomMsgBody(0, "[Description] is a mandatory field. Please enter a valid value then try again."));
            modWSNotify.modal('show');
            shiftDesc.focus();
            return;
        }

        if(shiftType.val() === "0"){
            modWSNotifyTitle.empty().append("Error [Shift Type]");
            modWSNotifyBody.empty().append(getCustomMsgBody(0, "[Shift Type] is a mandatory field. Please enter a valid value from the available option(s) then try again."));
            modWSNotify.modal('show');
            shiftType.focus();
            return;
        }

        if(shiftType.val() === "1" && (shiftTS.val() === "0" || shiftTE.val() === "0")){
            modWSNotifyTitle.empty().append("Warning [Shift Start/End]");
            modWSNotifyBody.empty().append(getCustomMsgBody(1, "System loaded default values. Change values when necessary."));
            modWSNotify.modal('show');
            shiftTS.val("06:00:00.0000000");
            shiftTE.val("18:00:00.0000000");
            return;
        }

        if(shiftType.val() === "2" && (shiftTS.val() === "0" || shiftTE.val() === "0")){
            modWSNotifyTitle.empty().append("Warning [Shift Start/End]");
            modWSNotifyBody.empty().append(getCustomMsgBody(1, "System loaded default values. Change values when necessary."));
            modWSNotify.modal('show');
            shiftTS.val("06:00:00.0000000");
            shiftTE.val("18:00:00.0000000");
            return;            
        } 

        if(shiftType.val() === "3" && (shiftTS.val() === "0" || shiftTE.val() === "0")){
            modWSNotifyTitle.empty().append("Warning [Shift Start/End]");
            modWSNotifyBody.empty().append(getCustomMsgBody(1, "System loaded default values. Change values when necessary."));
            modWSNotify.modal('show');
            shiftTS.val("06:00:00.0000000");
            shiftTE.val("18:00:00.0000000");
            return;            
        }
        
        if(shiftHrs.val() === "" || shiftHrs.val() === "0"){
            modWSNotifyTitle.empty().append("Error [Shift Hours]");
            modWSNotifyBody.empty().append(getCustomMsgBody(0, "[Shift Hours] should not be empty or 0. Please enter a valid number then try again."));
            modWSNotify.modal('show');
            shiftHrs.focus();
            return;             
        } 

        if(isNaN(shiftHrs.val()) === true){
            modWSNotifyTitle.empty().append("Error [Shift Hours]");
            modWSNotifyBody.empty().append(getCustomMsgBody(0, "The system is expecting a number when [" + shiftHrs.val() + "] is supplied. Please enter a valid value then try again."));
            modWSNotify.modal('show');
            shiftHrs.val("").focus();
            return; 
        }

        if(mon.val() === "0" && tue.val() === "0" && wed.val() === "0" && thu.val() === "0" && fri.val() === "0" && sat.val() === "0" && sun.val() === "0"){
            if(shiftType.val() === "1"){
                modWSNotifyTitle.empty().append("Error [Shift Schedule]");
                modWSNotifyBody.empty().append(getCustomMsgBody(0, "Please enable at least 1 day for the week's schedule. Please try again."));
                modWSNotify.modal('show');
                mon.focus();
                return;                  
            } 
            else {
                modWSNotifyTitle.empty().append("Error [Shift Schedule]");
                modWSNotifyBody.empty().append(getCustomMsgBody(0, "Please enable at least 2 or more days for the week's schedule. Please try again."));
                modWSNotify.modal('show');
                mon.focus();
                return;                   
            }
        }

        if(sellb.val() === "1" && (lb.val() === "" || lb.val() === "0" || isNaN(lb.val()) === true)) {
            modWSNotifyTitle.empty().append("Error [Breaks Setup]");
            modWSNotifyBody.empty().append(getCustomMsgBody(0, "[Lunch Break] once enabled must supply a valid value for its duration in minutes. Please enter a valid value then try again."));
            modWSNotify.modal('show');
            lb.val("0").focus();
            return;  
        }

        if(selcb1.val() === "1" && (cb1.val() === "" || cb1.val() === "0" || isNaN(cb1.val()) === true)) {
            modWSNotifyTitle.empty().append("Error [Breaks Setup]");
            modWSNotifyBody.empty().append(getCustomMsgBody(0, "[Coffee Break 1] once enabled must supply a valid value for its duration in minutes. Please enter a valid value then try again."));
            modWSNotify.modal('show');
            cb1.val("0").focus();
            return;  
        }

        if(selcb2.val() === "1" && (cb2.val() === "" || cb2.val() === "0" || isNaN(cb2.val()) === true)) {
            modWSNotifyTitle.empty().append("Error [Breaks Setup]");
            modWSNotifyBody.empty().append(getCustomMsgBody(0, "[Coffee Break 2] once enabled must supply a valid value for its duration in minutes. Please enter a valid value then try again."));
            modWSNotify.modal('show');
            cb1.val("0").focus();
            return;  
        }

        if(shiftId.val() === 0 && confirm("Proceed creation of shift [" + shiftDesc.val() + "]? Click Ok to confirm.") === true){
            DeRegisterShifts(1);
        } else {
            if(confirm("Update shift information? Click Ok to confirm.") === true) {
                DeRegisterShifts(1);
            }
        }

    });

    $(document).on("click", "[name='cancelShift']", function(){
        shiftId.val(0);
        shiftCode.val('');
        shiftDesc.val('');
        shiftType.val(0);
        shiftTS.val(0);
        shiftTE.val(0);
        shiftHrs.val(0);
        modWSTitle.empty();
        modWSNotifyTitle.empty();
    });

    modWS.on('hidden.bs.modal', function (e) {
        shiftId.val(0);
        shiftCode.val('');
        shiftDesc.val('');
        shiftType.val(0);
        shiftTS.val(0);
        shiftTE.val(0);
        shiftHrs.val(0);
        modWSTitle.empty();
        modWSNotifyTitle.empty();
    });

    function loadShifts(){
        if(tblWS.length > 0){
            $.ajax({
                url: '/admin/loadworkshifts',
                data: {"data" : {"lt" : 1, "sid" : 0}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        for(i = 0; i <= itm.length - 1; i++){
                            html += '<tr>' + 
                                        '<td align="center">' +
                                            '<a href="#" id="' + itm[i]['shid'] + '" name="modifyShift" class="btn" data-toggle="modal" data-target="#modShifts"><i class="far fa-edit" data-toggle="tooltip" data-placement="top" title="Modify Shift"></i></a>' +
                                            '<a href="#" id="' + itm[i]['shid'] + '" name="deleteShift" class="btn"><i class="far fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Delete Shift"></i></a>' +
                                        '</td>' +
                                        '<td style="vertical-align:middle;">' + itm[i]['sc'] + '</td>' +
                                        '<td style="vertical-align:middle;">' + itm[i]['sd'] + '</td>' +
                                        '<td style="vertical-align:middle;text-align:center;">' + itm[i]['ts'] + '</td>' +
                                        '<td style="vertical-align:middle;text-align:center;">' + itm[i]['te'] + '</td>' +
                                        '<td style="vertical-align:middle;text-align:center;">' + itm[i]['weekq'] + '</td>' +
                                        '<td style="vertical-align:middle;text-align:center;">' + itm[i]['flexq'] + '</td>' +
                                        '<td style="vertical-align:middle;text-align:center;">' + itm[i]['mon'] + '</td>' +
                                        '<td style="vertical-align:middle;text-align:center;">' + itm[i]['tue'] + '</td>' +
                                        '<td style="vertical-align:middle;text-align:center;">' + itm[i]['wed'] + '</td>' +
                                        '<td style="vertical-align:middle;text-align:center;">' + itm[i]['thu'] + '</td>' +
                                        '<td style="vertical-align:middle;text-align:center;">' + itm[i]['fri'] + '</td>' +
                                        '<td style="vertical-align:middle;text-align:center;">' + itm[i]['sat'] + '</td>' +
                                        '<td style="vertical-align:middle;text-align:center;">' + itm[i]['sun'] + '</td>' +
                                        '<td style="vertical-align:middle;text-align:center;">' + itm[i]['lbflag'] + '</td>' +
                                        '<td style="vertical-align:middle;text-align:center;">' + itm[i]['cb1flag'] + '</td>' +
                                        '<td style="vertical-align:middle;text-align:center;">' + itm[i]['cb2flag'] + '</td>' +
                                    '</tr>';
                        }                        
                    } else {
                        html = '<tr><td colspan="17" align="center"> - No data available -</td></tr>';
                    }

                    tblWS.empty().append(html);
                    shiftCnt.empty().append('Total Registered Shifts : ' + itm.length); 
                    
                },
                error: function(){
                    console.log('failed');
                }
            });
        }
    }

    function loadShiftInfo(sId = 0){
        if(tblWS.length > 0){
            $.ajax({
                url: '/admin/loadworkshifts',
                data: {"data" : {"lt" : 2, "sid" : sId}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        for(i = 0; i <= itm.length - 1; i++){
                            if(itm[i]['istime'] == 1){
                                shiftType.val(1);
                                shiftHrs.val(itm[i]['flexq']);
                                shiftTS.val(itm[i]['ts']);
                                shiftTE.val(itm[i]['te']);

                            } else if(itm[i]['isflex'] == 1){
                                shiftType.val(2);
                                shiftHrs.val(itm[i]['flexq']);
                                shiftTS.val(0);
                                shiftTE.val(0);    
                            } else if(itm[i]['isweek'] == 1){
                                shiftType.val(3);
                                shiftHrs.val(itm[i]['weekq']);
                                shiftTS.val(0);
                                shiftTE.val(0);  
                            } else {
                                shiftType.val(1);
                                shiftHrs.val(0);
                                shiftTS.val(itm[i]['ts']);
                                shiftTE.val(itm[i]['te']);
                            }

                            shiftId.val(sId);
                            shiftCode.val(itm[i]['sc']);
                            shiftDesc.val(itm[i]['sd']);
                            mon.val(itm[i]['mon']);
                            tue.val(itm[i]['tue']);
                            wed.val(itm[i]['wed']);
                            thu.val(itm[i]['thu']);
                            fri.val(itm[i]['fri']);
                            sat.val(itm[i]['sat']);
                            sun.val(itm[i]['sun']);
                            lb.val(itm[i]['lb']);
                            sellb.val(itm[i]['lbflag']);
                            cb1.val(itm[i]['cb1']);
                            selcb1.val(itm[i]['cb1flag']);
                            cb2.val(itm[i]['cb2']);
                            selcb2.val(itm[i]['cb2flag']);
                        }
                        
                        modWSTitle.empty().append('Modify Workshift');

                    } else {
                        modWSNotifyBody.empty().append(getCustomMsgBody(0, "No record found."));
                        modWSNotifyTitle.empty().append('Error');
                        modWSNotify.modal('show');
                    }    
                },
                error: function(){
                    console.log('failed');
                }
            });
        }        
    }

    function DeRegisterShifts(setToActive = 1){
        if(tblWS.length > 0){
            $.ajax({
                url: '/admin/regworkshift',
                data: {"data" : {"sid" : shiftId.val(), "sc" : shiftCode.val(), "sd" : shiftDesc.val(), "st" : shiftType.val(), "sts" : shiftTS.val(), "ste" : shiftTE.val(), "wh" : shiftHrs.val(), "ia" : setToActive,
                                 "mon" : mon.val(), "tue" : tue.val(), "wed" : wed.val(), "thu" : thu.val(), "fri" : fri.val(), "sat" : sat.val(), "sun" : sun.val(),
                                 "lb" : lb.val(), "lbf" : sellb.val(), "cb1" : cb1.val(), "cb1f" : selcb1.val(), "cb2" : cb2.val(), "cb2f" : selcb2.val()}},
                method: 'POST',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        if(itm[0]['flag'] === 1){
                            if(setToActive == 0){
                                modWSNotifyTitle.empty().append("Delete");  
                            } else {
                                if(shiftId == 0){
                                    modWSTitle.empty().append('New Workshift');
                                    shiftId.val(0);
                                    shiftCode.val('');
                                    shiftDesc.val('');
                                    shiftType.val(0);
                                    shiftTS.val(0);
                                    shiftTE.val(0);
                                    shiftHrs.val(0);
                                    mon.val(0);
                                    tue.val(0);
                                    wed.val(0);
                                    thu.val(0);
                                    fri.val(0);
                                    sat.val(0);
                                    sun.val(0);
                                    sellb.val("1");
                                    lb.val("60");
                                    selcb1.val(0);
                                    cb1.val("0");
                                    selcb2.val(0);
                                    cb2.val("0");
                                } else {
                                    modWSTitle.empty().append('Modify Workshift'); 
                                }
                            }

                        } else {
                            modWSNotifyTitle.empty().append('Error');
                        }

                        loadShifts();
                     
                    } else {
                        modWSNotifyTitle.empty().append('Error');
                    }

                    modWSNotifyBody.empty().append(getCustomMsgBody(itm[0]['flag'], itm[0]['msg']));
                    modWSNotify.modal('show');
                    
                },
                error: function(){
                    console.log('failed');
                }
            });
        }
    }
    // End Work Shifts

    // Workcenters
    var tblWC = $('#tWorkcenter');
    var tblWCTotal = $('#tWCTotal');
    var modWC = $('#modWC');
    var modWCTitle = $('#modWCTitle');
    var txtWCCode = $('#wccode');
    var txtWCDesc = $('#wcdesc');
    var btnCancelWC = $('[name="cancelWC"]');
    var btnSaveWC = $('[name="saveWC"]');
    var btnNewWC = $('[name="newWC"]');
    var modWCN = $('#modWCNotify');
    var modWCNTitle = $('#modWCNotifyTitle');
    var modWCNBody = $('[name="modWCNotifyBody"]');
    var selWCId = $('#wcid');

    $(document).on("keyup", "[name='findWC']", function(){
        var value = $(this).val().toLowerCase();
        $("#tWorkcenter > tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $(document).on("click", "[name='cancelFindWC']", function(){
        $("[name='findWC']").val("");
    });

    $(document).on("click", "[name='newWC']", function(){
        modWCTitle.empty().append('New Workcenter');
        txtWCCode.val("").focus();
        txtWCDesc.val("");
    });

    $(document).on("click", "[name='lnkModify']", function(){
        modWCTitle.empty().append('Modify Workcenter');
        loadworkcenterinfo($(this).prop('id'));
    });

    $(document).on("click", "[name='lnkDelete']", function(){
        DeRegisterWorkcenter($(this).prop('id'), 0);
    });

    $(document).on("click", "[name='saveWC']", function(){

        if(txtWCCode.val().length === 0){
            modWCNTitle.empty().append("Error");
            modWCNBody.empty().append(getCustomMsgBody(0, "Workcenter code is a mandatory field and cannot be empty. Please enter a valid value then try saving again."));
            modWCN.modal('show');
            txtWCCode.focus();
            return;
        }

        if(txtWCDesc.val().length === 0){
            modWCNTitle.empty().append("Error");
            modWCNBody.empty().append(getCustomMsgBody(0, "Description is a mandatory field and cannot be empty. Please enter a valid value then try saving again."));
            modWCN.modal('show');
            txtWCDesc.focus();
            return;            
        }

        if(confirm("Proceed in Adding/Updating Work center information? Click Ok to confirm.") === true){
            DeRegisterWorkcenter(selWCId.val(), 1);            
        }
    });

    function loadWorkCenters(){
        if(tblWC.length > 0){
            $.ajax({
                url: '/admin/loadworkcenters',
                data: {"data" : {"lt" : 1, "sid" : null, "did" : null}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        for(i = 0; i <= itm.length - 1; i++){
                            html += '<tr>' + 
                                        '<td align="center">' +
                                            '<a href="#" id="'+ itm[i]['id'] +'" name="lnkModify" class="btn"><i class="far fa-edit" data-toggle="tooltip" data-placement="top" title="Modify"></i></a>' +
                                            '<a href="#" id="'+ itm[i]['id'] +'" name="lnkDelete" class="btn"><i class="far fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>' +
                                        '</td>' +
                                        '<td style="vertical-align:middle;">'+ itm[i]['wccode'] +'</td>' +
                                        '<td style="vertical-align:middle;">'+ itm[i]['wcdesc'] +'</td>' +
                                    '</tr>';
                        }                        
                    } else {
                        html = '<tr><td colspan="3" align="center"> - No data available -</td></tr>';
                    }

                    tblWC.empty().append(html);
                    tblWCTotal.empty().append('Total Work Center Count : ' + itm.length); 
                    
                },
                error: function(){
                    console.log('failed');
                }
            });
        }
    }

    function loadworkcenterinfo(id){
        if(tblWC.length > 0){
            $.ajax({
                url: '/admin/loadworkcenters',
                data: {"data" : {"lt" : 2, "wcid" : id, "did" : 0}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        selWCId.val(itm[0]['id']);
                        txtWCCode.val(itm[0]['wccode']);
                        txtWCDesc.val(itm[0]['wcdesc']);
                        modWCTitle.empty().append('Modify Workcenter');
                        modWC.modal('show');
                    }                   
                },
                error: function(){
                    console.log('failed');
                }
            });
        }
    }

    function DeRegisterWorkcenter(id = 0, activate = 1){
        if(tblWC.length > 0){
            $.ajax({
                url: '/admin/regworkcenter',
                data: {"data" : {"wcid" : id, "wc" : txtWCCode.val(), "wd" : txtWCDesc.val(), "ia" : activate}},
                method: 'POST',
                success: function(res){
                    var itm = JSON.parse(res);
                    var title = "";

                    if(itm[0]['flag'] === 0){ title = "Error Occurred"; } else { title = "Success" ;}
                    
                    modWCNTitle.empty().append(title);
                    modWCNBody.empty().append(getCustomMsgBody(itm[0]['flag'], itm[0]['msg']));
                    modWCN.modal('show'); 

                    loadWorkCenters();
                },
                error: function(){
                    console.log('failed');
                },
                done: function(){
                    loadWorkCenters();
                }
            });
        }        
    }

    // End Workcenters

    // Activity
    var tAct = $('#tActivity');
    var actCnt = $('[name="actCount"]')
    var selAWC = $('#selawc');
    var modAct = $('#modAct');
    var modActTitle = $('#modActTitle');
    var modActN = $('#modActNotify');
    var modActNTitle = $('#modActNotifyTitle');
    var modActNBody = $('#modActNotifyBody');
    var selActId = $('#actid');
    var selAWC2 = $('#selawcreg');
    var txtACode = $('#acode');
    var txtADesc = $('#adesc');
    
    var btnSaveAct = $('[name="saveAct"]');
    var btnCancelAct = $('[name="cancelAct"]');

    $(document).on("keyup", "[name='findAct']", function(){
        var value = $(this).val().toLowerCase();
        $("#tActivity > tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $(document).on("click", "[name='cancelFindAct']", function(){
        $("[name='findAct']").val("");
    });

    $(document).on("click", "[name='newActivity']", function(){
        selActId.val('0');
        selAWC2.val(0);
        txtACode.val('');
        txtADesc.val('');
    });

    $(document).on("click", "[name='lnkModify']", function(){
        loadactivityinfo($(this).prop('id'), 1);
    });

    $(document).on("click", "[name='lnkDelete']", function(){
        DeRegisterActivity($(this).prop('id'), 0);
    });

    $(document).on("click", "[name='saveAct']", function(){

        if(selAWC2.val() === 0){
            modActNTitle.empty().append("Error");
            modActNBody.empty().append(getCustomMsgBody(0, "You must select a work center from the dropdown list then try again."));
            modActN.modal('show'); 
            return;            
        }

        if(txtACode.val().length === 0){
            modActNTitle.empty().append("Error");
            modActNBody.empty().append(getCustomMsgBody(0, "Activity code is a mandatory field. Enter a valid entry then try again."));
            modActN.modal('show'); 
            return;
        }

        if(txtADesc.val().length === 0){
            modActNTitle.empty().append("Error");
            modActNBody.empty().append(getCustomMsgBody(0, "Description is a mandatory field. Enter a valid entry then try again."));
            modActN.modal('show'); 
            return;
        }

        DeRegisterActivity(selActId.val(), 1);
    });

    selAWC.on("change", function(){
        loadactivity($(this).val());
    });
  
    function loadworkcenterstoactivitydd(){
        if(tAct.length > 0){
            $.ajax({
                url: '/admin/loadworkcenters',
                data: {"data":{"lt": 3, "wcid": 0, "did": 0}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        html += '<option value="0" selected="selected">- Select a Workcenter -</option>';
                        for(i = 0; i <= itm.length - 1; i++){
                            html += '<option value="' + itm[i]['wcid'] + '">' + itm[i]['wc'] + '</option>';
                        }                        
                    } else {
                        html = '<option value="0" selected="selected">- No Available options -</option>';
                    }

                    selAWC.empty().append(html);
                    selAWC2.empty().append(html);
                },
                error: function(){
                    console.log('failed');
                }
            });            
        }
    }

    function loadactivity(wcid = 0){
        if(tAct.length > 0){
            $.ajax({
                url: '/admin/loadactivity',
                data: {"data":{"lt": 1, "wcid": wcid, "aid": 0}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        for(i = 0; i <= itm.length - 1; i++){
                            html += '<tr>' +
                                        '<td align="center">' + 
                                            '<a href="#" id="'+ itm[i]['actid'] +'" name="lnkModify" class="btn"><i class="far fa-edit" data-toggle="tooltip" data-placement="top" title="Modify"></i></a>' +
                                            '<a href="#" id="'+ itm[i]['actid'] +'" name="lnkDelete" class="btn"><i class="far fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>' +
                                        '</td>' +
                                        '<td style="vertical-align:middle;">'+ itm[i]['code'] +'</td>' +
                                        '<td style="vertical-align:middle;">'+ itm[i]['descr'] +'</td>' +
                                        '<td style="vertical-align:middle;">'+ itm[i]['wc'] +'</td>' +
                                    '</tr>';
                        }                        
                    } else {
                        html = '<tr><td colspan="4" align="center"> - No data available -</td></tr>';
                    }

                    tAct.empty().append(html);
                    actCnt.empty().append("Total registered Activity : " + itm.length);

                },
                error: function(){
                    console.log('failed');
                }
            });            
        }       
    }

    function loadactivityinfo(aid = 0){
        if(tAct.length > 0){
            $.ajax({
                url: '/admin/loadactivity',
                data: {"data":{"lt": 2, "wcid": 0, "aid": aid}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                       selActId.val(itm[0]['aid']);
                       selAWC2.val(itm[0]['wid']);
                       txtACode.val(itm[0]['acode']);
                       txtADesc.val(itm[0]['descr']);
                       modActTitle.empty().append('Modify Workcenter');
                       modAct.modal('show');
                    } 
                },
                error: function(){
                    console.log('failed');
                }
            });            
        }
    }

    function DeRegisterActivity(id = 0, activate = 1){
        if(tAct.length > 0){
            $.ajax({
                url: '/admin/regactivity',
                data: {"data":{"aid": id, "wcid": selAWC2.val(), "acode": txtACode.val(), "adesc": txtADesc.val(), "ia": activate}},
                method: 'POST',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm[0]['flag'] === 0){ title = "Error Occurred"; } else { title = "Success" ;}
                    
                    modActNTitle.empty().append(title);
                    modActNBody.empty().append(getCustomMsgBody(itm[0]['flag'], itm[0]['msg']));
                    modActN.modal('show');
                    selAWC.val(0); 

                    loadactivity();
                },
                error: function(){
                    console.log('failed');
                },
                done: function(){
                    selAWC.val(0); 
                    loadactivity();
                }
            });            
        }        
    }

    // End Activity

    // Employees
    var tblEmp = $('#tEmp');
    var empCnt = $('#empCnt');
    var modEmp = $('#modEmp');
    var modEmpTitle = $('#modEmpTitle');
    var modEmpNotify = $('#modEmpNotify');
    var modEmpNotifyTitle = $('#modNotifyEmpTitle');
    var modEmpNotifyBody = $('#modEmpNotifyBody');
    var empid = $('#empid');
    var empcode = $('#empcode');
    var emppwd = $('#emppwd');
    var empcpwd = $('#empcpwd');
    var emprole = $('#selrole');
    var empexec = $('#selisexec'); 
    var empln = $('#empln');
    var empfn = $('#empfn');
    var empmn = $('#empmn');
    var ssno = $('#ssno');
    var addr = $('#addr');
    var city = $('#city');
    var state = $('#state');
    var zipcode = $('#zipcode');
    var country = $('#country');
    var phone = $('#phone');
    var dept = $('#seldept')
    var jobpost = $('#jobpost');
    var hrrate = $('#hrrate');
    var dthired = $('#dthired');
    var dtleft = $('#dtleft');
    var wshift = $('#selshift');
    var findemp = $('#findemp');
    var btnNewEmp = $('[name="newEmp"]');
    var btnEmpSave = $('[name="saveEmp"]');
    var btnNPEmp = $('[name="nextprevInfo"]');

    $(document).on('click', '[name="newEmp"]', function(){
        modEmpTitle.empty().append('New Employee');
        empid.val("0");
        empcode.val("");
        emppwd.val("");
        empcpwd.val("");
        emprole.val(0);
        empexec.val(0);
        empln.val("");
        empfn.val("");
        addr.val("");
        city.val("");
        state.val("");        
        zipcode.val("");
        country.val("");
        phone.val("");
        dept.val(0);
        jobpost.val("");
        wshift.val(0);
        dthired.val("");
        dtleft.val("");
    });

    $(document).on("click", "[name='modifyEmp']", function(){
        loademployeeinfo(parseInt($(this).attr("id")));
    });

    $(document).on("click", "[name='deleteEmp']", function(){
        if(confirm("Are you sure you want to remove selected employee profile? Click Ok to proceed.") === true){
           DeRegisterEmployee($(this).attr("id"), 0); 
        }
    });

    $(document).on('click', '[name="saveEmp"]', function(){
        if(empcode.val().length == 0){
            modEmpNotifyTitle.empty().append('Error Occured');
            modEmpNotifyBody.empty().append(getCustomMsgBody(0, "Employee Code cannot be empty. Please key in a valid entry then try again."));
            modEmpNotify.modal('show');
            empcode.focus();
            return false ;
        }
        
        if(empid.val() === 0){
            if(emppwd.val().length == 0){
                modEmpNotifyTitle.empty().append('Error Occured');
                modEmpNotifyBody.empty().append(getCustomMsgBody(0, "Password cannot be empty. Please enter a 6-10 alphanumeric character for the password."));
                modEmpNotify.modal('show');
                emppwd.focus();
                return false ;            
            }

            if(empcpwd.val().length == 0){
                modEmpNotifyTitle.empty().append('Error Occured');
                modEmpNotifyBody.empty().append(getCustomMsgBody(0, "Please re-type your chosen password."));
                modEmpNotify.modal('show');
                empcpwd.focus();
                return false ;            
            }

            if(emppwd.val() !== empcpwd.val()){
                modEmpNotifyTitle.empty().append('Error Occured');
                modEmpNotifyBody.empty().append(getCustomMsgBody(0, "Passwords entered are not the same. Please re-type your password then try again."));
                modEmpNotify.modal('show');
                emppwd.focus();
                return false ;            
            }
        } 
        else {
            if(emppwd.val() !== empcpwd.val()){
                modEmpNotifyTitle.empty().append('Error Occured');
                modEmpNotifyBody.empty().append(getCustomMsgBody(0, "Passwords entered are not the same. Please re-type your password then try again."));
                modEmpNotify.modal('show');
                emppwd.focus();
                return false ;            
            }
        }


        if(empln.val().length == 0){
            modEmpNotifyTitle.empty().append('Error Occured');
            modEmpNotifyBody.empty().append(getCustomMsgBody(0, "Last name is a mandatory field. Please enter a valid value then try again."));
            modEmpNotify.modal('show');
            empln.focus();
            return false ;      
        }

        if(empfn.val().length == 0){
            modEmpNotifyTitle.empty().append('Error Occured');
            modEmpNotifyBody.empty().append(getCustomMsgBody(0, "First name is a mandatory field. Please enter a valid value then try again."));
            modEmpNotify.modal('show');
            empfn.focus();
            return false ;      
        }

        if(addr.val().length == 0){
            modEmpNotifyTitle.empty().append('Error Occured');
            modEmpNotifyBody.empty().append(getCustomMsgBody(0, "Address is a mandatory field. Please enter a valid value then try again."));
            modEmpNotify.modal('show');
            addr.focus();
            return false ;      
        }

        if(city.val().length == 0){
            modEmpNotifyTitle.empty().append('Error Occured');
            modEmpNotifyBody.empty().append(getCustomMsgBody(0, "City is a mandatory field. Please enter a valid value then try again."));
            modEmpNotify.modal('show');
            addr.focus();
            return false ;      
        }

        if(state.val().length == 0){
            modEmpNotifyTitle.empty().append('Error Occured');
            modEmpNotifyBody.empty().append(getCustomMsgBody(0, "State is a mandatory field. Please enter a valid value then try again."));
            modEmpNotify.modal('show');
            state.focus();
            return false ;      
        }

        if(zipcode.val().length == 0){
            modEmpNotifyTitle.empty().append('Error Occured');
            modEmpNotifyBody.empty().append(getCustomMsgBody(0, "Zip Code is a mandatory field. Please enter a valid value then try again."));
            modEmpNotify.modal('show');
            zipcode.focus();
            return false ;      
        }

        if(country.val().length == 0){
            modEmpNotifyTitle.empty().append('Error Occured');
            modEmpNotifyBody.empty().append(getCustomMsgBody(0, "Country is a mandatory field. Please enter a valid value then try again."));
            modEmpNotify.modal('show');
            country.focus();
            return false ;      
        }

        if(phone.val().length == 0){
            phone.focus();
            modEmpNotifyTitle.empty().append('Error Occured');
            modEmpNotifyBody.empty().append(getCustomMsgBody(0, "Phone is a mandatory field. Please enter a valid value then try again."));
            modEmpNotify.modal('show');
            return false ;      
        }

        if(dept.val() == 0){
            dept.focus();
            modEmpNotifyTitle.empty().append('Error Occured');
            modEmpNotifyBody.empty().append(getCustomMsgBody(0, "You must select a valid Department for the employee. Please choose from the list then try again."));
            modEmpNotify.modal('show');
            return false ;      
        }

        if(jobpost.val().length == 0){
            jobpost.focus();
            modEmpNotifyTitle.empty().append('Error Occured');
            modEmpNotifyBody.empty().append(getCustomMsgBody(0, "Job Position is a mandatory field. Please enter a valid value then try again."));
            modEmpNotify.modal('show');
            return false ;      
        }

        // if(hrrate.val().length == 0){
        //     hrrate.val('0').focus();
        //     modEmpNotifyTitle.empty().append('Error Occured');
        //     modEmpNotifyBody.empty().append(getCustomMsgBody(0, "Rate per Hour is a mandatory field. Please enter a valid value then try again."));
        //     modEmpNotify.modal('show');
        //     return false ;      
        // }

        // if(isNaN(hrrate.val())){
        //     hrrate.val('0').focus();
        //     modEmpNotifyTitle.empty().append('Error Occured');
        //     modEmpNotifyBody.empty().append(getCustomMsgBody(0, "Rate per hour is expecting a number. Please enter a valid value."));
        //     modEmpNotify.modal('show');
        //     return false ;             
        // }

        if(wshift.val() == 0){
            cb2.val('0').focus();
            modEmpNotifyTitle.empty().append('Error Occured');
            modEmpNotifyBody.empty().append(getCustomMsgBody(0, "Work shift is mandatory. Please choose one from the list."));
            modEmpNotify.modal('show');
            return false ;      
        }

        if(dthired.val() === ""){
            dthired.focus();
            modEmpNotifyTitle.empty().append('Error Occured');
            modEmpNotifyBody.empty().append(getCustomMsgBody(0, "Date Hired is mandatory for new Employees. Please select a valid date from the calendar then try again."));
            modEmpNotify.modal('show');
            return false ;             
        }

        if(empid.val() === 0){
            if(confirm("Proceed in adding new employee profile? Click Ok to proceed.") === true){
                DeRegisterEmployee(empid.val(), 1);
            }
        } else {
            if(confirm("Update employee profile? Click Ok to proceed.") === true){
                DeRegisterEmployee(empid.val(), 1);
            }            
        }
    });

    $(document).on("click", "[name='cancelEmp']", function(){
        empid.val("0");
        empcode.val("");
        emppwd.val("");
        empcpwd.val("");
        emprole.val(0);
        empexec.val(0);
        empln.val("");
        empfn.val("");
        addr.val("");
        city.val("");
        state.val("");        
        zipcode.val("");
        country.val("");
        phone.val("");
        dept.val(0);
        jobpost.val("");
        wshift.val(0);
        dthired.val("");
        dtleft.val("");
    });
    
    $(document).on("keydown", "#findemp", function(){
        var value = $(this).val().toLowerCase();
        $("#tEmp > tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    })

    $(document).on("click", "[name='cancelFindEmp']", function(){
        $("#findemp").val("").trigger("keydown");
    });

    $(document).on("click", "[name='resetPwd']", function(e){
        e.preventDefault();
        if(confirm("Reset password for the selected employee? Click Ok to proceed.") === true){
            $.ajax({
                url     : '/admin/resetpassword',
                data    : {"data" : {"eid" : $(this).attr('id')}},
                method  : 'POST',
                success : function(res){
                    var itm = JSON.parse(res);

                    modEmpNotifyTitle.empty().append('Success : Password Reset');
                    modEmpNotifyBody.empty().append(getCustomMsgBody(1, 'Password reset successful. User must change password on his next login.'));
                    modEmpNotify.modal('show');                        
                },
                error   : function(jqXHR, textStatus, errorThrown){
                    modEmpNotifyTitle.empty().append('Error : Password Reset');
                    modEmpNotifyBody.empty().append(getCustomMsgBody(0, 'Failed to reset password. Please contact your system adminstrator.'));
                    modEmpNotify.modal('show'); 
                }
            }); 
         }
        
    });

    function loadrolestoemployees(){
        if(tblEmp.length > 0){
            $.ajax({
                url: '/admin/loaduserroles',
                data: {"data" : {"lt": 0, "rid": 0}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        html += '<option value="0" selected="selected">- Select an Access Role -</option>';
                        for(i = 0; i <= itm.length - 1; i++){
                            html += '<option value="' + itm[i]['roleid'] + '">' + itm[i]['role'] + '</option>';
                        }                        
                    } else {
                        html = '<option value="0" selected="selected">- No Available options -</option>';
                    }

                    emprole.empty().append(html);
                },
                error: function(){
                    console.log('failed');
                }
            });
        }        
    }

    function loaddeptonemployees(){
        if(tblEmp.length > 0){
            $.ajax({
                url: '/admin/loaddepartments',
                data: {"data" : 0},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        html += '<option value="0" selected="selected">- Select a Department -</option>';
                        for(i = 0; i <= itm.length - 1; i++){
                            html += '<option value="' + itm[i]['deptid'] + '">' + itm[i]['dept'] + '</option>';
                        }                        
                    } else {
                        html = '<option value="0" selected="selected">- No Available options -</option>';
                    }

                    dept.empty().append(html);
                },
                error: function(){
                    console.log('failed');
                }
            });
        }
    }

    function loadshifttoemployees(){
        if(tblEmp.length > 0){
            $.ajax({
                url: '/admin/loadworkshifts',
                data: {"data" : {"lt" : 0, "sid" : 0}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        html += '<option value="0" selected="selected">- Select a Work Shift -</option>';
                        for(i = 0; i <= itm.length - 1; i++){
                            html += '<option value="' + itm[i]['shid'] + '">' + itm[i]['shiftnm'] + '</option>';
                        }                        
                    } else {
                        html = '<option value="0" selected="selected">- No Available options -</option>';
                    }

                    wshift.empty().append(html);
                },
                error: function(){
                    console.log('failed');
                }
            });
        }
    }

    function loademployees(findemp = ''){
        if(tblEmp.length > 0){
            $.ajax({
                url: '/admin/loademployees',
                data: {"data" : {"lt" : 1, "eid": 0, "find": findemp}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        for(i = 0; i <= itm.length - 1; i++){
                            html += '<tr>' +
                                        '<td style="text-align: center; vertical-align: middle;">' +
                                            '<a href="#" name="modifyEmp" id="' + itm[i]["id"] + '" class="btn"><i class="far fa-edit" data-toggle="tooltip" data-placement="top" title="Modify"></i></a>' +
                                            '<a href="#" name="deleteEmp" id="' + itm[i]["id"] + '" class="btn"><i class="far fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>' +
                                            '<a href="#" name="resetPwd" id="' + itm[i]["id"] + '" class="btn"><i class="fas fa-key" data-toggle="tooltip" data-placement="top" title="Reset Password"></i></a>' +
                                        '</td>' +
                                        '<td style="vertical-align: middle;">' + itm[i]["empcode"] + '</td>' +
                                        '<td style="vertical-align: middle;">' + itm[i]["nm"] + '</td>' +
                                        '<td style="text-align: center; vertical-align: middle;">' + itm[i]["jp"] + '</td>' +
                                        '<td style="text-align: center; vertical-align: middle;">' + itm[i]["dn"] + '</td>' +
                                        '<td style="text-align: center; vertical-align: middle;">' + itm[i]["sflag"] + '</td>' +
                                    '<tr>'
                        }                        
                    } else {
                        html = '<tr><td colspan="6" align="center"> - No data available -</td></tr>';
                    }

                    tblEmp.empty().append(html);
                    $("[name='empCnt']").empty().append("Total Registered Employee : " + itm.length);
                },
                error: function(){
                    console.log('failed');
                }
            });
        }        
    }

    function loademployeeinfo(id){
        if(tblEmp.length > 0){
            $.ajax({
                url: '/admin/loademployees',
                data: {"data" : {"lt" : 2, "eid": id, "find": ''}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);

                    if(itm.length > 0){
                        empid.val(itm[0]["id"]);
                        empcode.val(itm[0]["empcode"]);
                        //emppwd.val(itm[0]["emppwd"]);
                        //empcpwd.val(itm[0]["emppwd"]);
                        emprole.val(itm[0]["roleid"]);
                        empexec.val(itm[0]["isexec"]);
                        empln.val(itm[0]["empLN"]);
                        empfn.val(itm[0]["empFN"]);
                        addr.val(itm[0]["addr"]);
                        city.val(itm[0]["city"]);
                        state.val(itm[0]["state"]);        
                        zipcode.val(itm[0]["zipcode"]);
                        country.val(itm[0]["country"]);
                        phone.val(itm[0]["phoneno"]);
                        hrrate.val(itm[0]["hrrate"]);
                        dept.val(itm[0]["deptid"]);
                        jobpost.val(itm[0]["jobpost"]);
                        wshift.val(itm[0]["shiftid"]);
                        dthired.val(itm[0]["datehired"]);
                        dtleft.val(itm[0]["dateleft"]);      
                        
                        modEmpTitle.empty().append("Modify Employee");
                        modEmp.modal('show');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) 
                {
                    alert(errorThrown);
                }
            });
        }                 
    }

    function DeRegisterEmployee(id = 0, activate = 1){
        if(tblEmp.length > 0){
            $.ajax({
                url: '/admin/regemployee',
                data: {"data" : {"eid": id, "ec": empcode.val(), "pwd" : emppwd.val(), "role" : emprole.val(), "exec" : empexec.val(),
                                 "efn" : empfn.val(), "eln" : empln.val(), "emn" : empmn.val(), "addr" : addr.val(), "city" : city.val(), "state" : state.val(), "zip" : zipcode.val(), "country" : country.val(),
                                 "phone" : phone.val(), "rate" : 0, "did" : dept.val(), "sid" : wshift.val(), "jp" : jobpost.val(), "dh": dthired.val(), "dl" : dtleft.val(), "ia": activate}
                    },
                method: 'POST',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm[0]['flag'] === 0){ title = "Error Occurred"; } else { title = "Success" ;}
                    
                    modEmpNotifyTitle.empty().append(title);
                    modEmpNotifyBody.empty().append(getCustomMsgBody(itm[0]['flag'], itm[0]['msg']));
                    modEmpNotify.modal('show'); 

                    loademployees();
                },
                error: function(){
                    console.log('failed');
                }
            });
        }         
    }

    // End Employees

    // Roles
    var tblRoles = $('#tRoles');
    var tblRoleCnt = $('#roleCnt');
    var modRoles = $('#modRoles');
    var modRolesTitle = $('#modRoleTitle');
    var modNotifyRoles = $('#modNotifyRole');
    var modNotifyRolesTitle = $('#modNotifyRoleTitle');
    var modNotifyRolesBody = $('#modNotifyRoleBody');
    var roleId = $('#roleid');
    var roleCode = $('#rcode');
    var roleDesc = $('#rdesc');
    var cLogin = $('#selclogin');
    var cGrpLogin = $('#selcgrplogin');
    var aLogin = $('#seladmlogin');
    var aDept = $('#seladmdept');
    var aWGroup = $('#seladmwg');
    var aWShift = $('#seladmshift');
    var aWCenter = $('#seladmwc');
    var aActivity = $('#seladmact');
    var aCustomer = $('#seladmcust');
    var aJobOrder = $('#seladmjo');
    var aEmployee = $('#seladmemp');
    var aRoles = $('#seladmroles');
    var aReport = $('#seladmrpt');
    var aRemote = $('#seladmremote');
    var aDataOps = $('#seladmdataops');

    $(document).on("click", "[name='saveRole']", function(){

        if(roleCode.val() === ""){
            modNotifyRolesTitle.empty().append("Error [Code]");
            modNotifyRolesBody.empty().append(getCustomMsgBody(0, "[Code] is a mandatory field. Please enter a valid value then try again."));
            modNotifyRoles.modal('show');
            return;
        }

        if(roleDesc.val() === ""){
            modNotifyRolesTitle.empty().append("Error [Desc]");
            modNotifyRolesBody.empty().append(getCustomMsgBody(0, "[Description] is a mandatory field. Please enter a short description for the role then try again."));
            modNotifyRoles.modal('show');
            return;
        }
        if(roleId.val() === 0){
            if(confirm("Proceed in creating new role profile? Click Ok to proceed.") === true){
                DeRegisterRoles(roleId.val(), 1);
            }
        } else {
            if(confirm("Save changes made to role profile? Click Ok to proceed.") === true){
                DeRegisterRoles(roleId.val(), 1);
            }
        }
        
    });

    $(document).on("click","[name='newRole']", function(){
        modRolesTitle.empty().append('[New Role]');
    });

    $(document).on("click", "[name='cancelRole']", function(){
        roleId.val("0");
        roleCode.val("");
        roleDesc.val("");
        cLogin.val(0);
        cGrpLogin.val(0);
        aLogin.val(0);
        aDept.val();
        aWGroup.val(0);
        aWShift.val(0);
        aWCenter.val(0);
        aActivity.val(0);
        aCustomer.val(0);
        aJobOrder.val(0);
        aEmployee.val(0);
        aRoles.val(0);
        aReport.val(0);
        aRemote.val(0);
        aDataOps.val(0);

        modRolesTitle.empty().append('[New Role]');
    });

    $(document).on("click", "[name='modifyRole']", function(){
        loadRoleInfo($(this).attr("id"));
    });

    $(document).on("click", "[name='deleteRole']", function(){
        if(confirm("Are you sure you want to remove Role profile? Click Ok to proceed.") === true){
            DeRegisterRoles($(this).attr("id"), 0);
        }
    });

    function loadRoles(){
        if(tblRoles.length > 0){
            $.ajax({
                url: '/admin/loaduserroles',
                data: {"data" : {"lt": 1, "rid": 0}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        for(i = 0; i <= itm.length - 1; i++){
                            html += '<tr>' +
                                        '<td style="text-align: center; vertical-align: middle;">' +
                                            '<a href="#" name="modifyRole" id="' + itm[i]["rid"] + '" class="btn"><i class="far fa-edit" data-toggle="tooltip" data-placement="top" title="Modify"></i></a>' +
                                            '<a href="#" name="deleteRole" id="' + itm[i]["rid"] + '" class="btn"><i class="far fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>' +
                                        '</td>' +
                                        '<td style="vertical-align: middle;">' + itm[i]["code"] + '</td>' +
                                        '<td style="vertical-align: middle;">' + itm[i]["desc"] + '</td>' +
                                        '<td style="text-align: center; vertical-align: middle;">' + itm[i]["ca1"] + '</td>' +
                                        '<td style="text-align: center; vertical-align: middle;">' + itm[i]["ca2"] + '</td>' +
                                        '<td style="text-align: center; vertical-align: middle;">' + itm[i]["aa1"] + '</td>' +
                                        '<td style="text-align: center; vertical-align: middle;">' + itm[i]["aa2"] + '</td>' +
                                        '<td style="text-align: center; vertical-align: middle;">' + itm[i]["aa3"] + '</td>' +
                                        '<td style="text-align: center; vertical-align: middle;">' + itm[i]["aa4"] + '</td>' +
                                        '<td style="text-align: center; vertical-align: middle;">' + itm[i]["aa5"] + '</td>' +
                                        '<td style="text-align: center; vertical-align: middle;">' + itm[i]["aa6"] + '</td>' +
                                        '<td style="text-align: center; vertical-align: middle;">' + itm[i]["aa7"] + '</td>' +
                                        '<td style="text-align: center; vertical-align: middle;">' + itm[i]["aa8"] + '</td>' +
                                        '<td style="text-align: center; vertical-align: middle;">' + itm[i]["aa9"] + '</td>' +
                                        '<td style="text-align: center; vertical-align: middle;">' + itm[i]["aa10"] + '</td>' +
                                        '<td style="text-align: center; vertical-align: middle;">' + itm[i]["aa11"] + '</td>' +
                                        '<td style="text-align: center; vertical-align: middle;">' + itm[i]["aa12"] + '</td>' +
                                        '<td style="text-align: center; vertical-align: middle;">' + itm[i]["aa13"] + '</td>' +
                                    '</tr>';
                        }                        
                    } else {
                        html = '<tr><td colspan="18" align="center"> - No data available -</td></tr>';
                    }

                    tblRoles.empty().append(html);
                    tblRoleCnt.empty().append('Total Role Count : ' + itm.length);
                },
                error: function(){
                    console.log('failed');
                }
            });
        }
    }

    function loadRoleInfo(rId = 0){
        if(tblRoles.length > 0){
            $.ajax({
                url: '/admin/loaduserroles',
                data: {"data" : {"lt": 2, "rid": rId}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    
                    if(itm.length > 0){
                        roleId.val(itm[0]['rid']);
                        roleCode.val(itm[0]['code']);
                        roleDesc.val(itm[0]['desc']);
                        cLogin.val(itm[0]['ca1']);
                        cGrpLogin.val(itm[0]['ca2']);
                        aLogin.val(itm[0]['aa1']);
                        aDept.val(itm[0]['aa2']);
                        aWGroup.val(itm[0]['aa3']);
                        aWShift.val(itm[0]['aa4']);
                        aWCenter.val(itm[0]['aa5']);
                        aActivity.val(itm[0]['aa6']);
                        aCustomer.val(itm[0]['aa7']);
                        aJobOrder.val(itm[0]['aa8']);
                        aEmployee.val(itm[0]['aa9']);
                        aRoles.val(itm[0]['aa10']);
                        aReport.val(itm[0]['aa11']);
                        aRemote.val(itm[0]['aa12']);
                        aDataOps.val(itm[0]['aa13']);

                        modRolesTitle.empty().append('Modify Role');
                        modRoles.modal('show');
                        
                    }

                },
                error: function(){
                    console.log('failed');
                }
            });
        }
    }

    function DeRegisterRoles(id = 0, activate = 1){
        if(tblRoles.length > 0){
            $.ajax({
                url: '/admin/reguserroles',
                data: {"data":{"rid": id, "rc": roleCode.val(), "rd": roleDesc.val(), 
                               "cl": cLogin.val(), "cg": cGrpLogin.val(),
                               "al": aLogin.val(), "ad": aDept.val(), "awg": aWGroup.val(), "aws": aWShift.val(), "awc": aWCenter.val(),
                               "aa": aActivity.val(), "ac": aCustomer.val(), "aj": aJobOrder.val(), "ae": aEmployee.val(), "ar": aRoles.val(), "aro": aReport.val(), "ara": aRemote.val(), "ado": aDataOps.val(),  
                               "ia": activate}},
                method: 'POST',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm[0]['flag'] === 0){ title = "Error Occurred"; } else { title = "Success" ;}
                    
                    modNotifyRolesTitle.empty().append(title);
                    modNotifyRolesBody.empty().append(getCustomMsgBody(itm[0]['flag'], itm[0]['msg']));
                    modNotifyRoles.modal('show'); 

                    loadRoles();
                },
                error: function(){
                    console.log('failed');
                },
                done: function(){
                    loadRoles();
                }
            });            
        }
    }

    // End Roles

    // Customers
    var tblCust = $('#tCust');
    var tblCustCnt = $('[name="custCnt"]');
    var txtFindCust = $('#findcust');
    var modCust = $('#modCust');
    var modCustTitle = $('#modCustTitle');
    var modNCust = $('#modCustNotify');
    var modNCustTitle = $('#modNotifyCustTitle');
    var modNCustBody = $('#modCustNotifyBody');
    var custId = $('#custid');
    var custCode = $('#custcode');
    var custName = $('#custname');
    var cAddr1 = $('#addr1');
    var cAddr2 = $('#addr2');
    var cCity = $('#city');
    var cState = $('#state');
    var cZip = $('#zipcode');
    var cCountry = $('#country');
    var cPhone = $('#phone');

    $(document).on("click", "[name='newCust']", function(){
        modCustTitle.empty().append("New Customer");
    });

    $(document).on("click", "[name='modifyCust']", function(){
        loadCustomerInfo($(this).attr("id"));
    });

    $(document).on("click", "[name='deleteCust']", function(){
        DeRegisterCustomers($(this).attr("id"), 0);
    });

    $(document).on("click", "[name='saveCust']", function(){
        if(custCode.val().length === 0) {
            modNCustTitle.empty().append("Error occurred");
            modNCustBody.empty.append(getCustomMsgBody(0, "[Customer Code] is a mandatory field. Please enter a valid value then try again."));
            modNCust.modal('show');
            return;
        }

        if(custName.val().length === 0) {
            modNCustTitle.empty().append("Error occurred");
            modNCustBody.empty.append(getCustomMsgBody(0, "[Customer Name] is a mandatory field. Please enter a valid value then try again."));
            modNCust.modal('show');
            return;
        }

        if(cAddr1.val().length === 0 && cAddr2.val().length === 0) {
            modNCustTitle.empty().append("Error occurred");
            modNCustBody.empty.append(getCustomMsgBody(0, "[Address] is a mandatory field. Please supply a value to Address 1 or Address 2 then try again."));
            modNCust.modal('show');
            return;
        }

        if(cCity.val().length === 0) {
            modNCustTitle.empty().append("Error occurred");
            modNCustBody.empty.append(getCustomMsgBody(0, "[City] is a mandatory field. Please supply a value then try again."));
            modNCust.modal('show');
            return;
        }

        if(cState.val().length === 0) {
            modNCustTitle.empty().append("Error occurred");
            modNCustBody.empty.append(getCustomMsgBody(0, "[State] is a mandatory field. Please supply a value then try again."));
            modNCust.modal('show');
            return;
        }

        if(cZip.val().length === 0) {
            modNCustTitle.empty().append("Error occurred");
            modNCustBody.empty.append(getCustomMsgBody(0, "[Zip Code] is a mandatory field. Please supply a value then try again."));
            modNCust.modal('show');
            return;
        }

        if(cCountry.val().length === 0) {
            modNCustTitle.empty().append("Error occurred");
            modNCustBody.empty.append(getCustomMsgBody(0, "[Country] is a mandatory field. Please supply a value then try again."));
            modNCust.modal('show');
            return;
        }

        if(cPhone.val().length === 0) {
            modNCustTitle.empty().append("Error occurred");
            modNCustBody.empty.append(getCustomMsgBody(0, "[Phone Number] is a mandatory field. Please supply a value then try again."));
            modNCust.modal('show');
            return;
        }
        
        DeRegisterCustomers(custId.val(), 1);
        
    }); 

    $(document).on("click", "[name='cancelCust']", function(){
        custId.val("0");
        custCode.val("");
        custName.val("");
        cAddr1.val("");
        cAddr2.val("");
        cCity.val("");
        cState.val("");
        cZip.val("");
        cCountry.val("");
        cPhone.val("");
    });

    $(document).on("keydown", "#findcust", function(){
        loadCustomers($(this).val());
    });

    function loadCustomers(find = null){
        if(tblCust.length > 0){
            $.ajax({
                url: '/admin/loadcustomers',
                data: {"data" : {"lt": 1, "cid": 0, "find": find}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        for(i = 0; i <= itm.length - 1; i++){
                            html += '<tr>' +
                                        '<td style="text-align: center; vertical-align: middle;">' +
                                            '<a href="#" name="modifyCust" id="' + itm[i]["cuid"] + '" class="btn"><i class="far fa-edit" data-toggle="tooltip" data-placement="top" title="Modify"></i></a>' +
                                            '<a href="#" name="deleteCust" id="' + itm[i]["cuid"] + '" class="btn"><i class="far fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>' +
                                        '</td>' +
                                        '<td style="vertical-align: middle;">' + itm[i]["code"] + '</td>' +
                                        '<td style="vertical-align: middle;">' + itm[i]["name"] + '</td>' +
                                        '<td style="text-align: center; vertical-align: middle;">' + itm[i]["sflag"] + '</td>' +
                                    '</tr>';
                        }                        
                    } else {
                        html = '<tr><td colspan="4" align="center"> - No data available -</td></tr>';
                    }

                    tblCust.empty().append(html);
                    tblCustCnt.empty().append('Total Customer Count : ' + itm.length);
                },
                error: function(){
                    console.log('failed');
                }
            });
        }
    }

    function loadCustomerInfo(id = 0){
        if(tblCust.length > 0){
            $.ajax({
                url: '/admin/loadcustomers',
                data: {"data" : {"lt": 1, "cid": id, "find": ''}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);

                    if(itm.length > 0){
                        custId.val(itm[0]['cuid']);
                        custCode.val(itm[0]['code'])
                        custName.val(itm[0]['name']);
                        cAddr1.val(itm[0]['addr1']);
                        cAddr2.val(itm[0]['addr2']);
                        cCity.val(itm[0]['city']);
                        cState.val(itm[0]['state']);
                        cZip.val(itm[0]['zipcode']);
                        cCountry.val(itm[0]['country']);
                        cPhone.val(itm[0]['phoneno']);
                        modCustTitle.empty().append("Modify Customer Information");
                        modCustTitle.modal('show');
                    }
                },
                error: function(){
                    console.log('failed');
                }
            });
        }
    }

    function DeRegisterCustomers(id = 0, activate = 1){
        if(tblCust.length > 0){
            $.ajax({
                url: '/admin/regcustomer',
                data: {"data" : {"cid": id, "cc": custCode.val(), "cn": custName.val(),
                                 "addr1": cAddr1.val(), "addr2": cAddr2.val(), "city": cCity.val(), "state": cState.val(), "zip": cZip.val(),
                                 "country": cCountry.val(), "phone": cPhone.val(), "ia": activate}},
                method: 'POST',
                success: function(res){
                    var itm = JSON.parse(res);

                    if(itm[0]['flag'] === 0){ title = "Error Occurred"; } else { title = "Success" ;}
                    
                    modNCustTitle.empty().append(title);
                    modNCustBody.empty().append(getCustomMsgBody(itm[0]['flag'], itm[0]['msg']));
                    modNCust.modal('show'); 

                    loadCustomers(txtFindCust.val());
                },
                error: function(){
                    console.log('failed');
                }
            });
        }
    }

    // End Customers

    // Job Orders and Details
    // Job Orders
    var tblJO = $('#tJO');
    var tblJoCount = $('#JOCount');
    var joId = $('#joid');
    var joCust = $('#jocust');
    var joCode = $('#jocode');
    var joDesc = $('#jodesc');
    var joFind = $('#findjo');
    var modJO = $('#modJO');
    var modJOTitle = $('#modJOTitle');

    // Details
    var tblJD = $('#tJOD');
    var tblJDCount = $('#JODCount');
    var jodId = $('#jodid');
    var jodJo = $('#jodjo');
    var jodCode = $('#jodno');
    var jodPNo = $('#jodpno');
    var jodDesc = $('#joddesc');
    var jodFind = $('#findjod');
    var modJOD  = $('#modJOD');
    var modJODTitle = $('#modJODTitle');

    var modJONotify = $('#modJONotify');
    var modJONotifyTitle = $('#modJONotifyTitle');
    var modJONotifyBody = $('#modJONotifyBody');

    $(document).on("click", "[name='modifyJO']", function(){
        loadJOInfo($(this).attr("id"));
    });

    $(document).on("click", "[name='deleteJO']", function(){
        DeRegisterJO($(this).attr("id"), 0);
    });

    $(document).on("click", "[name='linkJO']", function(){
        loadJOItem($(this).attr("id"));
        //console.log($(this).attr("id"));
    });

    $(document).on("keydown", "#findjo", function(){
        loadJOs($(this).val());
    });

    $(document).on("click", "[name='JOSave']", function(){
        if(joCode.val().length === 0){
            modJONotifyTitle.empty().append('Error');
            modJONotifyBody.empty().append(getCustomMsgBody(0, "[Code] is a mandatory field. Please supply a valid value then try again."));
            modJONotify.modal('show');
            return;
        }

        if(joDesc.val().length === 0){
            modJONotifyTitle.empty().append('Error');
            modJONotifyBody.empty().append(getCustomMsgBody(0, "[Description] is a mandatory field. Please supply a valid value then try again."));
            modJONotify.modal('show');
            return;
        }

        if(joId.val() === 0){
            if(confirm("Save new job order? Click Ok to confirm.") === true){
                DeRegisterJO(joId.val(), 1);
            }
        } else {
            if(confirm("Save changes to job order? Click Ok to confirm.") === true){
                DeRegisterJO(joId.val(), 1);
            }
        }

        

    });

    $(document).on("click", "[name='JOCancel']", function(){
        joId.val("0");
        joCode.val("");
        joDesc.val("");
    });

    $(document).on("click", "[name='modifyJOD']", function(){
        loadJODInfo($(this).attr("id"));
    });

    $(document).on("click", "[name='deleteJOD']", function(){
        DeRegisterJODetails($(this).attr("id"), 0);
    });

    $(document).on("keydown", "#findjod", function(){
        loadJOItem(0, $(this).val());
    });

    $(document).on("click", "[name='JODSave']", function(){

        if(jodJo.val() === 0){
            modJONotifyTitle.empty().append('Error');
            modJONotifyBody.empty().append(getCustomMsgBody(0, "[JO Item Code] is a mandatory field. Please select a value from the available options then try again."));
            modJONotify.modal('show');
            return;
        }

        if(jodCode.val().length === 0){
            modJONotifyTitle.empty().append('Error');
            modJONotifyBody.empty().append(getCustomMsgBody(0, "[JO Item Code] is a mandatory field. Please supply a valid value then try again."));
            modJONotify.modal('show');
            return;
        }

        if(jodPNo.val().length === 0){
            modJONotifyTitle.empty().append('Error');
            modJONotifyBody.empty().append(getCustomMsgBody(0, "[Part Number] is a mandatory field. Please supply a valid value then try again."));
            modJONotify.modal('show');
            return;
        }

        if(jodDesc.val().length === 0){
            modJONotifyTitle.empty().append('Error');
            modJONotifyBody.empty().append(getCustomMsgBody(0, "[Description] is a mandatory field. Please supply a valid value then try again."));
            modJONotify.modal('show');
            return;
        }

        DeRegisterJODetails(jodId.val(), 1);

    });

    $(document).on("click", "[name='JODCancel']", function(){
        jodId.val("0");
        jodJo.val(0);
        jodCode.val("");
        jodPNo.val("");
        jodDesc.val("");
    });

    function loadJOs(find = ''){
        if(tblJO.length > 0){
            $.ajax({
                url: '/admin/loadjobs',
                data: {"data" : {"lt": 1, "joid": 0, "find": find}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        for(i = 0; i <= itm.length - 1; i++){
                            html += '<tr>' +
                                        '<td style="text-align: center; vertical-align: middle;">' +
                                            '<a href="#" name="modifyJO" id="' + itm[i]["joid"] + '" class="btn"><i class="far fa-edit" data-toggle="tooltip" data-placement="top" title="Modify"></i></a>' +
                                            '<a href="#" name="deleteJO" id="' + itm[i]["joid"] + '" class="btn"><i class="far fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>' +
                                            '<a href="#" name="linkJO"   id="' + itm[i]['joid'] + '" class="btn"><i class="fas fa-link" data-toggle="tooltip" data-placement="top" title="Order Items"></i></a>' +
                                        '</td>' +
                                        '<td style="vertical-align: middle;">' + itm[i]["orderno"] + '</td>' +
                                        '<td style="vertical-align: middle;">' + itm[i]["orderdesc"] + '</td>' +
                                    '</tr>';
                        }                        
                    } else {
                        html = '<tr><td colspan="4" align="center"> - No data available -</td></tr>';
                    }

                    tblJO.empty().append(html);
                    $('#JOCount').empty().append('Total Job Order(s) : ' + itm.length);
                },
                error: function(){
                    console.log('failed');
                }
            });
        }
    }

    function loadJOItem(jid = 0, find = ''){
        if(tblJD.length > 0){
            $.ajax({
                url: '/admin/loadorders',
                data: {"data" : {"lt": 1, "jdid": 0, "joid": jid, "find": find}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        for(i = 0; i <= itm.length - 1; i++){
                            html += '<tr>' +
                                        '<td style="text-align: center; vertical-align: middle;">' +
                                            '<a href="#" name="modifyJOD" id="' + itm[i]["jdid"] + '" class="btn"><i class="far fa-edit" data-toggle="tooltip" data-placement="top" title="Modify"></i></a>' +
                                            '<a href="#" name="deleteJOD" id="' + itm[i]["jdid"] + '" class="btn"><i class="far fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>' +
                                        '</td>' +
                                        '<td style="vertical-align: middle;">' + itm[i]["orderno"] + '</td>' +
                                        '<td style="vertical-align: middle;">' + itm[i]["jobno"] + '</td>' +
                                        '<td style="vertical-align: middle;">' + itm[i]["partdesc"] + '</td>' +
                                    '</tr>';
                        }                        
                    } else {
                        html = '<tr><td colspan="4" align="center"> - No data available -</td></tr>';
                    }

                    tblJD.empty().append(html);
                    tblJDCount.empty().append('Total Job Order(s) : ' + itm.length);
                },
                error: function(){
                    console.log('failed');
                }
            });
        }        
    }

    function loadJOInfo(id = 0){
        if(tblJO.length > 0){
            $.ajax({
                url: '/admin/loadjobs',
                data: {"data" : {"lt": 2, "joid": id, "find": ""}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    console.log(itm);
                    
                    if(itm.length > 0){
                        for(i = 0; i <= itm.length - 1; i++){
                            joId.val(itm[i]["joid"]);
                            joCode.val(itm[i]["orderno"]);
                            joDesc.val(itm[i]["orderdesc"]);
                            modJO.modal('show');
                            modJOTitle.empty().append("Modify Job Order");
                        }                        
                    }
                },
                error: function(){
                    console.log('failed');
                }
            });
        }
    }

    function loadJODInfo(id = 0){
        if(tblJD.length > 0){
            $.ajax({
                url: '/admin/loadorders',
                data: {"data" : {"lt": 2, "jdid": id, "joid": 0, "find": ""}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    
                    if(itm.length > 0){
                        for(i = 0; i <= itm.length - 1; i++){
                            jodId.val(itm[0]["jdid"]);
                            jodJo.val(itm[0]["orderid"]);
                            jodCode.val(itm[0]["jobno"]);
                            jodPNo.val(itm[0]["partno"]);
                            jodDesc.val(itm[0]["partdesc"]);
                            modJOD.modal('show');
                            modJODTitle.empty().append("Modify Order Item");
                        }                       
                    }
                },
                error: function(){
                    console.log('failed');
                }
            });
        } 
    }

    function loadJOtoJOD(){
        if(tblJO.length > 0){
            $.ajax({
                url: '/admin/loadjobs',
                data: {"data" : {"lt": 0, "joid": 0, "find": ""}},
                method: 'GET',
                success: function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    
                    if(itm.length > 0){
                        html += '<option selected="selected" value="0">- Select a Job Order -</option>';
                        for(i = 0; i <= itm.length - 1; i++){
                            html += '<option value="' + itm[i]['joid']+ '">' + itm[i]['jodesc'] + '</option>';
                        }                        
                    } else {
                        html = '<option selected="selected" value="0">- No available options -</option>';
                    }
                    jodJo.empty().append(html);
                },
                error: function(){
                    console.log('failed');
                }
            });
        }
    }

    function DeRegisterJO(id = 0, activate = 1){
        if(tblJO.length > 0){
            $.ajax({
                url: '/admin/regjob',
                data: {"data" : {"id": id, "jn": joCode.val(), "jd": joDesc.val(), "ia": activate}},
                method: 'POST',
                success: function(res){
                    var itm = JSON.parse(res);

                    if(itm[0]['flag'] === 0){ title = "Error Occurred"; } else { title = "Success" ;}
                    
                    modJONotifyTitle.empty().append(title);
                    modJONotifyBody.empty().append(getCustomMsgBody(itm[0]['flag'], itm[0]['msg']));
                    modJONotify.modal('show'); 

                    loadJOs(joFind.val());
                    loadJOtoJOD();
                },
                error: function(){
                    console.log('failed');
                }
            });
        }       
    }

    function DeRegisterJODetails(id = 0, activate = 1){
        if(tblJO.length > 0){
            $.ajax({
                url: '/admin/regorders',
                data: {"data" : {"id": id, "oid": jodJo.val(), "jn": jodCode.val(), "pn": jodPNo.val(), "pd": jodDesc.val(), "ia": activate}},
                method: 'POST',
                success: function(res){
                    var itm = JSON.parse(res);

                    if(itm[0]['flag'] === 0){ title = "Error Occurred"; } else { title = "Success" ;}
                    
                    modJONotifyTitle.empty().append(title);
                    modJONotifyBody.empty().append(getCustomMsgBody(itm[0]['flag'], itm[0]['msg']));
                    modJONotify.modal('show'); 

                    loadJOItem();
                },
                error: function(){
                    console.log('failed');
                }
            });
        } 
    }



    // End Job Orders and Details



    // Initialisation

    if(tblDept.length > 0){
        loadDepartments();
        loadDeptLeads();
        loadDeptToDropdown();  
        loadDWCList(-1);
    }   

    if(tblWG.length > 0) {
        loadWorkGroups();
        loadEmployeesToWGDropdown();
        loadWorkgrouptoDropdown();
        loadEmployeesToAddToWG();
        loadApprovers();
        loadDeptApprovers();
    }

    if(tblWS.length > 0){
        loadShifts();
    }

    if(tblWC.length > 0){
        loadWorkCenters();
    }

    if(tAct.length > 0){
        loadworkcenterstoactivitydd();
        loadactivity(selAWC.val());
    }

    if(tblEmp.length > 0){
        loademployees();
        loadrolestoemployees();
        loaddeptonemployees();
        loadshifttoemployees();
    
        $('#dthired, #dtleft').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        }).css({"cssText" : "z-index:9999 !important;"});
        
    }

    if(tblRoles.length > 0){
        loadRoles();
    }

    if(tblCust.length > 0){
        loadCustomers();
    }

    if(tblJO.length > 0 || tblJD.length > 0){
        loadJOs();
        loadJOItem();
        loadJOtoJOD();
    }

    if($('[name="logEx"]').length > 0){
        $('#cutoffstart, #cutoffend').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        }).css({"cssText" : "z-index:9999 !important;"});
    }

    // End Initialisation

    // General Functions
    function getCustomMsgBody(flag, msg){
        var html = "";
        var icon = "";

        if(flag === 1){
            icon = "<i class='fas fa-info-circle fa-7x' style='color: #14BA19;'></i>";
        }
        else {
            icon = "<i class='fas fa-exclamation-triangle fa-7x' style='color: #EC2A2A;'></i>";
        }

        html = '<div class="row">' +
                    '<div class="col-3">' +
                        icon +
                    '</div>' +
                    '<div class="col">' +
                        '<p class="mt-4">' +  msg + '</p>' +
                    '</div>' +
                '</div>';
        
        return html;
    }


    // End General Functions
 

});