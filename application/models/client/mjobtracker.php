<?php
    class mjobtracker extends CI_Model {

        public function __construct(){
            parent::__construct();
            $this->getpendingjobs();
        }

        public function index(){

        }

        public function logintosystem(){
            $empid = $this->db->escape($_POST['data']['lid']);
            $empwd = $this->db->escape($_POST['data']['pwd']);
            $locip = $this->db->escape($_SERVER['REMOTE_ADDR']);
            $sesid = $this->db->escape(session_id());

            $qry = "sp_getvalidateuserlogin $empid, $empwd, $locip, $sesid";

            $rs = $this->db->query($qry);
            $rw = $rs->row();

            if(isset($rw->eid)){
                if($rw->c1 == true){
                    $udata = array(
                        'eid' => $rw->eid,
                        'ecode' => $rw->ecode,
                        'ename' => $rw->ename,
                        'dept' => $rw->did,
                        'pwdc' => $rw->c0,
                        'shift' => $rw->sid,
                        'access1' => $rw->c1,
                        'access2' => $rw->c2, 
                        'clientip' => $rw->cip,
                        'sessionid' => $rw->seid
                    );

                    $this->session->set_userdata(array("userdata" => $udata));

                    return json_encode(array('flag' => true, 'message' => 'Employee has been validated/authenticated successfully.'));     

                } else {
                    return json_encode(array('flag' => false, 'message' => "You don't have sufficient access rights to use the system. Please contact your system administrator."));
                }
            } else {
                return json_encode(array('flag' => false, 'message' => 'Error in validating supplied employee credential. Check your credentials then try again.'));
            }
        }

        public function changepwd(){
            $eid = $_SESSION['userdata']['eid'];
            $npwd = $_POST['data']['npwd'];

            $qry = "sp_changepassword $eid, $npwd";
            $rs = $this->db->query($qry);

            $this->session->sess_destroy();

            return json_encode($rs->result_array());
        }

        public function fillnologdates(){
            $empid = $_SESSION['userdata']['eid'];
            $locip = $this->db->escape($_SESSION['userdata']['clientip']);

            $qry = "sp_fillinlostlogs $empid, $locip";
            $this->db->query($qry);
        }

        public function getserverdate(){
            $qry = "select convert(varchar, getdate(), 23) as dt, getdate() as lt";
            $rs = $this->db->query($qry);
            $rw = $rs->row();

            if(isset($rw)){ return array($rw->dt, $rw->lt);}
        }

        public function getlastlogdate(){
            $empid = $_SESSION['userdata']['eid'];

            $qry = "select max(workdate) as workdate from timelogs where empid = $empid";
            $rs = $this->db->query($qry);
            $rw = $rs->row();

            if(isset($rw)){ return $rw->workdate;}
        }

        public function getpendingjobs(){
            $empid = isset($_SESSION['userdata']['eid']) ? $_SESSION['userdata']['eid'] : 0;

            $qry = "select count(id) as pendingjob from joblogs where timeend is null and empid = $empid";

            $rs = $this->db->query($qry);
            $rw = $rs->row();

            if(isset($rw->pendingjob) && $rw->pendingjob > 0){
                $this->session->set_userdata(array("inout" => 1));
            } else {
                $this->session->set_userdata(array("inout" => 0));
            }
        }

        public function logtotimesheet(){
            if(isset($_POST['data'])){
                $logtype = isset($_POST['data']['lt']) ? $this->db->escape($_POST['data']['lt']) : 0;
                $empid = $_SESSION['userdata']['eid'];
                $empname = $this->db->escape($_SESSION['userdata']['ename']);
                $locip = $this->db->escape($_SESSION['userdata']['clientip']);

                $qry = "sp_logtimesheet $empid, $locip, $logtype";

                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());

            } else {
                return json_encode(array(
                    "flag" => false,
                    "message" => "Unable to process request due to Post values are null or invalid"
                ));
            }
        }

        public function logtojobsheet(){
            if(isset($_POST['data'])){
                $empid = isset($_SESSION['userdata']['eid']) ? $_SESSION['userdata']['eid'] : 0;
                $jobty = isset($_POST['data']['jt']) ? $_POST['data']['jt'] : 0;
                $jobwc = isset($_POST['data']['wc']) ? $_POST['data']['wc'] : 0;
                $jobac = isset($_POST['data']['act']) ? $_POST['data']['act'] : 0;
                $jobor = isset($_POST['data']['ord']) ? $_POST['data']['ord'] : 0;
                $jobjb = isset($_POST['data']['job']) ? $_POST['data']['job'] : 0;
                $locip = isset($_SESSION['userdata']['clientip']) ? $this->db->escape($_SESSION['userdata']['clientip']) : '';

                $qry = "sp_logjobsheet $jobty, $empid, $jobor, $jobjb, $jobwc, $jobac, $locip, $empid";
                $rs  = $this->db->query($qry);
                return json_encode($rs->result_array());
            }
        }

        public function logtogroupjob(){
            if(isset($_POST['data'])){
                $jt = isset($_POST['data']['jt']) ? $this->db->escape($_POST['data']['jt']) : 0;
                $jlid = isset($_POST['data']['jlid']) ? $this->db->escape($_POST['data']['jlid']) : 0;
                $wcid = isset($_POST['data']['wc']) ? $_POST['data']['wc'] : 0;
                $acid = isset($_POST['data']['act']) ? $_POST['data']['act'] : 0;
                $ord = isset($_POST['data']['ord']) ? $_POST['data']['ord'] : 0;
                $job = isset($_POST['data']['job']) ? $_POST['data']['job'] : 0;
                $cid = $_SESSION['userdata']['eid'];
                $locip = $this->db->escape($_SESSION['userdata']['clientip']);
                
                $sid = isset($_POST['data']['smembers']) ? $_POST['data']['smembers'] :  null;

                foreach($sid as $eid){
                    $qry_jg = "sp_loggroupjob $eid, $jlid, $wcid, $acid, $ord, $job, $cid";
                    $this->db->query($qry_jg);                 
                }

                foreach($sid as $eid){
                    $qry_ji = "sp_logjobsheet $jt, $eid, $ord, $job, $wcid, $acid, $locip, $cid";
                    $res = $this->db->query($qry_ji);   
                }

                return json_encode($res->result_array());

            } else {
                return json_encode(array('flag' => false, "message" => 'Unable to process group job.'));
            }
        }

        public function gettimesheetbyrange(){
            $sd = $this->getserverdate();
            $dtstart = (isset($_GET['data']['start'])) ? $this->db->escape($_GET['data']['start']) : null; 
            $dtend = (isset($_GET['data']['end'])) ? $this->db->escape($_GET['data']['end']) : null; 
            $empid = (isset($_SESSION['userdata']['eid'])) ? $_SESSION['userdata']['eid'] : 0;

            if(strlen($dtstart) <= 2 || strlen($dtend) <= 2){
                $qry = "sp_gettimesheet $empid, null, null";
            } else {
                $qry = "sp_gettimesheet $empid, $dtstart, $dtend";
            }            
            $rs = $this->db->query($qry);
            return json_encode($rs->result_array());
        }

        public function getjobsheetbyrange(){
            $sd = $this->getserverdate();
            $dtstart = (isset($_POST['data']['start'])) ? $this->db->escape($_POST['data']['start']) : null; 
            $dtend = (isset($_POST['data']['end'])) ? $this->db->escape($_POST['data']['end']) : null; 
            $empid = (isset($_SESSION['userdata']['eid'])) ? $_SESSION['userdata']['eid'] : 0;

            if(strlen($dtstart) <= 2 || strlen($dtend) <= 2){
                $qry = "sp_getjoblogs $empid, null, null";
            } else {
                $qry = "sp_getjoblogs $empid, $dtstart, $dtend";
            }    
            $rs = $this->db->query($qry);

            return json_encode($rs->result_array());
        }

        public function getjoblogs(){
            $empid = (isset($_SESSION['userdata']['eid'])) ? $_SESSION['userdata']['eid'] : 0;
            $qry = "sp_getjoblogs $empid, null, null";
            $rs = $this->db->query($qry);
            return json_encode($rs->result_array());
        }

        public function getlogstats(){
            $empid = isset($_SESSION['userdata']['eid']) ? $_SESSION['userdata']['eid'] : 0;

            $qry = "sp_getlogstatus $empid";
            $rs = $this->db->query($qry);
            return json_encode($rs->result_array());
        }

        public function getJOs(){
            if(isset($_GET['data'])){
                $listype = isset($_GET['data']['lt']) ? $this->db->escape($_GET['data']['lt']) : 0;

                $qry = "sp_getjos $listype, 0, ''";
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());               
            }
        }

        public function getJODetails(){
            if(isset($_GET['data'])){
                $listype = isset($_GET['data']['lt']) ? $_GET['data']['lt'] : 0;
                $ordid = isset($_GET['data']['jid']) ? $_GET['data']['jid'] : 0;
                $qry = "sp_getjodetails $listype, 0, $ordid, ''";
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());                
            }
        }

        public function getworkcenters(){
            if(isset($_GET['data'])){
                $listype = isset($_GET['data']['lt']) ? $_GET['data']['lt'] : 0;
                $dept = isset($_SESSION['userdata']['dept']) ? $_SESSION['userdata']['dept'] : 0;
                $qry = "sp_getworkcenters $listype, 0, $dept";
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());                
            }
        }

        public function getactivity(){
            if(isset($_GET['data'])){
                $listype = isset($_GET['data']['lt']) ? $_GET['data']['lt'] : 0;
                $wcid = isset($_GET['data']['wcid']) ? $_GET['data']['wcid'] : 0;
                $qry = "sp_getactivity $listype, 0, $wcid";
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());                
            }
        }
        
        public function getnonactivity(){
            if(isset($_GET['data'])){
                $jid = isset($_GET['data']['jid']) ? $_GET['data']['jid'] : 0;
                
                $qry = "sp_getnonworkactivity $jid";
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            }
        }

        public function getgroups(){
            if(isset($_SESSION['userdata'])){
                $eid = isset($_SESSION['userdata']['eid']) ? $this->db->escape($_SESSION['userdata']['eid']) : 0;
                $qry = "sp_getworkgroups 5, 0, $eid;";
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            }
        }

        public function getworkgroups(){
            if(isset($_SESSION['userdata'])){
                $eid = isset($_SESSION['userdata']['eid']) ? $this->db->escape($_SESSION['userdata']['eid']) : 0;
                $qry = "sp_getworkgroups 0, 0, $eid;";
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            }            
        } 

        public function getgroupmembers(){
            if(isset($_GET['data'])){
                $gid = isset($_GET['data']['gid']) ? $this->db->escape($_GET['data']['gid']) : 0;  
                $lid = $this->db->escape($_SESSION['userdata']['eid']);
                $qry = "sp_getmembers $gid, $lid";
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());                
            }
        }

        public function getavailablegms(){
            if(isset($_GET["data"])){
                $gid = (isset($_GET['data']['gid'])) ? $this->db->escape($_GET['data']['gid']) : 0; 
                $lid = $this->db->escape($_SESSION['userdata']['eid']);
                $qry = "sp_getworkgroups 401, $gid, $lid";
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());                    
            }
        }

        public function getgroupjoblogs(){
            $empid = isset($_SESSION['userdata']['eid']) ? $_SESSION['userdata']['eid'] : 0;
            $qry = "sp_getgroupjoblogs $empid";
            $rs = $this->db->query($qry);
            return json_encode($rs->result_array());
        }

        public function getactivejobmembers(){
            $jlid = isset($_POST['data']) ? $this->db->escape($_POST['data']) : null;
            $qry = "sp_getactivejobmembers $jlid";
            $rs = $this->db->query($qry);
            return json_encode($rs->result_array()); 
        }

        public function registergroupjob(){
            $ttyp  = (isset($_POST['data']['typ'])) ? $_POST['data']['typ'] : 0;
            $glid = (isset($_POST['data']['glid'])) ? $_POST['data']['glid'] : 0;
            $ordid = (isset($_POST['data']['oi'])) ? $_POST['data']['oi'] : 0;
            $jobid = (isset($_POST['data']['ji'])) ? $_POST['data']['ji'] : 0;
            $wcid = (isset($_POST['data']['wcid'])) ? $_POST['data']['wcid'] : 0;
            $acid = (isset($_POST['data']['acid'])) ? $_POST['data']['acid'] : 0;
            $emp = (isset($_POST['data']['members'])) ? $_POST['data']['members'] : null;
            $locip = $this->db->escape($_SERVER['REMOTE_ADDR']);
            $eid = $_SESSION['userdata']['eid'];

            $qry = "sp_loggroupjobs $ttyp, $glid, $ordid, $jobid, $wcid, $acid, $eid";
            $rs = $this->db->query($qry);

            return json_encode($rs->result_array());
        }
        
        public function clockoutgroupjob(){
            $gid = (isset($_POST['data']['jid'])) ? $_POST['data']['jid'] : 0;
            $eid = $_SESSION['userdata']['eid'];

            $qry = "sp_loggroupjobs 1, $gid, 0, 0, 0, 0, $eid";
            $rs = $this->db->query($qry);

            return json_encode($rs->result_array());
        }

        public function registermemberongroupjob(){
            $gid = (isset($_POST['data']['jid'])) ? $_POST['data']['jid'] : 0;
            $typ = (isset($_POST['data']['typ'])) ? $_POST['data']['typ'] : 0;
            $emp = (isset($_POST['data']['emp'])) ? $_POST['data']['emp'] : 0;

            $qry = "sp_loggroupmemberstojob $typ, $gid, $emp";
            $rs = $this->db->query($qry);

            return json_encode($rs->result_array());
        }

        public function clockoutgroupjobmember(){
            $emp = (isset($_POST['data']['mid'])) ? $_POST['data']['mid'] : 0;

            $qry = "sp_loggroupmemberstojob 1, 0, $emp";
            $rs = $this->db->query($qry);

            return json_encode($rs->result_array());
        }

        public function getmembersfromjob(){
            $gid = (isset($_GET['data']['jid'])) ? $_GET['data']['jid'] : 0;

            $qry = "sp_getgroupjobmembers $gid";
            $rs = $this->db->query($qry);

            return json_encode($rs->result_array());
        }

        public function clockoutgroupfromjob(){
            $jlid = isset($_POST['data']) ? $this->db->escape($_POST['data']) : null;
            $qry = "sp_clockoutgroupfromjob $jlid";
            $rs = $this->db->query($qry);
            return json_encode($rs->result_array()); 
        }

        public function clockoutmemberfromjob(){
            $jlid = isset($_POST['data']) ? $_POST['data'] : 0;
            $qry = "sp_clockoutmemberfromjob $jlid";
            $rs = $this->db->query($qry);
            return json_encode($rs->result_array()); 
        }

        public function getshifts(){
            $qry = "sp_getworkshifts 0, 0";
            $rs = $this->db->query($qry);
            return json_encode($rs->result_array());
        }

        public function getmemberstosc(){
            $lid = (isset($_SESSION['userdata']['eid'])) ? $_SESSION['userdata']['eid'] : 0;
            $gid = (isset($_GET['data']['gid'])) ? $_GET['data']['gid'] : 0;
            $sid = (isset($_GET['data']['sid'])) ? $_GET['data']['sid'] : 0;
            $dtf = (isset($_GET['data']['dtf'])) ? $this->db->escape($_GET['data']['dtf']) : $this->db->escape(date("Y-m-d"));
            $dtt = (isset($_GET['data']['dtt'])) ? $this->db->escape($_GET['data']['dtt']) : $this->db->escape(date("Y-m-d"));

            $qry = "sp_getemployeestosc $lid, $gid, $sid, $dtf, $dtt";

            $rs = $this->db->query($qry);
            return json_encode($rs->result_array());
        }

        public function getappliedsc(){
            $lid = (isset($_SESSION['userdata']['eid'])) ? $_SESSION['userdata']['eid'] : 0;
            $dtf = (isset($_GET['data']['dtf'])) ? $this->db->escape($_GET['data']['dtf']) : $this->db->escape(date("Y-m-d"));
            $dtt = (isset($_GET['data']['dtt'])) ? $this->db->escape($_GET['data']['dtt']) : $this->db->escape(date("Y-m-d"));

            $qry = "sp_getappliedshiftchange $lid, $dtf, $dtt";

            $rs = $this->db->query($qry);
            return json_encode($rs->result_array());            
        }
                                                         
        public function registerchangeshift(){
            $sid = (isset($_POST['data']['csto']) ? $_POST['data']['csto'] : 0 );
            $dtf = (isset($_POST['data']['dtf'])) ? $this->db->escape($_POST['data']['dtf']) : $this->db->escape(date("Y-m-d"));
            $dtt = (isset($_POST['data']['dtt'])) ? $this->db->escape($_POST['data']['dtt']) : $this->db->escape(date("Y-m-d"));
            $eid = (isset($_POST['data']['eid']) ? $_POST['data']['eid'] : 0 );
            $cid = $_SESSION['userdata']['eid'];

            $qry = "sp_tranchangeshift $sid, $dtf, $dtt, $eid, $cid";

            $rs = $this->db->query($qry);
            return json_encode($rs->result_array());
        }

        public function deletecs(){
            $csid = (isset($_POST['data']['csid']) ? $_POST['data']['csid'] : 0);

            $qry = "sp_cancelchangeshift $csid";
            
            $rs = $this->db->query($qry);
            return json_encode($rs->result_array());
        }

        // Change Group

        public function getmemberstogc(){
            $lid = (isset($_SESSION['userdata']['eid'])) ? $_SESSION['userdata']['eid'] : 0;
            $gid = (isset($_POST['data']['gid'])) ? $_POST['data']['gid'] : 0;
            $dtf = (isset($_POST['data']['dtf'])) ? $this->db->escape($_POST['data']['dtf']) : $this->db->escape(date("Y-m-d"));
            $dtt = (isset($_POST['data']['dtt'])) ? $this->db->escape($_POST['data']['dtt']) : $this->db->escape(date("Y-m-d"));

            $qry = "sp_getgroupmemberstocg $lid, $gid, $dtf, $dtt";

            $rs = $this->db->query($qry);
            return json_encode($rs->result_array());            
        }

        public function getdeptgroups(){
            $lid = (isset($_SESSION['userdata']['eid'])) ? $_SESSION['userdata']['eid'] : 0;
            $did = (isset($_SESSION['userdata']['dept'])) ? $_SESSION['userdata']['dept'] : 0;

            $qry = "sp_getdeptgroups $lid, $did";

            $rs = $this->db->query($qry);
            return json_encode($rs->result_array());   
        }


        // Report

        public function generatelogs(){
            if(isset($_SESSION['userdata'])){
                $ds = (isset($_POST['data']['ds'])) ? $this->db->escape($_POST['data']['ds']) : $this->db->escape(date("Y-m-d"));
                $dt = (isset($_POST['data']['dt'])) ? $this->db->escape($_POST['data']['dt']) : $this->db->escape(date("Y-m-d"));
                $did = $_SESSION['userdata']['dept'];
                $cid = $_SESSION['userdata']['eid'];

                $arr = array();

                $qryt = "sp_generatetimesheet $ds, $dt, $did, $cid";
                $rst = $this->db->query($qryt);

                array_push($arr, $rst->result_array());

                $qryj = "sp_generatejobsheet $ds, $dt, $did, $cid";
                $rsj = $this->db->query($qryj);

                array_push($arr, $rsj->result_array());

                return json_encode($arr);
            }
        }

        public function getforapprovalTS(){
            if(isset($_SESSION['userdata'])){
                $did = $_SESSION['userdata']['dept'];

                $qry = "sp_gettsforapproval $did";
                $rs = $this->db->query($qry);

                return json_encode($rs->result_array());
            }
        }

        public function getmemberswithlogs(){
            if(isset($_SESSION['userdata'])){
                $tsid = (isset($_POST['data']['tsid']) ? $_POST['data']['tsid'] : 0 );
                $cid = $_SESSION['userdata']['eid'];

                $qry = "sp_gettsemployees $tsid, $cid";
                $rs = $this->db->query($qry);

                return json_encode($rs->result_array());
            }            
        }

        public function gettslogs(){
            if(isset($_SESSION['userdata'])){
                $tsid = (isset($_POST['data']['tsid']) ? $_POST['data']['tsid'] : 0 );
                $empid = (isset($_POST['data']['eid']) ? $_POST['data']['eid'] : 0 );

                $qry = "sp_getTSLogs $tsid, $empid";
                $rs = $this->db->query($qry);

                return json_encode($rs->result_array());
            }
        }

        public function getjslogs(){
            if(isset($_SESSION['userdata'])){
                $tsid = (isset($_POST['data']['tsid']) ? $_POST['data']['tsid'] : 0 );
                $empid = (isset($_POST['data']['eid']) ? $_POST['data']['eid'] : 0 );
                $wrkdt = (isset($_POST['data']['wd']) ? $this->db->escape($_POST['data']['wd']) : $this->db->escape(date('Y-m-d')));

                $qry = "sp_getJSLogs $tsid, $empid, $wrkdt";
                $rs = $this->db->query($qry);

                return json_encode($rs->result_array());
            }
        }

        public function changetsstatus(){
            if(isset($_SESSION['userdata'])){
                $styp = (isset($_POST['data']['st']) ? $_POST['data']['st'] : 0 );
                $tsid = (isset($_POST['data']['tsid']) ? $_POST['data']['tsid'] : 0 );
                $cid = $_SESSION['userdata']['eid'];

                $qry = "sp_updatetslogstatus $styp, $tsid, $cid";
                $rs = $this->db->query($qry);

                return json_encode($rs->result_array());
            }            
        }

        public function gettsinfo(){
            if(isset($_SESSION['userdata'])){
                $info = (isset($_POST['data']['info']) ? $_POST['data']['info'] : 0 );
                $tdid = (isset($_POST['data']['tdid']) ? $_POST['data']['tdid'] : 0 );

                $qry = "sp_gettimesheetinfo $info, $tdid";
                $rs = $this->db->query($qry);

                return json_encode($rs->result_array());
            }  
        }

        public function updatetsinfo(){
            if(isset($_SESSION['userdata'])){
                $info = (isset($_POST['data']['info']) ? $_POST['data']['info'] : 0 );
                $tsid = (isset($_POST['data']['tdid']) ? $_POST['data']['tdid'] : 0 );
                $to   = (isset($_POST['data']['to']) ? $this->db->escape($_POST['data']['to']) : $this->db->escape(date("Y-m-d H:i:s")));
                $cid  = $_SESSION['userdata']['eid'];

                $qry = "sp_updtimesheetinfo $info, $tsid, $to, $cid";
                $rs = $this->db->query($qry);

                return json_encode($rs->result_array());
            }  
        }
    }
?>