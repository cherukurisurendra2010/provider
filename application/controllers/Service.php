<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

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
        }
        
        public function details() {
            if (!isset ($_SESSION['user'])) {
                redirect('user/login');
            }
            $this->load->helper('url');
            $this->load->model('services');
            $search_data = array();
            $search_data['k_search'] = '';
            if($this->input->post('k_search')){
                $search_data['k_search'] = $this->input->post('k_search');
            }
            if($this->input->post('k_c_submit')){
                $search_data['k_search'] = '';
            }
            $result = $this->services->getAllServices();
            $data = array('data'=>$result,'k_search'=>$search_data['k_search']);
            $this->load->view('services/details',$data);
        }
        
        public function add() {
            if (!isset ($_SESSION['user'])) {
                redirect('user/login');
            }
            $this->load->helper('url');
            $this->load->model('services');
            $status = '';
            $msg = '';
            if($this->input->post('srvname')){
                $postData['srvname'] = $this->input->post('srvname');
                $postData['descr'] = $this->input->post('descr');
                $postData['enableservice'] = $this->input->post('enableservice');
                $postData['uprate'] = $this->input->post('uprate')?$this->input->post('uprate'):0;
                $postData['downrate'] = $this->input->post('downrate')?$this->input->post('downrate'):0;
                $postData['srvtype'] = $this->input->post('service_type');
                $postData['limitexpiration'] = $this->input->post('package_expiry_type')?1:1;
                $postData['package_data_type'] = $this->input->post('package_data_type')?1:0;
                $postData['created_by'] = $_SESSION['user']->id;
                $postData['limitdl'] = $this->input->post('limitdl')?1:0;
                $postData['limitul'] = $this->input->post('limitul')?1:0;
                $postData['limitcomb'] = $this->input->post('limitcomb')?1:0;
                $postData['trafficunitdl'] = $this->input->post('dl_traffic_unit')?$this->input->post('dl_traffic_unit'):0;
                $postData['trafficunitul'] = $this->input->post('ul_traffic_unit')?$this->input->post('ul_traffic_unit'):0;
                $postData['trafficunitcomb'] = $this->input->post('total_traffic_unit')?$this->input->post('total_traffic_unit'):0;
                $postData['monthly'] = $this->input->post('data_split_monthly')?1:0;
                $postData['inittimeonline'] = $this->input->post('inittimeonline')?$this->input->post('inittimeonline'):0;
                $postData['dlquota'] = $this->input->post('dl_quota_day')?$this->input->post('dl_quota_day'):0;
                $postData['ulquota'] = $this->input->post('ul_quota_day')?$this->input->post('ul_quota_day'):0;
                $postData['combquota'] = $this->input->post('total_quota_day')?$this->input->post('total_quota_day'):0;
                $postData['timequota'] = $this->input->post('time_quota_day')?$this->input->post('time_quota_day'):0;
                $postData['enableburst'] = $this->input->post('enable_burst')?1:0;
                $postData['dlburstlimit'] = $this->input->post('burst_dl_limit')?$this->input->post('burst_dl_limit'):0;
                $postData['ulburstlimit'] = $this->input->post('burst_ul_limit')?$this->input->post('burst_ul_limit'):0;
                $postData['dlburstthreshold'] = $this->input->post('burst_dl_threshold')?$this->input->post('burst_dl_threshold'):0;
                $postData['ulburstthreshold'] = $this->input->post('burst_ul_threshold')?$this->input->post('burst_ul_threshold'):0;
                $postData['dlbursttime'] = $this->input->post('burst_dl_time')?$this->input->post('burst_dl_time'):0;
                $postData['ulbursttime'] = $this->input->post('burst_ul_time')?$this->input->post('burst_ul_time'):0;
                $postData['priority'] = $this->input->post('burst_priority')?$this->input->post('burst_priority'):0;
                $postData['timeaddmodeexp'] = $this->input->post('date_addition_mode');
                $postData['timeaddmodeonline'] = $this->input->post('time_addition_mode');
                $postData['trafficaddmode'] = $this->input->post('traffic_addition_mode');
                
                $postData['nextsrvid'] = $this->input->post('fallen_service');
                $postData['dailynextsrvid'] = $this->input->post('fallen_daily_service');
                $postData['subplan_name'] = $this->input->post('subplan_name[]');
                $postData['subplan_price'] = $this->input->post('subplan_price[]');
                $postData['subplan_unit'] = $this->input->post('subplan_unit[]');
                $postData['subplan_unit_type'] = $this->input->post('subplan_unit_type[]');
                $postData['subplan_status'] = $this->input->post('subplan_status[]');
                //print_r($postData['subplan_name']);
                $result = $this->services->addService($postData);
                $status = 'success';
                $msg = 'Service Added Successfully';
            }
            $nextServices = $this->services->getAllNextServices();
            $data = array('msg'=>$msg,'status'=>$status,'data'=>$nextServices);
            $this->load->view('services/create',$data);
        }

        public function subplan(){
			if (!isset ($_SESSION['user'])) {
				redirect('user/login');
			}
			$this->load->helper('url');
			$this->load->model('services');
            if($this->input->post('service_id')){
                $postData['service_id'] = $this->input->post('service_id');
                $subplans = $this->services->getSubplansByService($postData);
				echo JSON_ENCODE($subplans);
			}
        }
}
?>
