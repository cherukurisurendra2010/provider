<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Model{
	
    function __construct(){
        parent::__construct();
    }
    
    function getAllServices(){
        $query = $this->db->query("select * from rm_services");    
        $result = $query->result();
        return $result;
    }
    
    function addService($data){
        $result = $this->db->query("insert into rm_services(srvname,descr,enableservice,downrate,uprate,srvtype,limitexpiration,limitdl,limitul,limitcomb,trafficunitdl,trafficunitul,trafficunitcomb,monthly,inittimeonline,dlquota,ulquota,combquota,timequota,enableburst,dlburstlimit,ulburstlimit,dlburstthreshold,ulburstthreshold,dlbursttime,ulbursttime,priority,timeaddmodeexp,timeaddmodeonline,trafficaddmode,nextsrvid,dailynextsrvid) values('".$data['srvname']."','".$data['descr']."','".$data['enableservice']."','".$data['downrate']."','".$data['uprate']."','".$data['srvtype']."','".$data['limitexpiration']."','".$data['limitdl']."','".$data['limitul']."','".$data['limitcomb']."','".$data['trafficunitdl']."','".$data['trafficunitul']."','".$data['trafficunitcomb']."','".$data['monthly']."','".$data['inittimeonline']."','".$data['dlquota']."','".$data['ulquota']."','".$data['combquota']."','".$data['timequota']."','".$data['enableburst']."','".$data['dlburstlimit']."','".$data['ulburstlimit']."','".$data['dlburstthreshold']."','".$data['ulburstthreshold']."','".$data['dlbursttime']."','".$data['ulbursttime']."','".$data['priority']."','".$data['timeaddmodeexp']."','".$data['timeaddmodeonline']."','".$data['trafficaddmode']."','".$data['nextsrvid']."','".$data['dailynextsrvid']."')");    
        $insert_id = $this->db->insert_id();
        $invic_db = $this->load->database("invic",true);
        if($result){
            $in_result = $invic_db->query("insert into in_services(service_id,service,service_type,package_type,createdby) values('".$insert_id."','".$data['srvname']."','".$data['srvtype']."','".$data['service_type']."','".$data['created_by']."')");
            if($in_result){
               $count = 0;
               for($i=0;$i<count($data['subplan_name']);$i++){
                  $result = $invic_db->query("insert into in_subplans(service_id,subplan,amount,unit,unit_type,status,createdby) values('".$insert_id."','".$data['subplan_name'][$i]."','".$data['subplan_price'][$i]."','".$data['subplan_unit'][$i]."','".$data['subplan_unit_type'][$i]."','".$data['subplan_status'][$i]."','".$data['created_by']."')");
                  $count++;
               }
               if($count = count($data['subplan_name'])){
                   return $in_result;
               }
            }
        }
    }
    
    function getAllNextServices($data=array()){
        $invic_db = $this->load->database("invic",true);
        $in_query = $invic_db->query("select service_id from in_services where package_type=1");
        $in_result = $in_query->result();
        $services = array();
        foreach ($in_result as $row) {
            array_push($services, $row->service_id);
        }
        $result = $this->db->query("select * from rm_services where srvid in (".  implode(",", $services).")");    
        return $result->result();
    }

    function getServices(){
        $invic_db = $this->load->database("invic",true);
        $in_query = $invic_db->query("select * from in_services where package_type!=3");
        $in_result = $in_query->result();
        return $in_result;
    }

    function getSubplansByService($data){
        $invic_db = $this->load->database("invic",true);
        $in_query = $invic_db->query("select * from in_subplans where service_id='".$data['service_id']."'");
        $in_result = $in_query->result();
        return $in_result;
    }

}

?>