<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminusers extends CI_Model{
	
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
    
    function getAdminusers($search_data){
        $invic_db = $this->load->database("invic",true);
        if(!empty ($search_data['k_search'])){
            $query = $invic_db->query("select u.* from in_users u join in_user_roles ur on u.id=ur.user_id  where u.created_reseller_id='".$search_data['created_reseller_id']."' and ur.role_id='4' and (u.username like '%".$search_data['k_search']."%')");
        }  else {
            $query = $invic_db->query("select u.* from in_users u join in_user_roles ur on u.id=ur.user_id where u.created_reseller_id='".$search_data['created_reseller_id']."' and ur.role_id='4'");    
        }
        $result = $query->result();
        return $result;
    }
    
    function addAdminuser($data){
        $returnValue = false;
        try {
            $invic_db = $this->load->database("invic",true);
            $in_result_user = $invic_db->query("insert into in_users(username,password,isactive,firstname,lastname,email,mobile,createdby,created_reseller_id) values('".$data['username']."','".$data['password']."','".$data['isactive']."','".$data['firstname']."','".$data['lastname']."','".$data['email']."','".$data['mobile']."','".$data['user_id']."','".$data['created_reseller_id']."')");
            if($in_result_user){
                $user_id = $invic_db->insert_id();
                //reg_address,reg_city,reg_state,reg_country,reg_zip,inst_address,inst_city,inst_state,inst_country,inst_zip
                //        ,'".$data['reg_city']."','".$data['reg_state']."','".$data['reg_country']."','".$data['reg_zip']."''".$data['inst_address']."','".$data['inst_city']."','".$data['inst_state']."','".$data['inst_country']."','".$data['inst_zip']."'
                $in_result_user_role = $invic_db->query("insert into in_user_roles(user_id,role_id) values('".$user_id."','4')");
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
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $returnValue;
    }
    
}

?>