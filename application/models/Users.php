<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Model{
	
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
    
    function AuthenticateISP($data){
        $invic_db = $this->load->database("invic",true);
        $query = $invic_db->query("select u.*,ur.role_id,ur.user_id from in_users u join in_user_roles ur on ur.user_id=u.id where u.username='".$data['username']."'");
        $result = $query->result();
        foreach ($result as $row){
            if($row->password == md5($data['password'])){
                return $row;
            }  else {
                return false;
            }
        }
    }
    
    function CreateOrUpdateUser($data){
        $return;
        if(!isset ($data['id'])){
            $userdata = $this->getUserDetails($data);
            if(!empty ($userdata)){
                return $userdata;
            }else{
                $this->db->set($data);
                $return = $this->db->insert('users',$data);
            }
        }else{
            $this->db->set($data);
            $return = $this->db->insert('users',$data);
        }
        return $return;
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
    
    function getAllUsers($search_data){
        if(!empty ($search_data['k_search'])){
            $query = $this->db->query("select * from rm_users where (firstname like '%".$search_data['k_search']."%' or lastname like '%".$search_data['k_search']."%'  or email like '%".$search_data['k_search']."%')");
        }  else {
            $query = $this->db->query("select * from rm_users");
        }
        $result = $query->result();
        return $result;
    }
    
    function getAllUserGroups(){
        $query = $this->db->query("select * from rm_usergroups");    
        $result = $query->result();
        return $result;
    }
    
    function addUser($data){
        $returnValue = false;
        try {
        $result = $this->db->query("INSERT INTO rm_users (username, password, enableuser, srvid, owner, firstname, lastname, email, mobile, address, city, state, country, zip,createdon,expiration) VALUES ('".$data['username']."','".$data['password']."','".$data['enableuser']."','".$data['srvid']."','".$data['owner']."','".$data['firstname']."','".$data['lastname']."','".$data['email']."','".$data['mobile']."','".$data['address']."','".$data['city']."','".$data['state']."','".$data['country']."','".$data['zip']."',DATE_FORMAT(NOW(),'%Y-%m-%d'),now())");
        if($result){
            $invic_db = $this->load->database("invic",true);
            $in_result_user = $invic_db->query("insert into in_rm_users(username,password,manager,inst_address,inst_city,inst_state,inst_country,inst_zip) values('".$data['username']."','".$data['password']."','".$data['owner']."','".$data['inst_address']."','".$data['inst_city']."','".$data['inst_state']."','".$data['inst_country']."','".$data['inst_zip']."')");
            if($in_result_user){
                $user_id = $invic_db->insert_id();
                $in_result_user_role = $invic_db->query("insert into in_user_roles(user_id,role_id) values('".$user_id."','2')");
                if($in_result_user_role){
                    $in_result_user_service = $invic_db->query("insert into in_user_services(user_id,service_id,subplan_id) values('".$user_id."','".$data['srvid']."','".$data['subplan_id']."')");
					if($in_result_user_service){
                       $result_radcheck1 = $this->db->query("insert into radcheck(username,attribute,op,value) values('".$data['username']."','Cleartext-Password',':=','".$data['actual_password']."')");
                       $result_radcheck2 = $this->db->query("insert into radcheck(username,attribute,op,value) values('".$data['username']."','Simultaneous-Use',':=','1')");
						if($result_radcheck2){
						   $returnValue = true;
						}else {
							$returnValue = false;
						}
					}else {
						$returnValue = false;
					}
                }  else {
                    $returnValue = false;
                }
            }  else {
                $returnValue = false;
            }
        }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $returnValue;
    }
    
    function AuthenticateHotspot($data){
        $query = $this->db->query("select * from rm_users u where u.username='".$data['username']."'");
        $result = $query->result();
        foreach ($result as $row){
            if($row->password == md5($data['password'])){
                return $row;
            }  else {
                return false;
            }
        }
    } 
    
    function RegisterHotspotUser($data){
        $query = $this->db->query("insert into rm_users(username,password,enableuser,firstname,lastname,owner,email,mobile,srvid) values('".$data['username']."','".$data['password']."','1','".$data['first_name']."','".$data['last_name']."','".$data['owner']."','".$data['email']."','".$data['mobile']."','".$data['srvid']."')");
        if($query){
           return true;
        }  else {
           return false;
        }
    }
    
    function radius_userProfile($data){
        $query = $this->db->query("select * from rm_users ru join rm_services rs on ru.srvid=rs.srvid where ru.username='".$data['username']."'");
        $result = $query->result();
        foreach ($result as $row){
            return $row;
        }
        
    }

    function getISPUserDetails($data){
        $returnValue = array();
        $query = $this->db->query("select * from rm_users ru join rm_services rs on ru.srvid=rs.srvid where ru.username='".$data['username']."'");
        $result = $query->result();
        $returnValue['radius_user'] = $result;
        $invic_db = $this->load->database("invic",true);
        $query = $invic_db->query("select ius.*,i_s.*,isp.* from in_user_services ius join in_services i_s on ius.service_id=i_s.service_id join in_subplans isp on ius.subplan_id=isp.id join in_rm_users iu on ius.user_id=iu.id where iu.username='".$data['username']."'");
        $result = $query->result();
        $returnValue['in_services'] = $result;
        return $returnValue;
    }

    public function createInvoice($data){
        $returnValue = array();
        $invic_db = $this->load->database("invic",true);
        $query = $invic_db->query("insert into in_invoices(user_id,service_id,subplan_id,amount,paid_amount,pending_amount,period_start,period_end,status,createdat,createdby) values('".$data['in_services'][0]->user_id."','".$data['in_services'][0]->service_id."','".$data['in_services'][0]->subplan_id."','".$data['in_services'][0]->amount."','0','".$data['in_services'][0]->amount."',now(),now(),'1','".$data['createdat']."',now())");
        if($query){
			return $invic_db->insert_id();
		}
    }

    public function getInVoiceDetails($data){
        $returnValue = array();
        $invic_db = $this->load->database("invic",true);
        $query = $invic_db->query("select iv.*,i_s.*,isp.*,iv.status as invoice_status from in_invoices iv join in_services i_s on iv.service_id=i_s.service_id join in_subplans isp on iv.subplan_id = isp.id join in_rm_users iu on iv.user_id=iu.id where iu.username='".$data['username']."'");
        return $query->result();
    }

   public function doPayment($data){
        $returnValue = array();
        $invic_db = $this->load->database("invic",true);
        $query = $invic_db->query("insert into in_transactions(invoice_id,transaction_id,payment_type,amount,payment_at,payment_by) values('".$data['invoice_id']."','".rand(1,100000)."','".$data['payment_type']."','".$data['amount']."',now(),'".$data['payment_by']."')");
        if($query){
           $query = $invic_db->query("select sum(amount) paid_amount  from in_transactions where invoice_id='".$data['invoice_id']."'");
           $result = $query->result();
           $query1 = $invic_db->query("select * from in_invoices where invoice_id='".$data['invoice_id']."'");
           $invoice_data = $query1->result();
           $pending_amount = ($invoice_data[0]->amount-$result[0]->paid_amount);
           if($pending_amount>0){
                 $status =2;
           }elseif($pending_amount==0){
                 $status =3;
           }
           $update_query = $invic_db->query("update in_invoices set paid_amount='".$result[0]->paid_amount."',pending_amount='".$pending_amount."',status='".$status."' where invoice_id='".$data['invoice_id']."'");
		   if($update_query){
			   return true;
		   }
        }
    }

}

?>