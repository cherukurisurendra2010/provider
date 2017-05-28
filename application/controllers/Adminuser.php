<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminuser extends CI_Controller {

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
            @session_start();
            parent::__construct();
            //$this->load->library('templates');
        }
        
        public function details() {            
            if (!isset ($_SESSION['user'])) {
                redirect('user/login');
            }
            $this->load->model('adminusers');
            $search_data = array();
            $search_data['k_search'] = '';
            if($this->input->post('k_search')){
                $search_data['k_search'] = $this->input->post('k_search');
            }
            if($this->input->post('k_c_submit')){
                $search_data['k_search'] = '';
            }
            $search_data['user_id'] = $_SESSION['user']->id;
            if(($_SESSION['user']->role_id == $this->config->item('reseller_role_id')) || ($_SESSION['user']->role_id == $this->config->item('superadmin_role_id'))){
                $search_data['created_reseller_id'] =  $_SESSION['user']->user_id;
            }  else {
                $search_data['created_reseller_id'] = $_SESSION['user']->created_reseller_id ;
            }            
            $result = $this->adminusers->getAdminUsers($search_data);
            $data = array('data'=>$result,'k_search'=>$search_data['k_search']);
            $this->load->view('adminusers/details',$data);
        }
        
        public function create() {            
            if (!isset ($_SESSION['user'])) {
                redirect('user/login');
            }            
            $this->load->helper('url');
            $this->load->model('adminusers');
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
                    $postData['isactive'] = $this->input->post('enableuser');                    
                    $postData['srvid'] = $this->input->post('service');
                    $postData['managers'] = $this->input->post('managers');
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
                    $postData['user_id'] =  $_SESSION['user']->id;
                    if(($_SESSION['user']->role_id == $this->config->item('reseller_role_id')) || ($_SESSION['user']->role_id == $this->config->item('superadmin_role_id'))){
                        $postData['created_reseller_id'] =  $_SESSION['user']->user_id;
                    }  else {
                        $postData['created_reseller_id'] = $_SESSION['user']->created_reseller_id ;
                    }
                    $result = $this->adminusers->addAdminuser($postData);
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
            $user_ids = array();
            if($_SESSION['user']->role_id == $this->config->item('adminuser_role_id')){
                array_push($user_ids, $_SESSION['user']->created_reseller_id);
                array_push($user_ids, $_SESSION['user']->user_id);
            }  else {
                array_push($user_ids, $_SESSION['user']->user_id);
            }
            $model_input = array('user_ids'=>$user_ids);
            $managers = $this->managers->getManagersFromINRadius($model_input);
            $services = $this->services->getAllServices();            
            $data = array('managers'=>$managers,'services'=>$services,'status'=>$status,'msg'=>$msg);
            $this->load->view('adminusers/create',$data);
        }
}
