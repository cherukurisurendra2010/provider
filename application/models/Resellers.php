<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resellers extends CI_Model{
	
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
    
    function getAll(){
        $query = $this->db->get('users');
        $data = $query->result();
        return $data;
    }
    
    function getUserDetails($data){
        $query = $this->db->query("select * from users where user_email='".$data['email']."'");
        $result = $query->result();
        if(!empty ($result[0])){
            return $result[0];
        }else {
            return '';
        }
    }
    
    function getResellers($search_data){
        $invic_db = $this->load->database("invic",true);
        if(!empty ($search_data['k_search'])){
            $query = $invic_db->query("select u.username from in_users u join in_resellers r on u.id=r.user_id  where u.createdby='".$search_data['user_id']."' and (u.username like '%".$search_data['k_search']."%')");
        }  else {
            $query = $invic_db->query("select u.username from in_users u join in_resellers r on u.id=r.user_id where  u.createdby='".$search_data['user_id']."'");    
        }
        $result = $query->result();
        return $result;
    }
    
    function addReseller($data){
        $returnValue = false;
        try {
            $invic_db = $this->load->database("invic",true);
            $in_result_user = $invic_db->query("insert into in_users(username,password,isactive,firstname,lastname,email,mobile,createdby) values('".$data['username']."','".$data['password']."','".$data['isactive']."','".$data['firstname']."','".$data['lastname']."','".$data['email']."','".$data['mobile']."','".$data['user_id']."')");
            if($in_result_user){
                $user_id = $invic_db->insert_id();
                //reg_address,reg_city,reg_state,reg_country,reg_zip,inst_address,inst_city,inst_state,inst_country,inst_zip
                //        ,'".$data['reg_city']."','".$data['reg_state']."','".$data['reg_country']."','".$data['reg_zip']."''".$data['inst_address']."','".$data['inst_city']."','".$data['inst_state']."','".$data['inst_country']."','".$data['inst_zip']."'
                $in_result_user_reseller = $invic_db->query("insert into in_resellers(user_id) values('".$user_id."')");
                if($in_result_user_reseller){
                    $in_result_user_role = $invic_db->query("insert into in_user_roles(user_id,role_id) values('".$user_id."','3')");
                    if($in_result_user_role){
                        $in_result_user_manager;
                        foreach($data['managers'] as $manager){
                            $in_result_user_manager = $invic_db->query("insert into in_user_managers(user_id,manager_id) values('".$user_id."','".$manager."')");
                        }
                        if($in_result_user_manager){
                            $returnValue = true;
                        }
                    }
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $returnValue;
    }
    
}

?>