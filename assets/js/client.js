$(function(){

    var modLogN = $('#modLogNotify'), modLogNTitle = $('#modLogNotifyTitle', modLogNBody = $('#modLogNotifyBody'));
    var empId = $('[name="empid"]'), empPw = $('[name="emppw"]');
    var btnLogin = $('[name="btnlogin"]');

    var ofcClock = $('#logctrl');

    var jobOrder = $('#myjobord'), gjobOrder = $('#mygjobord');
    var jobSubOrd = $('#myjobjob'), gjobSubOrd = $('#mygjobjob');
    var jobWC = $('#myjobwc'), gjobWC = $('#mygjobwc');
    var jobWCA = $('#myjobact'), gjobWCA = $('#mygjobact');
    var jobGrp = $('#modgrplist');

    var jobData = $('#myjobdata'), gjobData = $('#mygjobdata');

    var jNew = $('#jmodnew'), jNotify = $('#jobNotify'), jNotifyTitle = $('#jobNotifyTitle'), jNotifyBody = $('#jobNotifyBody');
    var jgNotify = $('#jgNotify'), jgNotifyTitle = $('#jgNotifyTitle'), jgNotifyBody = $('#jgNotifyBody');

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

        validateUser(empId.val(), empPw.val());
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
            url: "/jobtracker/login",
            data: {"data": {"lid": lid, "pwd": pwd}},
            method: "POST",
            success: function(res){
                var itm = JSON.parse(res);
                if(itm["flag"] === false){
                    modLogNTitle.empty().append('Error Logging In');
                    modLogNBody.empty().append(getCustomMsgBody(0, itm["message"]));
                    modLogN.modal('show');
                    return; 
                } else {
                    window.location.redirect = "/";
                    window.location.reload();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
                alert(errorThrown);
            }
        });
    }

    $(document).on("click", "[name='resetpwd']", function(e){
        e.preventDefault();

        if($('[name="opwd"]').val().length === 0){
            modLogNTitle.empty().append("Error : Change Password");
            modLogNBody.empty().append(getCustomMsgBody(0, "Please input your old password."));
            modLogN.modal('show');
            return;
        }

        if($('[name="npwd"]').val().length === 0){
            modLogNTitle.empty().append("Error : Change Password");
            modLogNBody.empty().append(getCustomMsgBody(0, "Please input your new password."));
            modLogN.modal('show');
            return;
        }

        if($('[name="cpwd"]').val().length === 0){
            modLogNTitle.empty().append("Error : Change Password");
            modLogNBody.empty().append(getCustomMsgBody(0, "Please confirm your new password."));
            modLogN.modal('show');
            return;
        }

        if($('[name="cpwd"]').val() !== $('[name="npwd"]').val()){
            modLogNTitle.empty().append("Error : Change Password");
            modLogNBody.empty().append(getCustomMsgBody(0, "Password does not match"));
            modLogN.modal('show');
            return;
        }

        $.ajax({
            url: 'jobtracker/changepassword',
            method: 'POST',
            data: {"data" : {"npwd" : $("[name='npwd']").val()}},
            success : function(res){
                    var itm = JSON.parse(res);

                    modLogNTitle.empty().append('Success : Change Password');
                    modLogNBody.empty().append(getCustomMsgBody(1, 'Password change successful. Please login again.'));
                    modLogN.modal('show');
                    
            },
            error : function(jqXHR, textStatus, errorThrown){
                modLogNTitle.empty().append(textStatus);
                modLogNBody.empty().append(getCustomMsgBody(0, errorThrown));
                modLogN.modal('show');
            }
        });
    });

    $(document).on("click", "[name='closeModal']", function(){
        window.location.reload();
    });

    $(document).on("click", "[name='clockStamp']", function(){
        var selid = $(this).attr("id");

        if(selid === "0"){
            updatetimesheet($(this).attr("id"));
            updatelogstatus();
        } else if (selid === "3" && $('#0').length === 0){
            updatetimesheet($(this).attr("id"));
            updatelogstatus();
        } else {
            updatelogstatus();
        }

    });

    function updatetimesheet(lt = 0){
        $.ajax({
            url     : "/jobtracker/logtimesheet",
            data    : {"data": {"lt": lt}},
            method  : 'POST',
            success : function(res){
                var itm = JSON.parse(res);
                window.location.reload();
            },
            error   : function(jqXHR, textStatus, errorThrown){
                alert(errorThrown);
            }

        });
    }

    function updatelogstatus(){
        $.ajax({
            url     : "/jobtracker/updatestatus",
            method  : 'GET',
            success : function(res){
                var itm = JSON.parse(res);
                var html = '';

                if(itm.length > 0){

                    if(itm[0]['t0'] === 1 && itm[0]['t3'] === 1){
                        html += "<h4 style='text-align: center; margin-bottom: 10%; color:whitesmoke;'>You've already completed your tasks for the day "+ itm[0]['ename'] + ". Have a nice day!</h4>";
                        if($('#dpMy').length > 0){ $('#dpMy').hide()}
                    } else {
                        html += "<h4 style='text-align: center; margin-bottom: 10%; color:whitesmoke;'>Welcome back "+ itm[0]['ename'] + "!</h4>";
                        if(itm[0]['t0'] === 0){
                            $('#dpMy').hide();
                        } else {
                            $('#dpMy').show();
                        }
                    }

                    html += itm[0]['t0'] === 0 ? '<button id="0" name="clockStamp" class="btn btn-outline-light mr-1">Time In</button>' : '';
                    //html += itm[0]['t1'] === 0 ? '<button id="1" name="clockStamp" class="btn btn-outline-light mr-1">Out for Lunch</button>' : '';
                    //html += itm[0]['t2'] === 0 ? '<button id="2" name="clockStamp" class="btn btn-outline-light mr-1">Back from Lunch</button>' : '';
                    html += itm[0]['t3'] === 0 ? '<button id="3" name="clockStamp" class="btn btn-outline-light mr-1">Time Out</button>' : ''; 
                    //window.location.reload();
                }

                ofcClock.empty().append(html);

            },
            error   : function(jqXHR, textStatus, errorThrown){
                alert(errorThrown);
            }

        });
    }

    $(document).on("click", "#logout", function(e){
        e.preventDefault();
        $.ajax({
            url: '/jobtracker/logout',
            method: 'POST',
            data: {"data": $(this).attr('id')},
            success: function(res){
                var itm = JSON.parse(res);
                if(itm[0] == true){
                    window.location.redirect = "/";
                    window.location.reload();
                } else {
                    alert(itm[1]);
                    return false;
                }
            },
            error: function(){
                console.log('failed');
            }
        });
    });

    function loadorders(){
        if(jobOrder.length > 0 || gjobOrder.length > 0){
            $.ajax({
                url     : "/jobtracker/loadJOs",
                data    : {"data": {"lt": 0}},
                method  : "GET",
                success : function(res){
                    var itm = JSON.parse(res);
                    var html = "";

                    if(itm.length > 0){
                        html += "<option value='0' selected>- Select a Job Order -</option>";
                        for(i=0; i <= itm.length - 1; i++){
                            html += "<option value='" + itm[i]['joid'] + "'>" +  itm[i]['jodesc'] + "</option>";
                        }
                    } else {
                        html += "<option value='0' selected>- No available options -</option>";
                    }

                    jobOrder.length > 0 ? jobOrder.empty().append(html) : gjobOrder.empty().append(html);
                },
                error   : function(jqXHR, textStatus, errorThrown){
                    alert(errorThrown);
                }
            });
        }
    }

    $(document).on("change", "#myjobord", function(){
        loadjobs($(this).val());
        $('#myjobwc').val(0);
        loadwcactivity(0);
    });

    $(document).on("change", "#mygjobord", function(){
        loadjobs($(this).val());
        $("#mygjobwc").val(0);
        loadwcactivity(0);
    });

    function loadjobs(orderId = 0){
        if(jobSubOrd.length > 0 || gjobSubOrd.length > 0){
            $.ajax({
                url     : "/jobtracker/loadJODetails",
                data    : {"data": {"lt": 0, "jid": orderId}},
                method  : "GET",
                success : function(res){
                    var itm = JSON.parse(res);
                    var html = '';

                    if(itm.length > 0){
                        html += "<option value='0' selected>- Select a Charge Center -</option>";
                        for(i=0; i <= itm.length - 1; i++){
                            html += "<option value='" + itm[i]['jdid'] + "'>" +  itm[i]['jobno'] + "</option>";
                        }
                    } else {
                        html += "<option value='0' selected>- No available options -</option>"; 
                    }

                    jobSubOrd.length > 0 ? jobSubOrd.empty().append(html) : gjobSubOrd.empty().append(html);

                },
                error   : function(jqXHR, textStatus, errorThrown){
                    alert(errorThrown);
                }
            });
        }
    }

    function loadworkcenters(){
        if(jobWC.length > 0 || gjobWC.length > 0){
            $.ajax({
                url     : "/jobtracker/loadworkcenters",
                data    : {"data": {"lt": 0}},
                method  : "GET",
                success : function(res){
                    var itm = JSON.parse(res);
                    var html = '';

                    if(itm.length > 0){
                        if(itm.length === 1){
                            for(i=0; i <= itm.length - 1; i++){
                                html += "<option value='" + itm[i]['wcid'] + "' selected>" +  itm[i]['wc'] + "</option>";
                                loadwcactivity(itm[i]['wcid']);
                            }
                        } else {
                            html += "<option value='0' selected>- Select a Work Center -</option>";
                            for(i=0; i <= itm.length - 1; i++){
                                html += "<option value='" + itm[i]['wcid'] + "'>" +  itm[i]['wc'] + "</option>";
                            }
                        }

                    } else {
                        html += "<option value='0' selected>- No available options -</option>";
                    }

                    jobWC.length > 0 ? jobWC.empty().append(html) : gjobWC.empty().append(html);

                },
                error   : function(jqXHR, textStatus, errorThrown){
                    alert(errorThrown);
                }
            });
        }
    }

    $(document).on("change", "#myjobwc", function(){
        if(parseInt($("#myjobord").val()) === 3 || parseInt($("#myjobord").val()) === 4){
            loadnonworkactivity($("#myjobord").val());
        } else {
            loadwcactivity($(this).val());
        }
    });

    $(document).on("change", "#mygjobwc", function(){
        if($("#mygjobord").val() === "3" || $("#mygjobord").val() === "4"){
            loadnonworkactivity($("#mygjobord").val());
        } else {
            loadwcactivity($(this).val());
        }
    });

    function loadwcactivity(wcid = 0){
        if(jobWCA.length > 0 || gjobWCA.length > 0){
            $.ajax({
                url     : "/jobtracker/loadactivity",
                data    : {"data": {"lt": 0, "wcid": wcid}},
                method  : "GET",
                success : function(res){
                    var itm = JSON.parse(res);
                    var html = '';

                    if(itm.length > 0){
                            html += "<option value='0' selected>- Select an Activity -</option>";
                            for(i=0; i <= itm.length - 1; i++){
                                html += "<option value='" + itm[i]['actid'] + "'>" +  itm[i]['ac'] + "</option>";
                            }
                    } else {
                        html += "<option value='0' selected>- No available options -</option>";
                    }

                    jobWCA.length > 0 ? jobWCA.empty().append(html) : gjobWCA.empty().append(html);
                },
                error   : function(jqXHR, textStatus, errorThrown){
                    alert(errorThrown);
                }
            });
        }
    }

    function loadnonworkactivity(jid = 0){
        $.ajax({
            url     : '/jobtracker/loadnonactivity',
            method  : 'GET',
            data    : {"data" : {"jid": jid}},
            success : function(res){
                var itm = JSON.parse(res);
                var html = "";

                if(itm.length > 0){
                    html += "<option value='0' selected>- Select an Activity -</option>";
                    for(i=0; i <= itm.length - 1; i++){
                        html += "<option value='" + itm[i]['actid'] + "'>" +  itm[i]['ac'] + "</option>";
                    }
                } else {
                    html += "<option value='0' selected>- No available options -</option>";
                }

                jobWCA.length > 0 ? jobWCA.empty().append(html) : gjobWCA.empty().append(html);
            },
            error   : function(jqXHR, textStatus, errorThrown){
                alert(errorThrown);
            }
        });
    }

    function loadmyjobs(){
        if(jobData.length > 0){
            $.ajax({
                url     : "/jobtracker/jobsheet",
                method  : "GET",
                success : function(res){
                    var itm = JSON.parse(res);
                    var html = '', JCBtns = '';
                    var totalhrs = 0;

                    if(itm.length > 0){
                        for(i=0; i <= itm.length - 1; i++){
                            if(itm[i]["timeend"] === null){
                                html += "<tr class='fa-inverse border-bottom font-weight-bold bg-danger'>" +
                                            "<td class='text-center'>" + itm[i]["jobdate"] + "</td>" + 
                                            "<td class='text-center'>" + itm[i]["wccode"] + "</td>" + 
                                            "<td class='text-center'>" + itm[i]["actcode"] + "</td>" + 
                                            "<td class='text-center'>" + itm[i]["orderno"] + "</td>" + 
                                            "<td class='text-center'>" + itm[i]["jobno"] + "</td>" + 
                                            "<td class='text-center'>" + itm[i]["timestart"] + "</td>" + 
                                            "<td class='text-center'>" + itm[i]["timeend"] + "</td>" + 
                                            "<td class='text-right'>" + itm[i]["cyclehrs"] + "</td>" + 
                                        "</tr>";
                            }
                            else {
                                html += "<tr class='fa-inverse border-bottom bg-success'>" +
                                            "<td class='text-center'>" + itm[i]["jobdate"] + "</td>" + 
                                            "<td class='text-center'>" + itm[i]["wccode"] + "</td>" + 
                                            "<td class='text-center'>" + itm[i]["actcode"] + "</td>" + 
                                            "<td class='text-center'>" + itm[i]["orderno"] + "</td>" + 
                                            "<td class='text-center'>" + itm[i]["jobno"] + "</td>" + 
                                            "<td class='text-center'>" + itm[i]["timestart"] + "</td>" + 
                                            "<td class='text-center'>" + itm[i]["timeend"] + "</td>" + 
                                            "<td class='text-right'>" + itm[i]["cyclehrs"] + "</td>" + 
                                        "</tr>";
                            }

                            totalhrs += parseFloat(itm[i]["cyclehrs"]);
                        }

                        if(itm[itm.length - 1]["timeend"] === null){
                            JCBtns = '<a href="#" name="jobClockOut" class="btn btn-primary mb-2" data-toggle="modal" id="jclockout">Clock-out from current Job</a>';
                        } else {
                            JCBtns = '<a href="#" name="jobClockIn" class="btn btn-primary mb-2" data-toggle="modal" data-target="#jmodnew">Clock-in to a Job</a>';
                        }

                    } else {
                        html += "<tr class='fa-inverse border-bottom'><td colspan='8' align='center'>- No data available -</td></tr>";
                        JCBtns = '<a href="#" name="jobClockIn" class="btn btn-primary mb-2" data-toggle="modal" data-target="#jmodnew">Clock-in to a Job</a>';
                    }

                    if(jobData.length > 0){ jobData.empty().append(html); } 
                    $('#totaljobhrs').empty().append('Total hours worked on job(s) : <label style="color:#0FAE05;">' + ((totalhrs * 100)/100).toFixed(2) + '</label> hour(s)');
                    $("#CIOButtons").empty().append(JCBtns);
                },
                error   : function(jqXHR, textStatus, errorThrown){
                    alert(errorThrown);
                }
            });
        }
    }

    $(document).on("click", "#jclockin", function(){
        if(jobOrder.val() === "0"){
            jNotifyTitle.empty().append('Error');
            jNotifyBody.empty().append(getCustomMsgBody(0, "Unable to process job clock in/out request. Please select a valid Job/Workfront then try again."));
            jNotify.modal('show');
            return;
        }

        if(jobWC.val() === "0"){
            jNotifyTitle.empty().append('Error');
            jNotifyBody.empty().append(getCustomMsgBody(0, "Unable to process job clock in/out request. Please select a valid Work Center then try again."));
            jNotify.modal('show');
            return;
        }

        if(confirm("Proceed in clocking in to job? Click OK to confirm.") === true){
            clockinoutjob(0);
            loadmyjobs();
            jobOrder.val(0);
            jobWC.val(0);
        } 

    });

    $(document).on("click", "#jclockout", function(){
        clockinoutjob(1);
        loadmyjobs();
    });

    $(document).on("click", "[name='nConfirm']", function(){
        jNew.modal('hide');
    });

    $(document).on("click", "[name='jobCIO']", function(){
        if(jobOrder.val() === "0" && $(this).attr("id") === "0"){
            jNotifyTitle.empty().append('Error');
            jNotifyBody.empty().append(getCustomMsgBody(0, "Unable to process job clock in/out request. Please select a valid Job/Workfront then try again."));
            jNotify.modal('show');
            return;
        }

        clockinoutjob($(this).attr("id"));
    });

    $(document).on("click", "[name='amclear']", function(){
        loadmembersinjob(0);
    });

    $(document).on("click", '#jccancel', function(){
        $('#myjobord').val(0);
        $('#myjobjob').val(0);
        $("#myjobwc").val(0);
        $('#myjobact').val(0);
    });

    function clockinoutjob(jt = 0){
        if(jobWCA.length > 0 || gjobWCA.length > 0){
            $.ajax({
                url     : "/jobtracker/logjob",
                data    : {"data": {"jt": jt, "wc": jobWC.val(), "act": jobWCA.val(), "ord": jobOrder.val(), "job": jobSubOrd.val()}},
                method  : "POST",
                success : function(res){
                    var itm = JSON.parse(res);
                    
                    if(itm.length > 0){
                        if(itm[0].flag === 0) { jNotifyTitle.empty().append("Error Occurred"); } else { jNotifyTitle.empty().append("Success"); }
                        jNotifyBody.empty().append(getCustomMsgBody(itm[0].flag, itm[0].msg));
                        jNotify.modal('show');
                    } else {
                        jNotifyTitle.empty().append('Error');
                        jNotifyBody.empty().append(getCustomMsgBody(0, "Unable to process job clock in/out request. Please contact your System Administrator"));
                        jNotify.modal('show');
                    }
                    loadmyjobs();
                    jobWC.val(0);
                    loadwcactivity(0);
                    jobOrder.val(0);
                    loadjobs(0);
                },
                error   : function(jqXHR, textStatus, errorThrown){
                    alert(errorThrown);
                }
            });
        }
    }

    function loadmygroups(){
        if($('[name="mygroups"]').length > 0){
            $.ajax({
                url     : "/jobtracker/loadgroups",
                method  : "GET",
                success : function(res){
                    var itm = JSON.parse(res);
                    var html = "";
                    var opts = "";
    
                    if(itm.length > 0){
                        opts += '<option value="0" selected>- Select a group -</option>';
                        for(i = 0; i <= (itm.length -1); i++){
                            html += '<a id="'+ itm[i]['gid'] +'" href="#" name="groupnm" class="list-group-item list-group-item-action mb-1">' +
                                        '<span class="badge badge-success mr-1" style="font-size: 14px;">'+ itm[i]['available']+'</span>' +
                                        '<span class="badge badge-danger mr-1" style="font-size: 14px;">'+ itm[i]['intask']+'</span>' +
                                        '<span class="badge badge-dark mr-3" style="font-size: 14px;">'+ itm[i]['onleave']+'</span>' +
                                        '<label>' + itm[i]['gn'] + '</label>' + 
                                    '</a>';

                            opts += '<option value="'+ itm[i]['gid']+'">'+ itm[i]['gn'] +'</option>';
                        } 
                    } else {
                        html += '<div class="list-group-item mb-1">- No available group(s) -</div>';
                        opts += '<option value="0" selected>- No available group(s) -</option>';
                    }

                    $('[name="grouplist"]').empty().append(html);
                    jobGrp.empty().append(opts);
                },
                error   : function(jqXHR, textStatus, errorThrown){
                    alert(errorThrown);
                }
    
            });
        } else {
            return;
        }
    }

    function loadgroupmembers(gid = 0){
        if($('[name="mygroups"]').length > 0){
            $.ajax({
                url     : "/jobtracker/loadgrpmembers",
                method  : "GET",
                data    : {"data":{"gid": gid}},
                success : function(res){
                    var itm = JSON.parse(res);
                    var html = "";
    
                    if(itm.length > 0){
                        for(i = 0; i <= (itm.length -1); i++){
                            if(itm[i]['inofc'] === 0 && itm[i]['intask'] === 0){
                                html += '<div class="list-group-item mb-1">' +
                                            '<span class="badge badge-dark badge-pill mr-2">&nbsp;</span>' + itm[i]['eln'] + ', ' + itm[i]['efn'] +
                                        '</div>';
                            } else if (itm[i]['inofc'] === 1 && itm[i]['intask'] === 0){
                                html += '<div class="list-group-item mb-1">' +
                                            '<span class="badge badge-success badge-pill mr-2">&nbsp;</span>' + itm[i]['eln'] + ', ' + itm[i]['efn'] +
                                        '</div>';
                            } else if (itm[i]['inofc'] === 0 && itm[i]['intask'] === 1){
                                html += '<div class="list-group-item mb-1">' +
                                            '<span class="badge badge-warning badge-pill mr-2">&nbsp;</span>' + itm[i]['eln'] + ', ' + itm[i]['efn'] +
                                        '</div>';
                            } else {
                                html += '<div class="list-group-item mb-1">' +
                                            '<span class="badge badge-danger badge-pill mr-2">&nbsp;</span>' + itm[i]['eln'] + ', ' + itm[i]['efn'] +
                                        '</div>';
                            }
                        }
                    } else {
                        html += '<div class="list-group-item mb-1">- No available group members -</div>';
                    }

                    $('[name="gmlist"]').empty().append(html);
                },
                error   : function(jqXHR, textStatus, errorThrown){
                    alert(errorThrown);
                }
    
            });
        } else {
            return;
        }        
    }

    function loadavailablegms(gid = 0){
        if($('[name="mygroups"]').length > 0){
            $.ajax({
                url     : "/jobtracker/loadavailablegms",
                method  : "GET",
                data    : {"data":{"gid": gid}},
                success : function(res){
                    var itm = JSON.parse(res);
                    var html = "";
    
                    if(itm.length > 0){
                        for(i = 0; i <= (itm.length -1); i++){
                            html += '<div class="list-group-item checkbox mb-1">' +
                                        '<label>' +
                                            '<input id="' + itm[i]['eid'] + '" type="checkbox" class="mr-2"> ' + itm[i]['enm'] +
                                        '</label>' +
                                    '</div>';
                        }
                    } else {
                        html += '<div class="list-group-item mb-1">- No available group members -</div>';
                    }

                    $('[name="gmslist"]').empty().append(html);
                },
                error   : function(jqXHR, textStatus, errorThrown){
                    alert(errorThrown);
                }
    
            });
        } else {
            return;
        }        
    }

    $(document).on("click", "[name='grefresh']", function(){
        loadmygroups();
        loadgroupmembers(0);
        $('[name="groupsnm"]').empty();
    });

    $(document).on("click", "[name='gmclear']", function(){
        loadgroupmembers(0);
    });

    $(document).on("click", "[name='groupnm']", function(){
        var grpnm = $(this).html();
            grpnm = 'Members - ' + grpnm.substring(grpnm.indexOf('<label>') + 7, grpnm.indexOf("</label>")) ;
        
        loadgroupmembers($(this).attr("id"));
        $('[name="groupsnm"]').empty().append(grpnm);
    });

    $(document).on("keyup", "[name='gmsearch']", function(){
        var value = $(this).val().toLowerCase();
        $("[name='gmslist'] > .list-group-item").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $(document).on("click", "[name='gmsfindcancel']", function(){
        $('#gmsearch').val("");
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

    $(document).on("change", "#modgrplist", function(){
        loadavailablegms($(this).val());
    });

    $(document).on("click", "[name='gjNew']", function(){

        var selIds = [];
        
        if(gjobOrder.val() === "0"){
            jgNotifyTitle.empty().append("Error : Invalid Job");
            jgNotifyBody.empty().append(getCustomMsgBody(0, "Unable to register Group Job. Please select a valid Job Order then try again."));
            jgNotify.modal('show');
            return;
        }

        if(gjobWC.val() === 0){
            jNotifyTitle.empty().append("Error : Invalid Work Center");
            jNotifyBody.empty().append(getCustomMsgBody(0, "Unable to register Group Job. Please select a valid Work Center then try again."));
            jNotify.modal('show');
            return;
        }

        $('[name="gmslist"] > .list-group-item > label > input:checkbox:checked').each(function(){
            selIds.push($(this).attr("id"));
        });

        if(selIds.length === 0){
            jNotifyTitle.empty().append("Error : Insufficient Members");
            jNotifyBody.empty().append(getCustomMsgBody(0, "Unable to register Group Job. Please add at least 1 member to the job by ticking the checkbox beside the member\'s name then try again."));
            jNotify.modal('show');
            return;
        }

        if(confirm("Proceed in clocking in jobs for selected group member/s?") === true){
            loggroupjob(0, 0, selIds);
            gjobOrder.val(0);
            gjobSubOrd.val(0)
            gjobWC.val(0);
            gjobWCA.val(0);
            jobGrp.val(0);
            $('[name="gmslist"]').empty();
            $('[name="gmsearch"]').val("");
            loadgroupjobs();
        }
    });

    $(document).on("click", "[name='gjCancel']", function(){
        loadavailablegms(0);
    });

    $(document).on("click", "[name='viewGMs']", function(){
        loadmembersinjob($(this).attr("id"));
    });

    $(document).on("click", "[name='cOutJob']", function(){
        if(confirm("Are you sure you want to terminate job together with the members assigned to it?") === true){
            $.ajax({
                url     : "/jobtracker/clockoutgroup",
                method  : "POST",
                data    : {"data" : {"jid" : $(this).attr("id")}},
                success : function(res){
                    var itm = JSON.parse(res);
                    (itm[0]['flag'] > 0) ? jgNotifyTitle.empty().append('Success') : jgNotifyTitle.empty().append('Error');
                    jgNotifyBody.empty().append(getCustomMsgBody(itm[0]['flag'], itm[0]['msg']));
                    jgNotify.modal('show');
                    
                    loadgroupjobs();
                    loadmembersinjob(0);
                    loadmygroups();
                    loadgroupmembers(0);                    
                },
                error   : function(jqXHR, textStatus, errorThrown){
                    alert(errorThrown);
                }
            });


        }
    });

    $(document).on("click", "[name='cOutGM']", function(){
        if(confirm("Are you sure you want to clock-out member from assigned job?") === true){
            $.ajax({
                url     : "/jobtracker/clockoutmember",
                method  : "POST",
                data    : {"data" : {"mid" : $(this).attr("id")}},
                success : function(res){
                    var itm = JSON.parse(res);
                    (itm[0]['flag'] > 0) ? jgNotifyTitle.empty().append('Success') : jgNotifyTitle.empty().append('Error');
                    jgNotifyBody.empty().append(getCustomMsgBody(itm[0]['flag'], itm[0]['msg']));
                    jgNotify.modal('show');
                    
                    loadgroupjobs();
                    loadmembersinjob(0);
                    loadmygroups();x
                    loadgroupmembers(0);
                },
                error   : function(jqXHR, textStatus, errorThrown){
                    alert(errorThrown);
                }
            });
        }
    });

    function loggroupjob(cio = 0, jgid = 0, ids = []){
        $.ajax({
            url     : "/jobtracker/loggroupjob",
            method  : "POST",
            data    : {"data": {"typ": cio, "glid": jgid, "oi": gjobOrder.val(), "ji": gjobSubOrd.val() ,"wcid": gjobWC.val(), "acid": gjobWCA.val(), "members": ids}},
            success : function(res){
                var itm = JSON.parse(res);
                var jid = 0;
                var arrs = [];

                jid = itm[0]['id'];

                if(jid > 0){
                    for(i = 0; i <= (ids.length -1); i++){
                        $.ajax({
                            url     : "/jobtracker/logmembertojob",
                            method  : "POST",
                            data    : {"data" : {"typ" : cio, "jid" : jid, "emp" : ids[i]}},
                            success : function(r){
                                var obj = JSON.parse(r);
                                arrs.push(obj);
                            },
                            error   : function(jqXHR, textStatus, errorThrown){
                                alert(errorThrown);
                            }
                        });
                    }
                }

                (itm[0]['flag'] > 0) ? jgNotifyTitle.empty().append("Success : Group Jobs") : jgNotifyTitle.empty().append("Error : Group Jobs") ;
                jgNotifyBody.empty().append(getCustomMsgBody(itm[0]['flag'], itm[0]['msg']));
                jgNotify.modal('show');

                loadmygroups();
                loadgroupmembers(0);
                loadgroupjobs();
            },
            error   : function(jqXHR, textStatus, errorThrown){
                alert(errorThrown);
            }
        }); 
    }

    function loadgroupjobs(){
        if(gjobData.length > 0){
            $.ajax({
                url     : "/jobtracker/loadgroupjobs",
                method  : "GET",
                success : function(res){
                    var itm = JSON.parse(res);
                    var html = '';
                    var ttlhrs = 0;

                    if(itm.length > 0){
                            for(i=0; i <= itm.length - 1; i++){
                                if(itm[i]['mcount'] > 0){
                                    html += '<tr class="border-bottom bg-danger">' +
                                                '<td class="fa-inverse font-weight-bold text-center align-text-top">' +
                                                    '<a class="btn btn-sm" name="viewGMs" href="#" id="'+ itm[i]['id'] +'" role="button"><i class="fas fa-users fa-1x fa-inverse" data-toggle="tooltip" data-placement="top" title="View members in Job"></i></a>' +
                                                    '<a class="btn btn-sm" name="cOutJob" href="#" id="'+ itm[i]['id'] +'" role="button"><i class="fas fa-stopwatch fa-1x fa-inverse" data-toggle="tooltip" data-placement="top" title="Clock-out group from Job"></i></a>' +
                                                '</td>' +
                                                '<td class="fa-inverse font-weight-bold text-center align-text-bottom">' + itm[i]['workdate'] + '</td>' +
                                                '<td class="fa-inverse font-weight-bold text-center align-text-bottom">' + itm[i]['wccode'] + '</td>' +
                                                '<td class="fa-inverse font-weight-bold text-center align-text-bottom">' + itm[i]['actcode'] + '</td>' +
                                                '<td class="fa-inverse font-weight-bold text-center align-text-bottom">' + itm[i]['orderno'] + '</td>' +
                                                '<td class="fa-inverse font-weight-bold text-center align-text-bottom">' + itm[i]['jobno'] + '</td>' +
                                                '<td class="fa-inverse font-weight-bold text-center align-text-bottom">' + itm[i]['ts'] + '</td>' +
                                                '<td class="fa-inverse font-weight-bold text-center align-text-bottom">' + itm[i]['te'] + '</td>' +
                                                '<td class="fa-inverse font-weight-bold text-right align-text-bottom">' + itm[i]['cyclehrs'] + '</td>' +
                                            '</tr>';    
                                } else {
                                    html += '<tr class="border-bottom bg-success">' +
                                                '<td class="fa-inverse font-weight-bold text-center align-text-top"><i class="fas fa-check fa-1x" data-toggle="tooltip" data-placement="top" title="Job done!"></i></td>' +
                                                '<td class="fa-inverse font-weight-bold text-center align-text-bottom">' + itm[i]['workdate'] + '</td>' +
                                                '<td class="fa-inverse font-weight-bold text-center align-text-bottom">' + itm[i]['wccode'] + '</td>' +
                                                '<td class="fa-inverse font-weight-bold text-center align-text-bottom">' + itm[i]['actcode'] + '</td>' +
                                                '<td class="fa-inverse font-weight-bold text-center align-text-bottom">' + itm[i]['orderno'] + '</td>' +
                                                '<td class="fa-inverse font-weight-bold text-center align-text-bottom">' + itm[i]['jobno'] + '</td>' +
                                                '<td class="fa-inverse font-weight-bold text-center align-text-bottom">' + itm[i]['ts'] + '</td>' +
                                                '<td class="fa-inverse font-weight-bold text-center align-text-bottom">' + itm[i]['te'] + '</td>' +
                                                '<td class="fa-inverse font-weight-bold text-right align-text-bottom">' + itm[i]['cyclehrs'] + '</td>' +
                                            '</tr>';
                                }
                                
                                ttlhrs += parseFloat(itm[i]['cyclehrs']);
                            }
                    } else {
                        html += '<tr class="border-bottom">' +
                                    '<td colspan="9" class="fa-inverse text-center">- No registered jobs -</td>' +
                                '</tr>';
                    }

                    gjobData.empty().append(html);
                    $('[name="gjstotals"]').empty().append(parseFloat(ttlhrs).toFixed(2));
                   
                },
                error   : function(jqXHR, textStatus, errorThrown){
                    alert(errorThrown);
                }
            });
        }
    }

    function loadmembersinjob(id = 0){
        $.ajax({
            url     : "/jobtracker/loadjobmembers",
            method  : "GET",
            data    : {"data" : {"jid" : id}},
            success : function(res){
                var itm = JSON.parse(res);
                var html = "";

                if (itm.length > 0){
                    for(i=0; i <= (itm.length - 1); i++){
                        html += '<div class="list-group-item mb-1">' +
                                    '<a href="#" id="' + itm[i]['id'] + '" name="cOutGM" class="btn btn-sm"><i class="fas fa-stopwatch fa-1x mr-2" data-toggle="tooltip" data-placement="top" title="Clock-out member from job."></i></a>' + itm[i]['enm'] +
                                '</div>';                        
                    }
                } else {
                    html += '<div class="list-group-item">Click the [ <i class="fas fa-users fa-1x"></i> ] icon to view members of a job.</div>';
                }

                $('[name="jmlist"]').empty().append(html);
                $('[name="gmtotals"]').empty().append(itm.length);
                
            },
            error   : function(jqXHR, textStatus, errorThrown){
                alert(errorThrown);
            }
        });
    }

    // Change Shift

    $(document).on("change", "#shiftfrom", function(){
        if($("#shiftfrom").val() > 0) {
            loadempsonshift($("#shiftfrom").val());
        }
    });

    $(document).on("change", "#shiftfrom", function(){
        loadempsonshift($(this).val());
    });

    $(document).on("keyup", "[name='gmsearch']", function(){
        var value = $(this).val().toLowerCase();
        $("[name='scelist'] > .list-group-item").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $(document).on("click", "[name='gmsfindcancel']", function(){
        $("[name='gmsearch']").val("");
    });

    $(document).on("click", "[name='sceselall']", function(){
        if($(this).text() === 'Select All'){
            $("[name='scelist'] > .list-group-item > label > input[type='checkbox']").each(function(){
                if($(this).prop("checked") === false){
                    $(this).prop("checked", true);
                }
            });
            $(this).text("De-select All");
        } else {
            $("[name='scelist'] > .list-group-item > label > input[type='checkbox']").each(function(){
                if($(this).prop("checked") === true){
                    $(this).prop("checked", false);
                }
            });
            $(this).text("Select All");
        }
    });

    $(document).on("change","input[type='checkbox']", function(){
        var elCnt = $("[name='scelist'] > .list-group-item > label > input[type='checkbox']").length;
        var chkCnt = $("[name='scelist'] > .list-group-item > label > input[type='checkbox']:checked").length;
        
        if(elCnt === chkCnt){
            $("[name='gmsselall']").text("De-select All");
        } else {
            $("[name='gmsselall']").text("Select All");
        }
    });

    $(document).on("click", "[name='csload']", function(){
        var df = new Date($("#wddtfrom").val());
        var dt = new Date($("wddtto").val());

        if($("#wddtfrom").val().length === 0 || $("#wddtto").val().length === 0){
            $("[name='csnotifytitle']").empty().append("Error");
            $("[name='csnotifybody']").empty().append(getCustomMsgBody(0, "Dates cannot be empty. Please select a valid date."));
            $("[name='csnotify']").modal('show');
            $("[name='csreset']").trigger("click");
            return;
        }

        if(df.getTime() > dt.getTime()){
            $("[name='csnotifytitle']").empty().append("Error");
            $("[name='csnotifybody']").empty().append(getCustomMsgBody(0, "Invalid date range supplied."));
            $("[name='csnotify']").modal('show');
            $("[name='csreset']").trigger("click");
            return;
        }

        loadchangeshifts();
    });

    $(document).on("click", "[name='csreset']", function(){
        var dt = new Date();
        var yr = dt.getFullYear();
        var mo = ((dt.getMonth() + 1).toString().length === 1) ? "0" + (dt.getMonth() + 1).toString() : dt.getMonth();
        var dy = (dt.getDate().toString().length === 1) ? "0" + dt.getDate().toString() : dt.getDate();
        var nd = yr + '-' + mo + '-' + dy;

        $('#wddtfrom, #wddtto').val(nd);

    });

    $(document).on("click", "[name='csNew']", function(){
        var selemp = $("[name='scelist'] > .list-group-item > label > input[type='checkbox']:checked").length;
        var emps = [];

        if($("#dtfrom").val().length === 0 || $("#dtto").val().length === 0){
            $("[name='csnotifytitle']").empty().append("Error : Change Shift");
            $("[name='csnotifybody']").empty().append(getCustomMsgBody(0, "Please enter a valid date range then try again."));
            $("[name='csnotify']").modal('show');
            return;
        }

        var dtf = new Date($("#dtfrom").val());
        var dtt = new Date($("#dtto").val());

        if(dtf.getTime() > dtt.getTime()){
            $("[name='csnotifytitle']").empty().append("Error : Change Shift");
            $("[name='csnotifybody']").empty().append(getCustomMsgBody(0, "Anti-dates are not allowed. Please enter a valid date range then try again."));
            $("[name='csnotify']").modal('show');
            return;            
        }

        if($("#shiftto").val() === 0){
            $("[name='csnotifytitle']").empty().append("Error : Change Shift");
            $("[name='csnotifybody']").empty().append(getCustomMsgBody(0, "Please select a shift from the available options."));
            $("[name='csnotify']").modal('show');
            return;
        }

        if($("#shiftfrom").val() === $("#shiftto").val()){
            $("[name='csnotifytitle']").empty().append("Error : Change Shift");
            $("[name='csnotifybody']").empty().append(getCustomMsgBody(0, "Please select a shift different from the employee's original shift then try again."));
            $("[name='csnotify']").modal('show');
            return;            
        }

        if(selemp === 0) {
            $("[name='csnotifytitle']").empty().append("Error : Change Shift");
            $("[name='csnotifybody']").empty().append(getCustomMsgBody(0, "Please select employee(s) you want to transfer to another shift."));
            $("[name='csnotify']").modal('show');
            return;
        }

        $("[name='scelist'] > .list-group-item > label > input[type='checkbox']:checked").each(function(){
            emps.push(parseInt($(this).attr("id")));
        });

        if(confirm("Are you sure you want to change the shift schedule of the selected employee(s)? Click Ok to proceed.") === true){
            registerChangeShift(emps);
        }
    });

    $(document).on("click", "[name='csCancel']", function(){
        $("[name='scelist']").empty();
        $("#dtfrom").val("");
        $("#dtto").val("");
        loadworkgroups();
        loadshifts();
    });

    $(document).on("click", "[name='delsc']", function(){
        if(confirm("Are you sure you want to cancel applied shift for the selected employee? Click Ok to proceed.") === true){
            $.ajax({
                url     : "/jobtracker/deletechangeshift",
                method  : "POST",
                data    : {"data" : {"csid" : $(this).attr("id")}},
                success : function(res) {
                    empresult.push({"flag" : 1, "msg" : "Change shift schedule for employee id [" + eids[i] + "] has been cancelled."});
                },
                error   : function(jqXHR, textStatus, errorThrown){
                    //alert(errorThrown);
                    empresult.push({"flag" : 0, "msg" : "Failed to change schedule for employee id [" + eids[i] + "]."});
                } 
            });
            

            loadchangeshifts();
        }
    });

    function loadworkgroups(){
        if($('[name="chngShift"]').length > 0){
            $.ajax({
                url     : "/jobtracker/loadworkgroups",
                method  : "GET",
                success : function(res){
                    var itm = JSON.parse(res);
                    var html = "";

                    if(itm.length > 0){
                        if(itm.length === 1){
                            html += '<option value="0">- Select a group -</option>';
                            html += '<option value="'+ itm[0]['wgid'] +'" selected>'+ itm[0]['grp'] +'</option>';
                        } else {
                            html += '<option value="0" selected>- Select a group -</option>';
                            for(i = 0; i <= (itm.length -1); i++){
                                html += '<option value="'+ itm[i]['wgid'] +'">'+ itm[i]['grp'] +'</option>';
                            }                            
                        }
 
                    } else {
                        html += '<option value="0" selected>- No available group(s) -</option>';
                    }

                    ($('#selgrpfrom').length > 0) ? $('#selgrpfrom').empty().append(html) : $('#selgrp').empty().append(html);
                },
                error   : function(jqXHR, textStatus, errorThrown){
                    alert(errorThrown);
                }
    
            });
        } else {
            return;
        }        
    }

    function loadshifts(){
        if($('[name="chngShift"]').length > 0){
            $.ajax({
                url     : "/jobtracker/loadshifts",
                method  : "GET",
                success : function(res){
                    var itm = JSON.parse(res);
                    var html = "";

                    if(itm.length > 0){
                        html += '<option value="0" selected>- Select a shift profile -</option>';
                        for(i = 0; i <= (itm.length -1); i++){
                            html += '<option value="'+ itm[i]['shid'] +'">'+ itm[i]['shiftnm'] +'</option>';
                        } 
                    } else {
                        html += '<option value="0" selected>- No available option(s) -</option>';
                    }

                    $('#shiftfrom').empty().append(html);
                    $('#shiftto').empty().append(html);
                },
                error   : function(jqXHR, textStatus, errorThrown){
                    alert(errorThrown);
                }
            });
        } else {
            return;
        }         
    }

    function loadempsonshift(sid = 0){
        if($('[name="chngShift"]').length > 0){
            $.ajax({
                url     : "/jobtracker/loadmemberstosc",
                method  : "GET",
                data    : {"data" : {"sid" : sid, "gid" : $("#selgrp").val(), "dtf" : $("#dtfrom").val(), "dtt" : $("#dtto").val()}},
                success : function(res){
                    var itm = JSON.parse(res);
                    var html = "";

                    if(itm.length > 0){
                        for(i = 0; i <= itm.length - 1; i++){
                            html += '<div class="list-group-item checkbox mb-1">' +
                                        '<label>' +
                                            '<input id="' + itm[i]['eid'] + '" type="checkbox" class="mr-2"> ' + itm[i]['enm'] +
                                        '</label>' +
                                    '</div>';
                        }                        
                    } else {
                        html += '<div class="list-group-item mb-1">' +
                                    '<label>No members allocated on selected schedule.</label>' +
                                '</div>';
                    }

                    $("[name='scelist']").empty().append(html);

                },
                error   : function(jqXHR, textStatus, errorThrown){
                    alert(errorThrown);
                }
    
            });
        } else {
            return;
        } 
    }

    function loadchangeshifts(){
        if($('[name="chngShift"]').length > 0){
            $.ajax({
                url     : "/jobtracker/loadappliedsc",
                method  : "GET",
                data    : {"data" : { "dtf" : $("#wddtfrom").val(), "dtt" : $("#wddtto").val()}},
                success : function(res){
                    var itm = JSON.parse(res);
                    var html = "";

                    if(itm.length > 0){
                        for(i = 0; i <= (itm.length -1); i++){
                            html += '<tr class="border-bottom">' +
                                        '<td class="text-center">' +
                                            '<a id="' + itm[i]['scid'] + '" name="delsc" href="#" class="btn"><i class="fas fa-trash-alt text-danger" data-toggle="tooltip" data-placement="top" title="Cancel Change Shift"></i></a>' +
                                        '</td>' +
                                        '<td class="text-center align-middle">' + itm[i]['wd'] + '</td>' +
                                        '<td class="text-center align-middle">' + itm[i]['enm'] + '</td>' +
                                        '<td class="text-center align-middle">' + itm[i]['os'] + '</td>' +
                                        '<td class="text-center align-middle">' + itm[i]['ns'] + '</td>' +
                                        '<td class="text-center align-middle">' + itm[i]['dtc2'] + '</td>' +
                                    '</tr>';
                        } 
                    } else {
                        html += '<tr class="border-bottom"><td colspan="6" class="text-center">- No available data -</td></tr>';
                    }

                    $('[name="SCLogs"]').empty().append(html);
                },
                error   : function(jqXHR, textStatus, errorThrown){
                    alert(errorThrown);
                }
    
            });
        } else {
            return;
        }         
    }

    function registerChangeShift(eids = []){
        var empresult = [];
        var success = 0, failed = 0;

        if(eids.length > 0){
            for(i=0; i <= (eids.length - 1); i++){
                $.ajax({
                    url     : "/jobtracker/tranchangeshift",
                    method  : "POST",
                    data    : {"data" : {"eid" : eids[i], "csto" : $("#shiftto").val(), "dtf" : $("#dtfrom").val(), "dtt" : $("#dtto").val()}},
                    success : function(res) {
                        empresult.push({"flag" : 1, "msg" : "Change shift schedule for employee id [" + eids[i] + "] has been created."});
                        console.log(res);
                    },
                    error   : function(jqXHR, textStatus, errorThrown){
                        empresult.push({"flag" : 0, "msg" : "Failed to change schedule for employee id [" + eids[i] + "]."});
                    } 
                });
            }

            for(i=0; i <= (empresult.length - 1); i++){
                (empresult[i]["flag"] === 1) ? success += 1 : failed += 1; 
            }

            if(empresult.length === success) {
                $("[name='csnotifytitle']").empty().append("Success : Change Shift");
                $("[name='csnotifybody']").empty().append(getCustomMsgBody(1, "Selected employee(s) shift has been changed successfully."));
                $("[name='csnotify']").modal('show');
            } else {
                $("[name='csnotifytitle']").empty().append("Error : Change Shift");
                $("[name='csnotifybody']").empty().append(getCustomMsgBody(0, "Failed to allocate shift for [" + failed + "] employee(s)."));
                $("[name='csnotify']").modal('show');            
            }          

        } else {
            $("[name='csnotifytitle']").empty().append("Error : Change Shift");
            $("[name='csnotifybody']").empty().append(getCustomMsgBody(0, "Failed to allocate shift for selected employee(s)."));
            $("[name='csnotify']").modal('show');
        }
        loadempsonshift($('#shiftfrom').val());
    }

    // Change Group

    $(document).on("change", "#selgrpfrom", function(){
        loadempsongroup($(this).val());
    });

    $(document).on("click", "[name='gcselall']", function(){
        if($(this).text() === 'Select All'){
            $("[name='gcelist'] > .list-group-item > label > input[type='checkbox']").each(function(){
                if($(this).prop("checked") === false){
                    $(this).prop("checked", true);
                }
            });
            $(this).text("De-select All");
        } else {
            $("[name='gcelist'] > .list-group-item > label > input[type='checkbox']").each(function(){
                if($(this).prop("checked") === true){
                    $(this).prop("checked", false);
                }
            });
            $(this).text("Select All");
        }
    });

    $(document).on("change","input[type='checkbox']", function(){
        var elCnt = $("[name='gcelist'] > .list-group-item > label > input[type='checkbox']").length;
        var chkCnt = $("[name='gcelist'] > .list-group-item > label > input[type='checkbox']:checked").length;
        
        if(elCnt === chkCnt){
            $("[name='gcselall']").text("De-select All");
        } else {
            $("[name='gcselall']").text("Select All");
        }
    });

    $(document).on("click", "[name='gcNew']", function(){
        var selemp = $("[name='gcelist'] > .list-group-item > label > input[type='checkbox']:checked").length;
        var emps = [];

        if($('#dtfrom').val() === "" || $('#dtto').val() === ""){
            $('[name="cgnotifytitle"]').empty().append("Error : Change Group")
            $('[name="cgnotifybody"]').empty().append(getCustomMsgBody(0, "Please specify valid dates."));
            $('[name="cgnotify"]').show();
            return;
        }

        var dtf = new Date($("#dtfrom").val());
        var dtt = new Date($("#dtto").val());

        if(dtf.getTime() > dtt.getTime()){
            $("[name='csnotifytitle']").empty().append("Error : Change Group");
            $("[name='csnotifybody']").empty().append(getCustomMsgBody(0, "Anti-dates are not allowed. Please enter a valid date range then try again."));
            $("[name='csnotify']").modal('show');
            return;            
        }

        if(selemp === 0) {
            $("[name='csnotifytitle']").empty().append("Error : Change Group");
            $("[name='csnotifybody']").empty().append(getCustomMsgBody(0, "Please select employee(s) you want to transfer to another shift."));
            $("[name='csnotify']").modal('show');
            return;
        }

        $("[name='gcelist'] > .list-group-item > label > input[type='checkbox']:checked").each(function(){
            emps.push(parseInt($(this).attr("id")));
        });

        if(confirm("Are you sure you want to change the shift schedule of the selected employee(s)? Click Ok to proceed.") === true){
            registerChangeShift(emps);
        }

    });

    function loadempsongroup(gid = 0){
        $.ajax({
            url     : '/jobtracker/loadmemberstogc',
            method  : 'POST',
            data    : {"data" : {"gid" : gid, "dtf" : $('#dtfrom').val(), "dtt" : $('#dtto').val()}},
            success : function(res){
                var itm = JSON.parse(res);
                var html = "";

                if(itm.length > 0){
                    for(i = 0; i <= itm.length - 1; i++){
                        html += '<div class="list-group-item checkbox mb-1">' +
                                    '<label>' +
                                        '<input id="' + itm[i]['eid'] + '" type="checkbox" class="mr-2"> ' + itm[i]['enm'] +
                                    '</label>' +
                                '</div>';
                    }                        
                } else {
                    html += '<div class="list-group-item mb-1">' +
                                '<label>No members allocated on selected group.</label>' +
                            '</div>';
                }

                $('[name="gcelist"]').empty().append(html);

            },
            error   : function(jqXHR, textStatus, errorThrown){
                $("[name='csnotifytitle']").empty().append("Error : Change Group");
                $("[name='csnotifybody']").empty().append(getCustomMsgBody(0, errorThrown + ". Please contact your system administrator.");
                $("[name='csnotify']").modal('show');
            }
        });
    }

    function loadgroupsondept(){
        $.ajax({
            url     : '/jobtracker/loaddeptgroups',
            method  : 'POST',
            success : function(res){
                var itm = JSON.parse(res);
                var html = "";

                if(itm.length > 0){
                    html += '<option value="0" selected>- Please select a group -</option>';
                    for(i=0; i <= (itm.length - 1); i++){
                        html += '<option value="'+ itm[i]['gid'] +'">'+ itm[i]['grpname'] +'</option>';
                    }
                } 
                else {
                    html += '<option value="0" selected>- No available groups -</option>';
                }

                $('#selgrpto').empty().append(html);
            },
            error   : function(jqXHR, textStatus, errorThrown){
                $("[name='csnotifytitle']").empty().append("Error : Change Group");
                $("[name='csnotifybody']").empty().append(getCustomMsgBody(0, errorThrown + ". Please contact your system administrator.");
                $("[name='csnotify']").modal('show');
            }
        });        
    }

    function registergroupchange(emps = []){
        for(i=0; i <= (emps.length - 1); i++){
            $.ajax({
                url     : '',
                method  : 'POST',
                data    : {},
                success : function(res){

                },
                error   : function(jqXHR, textStatus, errorThrown){

                }
            });
        }
    }

    // Time sheet report

    var selTSEmp = 0, selTSWD = '';

    $(document).on("click", '[name="TSGen"]', function(){
        var ds = $('#cutoffstart').val();
        var dt = $('#cutoffend').val();

        if(confirm("Generate timesheet for the following period [" + ds + "] - [" + dt + "]? Click Generate to proceed.") === true){
            generatetimesheet(ds, dt);
        }
    });

    $(document).on("change", '#selTSCode', function(){
        selTSEmp = parseInt($(this).val());
        loadtsmembers($(this).val());
    });

    $(document).on("click", "[name='TSLoad']", function(){
        selTSEmp = parseInt($(this).attr('id'));
        loadtslogs($(this).attr('id'));
    });

    $(document).on("click", "[name='uTS']", function(){
        loadtsinfo(0, parseInt($(this).attr("id")));
    });

    $(document).on("click", "[name='uJS']", function(){
        loadtsinfo(1, parseInt($(this).attr("id")));
    });

    $(document).on("click", "[name='vwJobs']", function(){
        selTSWD = $(this).attr('id');
        loadjslogs(selTSEmp, $(this).attr('id'));
    });

    $(document).on("click", "[name='genCancel']", function(){
        $('[name="tLogs"]').empty();
        $('[name="jLogs"]').empty();
        $('[name="tseList"]').empty();
        $('#selTSCode').val(0);
        $('[name="TSTotal"]').empty().append("0.00");
        $('[name="TSTotal"]').empty().append("0.00");
        selTSEmp = 0;
        selTSWD = '';
        loadforapprovals();
    });

    $(document).on("click", "[name='bUpdTS']", function(){
        var tout = $('#tstodt').val() + ' ' + $('#tsto').val();
        var tin  = $('#tstidt').val() + ' ' + $('#tsti').val();

        if(Date.parse(tout) === NaN){
            $('[name="modTSTitle"]').empty().append('Error : Update Logs');
            $('[name="modTSBody"]').empty().append(getCustomMsgBody(0, 'Unable to process overriding of logs due to time supplied is invalid. Please supply a valid time then try again.'));
            $('[name="modTS"]').modal('show');
            return;
        }

        if(Date.parse(tout) < Date.parse(tin)){
            $('[name="modTSTitle"]').empty().append('Error : Update Logs');
            $('[name="modTSBody"]').empty().append(getCustomMsgBody(0, 'Unable to process overriding of logs due to time supplied is invalid. Please supply a valid time then try again.'));
            $('[name="modTS"]').modal('show');
            return;
        }

        //alert(tout);

        if(confirm("Proceed in overwritting selected log? Click OK to confirm.") === true){
            updatetsinfo(0, $('#selTSId').val(), tout);
        }
    });

    $(document).on("click", "[name='bCUpdTS']", function(){
        $('#selTSId').val("0");
        $('#twd').val("");
        $('#tstidt').val("");
        $('#tsti').val("");
        $('#tstodt').val("");
        $('#tsto').val("");
    });

    $(document).on("click", "[name='bUpdJS']", function(){
        var tout = $('#jstodt').val() + ' ' + $('#jsto').val();
        var tin  = $('#jstidt').val() + ' ' + $('#jsti').val();

        if(Date.parse(tout) === NaN){
            $('[name="modTSTitle"]').empty().append('Error : Update Logs');
            $('[name="modTSBody"]').empty().append(getCustomMsgBody(0, 'Unable to process overriding of logs due to time supplied is invalid. Please supply a valid time then try again.'));
            $('[name="modTS"]').modal('show');
            return;
        }

        if(Date.parse(tout) < Date.parse(tin)){
            $('[name="modTSTitle"]').empty().append('Error : Update Logs');
            $('[name="modTSBody"]').empty().append(getCustomMsgBody(0, 'Unable to process overriding of logs due to time supplied is invalid. Please supply a valid time then try again.'));
            $('[name="modTS"]').modal('show');
            return;
        }

        if(confirm("Proceed in overwritting selected log? Click OK to confirm.") === true){
            updatetsinfo(1, $('#selJSId').val(), tout);
        }
    });

    $(document).on("click", "[name='bCUpdJS']", function(){
        $('#selJSId').val("0");
        $('#jwd').val("");
        $('#jjob').val("");
        $('#jord').val("");
        $('#jwc').val("");
        $('#jact').val("");
        $('#jstidt').val("");
        $('#jsti').val("");
        $('#jstodt').val("");
        $('#jsto').val("");
    });

    $(document).on("click", "[name='approveTS']", function(){
        if(parseInt($('#selTSCode').val()) === 0){
            $('[name="modTSTitle"]').empty().append('Error : Timesheet Approval');
            $('[name="modTSBody"]').empty().append(getCustomMsgBody(0, "Please select a timesheet data (For Approval) from the dropdown above. If there is no timesheet data, generate one first."));
            $('[name="modTS"]').modal('show');
            return;
        }

        if(confirm("Approve selected timesheet data? \nMake sure that there are no exceptions, once approved it cannot be undone. \nClick Ok to proceed.") === true){
            $.ajax({
                url     : '/jobtracker/updatetsstatus',
                method  : 'POST',
                data    :  {"data" : {"st": 0, "tsid": $('#selTSCode').val()}},
                success : function(res){
                    var itm = JSON.parse(res);

                    $('[name="modTSTitle"]').empty().append((itm[0]['flag'] === 0) ? 'Error : Timesheet Data [Approval]' : 'Success : Timesheet Data [Approval]');
                    $('[name="modTSBody"]').empty().append(getCustomMsgBody(itm[0]['flag'], itm[0]['flag']));
                    $('[name="modTS"]').modal('show');

                    $("[name='genCancel']").trigger("click");

                },
                error   : function(jqXHR, textStatus, errorThrown){
                    $('[name="modTSTitle"]').empty().append('Error : Record update [Approval]');
                    $('[name="modTSBody"]').empty().append(getCustomMsgBody(0, 'There is a problem updating data [' + errorThrown + ']. Please contact your system administrator.'));
                    $('[name="modTS"]').modal('show');
                }
            });
        }
    });

    $(document).on("click", "[name='declineTS']", function(){
        if(parseInt($('#selTSCode').val()) === 0){
            $('[name="modTSTitle"]').empty().append('Error : Timesheet Declination');
            $('[name="modTSBody"]').empty().append(getCustomMsgBody(0, "Please select a timesheet data (For Declination) from the dropdown above. If there is no timesheet data, generate one first."));
            $('[name="modTS"]').modal('show');
            return;
        }

        if(confirm("Decline selected timesheet data? \nOnce declined it cannot be undone. \nClick Ok to proceed.") === true){
            $.ajax({
                url     : '/jobtracker/updatetsstatus',
                method  : 'POST',
                data    :  {"data" : {"st": 1, "tsid": $('#selTSCode').val()}},
                success : function(res){
                    var itm = JSON.parse(res);

                    $('[name="modTSTitle"]').empty().append((itm[0]['flag'] === 0) ? 'Error : Timesheet Data [Declination]' : 'Success : Timesheet Data [Declination]');
                    $('[name="modTSBody"]').empty().append(getCustomMsgBody(itm[0]['flag'], itm[0]['flag']));
                    $('[name="modTS"]').modal('show');

                    $("[name='genCancel']").trigger("click");
                },
                error   : function(jqXHR, textStatus, errorThrown){
                    $('[name="modTSTitle"]').empty().append('Error : Record loading [Declination]');
                    $('[name="modTSBody"]').empty().append(getCustomMsgBody(0, 'There is a problem updating data [' + errorThrown + ']. Please contact your system administrator.'));
                    $('[name="modTS"]').modal('show');
                }
            });
        }
    });

    function generatetimesheet(ds, dt){
        $.ajax({
            url     : '/jobtracker/generatetimesheet',
            method  : 'POST',
            data    : {"data" : {"ds" : ds, "dt" : dt}},
            success : function(res){
                var itm = JSON.parse(res);
                var title = (itm[0][0]['flag'] === 0 ? 'Error : Generate Timesheet' : 'Success : Generate Timesheet' );

                $('[name="modTSTitle"]').empty().append(title);
                $('[name="modTSBody"]').empty().append(getCustomMsgBody(itm[0][0]['flag'], itm[0][0]['msg']));
                $('[name="modTS"]').modal('show');

                loadforapprovals();
            },
            error   : function(jqXHR, textStatus, errorThrown) {
                $('[name="modTSTitle"]').empty().append('Error : Record loading');
                $('[name="modTSBody"]').empty().append(getCustomMsgBody(0, 'There is a problem loading data [' + errorThrown + ']. Please contact your system administrator.'));
                $('[name="modTS"]').modal('show');
            }
        });
    }

    function loadforapprovals(){
        if($('#selTSCode').length > 0){
            $.ajax({
                url     : '/jobtracker/loadfas',
                method  : 'GET',
                success : function(res){
                    var itm = JSON.parse(res);
                    var html = "";

                    
                    if(itm.length > 0){
                        html += '<option value="0" selected>- Select a Timesheet Data -</option>';
                        for(i=0; i <= (itm.length - 1); i++){
                            html += '<option value="'+ itm[i]['id'] +'">'+ itm[i]['tlcode'] +'</option>';
                        }
                    } else {
                        html += '<option value="0" selected>- No Timesheet Generated -</option>';
                    }

                    $('#selTSCode').empty().append(html);
                },
                error   : function(jqXHR, textStatus, errorThrown) {
                    $('[name="modTSTitle"]').empty().append('Error : Record loading');
                    $('[name="modTSBody"]').empty().append(getCustomMsgBody(0, 'There is a problem loading data [' + errorThrown + ']. Please contact your system administrator.'));
                    $('[name="modTS"]').modal('show');
                }
            });            
        }
    }

    function loadtsmembers(tsid = 0){
        $.ajax({
            url     : '/jobtracker/loadtsmembers',
            method  : 'POST',
            data    : {"data" : {"tsid" : tsid}},
            success : function(res){
                var itm = JSON.parse(res);
                var html = "";

                if(itm.length > 0){
                    for(i=0; i <= (itm.length -1); i++){
                        if(itm[i]['wEx'] > 0){
                            html += '<div class="list-group-item"><a href="#" name="TSLoad" id="'+ itm[i]['eid']+'"><i class="far fa-list-alt text-danger mr-3" data-toggle="tooltip" data-placement="top" title="With Exceptions"></i></a>'+ itm[i]['enm'] +'</div>';
                        } else {
                            html += '<div class="list-group-item"><a href="#" name="TSLoad" id="'+ itm[i]['eid']+'"><i class="far fa-check-circle text-success mr-3" data-toggle="tooltip" data-placement="top" title="No Exceptions"></i></a>'+ itm[i]['enm'] +'</div>';
                        }
                    }
                    
                } else {
                    html += '<div class="list-group-item">- No Employees available -</div>';
                }

                $('[name="tseList"]').empty().append(html);
            },
            error   : function(jqXHR, textStatus, errorThrown) {
                $('[name="modTSTitle"]').empty().append('Error : Record loading');
                $('[name="modTSBody"]').empty().append(getCustomMsgBody(0, 'There is a problem loading data [' + errorThrown + ']. Please contact your system administrator.'));
                $('[name="modTS"]').modal('show');
            }
        });
    }

    function loadtslogs(eid = 0){
        $.ajax({
            url     : '/jobtracker/loadtslogs',
            method  : 'POST',
            data    : {"data" : {"tsid" : $('#selTSCode').val(), "eid" : eid}},
            success : function(res){
                var itm = JSON.parse(res);
                var html = "";
                var totals = 0.00;

                if(itm.length > 0) {
                    for(i=0; i <= (itm.length - 1); i++){
                        if(itm[i]['TSEx'] === 0){
                            html += '<tr class="border-bottom">' +
                                        '<td>' +
                                            '<i class="fas fa-check mr-2 text-success" data-toggle="tooltip" data-placement="top" title="No Exceptions"></i>' +
                                            '<a href="#" id="'+ itm[i]['wd'] +'" name="vwJobs"><i class="fas fa-list" data-toggle="tooltip" data-placement="top" title="View Jobs"></i></a>' +
                                        '</td>' +
                                        '<td class="text-center">'+ itm[i]['wd'] +'</td>' +
                                        '<td class="text-center">'+ itm[i]['ts'] +'</td>' +
                                        '<td class="text-center">'+ itm[i]['te'] +'</td>' +
                                        '<td class="text-right">'+ itm[i]['hrs'] +'</td>' +
                                    '</tr>';
                        } else {
                            html += '<tr class="border-bottom">' +
                                        '<td>' +
                                            '<a href="#" name="uTS" id="'+ itm[i]['tdid'] +'" data-toggle="modal" data-target="#modUpdLog"><i class="far fa-edit mr-2 text-danger" data-toggle="tooltip" data-placement="top" title="Update Log"></i></a>' +
                                            '<a href="#" name="vwJobs" id="'+ itm[i]['wd'] +'"><i class="fas fa-list" data-toggle="tooltip" data-placement="top" title="View Jobs"></i></a>' +
                                        '</td>' +
                                        '<td class="text-center">'+ itm[i]['wd'] +'</td>' +
                                        '<td class="text-center">'+ itm[i]['ts'] +'</td>' +
                                        '<td class="text-center">'+ itm[i]['te'] +'</td>' +
                                        '<td class="text-right">'+ itm[i]['hrs'] +'</td>' +
                                    '</tr>';
                        }

                        totals += parseFloat(itm[i]['hrs']);
                    }

                } else {
                    html += '<tr><td colspan="5">- No data available -</td></tr>';
                }

                $('[name="tLogs"]').empty().append(html);
                (totals > 0) ? $('[name="TSTotal"]').empty().append(totals) : 0;
            },
            error   : function(jqXHR, textStatus, errorThrown) {
                $('[name="modTSTitle"]').empty().append('Error : Record loading');
                $('[name="modTSBody"]').empty().append(getCustomMsgBody(0, 'There is a problem loading data [' + errorThrown + ']. Please contact your system administrator.'));
                $('[name="modTS"]').modal('show');
            }
        });
    }

    function loadjslogs(eid = 0, wd = ''){
        $.ajax({
            url     : '/jobtracker/loadjslogs',
            method  : 'POST',
            data    : {"data" : {"tsid" : $('#selTSCode').val(), "eid" : eid, "wd" : wd}},
            success : function(res){
                var itm = JSON.parse(res);
                var html = "";
                var totals = 0.00;

                if(itm.length > 0){
                    for(i=0; i <= (itm.length - 1); i++){
                        if(itm[i]['JSex'] === 0){
                            html += '<tr class="border-bottom">' +
                                        '<td>' +
                                            '<i class="fas fa-check text-success" data-toggle="tooltip" data-placement="top" title="No Exceptions"></i>' +
                                        '</td>' +
                                        '<td>'+ itm[i]['wd'] +'</td>' +
                                        '<td class="text-center">'+ itm[i]['orn'] +'</td>' +
                                        '<td class="text-center">'+ itm[i]['od'] +'</td>' +
                                        '<td class="text-center">'+ itm[i]['wd'] +'</td>' +
                                        '<td class="text-center">'+ itm[i]['ac'] +'</td>' +
                                        '<td class="text-center">'+ itm[i]['ts'] +'</td>' +
                                        '<td class="text-center">'+ itm[i]['te'] +'</td>' +
                                        '<td class="text-right">'+ itm[i]['hrs'] +'</td>' +
                                    '</tr>';                            
                        } else {
                            html += '<tr class="border-bottom">' +
                                        '<td>' +
                                            '<a href="#" name="uJS" id="'+ itm[i]['jdid'] +'" data-toggle="modal" data-target="#modUpdJob"><i class="far fa-edit text-danger" data-toggle="tooltip" data-placement="top" title="Update Log"></i></a>' +
                                        '</td>' +
                                        '<td>'+ itm[i]['wd'] +'</td>' +
                                        '<td class="text-center">'+ itm[i]['orn'] +'</td>' +
                                        '<td class="text-center">'+ itm[i]['od'] +'</td>' +
                                        '<td class="text-center">'+ itm[i]['wd'] +'</td>' +
                                        '<td class="text-center">'+ itm[i]['ac'] +'</td>' +
                                        '<td class="text-center">'+ itm[i]['ts'] +'</td>' +
                                        '<td class="text-center">'+ itm[i]['te'] +'</td>' +
                                        '<td class="text-right">'+ itm[i]['hrs'] +'</td>' +
                                    '</tr>'; 
                        }

                        totals += parseFloat(itm[i]['hrs']);
                    }

                } else {

                }

                $("[name='jLogs']").empty().append(html);
                (totals > 0) ? $('[name="JSTotal"]').empty().append(totals) : 0;
            },
            error   : function(jqXHR, textStatus, errorThrown) {
                $('[name="modTSTitle"]').empty().append('Error : Record loading');
                $('[name="modTSBody"]').empty().append(getCustomMsgBody(0, 'There is a problem loading data [' + errorThrown + ']. Please contact your system administrator.'));
                $('[name="modTS"]').modal('show');
            }
        });
    }

    function loadtsinfo(info = 0, tdid = 0){
        $.ajax({
            url     : '/jobtracker/loadtsinfo',
            method  : 'POST',
            data    : {"data" : {"info": info , "tdid" : tdid}},
            success : function(res){
                var itm = JSON.parse(res);

                if(info === 0){
                    $('#selTSId').val(itm[0]['tsid']);
                    $('#twd').val(itm[0]['wd']);
                    $('#tstidt').val(itm[0]['tid']);
                    $('#tsti').val(itm[0]['ti']);
                    $('#tstodt').val(itm[0]['ted']);
                    $('#tsto').val(itm[0]['te']);                    
                } else {
                    $('#selJSId').val(itm[0]['jdid']);
                    $('#jwd').val(itm[0]['wd']);
                    $('#jjob').val(itm[0]['orn']);
                    $('#jord').val(itm[0]['od']);
                    $('#jwc').val(itm[0]['wc']);
                    $('#jact').val(itm[0]['ac']);
                    $('#jstidt').val(itm[0]['tid']);
                    $('#jsti').val(itm[0]['ti']);
                    $('#jstodt').val(itm[0]['ted']);
                    $('#jsto').val(itm[0]['te']);
                }
            },
            error   : function(jqXHR, textStatus, errorThrown){
                $('[name="modTSTitle"]').empty().append('Error : Record loading');
                $('[name="modTSBody"]').empty().append(getCustomMsgBody(0, 'There is a problem loading data [' + errorThrown + ']. Please contact your system administrator.'));
                $('[name="modTS"]').modal('show');
            }
        });
    }

    function updatetsinfo(info = 0, tdid = 0, tout = ''){
        $.ajax({
            url     : '/jobtracker/updatetsinfo',
            method  : 'POST',
            data    : {"data" : {"info": info , "tdid" : tdid, "to" : tout}},
            success : function(res){
                var itm = JSON.parse(res);

                $('[name="modTSTitle"]').empty().append((itm[0]['flag'] === 0) ? 'Error : Update Logs' : 'Success : Update Logs');
                $('[name="modTSBody"]').empty().append(getCustomMsgBody(itm[0]['flag'], itm[0]['msg']));
                $('[name="modTS"]').modal('show');

                if(info === 0){
                    loadtsmembers($('#selTSCode').val());
                    loadtslogs(selTSEmp);
                } else {
                    alert(selTSEmp + " " + selTSWD);
                    loadjslogs(selTSEmp, selTSWD);
                }
                
                
            },
            error   : function(jqXHR, textStatus, errorThrown){
                $('[name="modTSTitle"]').empty().append('Error : Update Information');
                $('[name="modTSBody"]').empty().append(getCustomMsgBody(0, 'There is a problem updating information [' + errorThrown + ']. Please contact your system administrator.'));
                $('[name="modTS"]').modal('show');
            }
        });
    }

    // Initialize
    updatelogstatus();
    loadorders();
    loadjobs();
    loadworkcenters();
    loadwcactivity();
    loadmyjobs();

    loadmygroups();
    loadgroupmembers(0);
    loadmembersinjob(0);

    loadgroupjobs();

    loadworkgroups();
    loadshifts();
    loadgroupsondept();

    if($('[name="logEx"]').length > 0){
       loadforapprovals(); 
    }
    

    if($('[name="logEx"]').length > 0){
        $('#cutoffstart, #cutoffend').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        }).css({"cssText" : "z-index:9999 !important;"});

        var dt = new Date();
        var yr = dt.getFullYear();
        var mo = ((dt.getMonth() + 1).toString().length === 1) ? "0" + (dt.getMonth() + 1).toString() : dt.getMonth();
        var dy = (dt.getDate().toString().length === 1) ? "0" + dt.getDate().toString() : dt.getDate();
        var nd = yr + '-' + mo + '-' + dy;

        $('#cutoffstart, #cutoffend').val(nd);
    }

    if($('[name="chngShift"]').length > 0){
        $('#wrkdtstart, #wrkdtend').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        }).css({"cssText" : "z-index:9999 !important;"});
    }

    if($('#dtfrom').length > 0 && $('#dtto').length > 0){
        $('#dtfrom, #dtto').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        }).css({"cssText" : "z-index:9999 !important;"});
    }

    if($('#wddtfrom').length > 0 && $('#wddtto').length > 0){
        $('#wddtfrom, #wddtto').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        });

        var dt = new Date();
        var yr = dt.getFullYear();
        var mo = ((dt.getMonth() + 1).toString().length === 1) ? "0" + (dt.getMonth() + 1).toString() : dt.getMonth();
        var dy = (dt.getDate().toString().length === 1) ? "0" + dt.getDate().toString() : dt.getDate();
        var nd = yr + '-' + mo + '-' + dy;

        $('#wddtfrom, #wddtto').val(nd);
        loadchangeshifts();
    }

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