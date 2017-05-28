<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hotspot extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		
	}
        
        public function __construct() {
            parent::__construct();
            @session_start();
            //$this->load->library('templates');
        }
        
        public function login() {
            if (isset ($_SESSION['user'])) {
                redirect('hotspot/dashboard');
            }
            $data = array('msg'=>'','status'=>'','data'=>'');
            if($this->input->post('username') && $this->input->post('password')){
                $this->load->model('users');
                $queryData;
                $queryData['username'] = $this->input->post('username');
                $queryData['password'] = $this->input->post('password');
                $returnValue = $this->users->AuthenticateHotspot($queryData);
                if($returnValue){
                    //if($returnValue->user_status==1){
                    //if($returnValue->role_id==$this->config->item('user_role_id')){
                        @session_start();
                        $_SESSION['hotspot'] = $returnValue;
                        redirect('hotspot/dashboard');
                    //}else{
                        $data = array('msg'=>'You are not authorised.','status'=>'','data'=>'');
                    //}
                    //}else{
                    //    $data = array('msg'=>'Your account is blocked, please contact our admin','status'=>'','data'=>'');
                    //}
                }else{
                    $data = array('msg'=>'You are not authorised.','status'=>'','data'=>'');
                }
                /*if($this->input->post('username')=='admin' && $this->input->post('password')=='test@123'){
                    
                }*/
            }else{
                //$data = array('msg'=>'Please enter valid email and password.','status'=>'','data'=>'');
            }
            $this->load->view('hotspots/login',$data);
            //$this->templates->load('user/login',$data);
        }
        
        public function dashboard() {
            if (!isset ($_SESSION['hotspot'])) {
                redirect('hotspot/login');
            }
            $this->load->view('hotspots/dashboard');
            //$this->templates->load('user/dashboard');
        }
        
        public function profile() {
            if (!isset ($_SESSION['hotspot'])) {
                redirect('hotspot/login');
            }
            $this->load->model('users');
            $result_data = $this->users->radius_userProfile($data=array('username'=>$_SESSION['hotspot']->username));
            $data = array('msg'=>'','status'=>'','data'=>$result_data);
            $this->load->view('hotspots/profile',$data);
            //$this->templates->load('user/dashboard');
        }        
        
        public function logout() {
            if (!isset ($_SESSION['hotspot'])) {
                redirect('hotspot/login');
            }
            session_destroy();
            $this->load->view('hotspots/logout');
            //$this->templates->load('user/logout');
        }
        
        public function register() {
            if (isset ($_SESSION['hotspot'])) {
                redirect('hotspot/dashboard');
            }
            $data = array('msg'=>'','status'=>'','data'=>'');
            if($this->input->post('mobile')){
                if($this->input->post('password') != $this->input->post('cpassword')){
                    $data = array('msg'=>'Password and Confirm Password are not matched','status'=>'success','data'=>'');
                    $this->load->view('hotspot/registration',$data);
                    return;
                }
                $this->load->model('users');
                $postData['username'] = $this->input->post('mobile');
                $random_number = rand(1000, 10000);
                $postData['password'] = md5($random_number);
                $postData['email'] = $this->input->post('email');
                $postData['owner'] = 'Hotspot';
                $postData['srvid'] = '5';
                $postData['first_name'] = $this->input->post('first_name');
                $postData['last_name'] = $this->input->post('last_name');
                $postData['mobile'] = $this->input->post('mobile');
                $returnValue = $this->users->RegisterHotspotUser($postData);
                if($returnValue){
                        $data = array('msg'=>'Registration Done Successfully.'.$random_number,'status'=>'success','data'=>'');
                    }  else {
                        $data = array('msg'=>'Error in Registration.','status'=>'error','data'=>'');
                    }
           }
            $this->load->view('hotspots/registration',$data);
        }
        
        public function details() {            
            if (!isset ($_SESSION['user'])) {
                redirect('hotspot/login');
            }
            $this->load->helper('url');
            $url_data['page_name'] = $this->uri->segment(2);
            $this->load->model('users');
            $search_data = array();
            $search_data['k_search'] = '';
            if($this->input->post('k_search')){
                $search_data['k_search'] = $this->input->post('k_search');
            }
            if($this->input->post('k_c_submit')){
                $search_data['k_search'] = '';
            }
            $result = $this->users->getAllUsers($search_data);
            $data = array('data'=>$result,'k_search'=>$search_data['k_search']);
            $this->load->view('hotspots/details',$data);
        }
        
        public function add() {            
            if (!isset ($_SESSION['user'])) {
                redirect('hotspot/login');
            }            
            $this->load->helper('url');
            $this->load->model('users');
            $this->load->model('services');
            $this->load->model('managers');
            $status = '';
            $msg = '';
            if($this->input->post('username') && $this->input->post('password')){
                if($this->input->post('password')!=$this->input->post('c_password')){
                    $status = 'error';
                    $msg = 'Password and Confirm Password should be same';
                }else{
                    $postData['username'] = $this->input->post('username');
                    $postData['password'] = md5($this->input->post('password'));
                    $postData['enableuser'] = $this->input->post('enableuser');                    
                    $postData['srvid'] = $this->input->post('service');
                    $postData['owner'] = $this->input->post('manager');
                    $postData['firstname'] = $this->input->post('firstname');
                    $postData['lastname'] = $this->input->post('lastname');
                    $postData['email'] = $this->input->post('email');
                    $postData['mobile'] = $this->input->post('mobile');
                    $postData['address'] = $this->input->post('reg_address');
                    $postData['city'] = $this->input->post('reg_city');
                    $postData['state'] = $this->input->post('reg_state');
                    $postData['country'] = $this->input->post('reg_country');
                    $postData['zip'] = $this->input->post('reg_zip');
                    $postData['inst_address'] = $this->input->post('inst_address');
                    $postData['inst_state'] = $this->input->post('inst_state');
                    $postData['inst_country'] = $this->input->post('inst_country');
                    $postData['inst_city'] = $this->input->post('inst_city');
                    $postData['inst_zip'] = $this->input->post('inst_zip');
                    $result = $this->users->addUser($postData);
                    if($result){
                    $status = 'success';
                    $msg = 'User added successfully';
                    }  else {
                        $status = 'error';
                        $msg = 'Internal Error';
                    }
                }
            }  else {
                //$status = 'error';
                //$msg = 'Please fill the mandatory fields.';
            }
            $managers = $this->managers->getManagers();
            $services = $this->services->getAllServices();            
            $data = array('managers'=>$managers,'services'=>$services,'status'=>$status,'msg'=>$msg);
            $this->load->view('hotspots/create',$data);
        }
}
