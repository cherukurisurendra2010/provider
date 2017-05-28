<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
                #$this->load->library('Layouts');
                $data = array('data'=>'','msg'=>'','status'=>'','search_results'=>'');
                $this->load->model('utilities');
                if($this->input->post('g_s_key')){
                $reqdata = $this->input->post();                
                $search_results_doctors = $this->utilities->get_search_results_with_doctors($reqdata);
                $search_results = $this->utilities->get_search_results_without_doctors($reqdata);
                $data['search_results'] = $search_results;
                $data['search_results_doctors'] = $search_results_doctors;
                }
                $cities = $this->utilities->getAllCities();
                $data['cities'] = $cities;
                $this->load->view('welcome_message',$data);
	}
        
        public function __construct() {
            parent::__construct();
            @session_start();
            $this->load->helper('url');
            //$this->load->library('templates');
        }


        public function search()
        {
            $search_value = $this->input->post('search');
            $data = array('data'=>'','msg'=>'','status'=>'');
            if(!empty ($search_value)){
                $query_data = array('company_name'=>$search_value);
                $this->load->model('vendors');
                $result = $this->vendors->getVendors($query_data);
                $data = array('data'=>$result,'msg'=>'','status'=>'');
            }
            $this->load->view('search',$data);
	}

        public function checkAvailability()
	{
            #$this->load->library('Layouts');
            $data = array('data'=>'','msg'=>'','status'=>'','message'=>'');
            $this->load->model('utilities');
            $reqdata = $this->input->post();
            //$this->output->set_content_type('text/plain', 'UTF-8');
            $results = $this->utilities->doctor_checkAvailability($reqdata);
            $data['results'] = $results;
            $data_o = $this->load->view('check_availability',$data,true);
            $this->output->set_output($data_o);
	}

        public function bookAppointment()
	{
            #$this->load->library('Layouts');
            $data = array('data'=>'','msg'=>'','status'=>'','message'=>'');
            $this->load->model('utilities');
            $reqdata = $this->input->post();
            if(!empty ($_SESSION['user_web'])){
                $reqdata['bookedby'] = $_SESSION['user_web']->user_id;
            }  else {
                $reqdata['bookedby'] = '0';
            }
            $reqdata['slot_end'] = date("H:i",strtotime("+14 minutes",strtotime($reqdata["appointment_check_date"].' '.$reqdata["slot_start"])));
            //$this->output->set_content_type('text/plain', 'UTF-8');
            $result = $this->utilities->doctor_bookAppointment($reqdata);
            if($result){
                $reqdata['appointment_id'] = $result;
                $results = $this->utilities->getAppointmentDetails($reqdata);
                $data['data'] = $results;
            }  else {
                $data = array('data'=>'','msg'=>'','status'=>'error','message'=>'Error in Booking Appointment');
            }
            $data_o = $this->load->view('book_appointment',$data,true);
            $this->output->set_output($data_o);
	}
}
