<?php
    class admin extends CI_Controller {
        public function __construct(){
            parent::__construct();
            $this->load->model('admin/madmin');
            $this->session->set_userdata(array('viewType' => 'admin'));
        }

        public function index(){
            if(isset($_SESSION['admindata'])){
                $this->load->view('layout/header');
                $this->load->view('admin/home');
                $this->load->view('layout/footer');                  
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function login(){
            $data = $this->madmin->logintosystem();
            echo $data;
        }

        public function logout(){
            $this->session->sess_destroy();
            $this->index();
        }

        // Manage -> Company (menu)

        public function department(){
            if(isset($_SESSION['admindata'])){
                $this->load->view('layout/header', $nav['navdisable'] = "none");
                $this->load->view('admin/department');
                $this->load->view('layout/footer');                
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function groups(){
            if(isset($_SESSION['admindata'])){
                $this->load->view('layout/header', $nav['navdisable'] = "none");
                $this->load->view('admin/groups');
                $this->load->view('layout/footer');
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function shifts(){
            if(isset($_SESSION['admindata'])){
                $this->load->view('layout/header', $nav['navdisable'] = "none");
                $this->load->view('admin/workshifts');
                $this->load->view('layout/footer');
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function workcenters(){
            if(isset($_SESSION['admindata'])){
                $this->load->view('layout/header', $nav['navdisable'] = "none");
                $this->load->view('admin/workcenters');
                $this->load->view('layout/footer');
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function activity(){
            if(isset($_SESSION['admindata'])){
                $this->load->view('layout/header', $nav['navdisable'] = "none");
                $this->load->view('admin/activity');
                $this->load->view('layout/footer');
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        // Manage -> Projects (menu)

        public function customers(){
            if(isset($_SESSION['admindata'])){
                $this->load->view('layout/header', $nav['navdisable'] = "none");
                $this->load->view('admin/customer');
                $this->load->view('layout/footer');
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function joborders(){
            if(isset($_SESSION['admindata'])){
                $this->load->view('layout/header', $nav['navdisable'] = "none");
                $this->load->view('admin/joborders');
                $this->load->view('layout/footer');
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        // Manage -> Accounts

        public function employee(){
            if(isset($_SESSION['admindata'])){
                $this->load->view('layout/header', $nav['navdisable'] = "none");
                $this->load->view('admin/employee');
                $this->load->view('layout/footer');
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function roles(){
            if(isset($_SESSION['admindata'])){
                $this->load->view('layout/header', $nav['navdisable'] = "none");
                $this->load->view('admin/roles');
                $this->load->view('layout/footer');
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }


        // API

        // Department
        public function regdepartment() {
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->registerDepartment();
                echo $data;                
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function regworkcentertodept(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->registerWorkcenterToDept();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function loaddepartments() {
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->getDepartment();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function loaddeptworkcenters(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->getDeptWorkcenters();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function loaddeptinfo(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->getDepartmentInfo();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function loadleads(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->getDepartmentLeads();
                echo $data; 
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function loaddrpworkcenters(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->getWorkcenters();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }
        // End Department

        // Workgroups
        public function regworkgroup(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->registerworkgroup();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function regwgmember(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->registerwgmember();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function loadworkgroup(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->getworkgroups();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function loadwgmembers(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->getwgmembers();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function loadwgemployees(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->getworkgroups();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function loadapprovers(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->getapprovers();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }           
        }

        public function loaddeptapprovers(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->getdeptapprovers();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }           
        }

        public function deregapprover(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->registerapprover();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }
        // End Workgroups

        // Workshifts
        public function loadworkshifts(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->getworkshifts();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function regworkshift(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->registerworkshifts();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }
        // End Workshifts

        // Workcenters
        public function loadworkcenters(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->getWorkcenters();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function regworkcenter(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->registerWorkCenters();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }
        // End Workcenters

        // Activity
        public function loadactivity(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->getActivityForWorkcenter();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function regactivity(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->registerActivity();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        // End Activity

        // Employees
        public function loademployees(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->getEmployees();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function regemployee(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->registerEmployee();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        // End Employees

        // Roles
        public function loaduserroles(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->getRoles();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function reguserroles(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->registerRoles();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        // End Roles

        // Customers
        public function loadcustomers(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->getCustomers();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function regcustomer(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->registerCustomers();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }
        // End Customers

        // Job Orders
        public function loadjobs(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->getJOs();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function loadorders(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->getJODetails();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function regjob(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->registerJOs();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        public function regorders(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->registerJODetails();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        // End Job Orders

        // Report Viewer

        public function reportviewer(){
            if(isset($_SESSION['admindata'])){
                $this->load->view('layout/header', $nav['navdisable'] = "none");
                $this->load->view('admin/report');
                $this->load->view('layout/footer');                
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        // End Report Viewer

        // Change Password
        
        public function resetpassword(){
            if(isset($_SESSION['admindata'])){
                $data = $this->madmin->resetpwd();
                echo $data;
            } else {
                $this->load->view('layout/header');
                $this->load->view('admin/login');
                $this->load->view('layout/footer');                
            }
        }

        // End Change Password

    }
?>