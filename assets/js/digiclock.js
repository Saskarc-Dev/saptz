function showTime(){
    var date = new Date();
    var h = date.getHours(); // 0 - 23
    var m = date.getMinutes(); // 0 - 59
    var s = date.getSeconds(); // 0 - 59
    var session = "AM";

    var y = date.getFullYear();
    var M = date.getMonth() + 1;
    var d = date.getDate();
    
    if(h == 0){
        h = 12;
    }
    
    if(h > 12){
        h = h - 12;
        session = "PM";
    }
    
    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;

    M = (M < 10) ? "0" + M : M;
    d = (d < 10) ? "0" + d : d;
    
    var time = h + ":" + m + ":" + s + " " + session;
    var dt = y + "/" + M + "/" + d;

    setTimeout(showTime, 1000);
    
    if($('#lblTime').length == 1){
        $('#lblTime').html('Current Date/Time : ' + dt + ' ' + time);
    }
}

showTime();