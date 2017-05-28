<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ippool extends CI_Controller {

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
            $this->load->model('ippools');
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
            $result = $this->ippools->getIppools($search_data);
            $data = array('data'=>$result,'k_search'=>$search_data['k_search']);
            $this->load->view('ippools/details',$data);
        }
        
        public function create() {            
            if (!isset ($_SESSION['user'])) {
                redirect('user/login');
            }            
            $this->load->helper('url');
            $this->load->model('ippools');
            $status = '';
            $msg = '';
            if($this->input->post('ippool_name') && $this->input->post('ippool_from') && $this->input->post('ippool_to')){
                    $postData['ippool_name'] = $this->input->post('ippool_name');
                    $postData['ippool_from'] = $this->input->post('ippool_from');
                    $postData['ippool_to'] = $this->input->post('ippool_to');
                    $postData['ippool_check_nas'] = $this->input->post('ippool_check_nas')?1:0;
                    $postData['ippool_nas'] = $this->input->post('ippool_nas');
                    $postData['ippool_notes'] = $this->input->post('ippool_notes');
                    $result = $this->ippools->addIppool($postData);
                    if($result){
                    $status = 'success';
                    $msg = 'Pool added successfully';
                    }  else {
                        $status = 'error';
                        $msg = 'Internal Error';
                    }
            }else {
                //$status = 'error';
                //$msg = 'Please fill the mandatory fields.';
            }
            $data = array('status'=>$status,'msg'=>$msg);
            $this->load->view('ippools/create',$data);
        }
}
