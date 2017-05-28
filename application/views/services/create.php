    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    ?><!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Welcome to CodeIgniter</title>
        <style type="text/css">
        ::selection { background-color: #E13300; color: white; }
        ::-moz-selection { background-color: #E13300; color: white; }
        body {
                background-color: #fff;
                margin: 40px;
                font: 13px/20px normal Helvetica, Arial, sans-serif;
                color: #4F5155;
        }
        a {
                color: #003399;
                background-color: transparent;
                font-weight: normal;
        }
        success{
                color: green;
                font-weight: normal;
        }
        .fup_class{
               display: none;
        }
        error{
                color: red;
                font-weight: normal;
        }
        h1 {
                color: #444;
                background-color: transparent;
                border-bottom: 1px solid #D0D0D0;
                font-size: 19px;
                font-weight: normal;
                margin: 0 0 14px 0;
                padding: 14px 15px 10px 15px;
        }
        code {
                font-family: Consolas, Monaco, Courier New, Courier, monospace;
                font-size: 12px;
                background-color: #f9f9f9;
                border: 1px solid #D0D0D0;
                color: #002166;
                display: block;
                margin: 14px 0 14px 0;
                padding: 12px 10px 12px 10px;
        }
        #body {
                margin: 0 15px 0 15px;
        }
        p.footer {
                text-align: right;
                font-size: 11px;
                border-top: 1px solid #D0D0D0;
                line-height: 32px;
                padding: 0 10px 0 10px;
                margin: 20px 0 0 0;
        }
        #container {
                margin: 10px;
                border: 1px solid #D0D0D0;
                box-shadow: 0 0 8px #D0D0D0;
        }
       table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        td, th {
            text-align: left;
            padding: 8px;
        }
        </style>
      <link rel="stylesheet" href="<?php echo $this->config->item('assets_base_url');?>css/jquery-ui.css"/>
      <script src="<?php echo $this->config->item('assets_base_url');?>js/jquery-1.12.4.js"></script>
      <script src="<?php echo $this->config->item('assets_base_url');?>js/jquery-1.12.1-ui.js"></script>
      <script>
      $( function() {
        $( "#menu" ).menu();
      } );
      </script>
      <style>
      .ui-menu { width: 150px; }
      </style>
    <!-- jQuery Form Validation code -->
    <script>

$(document).ready(function(){
$("#package_data_type").bind("change", function(){
if($(this).val()==2){
    $(".fup_class").show();
    $("#limitdl").attr("checked",false);
    $("#limitul").attr("checked",false);
    $("#limitcomb").attr("checked",false);
    $("#dl_traffic_unit").val("");
    $("#ul_traffic_unit").val("");
    $("#total_traffic_unit").val("");
    $("#data_split_monthly").attr("checked",true);
}else{
    $(".fup_class").hide();
}
});
$("#add_subplan").bind("click", function(){
var str = "<tr name='subplan_row[]'><td><input type='checkbox' name='subplan_check[]'/></td><td><input type='text' name='subplan_name[]'/></td><td><input type='text' name='subplan_price[]'/></td><td><input type='text' name='subplan_unit[]'/></td><td><select name='subplan_unit_type[]'><option value='1'>day(s)</option><option value='2'>month(s)</option></select></td><td><select name='subplan_status[]'><option value='1'>Active</option><option value='0'>Inactive</option></select></td></tr>";
$("#subplans").append(str);
});
$("#delete_subplan").bind("click", function(){

var i=0;
$('tr[name="subplan_row[]"]').each(function(){
    if($(this).find('input[name="subplan_check[]"]')){
    if($(this).find('input[name="subplan_check[]"]').attr('checked')==true){
        $(this).remove();
    }}
    i++;
});
});
});
    </script>
    
    </head>
    <body>
    <div id="container">
    <div><h1>Welcome to INVIC Radis module</h1>
        <div style="text-align:right;">Welcome <a href="<?php echo base_url();?>user/dashboard"><?php echo $_SESSION['user']->username;?></a> | <a href="<?php echo base_url();?>user/logout">Logout</a></div></div>
        <div id="body">
            <div style="width:20%;float: left;">Menu
              <ul id="menu" style="list-style: none;">
              <!--<li class="ui-state-disabled"><div>Toys (n/a)</div></li>-->
              <li><div><a href="<?php echo base_url();?>user/details">Users</a></div><ul>
              <li><div><a href="<?php echo base_url();?>user/add">Add User</a></div></li>
                  </ul></li>
              <li><div><a href="<?php echo base_url();?>service/details">Services</a></div><ul>
              <li><div><a href="<?php echo base_url();?>service/add">Add Service</a></div></li>
                  </ul></li>
              <li><div><a href="<?php echo base_url();?>adminuser/details">Admin Users</a></div>
                  <ul>
              <li><div><a href="<?php echo base_url();?>adminuser/create">Add adminuser</a></div></li>
                  </ul>
              </li>
              <li><div><a href="<?php echo base_url();?>manager/detail">Managers</a></div>
                  <ul>
              <li><div><a href="<?php echo base_url();?>manager/add">Add Manager</a></div></li>
                  </ul>
              </li>
              <li><div><a href="<?php echo base_url();?>reseller/detail">Resellers</a></div>
              <ul>
              <li><div><a href="<?php echo base_url();?>reseller/create">Add Reseller</a></div></li>
              </ul>
              </li>
              <li><div><a href="<?php echo base_url();?>branch/detail">Branches</a></div>
              <ul>
              <li><div><a href="<?php echo base_url();?>branch/create">Add Branch</a></div></li>
              </ul>
              </li>
              <li><div><a href="<?php echo base_url();?>area/detail">Areas</a></div>
              <ul>
              <li><div><a href="<?php echo base_url();?>area/create">Add Area</a></div></li>
              </ul>
              </li>
              <li><div><a href="<?php echo base_url();?>colony/detail">Colonys</a></div>
              <ul>
              <li><div><a href="<?php echo base_url();?>colony/create">Add Colony</a></div></li>
              </ul>
              </li>              
              <!--<li class="ui-state-disabled"><div>Specials (n/a)</div></li>-->
            </ul>
            </div><div  style="width:80%;float: left;">Content
                <div class="<?php echo $status;?>"><?php echo $msg;?></div>
                <form name="srv_create_form" id="srv_create_form" method="post">
                    <table border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>Service Name:</td><td><input type="text" name="srvname" id="srvname"/></td>
                        </tr>
                        <tr>
                            <td>Description:</td><td><input type="text" name="descr" id="descr"/></td>
                        </tr>
                        <tr>
                            <td>Enabled:</td><td><input type="checkbox" name="enableservice" id="enableservice" value="1" checked="true"/></td>
                        </tr>
                        <tr>
                            <td>Set Data rate(DL/UL):</td><td><input type="text" name="downrate" value="0"/><input type="text" name="uprate" value="0"/>Kbps</td>
                        </tr>                        
                        <tr>
                            <td>Billing Type:</td><td><input type="radio" name="billing_type"/>Prepaid<input type="radio" name="billing_type"/>Postpaid</td>
                        </tr>
                        <tr>
                            <td>Service Type:</td><td><select name="service_type" id="service_type"><option value="">Select</option><option value="1">Broadband Prepaid</option><option value="2">Leased line</option><option value="3">WIFI Hotspot</option></select></td>
                        </tr>
                        <tr>
                            <td>Package Expiry Type:</td><td><select name="package_expiry_type" id="package_expiry_type"><option value="1">Should be expired</option></select></td>
                        </tr>
                        <tr>
                            <td>Package Data Type:</td><td><select name="package_data_type" id="package_data_type"><option value="1">Unlimited</option><option value="2">FUP</option></select></td>
                        </tr>
                        <tr class="fup_class">
                            <td>Limit Download Bytes:</td><td><input type="checkbox" name="limitdl" id="limitdl"/></td>
                        </tr>
                        <tr class="fup_class">
                            <td>Limit Upload Bytes:</td><td><input type="checkbox" name="limitul" id="limitul"/></td>
                        </tr>
                        <tr class="fup_class">
                            <td>Limit (Download+Upload) traffic:</td><td><input type="checkbox" name="limitcomb" id="limitcomb"/></td>
                        </tr>
                        <tr class="fup_class">
                            <td>Download Traffic Unit:</td><td><input type="text" name="dl_traffic_unit" id="dl_traffic_unit"/></td>
                        </tr>
                        <tr class="fup_class">
                            <td>Upload Traffic Unit:</td><td><input type="text" name="ul_traffic_unit" id="ul_traffic_unit"/></td>
                        </tr>
                        <tr class="fup_class">
                            <td>Total Traffic Unit:</td><td><input type="text" name="total_traffic_unit" id="total_traffic_unit"/></td>
                        </tr>
                        <tr class="fup_class">
                            <td>Split Data Monthly:</td><td><input type="checkbox" name="data_split_monthly" id="data_split_monthly"/></td>
                        </tr>                        
                        <tr>
                            <td>Limit Online time:</td><td><input type="checkbox" name="limit_online_time" id="limit_online_time"/></td>
                        </tr>
                        <tr>
                            <td>Next Fallen Package:</td><td><select name="fallen_service" id="fallen_service"><option value="">Select</option>
                                    <?php foreach ($data as $row) {?>
                                    <option value="<?php echo $row->srvid;?>"><?php echo $row->srvname;?></option>        
                                    <?php }?></select></td>
                        </tr>
                        <tr>
                            <td>Download Quota per day:</td><td><input type="text" name="dl_quota_day" id="dl_quota_day"/></td>
                        </tr>
                        <tr>
                            <td>Upload Quota per day:</td><td><input type="text" name="ul_quota_day" id="ul_quota_day"/></td>
                        </tr>
                        <tr>
                            <td>Total Quota per day:</td><td><input type="text" name="total_quota_day" id="total_quota_day"/></td>
                        </tr>
                        <tr>
                            <td>Next Daily fallen Package:</td><td><select  name="fallen_daily_service" id="fallen_daily_service">
                                    <option value="">Select</option>
                                    <?php foreach ($data as $row) {?>
                                    <option value="<?php echo $row->srvid;?>"><?php echo $row->srvname;?></option>        
                                    <?php }?>
                                </select></td>
                        </tr>
                        <tr>
                            <td>Time Quota Per Day:</td><td><input type="text" name="time_quota_day" id="time_quota_day"/></td>
                        </tr>
                        <tr>
                            <td>Enable burst mode:</td><td><input type="checkbox" name="enable_burst" id="enable_burst"/></td>
                        </tr>
                        <tr>
                            <td>Burst Limit(DL/UL):</td><td><input type="text" name="burst_dl_limit" id="burst_dl_limit"/><input type="text" name="burst_ul_limit" id="burst_ul_limit"/></td>
                        </tr>
                        <tr>
                            <td>Burst Threshold(DL/UL):</td><td><input type="text" name="burst_dl_threshold" id="burst_dl_threshold"/><input type="text" name="burst_ul_threshold" id="burst_ul_threshold"/></td>
                        </tr>
                        <tr>
                            <td>Burst Time(DL/UL):</td><td><input type="text" name="burst_dl_time" id="burst_dl_time"/><input type="text" name="burst_ul_time" id="burst_ul_time"/></td>
                        </tr>
                        <tr>
                            <td>Priority:</td><td><input type="text" name="burst_priority" id="burst_priority"/></td>
                        </tr>
                        <tr>
                            <td>Date addition mode:</td><td><input type="radio" name="date_addition_mode" id="date_addition_mode" checked="true" value="1"/>Reset Expiration date<br/>
                            <input type="radio" name="date_addition_mode" id="date_addition_mode"  value="2"/>Prolong Expiration date<br/>
                            <input type="radio" name="date_addition_mode" id="date_addition_mode"  value="3"/>Prolong Expiration date with correction<br/>
                            </td>
                        </tr>
                        <tr>
                            <td>Time addition mode:</td><td><input type="radio" name="time_addition_mode" id="time_addition_mode" checked="true"  value="1"/>Reset Online time<br/>
                            <input type="radio" name="time_addition_mode" id="time_addition_mode"  value="2"/>Prolong Online time<br/>
                            </td>
                        </tr>
                        <tr>
                            <td>Traffic addition mode:</td><td><input type="radio" name="traffic_addition_mode" id="traffic_addition_mode" checked="true"  value="1"/>Reset Traffic Counters<br/>
                            <input type="radio" name="traffic_addition_mode" id="traffic_addition_mode"  value="2"/>Additive<br/>
                            </td>
                        </tr>
                        <tr>
                            <td>Custom RADIUS attributes:</td><td><textarea name="custom_attributes" id="custom_attributes"></textarea></td>
                        </tr>
                        <tr>
                            <td colspan="2"><hr/></td>
                        </tr>
                        <tr>
                            <td>Service Tax:<input type="checkbox" name="servicetax" id="servicetax"/></td><td><select name="price_with_tax" id="price_with_tax"><option value="1">Inclusive Tax</option><option value="2">Exclude Tax</option></select></td>
                        </tr>                        
                    </table>
                    <div>
                        <div>
                            <div><input type="button" id="add_subplan" value="Add"/>&nbsp;&nbsp;<input type="button" id="delete_subplan" value="Delete"/></div>
                            <table id="subplans">
                                <tr name='subplan_row[]'><th>Action</th><th>Sub Plan Name</th><th>Price</th><th>Time Unit</th><th>Unit Type</th><th>Status</th></tr>
                                <tr name='subplan_row[]'><td></td><td><input type="text" name="subplan_name[]"/></td><td><input type="text" name="subplan_price[]"/></td><td><input type="text" name="subplan_unit[]"/></td><td><select name="subplan_unit_type[]"><option value="1">day(s)</option><option value="2">month(s)</option></select></td><td><select name="subplan_status[]"><option value="1">Active</option><option value="0">Inactive</option></select></td></tr>
                            </table>
                        </div>
                    </div>
                    <input type="submit" name="addservice" value="Add Service"/>
                </form>
            </div>
            <div style="clear: both"></div>
        </div>

        <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
    </div>

    </body>
    </html>