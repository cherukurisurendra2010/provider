<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends CI_Controller {

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
            $this->load->model('managers');
            $result = $this->managers->getManagers();
            $data = array('data'=>$result,'k_search'=>$search_data['k_search']);
            $this->load->view('managers/details',$data);
        }
        
        public function add() {            
            //$this->load->helper('url');
            //$url_data['page_name'] = $this->uri->segment(2);
            $this->load->model('managers');
            $returnValue = '';
            $status = '';
            $msg = '';
            $managers = $this->managers->getManagers();
            if($this->input->post('managername')){
                $postData['managername'] = $this->input->post('managername');
                $postData['comment'] = $this->input->post('comment');
                if(isset ($_SESSION['superadmin'])){
                    $postData['createdby'] = '';
                    $postData['manager_id'] = '';
                }
                $returnValue = $this->managers->saveManager($postData);
                if($returnValue){
                    $status ='success';
                    $msg = 'Manager Added Successfully.';
                }  else {
                    $status ='failure';
                    $msg = 'Internal server error.';
                }
            }
            
            $data = array('managers'=>$managers,'status'=>'','msg'=>'');
            $this->load->view('managers/create',$data);
        }        
}
