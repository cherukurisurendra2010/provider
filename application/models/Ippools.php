<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ippools extends CI_Model{
	
    function __construct(){
        parent::__construct();
    }
    
    function getIppools($search_data){
        $query = $this->db->query("select * from rm_ippools where 1=1");    
        $result = $query->result();
        return $result;
    }
    
    function addIppool($data){
        $returnValue = false;
        try {
            $result = $this->db->query("INSERT INTO rm_ippools(type, name, fromip, toip,descr,nextpoolid) VALUES ('0','".$data['ippool_name']."','".$data['ippool_from']."','".$data['ippool_to']."','".$data['ippool_notes']."','-1')");
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