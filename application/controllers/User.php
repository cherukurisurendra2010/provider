<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
                redirect('user/dashboard');
            }
            $data = array('msg'=>'','status'=>'','data'=>'');
            if($this->input->post('username') && $this->input->post('password')){
                $this->load->model('users');
                $queryData;
                $queryData['username'] = $this->input->post('username');
                $queryData['password'] = $this->input->post('password');
                $returnValue = $this->users->AuthenticateISP($queryData);
                if($returnValue){
                    //if($returnValue->user_status==1){
                    if($returnValue->role_id!=$this->config->item('user_role_id')){
                        @session_start();
                        $_SESSION['user'] = $returnValue;
                        redirect('user/dashboard');
                    }else{
                        $data = array('msg'=>'You are not authorised.','status'=>'','data'=>'');
                    }
                    //}else{
                    //    $data = array('msg'=>'Your account is blocked, please contact our admin','status'=>'','data'=>'');
                    //}
                }else{
                    $data = array('msg'=>'Please enter valid email and password.','status'=>'','data'=>'');
                }
                /*if($this->input->post('username')=='admin' && $this->input->post('password')=='test@123'){
                    
                }*/
            }
            $this->load->view('user/login',$data);
            //$this->templates->load('user/login',$data);
        }
        
        public function dashboard() {
            if (!isset ($_SESSION['user'])) {
                redirect('user/login');
            }
            $this->load->view('user/dashboard');
            //$this->templates->load('user/dashboard');
        }
        
        public function logout() {
            if (!isset ($_SESSION['user'])) {
                redirect('user/login');
            }
            session_destroy();
            $this->load->view('user/logout');
            //$this->templates->load('user/logout');
        }
        
        public function register() {
            if (isset ($_SESSION['user'])) {
                redirect('user/dashboard');
            }
            $data = array('msg'=>'','status'=>'','data'=>'');
            if($this->input->post('email') && $this->input->post('password')){
                if($this->input->post('password') != $this->input->post('cpassword')){
                    $data = array('msg'=>'Password and Confirm Password are not matched','status'=>'success','data'=>'');
                    $this->load->view('user/registration',$data);
                    return;
                }
                $this->load->model('users');
                $postData['username'] = $this->input->post('email');
                $postData['password'] = md5($this->input->post('password'));
                $postData['email'] = $this->input->post('email');
                $postData['first_name'] = $this->input->post('first_name');
                $postData['last_name'] = $this->input->post('last_name');
                $postData['mobile'] = $this->input->post('mobile');
                $returnValue = $this->users->CreateOrUpdateUser($postData);
                if(is_array($returnValue)){
                    if($returnValue->email==$postData['email']){
                        $data = array('msg'=>'Email already existed.','status'=>'success','data'=>'');
                    }                    
                }  else {
                    if($returnValue){
                        $data = array('msg'=>'Registration Done Successfully.','status'=>'success','data'=>'');
                    }  else {
                        $data = array('msg'=>'Error in Registration.','status'=>'error','data'=>'');
                    }
                }
            }
            $this->load->view('user/registration',$data);
        }
        
        public function details() {
            if (!isset ($_SESSION['user'])) {
                redirect('user/login');
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
            $this->load->view('users/details',$data);
        }
        
        public function add() {
            if (!isset ($_SESSION['user'])) {
                redirect('user/login');
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
                    $postData['actual_password'] = $this->input->post('password');
                    $postData['enableuser'] = $this->input->post('enableuser');
                    $postData['srvid'] = $this->input->post('service');
                    $postData['subplan_id'] = $this->input->post('subplan');
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
            $this->load->view('users/create',$data);
        }

        public function renew(){
            if (!isset ($_SESSION['user'])) {
                redirect('user/login');
            }
            $data = array('msg'=>'','status'=>'','data'=>'');
            $this->load->helper('url');
            $this->load->model('users');
            if($this->uri->segment(3)){
                $queryData;
                $queryData['username'] = $this->uri->segment(4);
                $user_data = $this->users->getISPUserDetails($queryData);
                $data = array('msg'=>'','status'=>'','data'=>$user_data);
            }else{
                $data = array('msg'=>'','status'=>'','data'=>'');
            }

            if($this->input->post('submit')){
               $queryData['username'] = $this->uri->segment(4);
               $user_data = $this->users->getISPUserDetails($queryData);
			   $user_data['createdat'] = $_SESSION['user']->id;
               if($user_data){
                  $returnValue = $this->users->createInvoice($user_data);
				  if($returnValue){
					  echo 'invoice created';
				  }
               }
            }
            $this->load->view('users/renew',$data);
        }

        public function invoices(){
            if (!isset ($_SESSION['user'])) {
                redirect('user/login');
            }
            $data = array('msg'=>'','status'=>'','data'=>'');
            $this->load->helper('url');
            $this->load->model('users');
            if($this->input->post('submit') && $this->input->post('pay_amount')){
               if($this->input->post('terms')){
               $queryData['username'] = $this->uri->segment(4);
               $user_data = $this->users->getISPUserDetails($queryData);
               $invoice_data = $this->users->getInVoiceDetails($queryData);
               $in_data['invoice_id'] = $invoice_data[0]->id;
			   $in_data['amount'] = $this->input->post('pay_amount');
			   $in_data['payment_type'] = $this->input->post('method');
               $in_data['payment_by'] = $_SESSION['user']->id;
               if($user_data){
                  $returnValue = $this->users->doPayment($in_data);
               if($returnValue){
                  echo 'Payment updated';
               }
               }
               }else{
                   echo 'Please accept Terms and Conditions';
               }
            }
            if($this->uri->segment(4)){
                $queryData;
                $queryData['username'] = $this->uri->segment(4);
                $user_data = $this->users->getISPUserDetails($queryData);
                $invoice_data = $this->users->getInVoiceDetails($queryData);
				$obj = array('user'=>$user_data,'invoice'=>$invoice_data);
                $data = array('msg'=>'','status'=>'','data'=>$obj);
            }else{
                $data = array('msg'=>'','status'=>'','data'=>'');
            }
            $this->load->view('users/invoices',$data);
        }

}
