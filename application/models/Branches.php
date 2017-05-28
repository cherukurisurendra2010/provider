<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branches extends CI_Model{
	
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
    
    function getBranches($search_data){
        $invic_db = $this->load->database("invic",true);
        $user_ids = array();
        if($_SESSION['user']->role_id == $this->config->item('adminuser_role_id')){
            array_push($user_ids, $_SESSION['user']->created_reseller_id);
            array_push($user_ids, $_SESSION['user']->user_id);
        }elseif($_SESSION['user']->role_id == $this->config->item('superadmin_role_id')) {
            
        }  else {
            array_push($user_ids, $_SESSION['user']->user_id);
        }
        $where="";
        if(!empty($user_ids)){
            $where = " and br.createdby in ('".implode(',', $user_ids)."')";
        }
        if(!empty ($search_data['k_search'])){
            $where = " and (br.branch like '%".$search_data['k_search']."%')";
        }        
        $query = $invic_db->query("select br.*,m.managername from in_users u join in_branches br on br.createdby=u.id join in_managers m on br.manager_id=m.id where 1=1 $where");    
        $result = $query->result();
        return $result;
    }
    
    function addBranch($data){
        $returnValue = false;
        try {
            $invic_db = $this->load->database("invic",true);
            $in_result_user = $invic_db->query("insert into in_branches(branch,manager_id,createdby) values('".$data['branch']."','".$data['manager']."','".$data['user_id']."')");
            if($in_result_user){
               $returnValue = true;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $returnValue;
    }
    
}

?>