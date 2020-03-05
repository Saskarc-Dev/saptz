<?php
    class jobtracker extends CI_Controller {
        
        public function __construct(){
            parent::__construct();
            $this->load->model('client/mjobtracker');
            $this->session->set_userdata(array("viewType" => "client"));
        }

        public function index(){
            if(isset($_SESSION['userdata'])){
                if($_SESSION['userdata']['pwdc'] > 0){
                    $this->mjobtracker->fillnologdates();
                    $this->mjobtracker->getlogstats();
                    $this->load->view('layout/header');
                    $this->load->view('client/officeclock');
                    $this->load->view('layout/footer');                    
                } else {
                    $this->load->view('layout/header', $nav['navdisable'] = "none");
                    $this->load->view('client/resetpassword');
                    $this->load->view('layout/footer');
                }

            } else {
                $this->load->view('layout/header', $nav['navdisable'] = "none");
                $this->load->view('client/login');
                $this->load->view('layout/footer');
            }
        }

        public function login(){
            $data = $this->mjobtracker->logintosystem();
            echo $data;
        }

        public function logout(){
            $this->session->sess_destroy();
            echo json_encode(array(true, "User succesfully logged out.")); 
        }

        public function home(){
            header("Location: http://saptz:8081");
        }

        public function myinfo(){
            if(isset($_SESSION['userdata'])){
                $this->load->view('layout/header');
                $this->load->view('client/myinfo');
                $this->load->view('layout/footer');                
            } else {
                header("Location: http://saptz:8081");
            }
        }

        public function mytimesheet(){
            if(isset($_SESSION['userdata'])){
                $this->load->view('layout/header');
                $this->load->view('client/timesheet');
                $this->load->view('layout/footer');                
            } else {
                header("Location: http://saptz:8081");
            } 
        }

        public function myjobsheet(){
            if(isset($_SESSION['userdata'])){
                $this->load->view('layout/header');
                $this->load->view('client/jobsheet');
                $this->load->view('layout/footer');                     
            } else {
                header("Location: http://saptz:8081");
            } 
        }

        public function myjobs(){
            if(isset($_SESSION['userdata'])){
                $this->mjobtracker->getpendingjobs();
                $this->load->view('layout/header');
                $this->load->view('client/jobs');
                $this->load->view('layout/footer');                
            } else {
                header("Location: http://saptz:8081");
            }
        }

        public function mygroupjobs(){
            if(isset($_SESSION['userdata'])){
                $this->load->view('layout/header');
                $this->load->view('client/jobsgroup');
                $this->load->view('layout/footer');                
            } else {
                header("Location: http://saptz:8081");
            }            
        }

        public function myreports(){
            if(isset($_SESSION['userdata'])){
                $this->load->view('layout/header');
                $this->load->view('client/report');
                $this->load->view('layout/footer');                
            } else {
                header("Location: http://saptz:8081");
            }  
        }

        public function shiftchange(){
            if(isset($_SESSION['userdata'])){
                $this->load->view('layout/header');
                $this->load->view('client/changeshift');
                $this->load->view('layout/footer');                
            } else {
                header("Location: http://saptz:8081");
            }  
        }

        public function groupchange(){
            if(isset($_SESSION['userdata'])){
                $this->load->view('layout/header');
                $this->load->view('client/changegroup');
                $this->load->view('layout/footer');                
            } else {
                header("Location: http://saptz:8081");
            }  
        }



        // API

        public function changepassword(){
            $data = $this->mjobtracker->changepwd();
            echo $data;
        }
        public function logtimesheet(){
            $data = $this->mjobtracker->logtotimesheet();
            echo $data;
        }

        public function updatestatus(){
            $data = $this->mjobtracker->getlogstats();
            echo $data;
        }        

        public function logjob(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->logtojobsheet();
                echo $data;          
            } else {
                header("Location: http://saptz:8081");
            }         
        }

        public function loggroupjob(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->registergroupjob();
                echo $data;          
            } else {
                header("Location: http://saptz:8081");
            }             
        }

        public function clockoutgroup(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->clockoutgroupjob();
                echo $data;          
            } else {
                header("Location: http://saptz:8081");
            }                
        }

        public function logmembertojob(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->registermemberongroupjob();
                echo $data;          
            } else {
                header("Location: http://saptz:8081");
            }               
        }

        public function clockoutmember(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->clockoutgroupjobmember();
                echo $data;          
            } else {
                header("Location: http://saptz:8081");
            }                
        }

        public function loadjobmembers(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->getmembersfromjob();
                echo $data;          
            } else {
                header("Location: http://saptz:8081");
            }
        }

        public function logtime(){
            if(isset($_SESSION['userdata'])){
                
                $this->mjobtracker->getlogstats();
                $this->mjobtracker->getpendingjobs();

                if($_POST['data'] !== 'timeout'){
                    if($_SESSION['inout'] == 0){
                        $res = $this->mjobtracker->logtotimesheet();
                        if(boolval($res[0]) == true){          
                            //$this->index();
                            echo $res;
                        }
                    } else {
                        echo json_encode(array("flag" => false, "message" => "You still have pending jobs. Go to My->Activity, clock out all of your pending jobs then try logging out again."));
                    }

                } else {
                    $res = $this->mjobtracker->logtotimesheet();
                    if(boolval($res[0]) == true){          
                        //$this->index();
                        echo $res;
                    } else {
                        echo json_encode(array("flag" => false, "message" => "Error clocking out from work, please contact your system administrator!"));
                    }
                }
               
            } else {
                header("Location: http://saptz:8081");
            } 
        }

        public function timesheetbyrange(){
            if(isset($_SESSION['userdata'])){
                if(isset($_GET['data']['start']) && isset($_GET['data']['end'])){
                    $data = $this->mjobtracker->gettimesheetbyrange();
                    echo $data;                     
                }
            } else {
                header("Location: http://saptz:8081");
            } 
        }

        public function jobsheetbyrange(){
            if(isset($_SESSION['userdata'])){
                if(isset($_POST['data']['start']) && isset($_POST['data']['end'])){
                    $data = $this->mjobtracker->getjobsheetbyrange();
                    echo $data;
                }
            } else {
                header("Location: http://saptz:8081");
            }
        }

        public function jobsheet(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->getjoblogs();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }
        }

        public function loadworkcenters(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->getworkcenters();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }
        }

        public function loadactivity(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->getactivity();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }
        }

        public function loadnonactivity(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->getnonactivity();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }
        }

        public function loadJOs(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->getJOs();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }
        }

        public function loadJODetails(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->getJODetails();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }
        }

        public function loadgroups(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->getgroups();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }            
        }

        public function loadworkgroups(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->getworkgroups();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }            
        }

        public function loadgrpmembers(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->getgroupmembers();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }
        }

        public function loadavailablegms(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->getavailablegms();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }
        }

        public function loadgroupjobs(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->getgroupjoblogs();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }            
        }
        
        public function loadactivejobmembers(){
            if(isset($_SESSION['userdata'])){
                $eid = $_SESSION['userdata']['eid'];
                $data = $this->mjobtracker->getactivejobmembers();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }             
        }

        public function loadshifts(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->getshifts();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }               
        }

        public function loadmemberstosc(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->getmemberstosc();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }              
        }

        public function loadappliedsc(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->getappliedsc();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }             
        }

        public function tranchangeshift(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->registerchangeshift();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }
        }

        public function deletechangeshift(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->deletecs();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }            
        }

        public function loadmemberstogc(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->getmemberstogc();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }               
        }

        public function loaddeptgroups(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->getdeptgroups();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }               
        }

        public function groupjobclockout(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->clockoutgroupfromjob();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }             
        }

        public function memberjobclockout(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->clockoutmemberfromjob();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }             
        }

        public function generatetimesheet(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->generatelogs();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }
        }

        public function loadfas(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->getforapprovalTS();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }
        }

        public function loadtsmembers(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->getmemberswithlogs();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }
        }

        public function loadtslogs(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->gettslogs();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }            
        }

        public function loadjslogs(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->getjslogs();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }            
        }

        public function updatetsstatus(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->changetsstatus();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }              
        }

        public function loadtsinfo(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->gettsinfo();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }     
        }

        public function updatetsinfo(){
            if(isset($_SESSION['userdata'])){
                $data = $this->mjobtracker->updatetsinfo();
                echo $data;
            } else {
                header("Location: http://saptz:8081");
            }     
        }
        
    }
?>