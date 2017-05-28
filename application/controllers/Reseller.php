<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reseller extends CI_Controller {

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
                
		$this->load->view('welcome_message');
	}
        
        public function __construct() {
            @session_start();
            parent::__construct();
        }
        
        public function detail() {            
            //$this->load->helper('url');
            //$url_data['page_name'] = $this->uri->segment(2);
            $search_data = array();
            $search_data['k_search'] = '';
            if($this->input->post('k_search')){
                $search_data['k_search'] = $this->input->post('k_search');
            }                        
            $this->load->model('resellers');
            $search_data['user_id'] = $_SESSION['user']->id;
            $result = $this->resellers->getResellers($search_data);
            $data = array('data'=>$result,'k_search'=>$search_data['k_search']);
            $this->load->view('resellers/details',$data);
        }
        
        public function create() {            
            if (!isset ($_SESSION['user'])) {
                redirect('user/login');
            }            
            $this->load->helper('url');
            $this->load->model('resellers');
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
                    $postData['reg_address'] = $this->input->post('reg_address');
                    $postData['reg_city'] = $this->input->post('reg_city');
                    $postData['reg_state'] = $this->input->post('reg_state');
                    $postData['reg_country'] = $this->input->post('reg_country');
                    $postData['reg_zip'] = $this->input->post('reg_zip');
                    $postData['inst_address'] = $this->input->post('inst_address');
                    $postData['inst_state'] = $this->input->post('inst_state');
                    $postData['inst_country'] = $this->input->post('inst_country');
                    $postData['inst_city'] = $this->input->post('inst_city');
                    $postData['inst_zip'] = $this->input->post('inst_zip');
                    $postData['user_id'] =  $_SESSION['user']->id;
                    $result = $this->resellers->addReseller($postData);
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
            $this->load->view('resellers/create',$data);
        }        
}
