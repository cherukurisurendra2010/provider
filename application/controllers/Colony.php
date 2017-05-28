<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Colony extends CI_Controller {

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
            $this->load->model('colonys');
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
            $result = $this->colonys->getColonys($search_data);
            $data = array('data'=>$result,'k_search'=>$search_data['k_search']);
            $this->load->view('colonys/details',$data);
        }
        
        public function create() {            
            if (!isset ($_SESSION['user'])) {
                redirect('user/login');
            }            
            $this->load->helper('url');
            $this->load->model('branches');
            $this->load->model('services');
            $this->load->model('managers');
            $this->load->model('areas');
            $this->load->model('colonys');
            $status = '';
            $msg = '';
            if($this->input->post('branch') && $this->input->post('manager')){
                    $postData['colony'] = $this->input->post('colony');
                    $postData['area'] = $this->input->post('area');
                    $postData['branch'] = $this->input->post('branch');
                    $postData['manager'] = $this->input->post('manager');
                    $postData['user_id'] =  $_SESSION['user']->id;
                    $result = $this->colonys->addColony($postData);
                    if($result){
                    $status = 'success';
                    $msg = 'Colony added successfully';
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
            $managers = $this->managers->getManagersFromINRadius($model_input);
            $branches = $this->branches->getBranches($model_input);
            $areas = $this->areas->getAreas($model_input);
            $data = array('areas'=>$areas,'branches'=>$branches,'managers'=>$managers,'status'=>$status,'msg'=>$msg);
            $this->load->view('colonys/create',$data);
        }
}
