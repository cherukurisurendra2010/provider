<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nass extends CI_Model{
	
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
    
    function getNas($search_data){
        $query = $this->db->query("select * from nas where 1=1");    
        $result = $query->result();
        return $result;
    }
    
    function addNas($data){
        $returnValue = false;
        try {
            $result = $this->db->query("INSERT INTO nas(nasname, shortname, secret, description,apiusername,apipassword,enableapi) VALUES ('".$data['nas_ip']."','".$data['nas_name']."','".$data['nas_secret']."','".$data['nas_description']."','".$data['nas_apiusername']."','".$data['nas_apipassword']."','".$data['nas_enableapi']."')");
            if($result){
               $returnValue = true;
            }
        }catch(Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $returnValue;
    }
    
}

?>