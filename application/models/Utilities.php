<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utilities extends CI_Model{
	
    function __construct(){
        parent::__construct();
    }
    
    function insert($data){
        $this->db->set($data);
        if($this->db->insert('users')){
            return true;
        }  else {
            return false;
        }
    }
    
    function getAllHospitals($search_data){
        if(!empty ($search_data['k_search'])){
            $query = $this->db->query("select *,eb.name as eb_branch,eb.status as eb_status from entities e join entity_branches eb on e.id=eb.entity_id join entity_types et on e.entity_type=et.id where et.id=1 and (e.name like '%".$search_data['k_search']."%' or e.description like '%".$search_data['k_search']."%')");
        }  else {
            $query = $this->db->query("select *,eb.name as eb_branch,eb.status as eb_status from entities e join entity_branches eb on e.id=eb.entity_id join entity_types et on e.entity_type=et.id where et.id=1");    
        }        
        $data = $query->result();
        return $data;
    }   
    
    function getAllUsers(){
        $query = $this->db->query("select * from users");
        $result = $query->result();
        return $result;
    }
    
    function createHospital($reqdata){
        $this->db->trans_start();
        $result = FALSE;
        $query = $this->db->query("insert into entities(entity_type,name,description,status,website,created_at,created_by,modified_at,modified_by) values('".$reqdata['e_type']."',".$this->db->escape($reqdata['e_name']).",".$this->db->escape($reqdata['e_description']).",".$reqdata['e_status'].",".$this->db->escape($reqdata['e_website']).",now(),'1',now(),'1')");
        if($query){
            $query_result = $this->db->query("insert into entity_branches(entity_id,name,addressline1,addressline2,city,state,country,zipcode,poc_name,mobile,landline,email,status,created_at,created_by,modified_at,modified_by) values('".$this->db->insert_id()."',".$this->db->escape($reqdata['e_name'].$reqdata['e_loc_city']).",".$this->db->escape($reqdata['e_loc_addressline1']).",".$this->db->escape($reqdata['e_loc_addressline2']).",".$this->db->escape($reqdata['e_loc_city']).",".$this->db->escape($reqdata['e_loc_state']).",'India',".$this->db->escape($reqdata['e_loc_zipcode']).",".$this->db->escape($reqdata['e_poc_firstname'].$reqdata['e_poc_lastname']).",".$this->db->escape($reqdata['e_poc_mobile']).",".$this->db->escape($reqdata['e_loc_phone']).",".$this->db->escape($reqdata['e_poc_email']).",".$reqdata['e_status'].",now(),'1',now(),'1')");
            if($query_result){
                $result = $this->db->insert_id();
                $this->db->trans_complete();
            }
        }
        return $result;
    }
    
    function getAllCities(){
        $result = FALSE;
        $query = $this->db->query("select c.* from cities c join state s on c.state_id=s.id join country co on s.country_id=co.id where co.id=1");
        $result = $query->result();
        return $result;
    }
    
    function get_search_results_without_doctors($reqdata){
        $result = FALSE;
        //echo "select s.id,s.name specialization,e.name from specializations_and_services s join entity_specializations es on s.id=es.specialization_id join entities e on es.entity_id=e.id join entity_branches eb on eb.entity_id=e.id join entity_types et on e.entity_type=et.id where (s.name like '%".$reqdata['g_s_key']."%' or e.name like '%".$reqdata['g_s_key']."%') and et.id!='".$this->config->item('doctors_entity_type')."' and s.status=1 and e.status=1 and eb.status=1 and et.status=1";
        $query = $this->db->query("select s.id,s.name specialization,e.name,eb.addressline1,eb.addressline2,eb.city,eb.state,eb.zipcode,c.name city_name from specializations_and_services s join entity_specializations es on s.id=es.specialization_id join entities e on es.entity_id=e.id join entity_branches eb on eb.entity_id=e.id join cities c on eb.city=c.id join entity_types et on e.entity_type=et.id where (s.name like '%".$reqdata['g_s_key']."%' or e.name like '%".$reqdata['g_s_key']."%') and et.id!='".$this->config->item('doctors_entity_type')."' and s.status=1 and e.status=1 and eb.status=1 and et.status=1");
        $result = $query->result();
        return $result;
    }

    function get_search_results_with_doctors($reqdata){
        $result = FALSE;
        //echo "select s.id,s.name specialization,e.name,ua.* from specializations_and_services s join entity_specializations es on s.id=es.specialization_id join entities e on es.entity_id=e.id join user_address ua on ua.user_id=e.user_id join entity_types et on e.entity_type=et.id where (s.name like '%".$reqdata['g_s_key']."%' or e.name like '%".$reqdata['g_s_key']."%') and et.id='".$this->config->item('doctors_entity_type')."' and s.status=1 and e.status=1 and et.status=1";
        $query = $this->db->query("select s.id,s.name specialization,e.name,ua.* from specializations_and_services s join entity_specializations es on s.id=es.specialization_id join entities e on es.entity_id=e.id join user_address ua on ua.user_id=e.user_id join entity_types et on e.entity_type=et.id where (s.name like '%".$reqdata['g_s_key']."%' or e.name like '%".$reqdata['g_s_key']."%') and et.id='".$this->config->item('doctors_entity_type')."' and s.status=1 and e.status=1 and et.status=1");
        $result = $query->result();
        return $result;
    }
    
    function doctor_checkAvailability($reqdata){
        $result;
        $dates_data = array();
        if(isset($reqdata['appointment_check_date'])){
            $dates_data['appointment_check_date'] = $reqdata['appointment_check_date'];
            $dates_data['appointment_check_next_date'] = date('Y-m-d',strtotime($reqdata['appointment_check_date'] . "+1 days"));
            $now = time(); // or your date as well
            $input_date = strtotime($reqdata['appointment_check_date']);
            $datediff = $now - $input_date;
            $datediff = floor($datediff / (60 * 60 * 24));
            if($datediff==0){
            $dates_data['appointment_check_previous_date'] = '';
            }else{
            $dates_data['appointment_check_previous_date'] = date('Y-m-d',strtotime($reqdata['appointment_check_date'] . "-1 days"));
            }
            $reqdata['appointment_week_day'] = date('N',strtotime($reqdata['appointment_check_date']));
            $result['dates_data'] = $dates_data;
        }else{
            $dates_data['appointment_check_date'] = date('Y-m-d');
            $dates_data['appointment_check_next_date'] = date('Y-m-d',strtotime(date('Y-m-d') . "+1 days"));
            $dates_data['appointment_check_previous_date'] = '';
            $reqdata['appointment_week_day'] = date('N');
            $result['dates_data'] = $dates_data;
            //echo date('Y-m-d');echo date_default_timezone_get();
        }
        if(!empty ($reqdata['user_id'])){
        $result['user_data'] = array('user_id'=>$reqdata['user_id']);
        $query = $this->db->query("select id,user_id,week_day,time_start,time_end from doctor_availability_mgmt where user_id=".$this->db->escape($reqdata['user_id'])." and week_day=".$this->db->escape($reqdata['appointment_week_day'])." and is_active=1");
        $result['availability'] = $query->result_array();
        $query = $this->db->query("select * from doctor_availability_mgmt dam join entities e on e.id=dam.h_entity_id join entity_branches eb on dam.h_entity_branch_id=eb.id where dam.user_id=".$this->db->escape($reqdata['user_id'])." and dam.week_day=".$this->db->escape($reqdata['appointment_week_day'])." and dam.is_active=1");
        $result['entity_details'] = $query->result_array();
        $status =1;
        if(empty($result['entity_details'])){
            $status = 0;
        }
        $query = $this->db->query("select da.time_start from doctor_appointments da where da.d_user_id=".$this->db->escape($reqdata['user_id'])." and da.status='1' and da.booked_at=".$this->db->escape($dates_data['appointment_check_date']));
        $result['appointments'] = $query->result_array();
        $start_time = strtotime(date('Y-m-d').' '.$this->config->item('doctors_start_time'));
        $end_time = strtotime(date('Y-m-d').' '.$this->config->item('doctors_end_time'));
        $slots = array();
        while(($end_time-$start_time)>=0){
            //echo "========start==".$start_time."=========end===".$end_time."<br/>";
            $slot_start = date("H:i",$start_time);
            if(!empty($result['availability'])){
                $available_start = strtotime(date('Y-m-d').' '.$result['availability']['0']['time_start']);
                $available_end = strtotime(date('Y-m-d').' '.$result['availability']['0']['time_end']);
                if($start_time>=$available_start && $start_time<=$available_end){
                    if(!empty ($result['appointments'])){
                    $appointments_start = array_column($result['appointments'], 'time_start');
                    if(in_array($slot_start, $appointments_start)){
                        $status = 0;
                    }else {
                        $status = 1;
                    }
                    }
                }  else {
                    $status = 0;
                }
            }
            array_push($slots,array("slot_start"=>$slot_start,"status"=>$status));
            $start_time = strtotime("+15 minutes", $start_time);
        }
        $result['slots'] = $slots;
        }
        return $result;
    }

    public function doctor_bookAppointment($reqdata){
        $result;
        $this->db->trans_start();
        $result = FALSE;
        $query = $this->db->query("select * from entities where user_id=".$this->db->escape($reqdata['user_id']));
        $enity_details = $query->result();
        //print_r($enity_details);
        //echo "insert into doctor_appointments(d_user_id,d_entity_id,h_entity_id,h_entity_branch_id,time_start,time_end,bookedby,booked_at,booked_for,name,email,mobile,created_at) values('".$this->db->escape($reqdata['user_id'])."',".$enity_details[0]->id.",".$this->db->escape($reqdata['h_entity_id']).",".$this->db->escape($reqdata['h_entity_branch_id']).",".$this->db->escape($reqdata['slot_start']).",".$this->db->escape($reqdata['slot_end']).",".$this->db->escape($reqdata['bookedby']).",".$this->db->escape($reqdata['appointment_check_date']).",".$this->db->escape($reqdata['problem']).",".$this->db->escape($reqdata['patient_name']).",".$this->db->escape($reqdata['email']).",".$this->db->escape($reqdata['mobile_number']).",now())";
        $query = $this->db->query("insert into doctor_appointments(d_user_id,d_entity_id,h_entity_id,h_entity_branch_id,time_start,time_end,bookedby,booked_at,booked_for,name,email,mobile,created_at) values(".$this->db->escape($reqdata['user_id']).",".$enity_details[0]->id.",".$this->db->escape($reqdata['h_entity_id']).",".$this->db->escape($reqdata['h_entity_branch_id']).",".$this->db->escape($reqdata['slot_start']).",".$this->db->escape($reqdata['slot_end']).",".$this->db->escape($reqdata['bookedby']).",".$this->db->escape($reqdata['appointment_check_date']).",".$this->db->escape($reqdata['problem']).",".$this->db->escape($reqdata['patient_name']).",".$this->db->escape($reqdata['email']).",".$this->db->escape($reqdata['mobile_number']).",now())");
        if($query){
            $result = $this->db->insert_id();
            $this->db->trans_complete();
        }
        return $result;
    }

    public function getAppointmentDetails($reqdata){
        $result = FALSE;
        $query = $this->db->query("select * from doctor_appointments da join entities e on da.h_entity_id=e.id join entity_branches eb on da.h_entity_branch_id where da.id=".$this->db->escape($reqdata['appointment_id']));
        if($query){
            $result = $query->result();
        }
        return $result;
    }

    public function getAppointmentsByMe($reqdata){
        $result = FALSE;
        //echo "select *,da.status as app_status from doctor_appointments da join entities e on da.h_entity_id=e.id join entity_branches eb on da.h_entity_branch_id where da.bookedby=".$this->db->escape($reqdata['bookedby'])." order by da.id desc";
        $query = $this->db->query("select *,da.status as app_status from doctor_appointments da join entities e on da.h_entity_id=e.id join entity_branches eb on da.h_entity_branch_id and eb.entity_id=e.id where da.bookedby=".$this->db->escape($reqdata['bookedby'])." order by da.id desc");
        if($query){
            $result = $query->result();
        }
        return $result;
    }

    public function getAppointmentsForMe($reqdata){
        $result = FALSE;
        //echo "select *,da.status as app_status from doctor_appointments da join entities e on da.h_entity_id=e.id join entity_branches eb on da.h_entity_branch_id and eb.entity_id=e.id where da.d_user_id=".$this->db->escape($reqdata['bookedfor'])." order by da.id desc";
        $query = $this->db->query("select *,da.status as app_status from doctor_appointments da join entities e on da.h_entity_id=e.id join entity_branches eb on da.h_entity_branch_id and eb.entity_id=e.id where da.d_user_id=".$this->db->escape($reqdata['bookedfor'])." order by da.id desc");
        if($query){
            $result = $query->result();
        }
        return $result;
    }

}

?>