<?php
    class madmin extends CI_Model {
        public function __construct(){
            parent::__construct();
        }

        function index(){
            
        }

        public function logintosystem(){
            $empid = isset($_POST['data']['lid']) ? $this->db->escape($_POST['data']['lid']) : '0';
            $empwd = isset($_POST['data']['pwd']) ? $this->db->escape($_POST['data']['pwd']) : '';
            $locip = isset($_SERVER['REMOTE_ADDR']) ? $this->db->escape($_SERVER['REMOTE_ADDR']) : '127.0.0.1';
            $sesid = $this->db->escape(session_id());

            $qry = "sp_getvalidateuserlogin $empid, $empwd, $locip, $sesid";

            $rs = $this->db->query($qry);
            $rw = $rs->row();

            if(isset($rw->eid)){
                if($rw->a1 === 1){
                    $udata = array(
                        'eid' => $rw->eid,
                        'ecode' => $rw->ecode,
                        'ename' => $rw->ename,
                        'dept' => $rw->did,
                        'shift' => $rw->sid,
                        'a1' => $rw->a1,
                        'a2' => $rw->a2,
                        'a3' => $rw->a3,
                        'a4' => $rw->a4,
                        'a5' => $rw->a5,
                        'a6' => $rw->a6,
                        'a7' => $rw->a7,
                        'a8' => $rw->a8,
                        'a9' => $rw->a9,
                        'a10' => $rw->a10,
                        'a11' => $rw->a11,
                        'a12' => $rw->a12,
                        'a13' => $rw->a13, 
                        'clientip' => $rw->cip,
                        'sessionid' => $rw->seid
                    );

                    $this->session->set_userdata(array("admindata" => $udata));
                    return json_encode(array('flag' => true, 'message' => 'Employee has been validated/authenticated successfully.', 'sys' => $rw->a1));     
                                   
                } else {
                    return json_encode(array('flag' => false, 'message' => "You don't have sufficient access rights to use the system. Please contact your system administrator."));
                }
            } else {
                return json_encode(array('flag' => false, 'message' => 'Error in validating supplied employee credential. Check your credentials then try again.'));
            }
        }

        // Department
        public function registerDepartment(){
            if(isset($_POST['data'])){
                $cid = (isset($_SESSION['admindata']['eid'])) ? $this->db->escape($_SESSION['admindata']['eid']) : 0;
                $did = (isset($_POST['data']['did'])) ? $this->db->escape($_POST['data']['did']) : 0;
                $dcode = (isset($_POST['data']['dcode'])) ? $this->db->escape($_POST['data']['dcode']) : null;
                $dname = (isset($_POST['data']['dname'])) ? $this->db->escape($_POST['data']['dname']) : null;
                $dlead = (isset($_POST['data']['leadid'])) ? $this->db->escape($_POST['data']['leadid']) : 0;
                $isactive = (isset($_POST['data']['dtype'])) ? $this->db->escape($_POST['data']['dtype']) : 0;

                $qry = "sp_trandepartment $did, $dcode, $dname, $dlead, $isactive, $cid";
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            }
        }

        public function registerWorkcenterToDept(){
            if(isset($_POST['data'])){
                $id = (isset($_POST['data']['id'])) ? $this->db->escape($_POST['data']['id']) : 0;
                $did = (isset($_POST['data']['did'])) ? $this->db->escape($_POST['data']['did']) : 0;
                $wcid = (isset($_POST['data']['wcid'])) ? $this->db->escape($_POST['data']['wcid']) : 0;
                $isactive = (isset($_POST['data']['isactive'])) ? $this->db->escape($_POST['data']['isactive']) : 0;
                $cid = (isset($_SESSION['admindata']['eid'])) ? $this->db->escape($_SESSION['admindata']['eid']) : 0;

                $qry = "sp_trandeptworkcenter $id, $did, $wcid, $isactive, $cid";


                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            }            
        }

        public function getDepartment(){
            if(isset($_GET['data'])){
                $listtype = $_GET['data'];
                $qry = "sp_getdepartments $listtype";
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            }
        }

        public function getDeptWorkcenters(){
            if(isset($_GET['data'])){
                $listtype = $_GET['data']['lt'];
                $deptid = $_GET['data']['dept'];

                $qry = "sp_getdepartments $listtype, $deptid";
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            }            
        }

        public function getDepartmentInfo(){
            if(isset($_GET['lt'])){
                $listtype = $_GET['lt'];
                $id = $_GET['dept'];
                $qry = "sp_getdepartments $listtype, $id";
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            }            
        }

        public function getDepartmentLeads(){
            $qry = "sp_getemployees 3, 0, ''";
            $rs = $this->db->query($qry);
            return json_encode($rs->result_array());
        }

        public function getWorkcenters(){
            if(isset($_GET['data'])){
                $listtype = isset($_GET['data']['lt']) ? $this->db->escape($_GET['data']['lt']) : 0;
                $wcid = isset($_GET['data']['wcid']) ? $this->db->escape($_GET['data']['wcid']) : 0;
                $did = isset($_GET['data']['did']) ? $this->db->escape($_GET['data']['did']) : 0;

                $qry = "sp_getworkcenters $listtype, $wcid, $did";

                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());                
            }
        }
        // End Department

        // Workgroup
        public function getworkgroups(){
            if(isset($_GET['data'])){
                $listype = (isset($_GET['data']['lt'])) ? $this->db->escape($_GET['data']['lt']) : 0;
                $grpid = (isset($_GET['data']['gid'])) ? $this->db->escape($_GET['data']['gid']) : 0;
                $empid = (isset($_SESSION['admindata']['eid'])) ? $this->db->escape($_SESSION['admindata']['eid']) : 0;

                $qry = "sp_getworkgroups $listype, $grpid, $empid";
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            }
        }

        public function getwgmembers(){
            if(isset($_GET['data'])){
                $listype = (isset($_GET['data']['lt'])) ? $this->db->escape($_GET['data']['lt']) : 0;
                $grpid = (isset($_GET['data']['gid'])) ? $this->db->escape($_GET['data']['gid']) : 0;
                $empid = (isset($_SESSION['admindata']['eid'])) ? $this->db->escape($_SESSION['admindata']['eid']) : 0;

                $qry = "sp_getworkgroups $listtype, $grpid, $eid";
                echo $qry;
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            }
        }

        public function registerworkgroup(){
            if(isset($_POST['data'])){
                $gid = (isset($_POST['data']['gid'])) ? $this->db->escape($_POST['data']['gid']) : 0;
                $gcode = (isset($_POST['data']['gc'])) ? $this->db->escape($_POST['data']['gc']) : 'N/A';
                $gname = (isset($_POST['data']['gn'])) ? $this->db->escape($_POST['data']['gn']) : 'N/A';
                $glid = (isset($_POST['data']['gl'])) ? $this->db->escape($_POST['data']['gl']) : 0;
                $isactive = (isset($_POST['data']['ia'])) ? $this->db->escape($_POST['data']['ia']) : 0;
                $cid = (isset($_SESSION['admindata']['eid'])) ? $this->db->escape($_SESSION['admindata']['eid']) : 0;

                $qry = "sp_trangroups $gid, $gcode, $gname, $cid, $isactive, $cid";
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            }
        }

        public function registerwgmember(){
            if(isset($_POST['data'])){
                $mid = (isset($_POST['data']['mid'])) ? $this->db->escape($_POST['data']['mid']) : 0;
                $gid = (isset($_POST['data']['gid'])) ? $this->db->escape($_POST['data']['gid']) : 0;
                $eid = (isset($_POST['data']['eid'])) ? $this->db->escape($_POST['data']['eid']) : 0;
                $isactive = (isset($_POST['data']['ia'])) ? $this->db->escape($_POST['data']['ia']) : 0;
                $cid = (isset($_SESSION['admindata']['eid'])) ? $this->db->escape($_SESSION['admindata']['eid']) : 0;

                $arrs = array();

                if(count($eid) > 0){
                    for($i=0; $i <= (count($eid) -1); $i++){
                        $ee = $eid[$i];
                        $qry = "sp_trangroupmembers $mid, $gid, $ee, $isactive, $cid";
                        $rs = $this->db->query($qry);

                        $arr = array("id" => $ee, "result" => $rs->result());

                        array_push($arrs, $arr);
                    }
                } else {
                    array_push($arrs, array("id" => 0, "result" => array("flag" => 0, "msg" => "Failed to add member to group.")));
                }
                return json_encode($arrs);
            }
        }

        public function getdeptapprovers(){
            if(isset($_SESSION['admindata'])){
                $did = $_SESSION['admindata']['dept'];

                $qry = "sp_getdeptapprovers $did";
                $rs = $this->db->query($qry);

                return json_encode($rs->result_array());
            }
        }

        public function getapprovers(){
            if(isset($_SESSION['admindata'])){
                $did = $_SESSION['admindata']['dept'];

                $qry = "sp_getapprovers $did";
                $rs = $this->db->query($qry);

                return json_encode($rs->result_array());
            }            
        }

        public function registerapprover(){
            if(isset($_POST['data'])){
                $id = (isset($_POST['data']['id']) ? $_POST['data']['id'] : 0 );
                $eid = (isset($_POST['data']['eid']) ? $_POST['data']['eid'] : 0 );
                $pl = (isset($_POST['data']['pl']) ? $_POST['data']['pl'] : 0 );
                $oa = (isset($_POST['data']['oa']) ? $_POST['data']['oa'] : 0 );
                $td = ($id > 0 ? 1 : 0);

                $qry = "sp_tranapprovers $id, $eid, $pl, $oa, $td";

                $rs = $this->db->query($qry);

                return json_encode($rs->result_array());
            }
        }
        // End Workgroup

        // Workshifts
        public function getworkshifts(){
            if(isset($_GET['data'])){
                $listype = (isset($_GET['data']['lt'])) ? $this->db->escape($_GET['data']['lt']) : 0;
                $sid = (isset($_GET['data']['sid'])) ? $this->db->escape($_GET['data']['sid']) : 0;

                $qry = "sp_getworkshifts $listype, $sid";
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            }
        }

        public function registerworkshifts(){
            if(isset($_POST['data'])){
                $sid = (isset($_POST['data']['sid'])) ? $_POST['data']['sid'] : 0;
                $scode = (isset($_POST['data']['sc'])) ? $this->db->escape($_POST['data']['sc']) : '00000';
                $sdesc = (isset($_POST['data']['sd'])) ? $this->db->escape($_POST['data']['sd']) : 'Not defined';
                $stype = (isset($_POST['data']['st'])) ? $_POST['data']['st'] : 0;
                $ts = (isset($_POST['data']['sts'])) ? $this->db->escape($_POST['data']['sts']) : '00:00:00.000';
                $te = (isset($_POST['data']['ste'])) ? $this->db->escape($_POST['data']['ste']) : '00:00:00.000';
                $wh = (isset($_POST['data']['wh'])) ? $_POST['data']['wh'] : 0;
                $ia = (isset($_POST['data']['ia'])) ? $_POST['data']['ia'] : 0;
                $mon = (isset($_POST['data']['mon'])) ? $_POST['data']['mon'] : 0;
                $tue = (isset($_POST['data']['tue'])) ? $_POST['data']['tue'] : 0;
                $wed = (isset($_POST['data']['wed'])) ? $_POST['data']['wed'] : 0;
                $thu = (isset($_POST['data']['thu'])) ? $_POST['data']['thu'] : 0;
                $fri = (isset($_POST['data']['fri'])) ? $_POST['data']['fri'] : 0;
                $sat = (isset($_POST['data']['sat'])) ? $_POST['data']['sat'] : 0;
                $sun = (isset($_POST['data']['sun'])) ? $_POST['data']['sun'] : 0;
                $lb = (isset($_POST['data']['lb'])) ? $_POST['data']['lb'] : 0;
                $lbf = (isset($_POST['data']['lbf'])) ? $_POST['data']['lbf'] : 0;
                $cb1 = (isset($_POST['data']['cb1'])) ? $_POST['data']['cb1'] : 0;
                $cb1f = (isset($_POST['data']['cb1f'])) ? $_POST['data']['cb1f'] : 0;
                $cb2 = (isset($_POST['data']['cb2'])) ? $_POST['data']['cb2'] : 0;
                $cb2f = (isset($_POST['data']['cb2f'])) ? $_POST['data']['cb2f'] : 0;

                $eid = (isset($_SESSION['admindata']['eid'])) ? $this->db->escape($_SESSION['admindata']['eid']) : 0;
                if(strlen(trim($lb)) == 0){ $lb = 0; }
                if(strlen(trim($cb1)) == 0){ $cb1 = 0; }
                if(strlen(trim($cb2)) == 0){ $cb2 = 0; }

                if($ia == 0){
                    $ts = $this->db->escape('00:00:00.000');
                    $te = $this->db->escape('00:00:00.000');
                }

                if($stype == 1){
                    $qry = "sp_transhifts $sid, $scode, $sdesc, 1, $ts, $te, 0, 0, 0, $wh, $mon, $tue, $wed, $thu, $fri, $sat, $sun, $cb1, $cb1f, $lb, $lbf, $cb2, $cb2f, $ia, $eid";
                } elseif($stype == 2){
                    $qry = "sp_transhifts $sid, $scode, $sdesc, 0, $ts, $te, 0, 0, 1, $wh, $mon, $tue, $wed, $thu, $fri, $sat, $sun, $cb1, $cb1f, $lb, $lbf, $cb2, $cb2f, $ia, $eid";
                } elseif($stype == 3){
                    $qry = "sp_transhifts $sid, $scode, $sdesc, 0, $ts, $te, 1, $wh, 0, 0, $mon, $tue, $wed, $thu, $fri, $sat, $sun, $cb1, $cb1f, $lb, $lbf, $cb2, $cb2f, $ia, $eid"; 
                } else {
                    $qry = "sp_transhifts $sid, $scode, $sdesc, 1, $ts, $te, 0, 0, 0, $wh, $mon, $tue, $wed, $thu, $fri, $sat, $sun, $cb1, $cb1f, $lb, $lbf, $cb2, $cb2f, $ia, $eid";
                }

                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            }
        }

        // End Workshifts

        // Workcenters
        function registerWorkCenters(){
            if(isset($_POST['data'])){
                $wcid = (isset($_POST['data']['wcid'])) ? $this->db->escape($_POST['data']['wcid']) : 0;
                $wccode = (isset($_POST['data']['wc'])) ? $this->db->escape($_POST['data']['wc']) : '';
                $wcdesc = (isset($_POST['data']['wd'])) ? $this->db->escape($_POST['data']['wd']) : '';
                $isactive = (isset($_POST['data']['ia'])) ? $this->db->escape($_POST['data']['ia']) : 0;
                $eid = (isset($_SESSION['admindata']['eid'])) ? $this->db->escape($_SESSION['admindata']['eid']) : 0;

                $qry = "sp_tranworkcenter $wcid, $wccode, $wcdesc, $isactive, $eid";

                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            }
        }

        // End Workcenters

        // Activity
        function getActivityForWorkcenter(){
            if(isset($_GET['data'])){
                $listtype = (isset($_GET['data']['lt']) ? $this->db->escape(($_GET['data']['lt'])) : 0);
                $actid = (isset($_GET['data']['aid']) ? $this->db->escape(($_GET['data']['aid'])) : 0);
                $wcid = (isset($_GET['data']['wcid']) ? $this->db->escape(($_GET['data']['wcid'])) : 0);

                $qry = "sp_getactivity $listtype, $actid, $wcid";

                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            }
        }

        function registerActivity(){
            if(isset($_POST['data'])){
                $actid = (isset($_POST['data']['aid']) ? $this->db->escape($_POST['data']['aid']) : 0);
                $actcode = (isset($_POST['data']['acode']) ? $this->db->escape($_POST['data']['acode']) : '');
                $actdesc = (isset($_POST['data']['adesc']) ? $this->db->escape($_POST['data']['adesc']) : '');
                $wcid = (isset($_POST['data']['wcid']) ? $this->db->escape($_POST['data']['wcid']) : 0);
                $isactive = (isset($_POST['data']['ia']) ? $this->db->escape($_POST['data']['ia']) : 0);
                $eid = (isset($_SESSION['admindata']['eid']) ? $this->db->escape($_SESSION['admindata']['eid']) : 0);

                $qry = "sp_tranactivity $actid, $wcid, $actcode, $actdesc, $isactive, $eid";

                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            }
        }

        // End Activity

        // Employees
        public function getEmployees(){
            if(isset($_GET['data'])){
                $listype = (isset($_GET['data']['lt'])) ? $_GET['data']['lt'] : 0;
                $eid     = (isset($_GET['data']['eid'])) ? $_GET['data']['eid'] : 0;
                $find    = (isset($_GET['data']['find'])) ? $this->db->escape($_GET['data']['find']) : "";

                if(strlen($find) > 0){
                    $qry = "sp_getemployees $listype, $eid, $find";
                } else {
                    $qry = "sp_getemployees $listype, $eid";
                }
                
                $rs = $this->db->query($qry); 
                return json_encode($rs->result_array());
            }
        }

        public function registerEmployee(){
            if(isset($_POST['data'])){
                $id = (isset($_POST['data']['eid'])) ? $this->db->escape($_POST['data']['eid'] ) : 0;
                $ecode = (isset($_POST['data']['ec'])) ? $this->db->escape($_POST['data']['ec'] ) : 0;
                $epwd = (isset($_POST['data']['pwd'])) ? $this->db->escape($_POST['data']['pwd'] ) : '';
                $role = (isset($_POST['data']['role'])) ? $this->db->escape($_POST['data']['role'] ) : 0;
                $exec = (isset($_POST['data']['exec'])) ? $this->db->escape($_POST['data']['exec'] ) : 0;
                $efn = (isset($_POST['data']['efn'])) ? $this->db->escape($_POST['data']['efn'] ) : '';
                $eln = (isset($_POST['data']['eln'])) ? $this->db->escape($_POST['data']['eln'] ) : '';
                $emn = (isset($_POST['data']['emn'])) ? $this->db->escape($_POST['data']['emn'] ) : '';
                $addr = (isset($_POST['data']['addr'])) ? $this->db->escape($_POST['data']['addr'] ) : '';
                $city = (isset($_POST['data']['city'])) ? $this->db->escape($_POST['data']['city'] ) : '';
                $state = (isset($_POST['data']['state'])) ? $this->db->escape($_POST['data']['state'] ) : '';
                $zip = (isset($_POST['data']['zip'])) ? $this->db->escape($_POST['data']['zip'] ) : '';
                $country = (isset($_POST['data']['country'])) ? $this->db->escape($_POST['data']['country'] ) : '';
                $phone = (isset($_POST['data']['phone'])) ? $this->db->escape($_POST['data']['phone'] ) : '';
                $hrrate = (isset($_POST['data']['rate'])) ? $this->db->escape($_POST['data']['rate'] ) : 0;
                $did = (isset($_POST['data']['did'])) ? $this->db->escape($_POST['data']['did'] ) : 0;
                $sid = (isset($_POST['data']['sid'])) ? $this->db->escape($_POST['data']['sid'] ) : 0;
                $jpost = (isset($_POST['data']['jp'])) ? $this->db->escape($_POST['data']['jp'] ) : '';
                $dthire = (isset($_POST['data']['dh'])) ? $this->db->escape($_POST['data']['dh'] ) : $this->db->escape(date("Y-m-d"));
                $dtleft = (isset($_POST['data']['dl'])) ? $this->db->escape($_POST['data']['dl'] ) : null; 
                $active = (isset($_POST['data']['ia'])) ? $this->db->escape($_POST['data']['ia'] ) : 0;
                $eid = (isset($_SESSION['admindata']['eid']) ? $this->db->escape($_SESSION['admindata']['eid']) : 0);

                if($active === 0){
                    $qry = "sp_tranemployee $id, $ecode, '', $role, $exec, $eln, $efn, $emn, $addr, $city, $state, $zip, $country, $phone, '000-000-000', $hrrate, $did, $sid, $jpost, $dthire, null, $active, $eid";
                } else {
                    $qry = "sp_tranemployee $id, $ecode, '', $role, $exec, $eln, $efn, $emn, $addr, $city, $state, $zip, $country, $phone, '000-000-000', $hrrate, $did, $sid, $jpost, $dthire, $dtleft, $active, $eid";
                }
                
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            }
        }

        public function resetpwd(){
            if(isset($_POST['data'])){
                $id = (isset($_POST['data']['eid'])) ? $_POST['data']['eid'] : 0;

                $qry = "sp_resetpassword $id";

                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            
            }
        }

        // End Employees

        // Roles
        function getRoles(){
            if(isset($_GET['data'])){
                $listype = (isset($_GET['data']['lt'])) ? $this->db->escape($_GET['data']['lt']) : 0;
                $rid = (isset($_GET['data']['rid'])) ? $this->db->escape($_GET['data']['rid']) : 0;

                $qry = "sp_getroles $listype, $rid";
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            }
        }

        function registerRoles(){
            if(isset($_POST['data'])){
                $rid = (isset($_POST['data']['rid'])) ? $this->db->escape($_POST['data']['rid']) : 0;
                $code = (isset($_POST['data']['rc'])) ? $this->db->escape($_POST['data']['rc']) : '';
                $desc = (isset($_POST['data']['rd'])) ? $this->db->escape($_POST['data']['rd']) : '';
                $ca1 = (isset($_POST['data']['cl'])) ? $this->db->escape($_POST['data']['cl']) : 0;
                $ca2 = (isset($_POST['data']['cg'])) ? $this->db->escape($_POST['data']['cg']) : 0;
                $aa1 = (isset($_POST['data']['al'])) ? $this->db->escape($_POST['data']['al']) : 0;
                $aa2 = (isset($_POST['data']['ad'])) ? $this->db->escape($_POST['data']['ad']) : 0;
                $aa3 = (isset($_POST['data']['awg'])) ? $this->db->escape($_POST['data']['awg']) : 0;
                $aa4 = (isset($_POST['data']['aws'])) ? $this->db->escape($_POST['data']['aws']) : 0;
                $aa5 = (isset($_POST['data']['awc'])) ? $this->db->escape($_POST['data']['awc']) : 0;
                $aa6 = (isset($_POST['data']['aa'])) ? $this->db->escape($_POST['data']['aa']) : 0;
                $aa7 = (isset($_POST['data']['ac'])) ? $this->db->escape($_POST['data']['ac']) : 0;
                $aa8 = (isset($_POST['data']['aj'])) ? $this->db->escape($_POST['data']['aj']) : 0;
                $aa9 = (isset($_POST['data']['ae'])) ? $this->db->escape($_POST['data']['ae']) : 0;
                $aa10 = (isset($_POST['data']['ar'])) ? $this->db->escape($_POST['data']['ar']) : 0;
                $aa11 = (isset($_POST['data']['aro'])) ? $this->db->escape($_POST['data']['aro']) : 0;
                $aa12 = (isset($_POST['data']['ara'])) ? $this->db->escape($_POST['data']['ara']) : 0;
                $aa13 = (isset($_POST['data']['ado'])) ? $this->db->escape($_POST['data']['ado']) : 0;
                $ia = (isset($_POST['data']['ia'])) ? $this->db->escape($_POST['data']['ia']) : 0;
                $eid = (isset($_SESSION['admindata']['eid']) ? $this->db->escape($_SESSION['admindata']['eid']) : 0);

                $qry = "sp_tranuserroles $rid, $code, $desc, $ca1, $ca2, $aa1, $aa2, $aa3, $aa4, $aa5, $aa6, $aa7, $aa8, $aa9, $aa10, $aa11, $aa12, $aa13, $ia, $eid";
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            }
        }

        // End Roles

        // Customers
        function getCustomers(){
            $listype = (isset($_GET['data']['lt'])) ? $this->db->escape($_GET['data']['lt']) : 0;
            $eid = (isset($_GET['data']['cid'])) ? $this->db->escape($_GET['data']['cid']) : 0;
            $find = (isset($_GET['data']['find'])) ? $this->db->escape($_GET['data']['find']) : '';

            $qry = "sp_getcustomer $listype, $eid, $find";
            $rs = $this->db->query($qry);
            return json_encode($rs->result_array());
        }

        function registerCustomers(){
            $id = (isset($_POST['data']['cid'])) ? $this->db->escape($_POST['data']['cid']) : 0;
            $ccode = (isset($_POST['data']['cc'])) ? $this->db->escape($_POST['data']['cc'] ) : 0;
            $cname = (isset($_POST['data']['cn'])) ? $this->db->escape($_POST['data']['cn'] ) : '';
            $addr1 = (isset($_POST['data']['addr1'])) ? $this->db->escape($_POST['data']['addr1'] ) : '';
            $addr2 = (isset($_POST['data']['addr2'])) ? $this->db->escape($_POST['data']['addr2'] ) : '';
            $city = (isset($_POST['data']['city'])) ? $this->db->escape($_POST['data']['city'] ) : '';
            $state = (isset($_POST['data']['state'])) ? $this->db->escape($_POST['data']['state'] ) : '';
            $zip = (isset($_POST['data']['zip'])) ? $this->db->escape($_POST['data']['zip'] ) : '';
            $country = (isset($_POST['data']['country'])) ? $this->db->escape($_POST['data']['country'] ) : '';
            $phone = (isset($_POST['data']['phone'])) ? $this->db->escape($_POST['data']['phone'] ) : '';
            $active = (isset($_POST['data']['ia'])) ? $this->db->escape($_POST['data']['ia'] ) : 0;
            $eid = (isset($_SESSION['admindata']['eid']) ? $this->db->escape($_SESSION['admindata']['eid']) : 0);

            $qry = "sp_trancustomer $id, $ccode, $cname, $addr1, $addr2, $city, $state, $zip, $country, $phone, $active, $eid";
            $rs = $this->db->query($qry);
            return json_encode($rs->result_array());
        }

        // End Customers


        // Job Orders
        function getJOs(){
            if(isset($_GET['data'])){
                $listype = (isset($_GET['data']['lt'])) ? $this->db->escape($_GET['data']['lt']) : 0;
                $joid = (isset($_GET['data']['joid'])) ? $this->db->escape($_GET['data']['joid']) : 0;
                $find = (isset($_GET['data']['find'])) ? $this->db->escape($_GET['data']['find']) : 0;

                $qry = "sp_getjos $listype, $joid, $find";
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            }
        }

        function registerJOs(){
            if(isset($_POST['data'])){
                $id = (isset($_POST['data']['id'])) ? $this->db->escape($_POST['data']['id']) : 0;
                $cuid = 0;//(isset($_POST['data']['joid'])) ? $this->db->escape($_POST['data']['joid']) : 0;
                $jono = (isset($_POST['data']['jn'])) ? $this->db->escape($_POST['data']['jn']) : 0;
                $desc = (isset($_POST['data']['jd'])) ? $this->db->escape($_POST['data']['jd']) : 0;
                $active = (isset($_POST['data']['ia'])) ? $this->db->escape($_POST['data']['ia']) : 0;
                $eid = (isset($_SESSION['admindata']['eid']) ? $this->db->escape($_SESSION['admindata']['eid']) : 0);


                $qry = "sp_tranjos $id, $cuid, $jono, $desc, $active, $eid";
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            }
        }

        function getJODetails(){
            if(isset($_GET['data'])){
                $listype = (isset($_GET['data']['lt'])) ? $this->db->escape($_GET['data']['lt']) : 0;
                $jdid = (isset($_GET['data']['jdid'])) ? $this->db->escape($_GET['data']['jdid']) : 0;
                $joid = (isset($_GET['data']['joid'])) ? $this->db->escape($_GET['data']['joid']) : 0;
                $find = (isset($_GET['data']['find'])) ? $this->db->escape($_GET['data']['find']) : 0;

                $qry = "sp_getjodetails $listype, $jdid, $joid, $find";
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            }
        }

        function registerJODetails(){
            if(isset($_POST['data'])){
                $id = (isset($_POST['data']['id'])) ? $this->db->escape($_POST['data']['id']) : 0;
                $oid = (isset($_POST['data']['oid'])) ? $this->db->escape($_POST['data']['oid']) : 0;
                $jobno = (isset($_POST['data']['jn'])) ? $this->db->escape($_POST['data']['jn']) : 0;
                $partno = (isset($_POST['data']['pn'])) ? $this->db->escape($_POST['data']['pn']) : 0;
                $partdesc = (isset($_POST['data']['pd'])) ? $this->db->escape($_POST['data']['pd']) : 0;
                $active = (isset($_POST['data']['ia'])) ? $this->db->escape($_POST['data']['ia']) : 0;
                $eid = (isset($_SESSION['admindata']['eid']) ? $this->db->escape($_SESSION['admindata']['eid']) : 0);


                $qry = "sp_tranjodetails $id, $oid, $jobno, $partno, $partdesc, $active, $eid";
                $rs = $this->db->query($qry);
                return json_encode($rs->result_array());
            }
        }

        // End Job Orders

        // Orders

        // End Orders
    }
?>