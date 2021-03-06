<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
      <link rel="stylesheet" href="<?php echo $this->config->item('assets_base_url');?>css/jquery-ui.css"/>
      <script src="<?php echo $this->config->item('assets_base_url');?>js/jquery-1.12.4.js"></script>
      <script src="<?php echo $this->config->item('assets_base_url');?>js/jquery-1.12.1-ui.js"></script>
</head>
<body>
<div id="container">
    <div><h1>Welcome to Doctor App Admin module</h1>
        <div style="text-align:right;">Welcome <?php echo $_SESSION['user']->user_email;?> | <a href="<?php echo base_url();?>user/logout">Logout</a></div></div>
	<div id="body">
            <div style="width:20%;float: left;">Menu
                   <?php $this->load->view('common_view.php');
                   ?>
            </div><div  style="width:80%;float: left;">Content
                <div class="<?php //echo $status;?>"><?php //echo $msg;?></div>
                <form name="e_create_form" id="e_create_form" method="post" action="<?php echo base_url(); ?>user/update">
                    <table>
                        <tr><td style="width:20%"></td><td  style="width:80%"><input type="hidden" name="user_id" id="e_id" value="<?php echo $data[0]->user_id; ?>"/></td></tr>
                        <tr><td style="width:20%">First Name:</td><td  style="width:80%"><input type="text" name="e_firstname" id="e_firstname" value="<?php echo $data[0]->first_name; ?>"/></td></tr>
                        <tr><td style="width:20%">Last Name:</td><td  style="width:80%"><input type="text" name="e_lastname" id="e_lastname" value="<?php echo $data[0]->last_name; ?>" /></td></tr>
                        <tr><td style="width:20%">Email:</td><td  style="width:80%"><input type="text" name="e_email" id="e_email" value="<?php echo $data[0]->user_email; ?>"/></td></tr>
                        <tr><td style="width:20%">Mobile:</td><td  style="width:80%">+91-<input type="text" name="e_mobile" id="e_mobile" value="<?php echo $data[0]->user_mobile; ?>"/></td></tr>                        
                        <tr><td style="width:20%">Password:</td><td  style="width:80%"><input type="text" name="e_password" id="e_password" value="<?php echo $data[0]->user_password; ?>"/></td></tr>
                        <tr><td style="width:20%">Confirm Password:</td><td  style="width:80%"><input type="text" name="e_c_password" id="e_c_password" value="<?php echo $data[0]->user_password; ?>"/></td></tr>
                        <tr><td style="width:20%">Status:</td><td  style="width:80%"><select name="e_status" id="e_status">
                        <option value="0">Block</option>
                        <option value="1">Active</option>                        
                        </select></td></tr>
                        <tr><td style="width:20%">Location Details:</td><td  style="width:80%"></td></tr>
                        <tr><td style="width:20%">Address line1:</td><td  style="width:80%"><input type="text" name="e_addressline1" id="e_loc_addressline1" value="<?php echo $data[0]->user_add_line1; ?>"/></td></tr>
                        <tr><td style="width:20%">Address line2:</td><td  style="width:80%"><input type="text" name="e_addressline2" id="e_loc_addressline2" value="<?php echo $data[0]->user_add_line2; ?>"/></td></tr>
                         <tr><td style="width:20%">State:</td><td  style="width:80%">
                                <select name="e_state" id="e_state" class="e_state">
                                    <option value="">Select State..</option>
                                    <?php foreach($states as $state){ ?>
                                    <option value="<?php echo $state->id; ?>" <?php if($state->id == $data[0]->user_state){ echo "selected"; } ?>><?php echo $state->name; ?></option>
                                    <?php } ?>
                                </select></td></tr>
                           <tr><td style="width:20%">City:</td><td  style="width:80%"><select name="e_city" id="e_city"></select></td></tr>
                          <script>
                           
                             $("#e_state").change(function(){
                                 
                                 url = "<?php echo base_url().'user/get_cities'; ?>";
                                 state_id = $("#e_state").val();
                                 GA.UTIL.getcities(url,state_id);
                             });
                                                            </script>
                         
                           <script>
                                
                              $(window).load(function(){
                                  url = "<?php echo base_url().'user/get_cities'; ?>";
                                  state_id = $("#e_state").val();
                                  user_city = "<?php echo $data[0]->user_city; ?>";
                                  GE.UTIL.getcities(url,state_id,user_city);
                              });
                                                            </script>
                        <tr><td style="width:20%">Zip Code:</td><td  style="width:80%"><input type="text" name="e_zipcode" id="e_zipcode" value="<?php echo $data[0]->user_zipcode; ?>"/></td></tr>
                        <tr><td style="width:20%">Blood Donation Status:</td><td  style="width:80%"></td></tr>
                        <tr><td style="width:20%">Willing to Donate Blood:</td><td  style="width:80%"><input type="checkbox" name="e_donation_status" id="e_donation_status" value="1" <?php if($data[0]->blood_donation_status==1){echo "checked"; }?>/></td></tr>
                        <tr><td style="width:20%">Blood Group:</td><td  style="width:80%"><select name="e_blood_group" id="e_blood_group" >
                        <?php if($data[0]->blood_group=="A+"){?>
                        <option value="A+" <?php  echo "selected"; ?>>A+</option>
                       <?php  }else{ ?>
                           <option value="A+">A+</option>
                           <?php } ?>
                           <?php if($data[0]->blood_group=="A-"){?>
                           <option value="A-" <?php  echo "selected"; ?>>A-</option>
                       <?php  }else{ ?>
                           <option value="A-">A-</option>
                           <?php } ?>
                           <?php if($data[0]->blood_group=="B+"){?>
                           <option value="B+" <?php  echo "selected"; ?>>B+</option>
                       <?php  }else{ ?>
                           <option value="B+">B+</option>
                           <?php } ?>
                               <?php if($data[0]->blood_group=="B-"){?>
                           <option value="B-" <?php  echo "selected"; ?>>B-</option>
                       <?php  }else{ ?>
                           <option value="B-">B-</option>
                           <?php } ?>
                               <?php if($data[0]->blood_group=="O+"){?>
                           <option value="O+" <?php  echo "selected"; ?>>O+</option>
                       <?php  }else{ ?>
                           <option value="O+">O+</option>
                           <?php } ?>
                               <?php if($data[0]->blood_group=="O-"){?>
                           <option value="O-" <?php  echo "selected"; ?>>O-</option>
                       <?php  }else{ ?>
                           <option value="O-">O-</option>
                           <?php } ?>
                       
                        </select></td></tr>
                        
                        <tr><td style="width:20%"></td><td  style="width:80%"><input type="submit" name="e_update_submit" value="Update"/></td></tr>                        
                    </table>
                </form>
            </div>
            <div style="clear: both"></div>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>