<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Managers extends CI_Model{
	
    function __construct(){
        parent::__construct();
    }
    
    function getManagers($search_data = array()){
        $query = $this->db->query("select * from rm_managers");
        $data = $query->result();
        return $data;
    }
    
    function saveManager($reqData = array()){
        $returnValue = "";
        $result = $this->db->query("insert into rm_managers(managername,comment) values('".$reqData['managername']."','".$reqData['comment']."')");
        if($result){
            $invic_db = $this->load->database("invic",true);
            $in_result = $invic_db->query("insert into in_managers(managername,comment) values('".$reqData['managername']."','".$reqData['comment']."')");
            if($in_result){
                $returnValue = true;
            }  else {
                $returnValue = false;
            }
        }  else {
            $returnValue = false;
        }
        
        return $returnValue;
    }
    
    function getManagersFromINRadius($search_data = array()){
        $invic_db = $this->load->database("invic",true);
        $user_ids = array();
        if($_SESSION['user']->role_id == $this->config->item('adminuser_role_id')){
            array_push($user_ids, $_SESSION['user']->created_reseller_id);
            array_push($user_ids, $_SESSION['user']->user_id);
        }elseif($_SESSION['user']->role_id == $this->config->item('superadmin_role_id')) {
            //array_push($user_ids, '');
        }  else {
            array_push($user_ids, $_SESSION['user']->user_id);
        }
        $where="";
        if(!empty($user_ids)){
            $where = " (m.createdby in ('".implode(',',$user_ids)."') or um.user_id in ('".implode(',',$user_ids)."'))";
        }
        if(!empty ($search_data['k_search'])){
            $where = " and (a.area like '%".$search_data['k_search']."%')";
        }        
        $query = $invic_db->query("select m.* from in_managers m left join in_user_managers um on m.id=um.manager_id where 1=1 $where");
        $data = $query->result();
        return $data;
    }    
}

?>