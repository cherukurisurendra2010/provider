<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nas extends CI_Controller {

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
        
        public function detail() {            
            if (!isset ($_SESSION['user'])) {
                redirect('user/login');
            }
            $this->load->model('nass');
            $search_data = array();
            $search_data['k_search'] = '';
            if($this->input->post('k_search')){
                $search_data['k_search'] = $this->input->post('k_search');
            }
            if($this->input->post('k_c_submit')){
                $search_data['k_search'] = '';
            }
            $user_ids = array();
            if($_SESSION['user']->role_id == $this->config->item('adminuser_role_id')){
                array_push($user_ids, $_SESSION['user']->created_reseller_id);
                array_push($user_ids, $_SESSION['user']->user_id);
            }  else {
                array_push($user_ids, $_SESSION['user']->user_id);
            }
            $search_data['user_ids'] = $user_ids;
            $result = $this->nass->getNas($search_data);
            $data = array('data'=>$result,'k_search'=>$search_data['k_search']);
            $this->load->view('nass/details',$data);
        }
        
        public function create() {            
            if (!isset ($_SESSION['user'])) {
                redirect('user/login');
            }            
            $this->load->helper('url');
            $this->load->model('nass');
            $status = '';
            $msg = '';
            if($this->input->post('nas_ip') && $this->input->post('nas_secret')){
                    $postData['nas_ip'] = $this->input->post('nas_ip');
                    $postData['nas_name'] = $this->input->post('nas_name');
                    $postData['nas_secret'] = $this->input->post('nas_secret');
                    $postData['nas_description'] = $this->input->post('nas_description');
                    $postData['nas_apiusername'] = $this->input->post('nas_apiusername');
                    $postData['nas_apipassword'] = $this->input->post('nas_apipassword');
                    if(isset ($postData['nas_apipassword'])){
                    $postData['nas_enableapi'] = 1;
                    }  else {
                    $postData['nas_enableapi'] = 0;    
                    }
                    $result = $this->nass->addNas($postData);
                    if($result){
                    $status = 'success';
                    $msg = 'Branch added successfully';
                    }  else {
                        $status = 'error';
                        $msg = 'Internal Error';
                    }
            }else {
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
            $data = array('status'=>$status,'msg'=>$msg);
            $this->load->view('nass/create',$data);
        }
}
