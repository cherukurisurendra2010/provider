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
      $(document).ready(function(){
          $( function() {
               $("#menu").menu();
          });
          $("#service").on("change",function(){
            var service_id = $(this).val();
            $.ajax({
              method: "POST",
              url: "<?php echo $this->config->item('base_url');?>service/subplan",
              data: { service_id: service_id },
              success:function(data){
                   console.log(data);
				   var optionsHTML = '';
				   data = JSON.parse(data);
				   if(data.length>0){
				   for(i=0;i<data.length;i++){
					   optionsHTML += "<option value='"+data[i].id+"'>"+data[i].subplan+"</option>";
				   }}
				   $("#subplan").html(optionsHTML);

              }
            });
          });
      });
      </script>
      <style>
      .ui-menu { width: 150px; }
      </style>
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
                <form name="e_create_form" id="e_create_form" method="post">
                    <table border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>Manager:</td><td><select name="manager" id="manager">
                                    <?php foreach($managers as $manager){?>
                                    <option value="<?php echo $manager->managername;?>"><?php echo $manager->managername;?></option>
                                    <?php } ?>
                                </select></td>
                        </tr>                        
                        <tr>
                            <td>Username:</td><td><input type="text" name="username" id="username"/></td>
                        </tr>
                        <tr>
                            <td>Password:</td><td><input type="password" name="password" id="password"/></td>
                        </tr>
                        <tr>
                            <td>Confirm Password:</td><td><input type="password" name="c_password" id="c_password"/></td>
                        </tr>
                        <tr>
                            <td>Enable User:</td><td><input type="checkbox" name="enableuser" id="enableuser" checked="true" value="1"/></td>
                        </tr>
                        <tr>
                            <td>first name:</td><td><input type="text" name="firstname" id="firstname"/></td>
                        </tr>
                        <tr>
                            <td>last name:</td><td><input type="text" name="lastname" id="lastname"/></td>
                        </tr>
                        <tr>
                            <td>Email:</td><td><input type="text" name="email" id="email"/></td>
                        </tr>
                        <tr>
                            <td>Mobile:</td><td><input type="text" name="mobile" id="mobile"/></td>
                        </tr>
                        <tr>
                            <td>Phone:</td><td><input type="text" name="phone" id="phone"/></td>
                        </tr>
                        <tr>
                            <td>Service:</td><td><select name="service" id="service">
                                    <?php foreach($services as $service){?>
                                    <option value="<?php echo $service->srvid;?>"><?php echo $service->srvname;?></option>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td>Subplan:</td><td><select name="subplan" id="subplan">
                                </select></td>
                        </tr>
                        <tr>
                            <td>Registration Address:</td><td></td>
                        </tr>
                        <tr>
                            <td>Address:</td><td><input type="text" name="reg_address" id="reg_address"/></td>
                        </tr>
                        <tr>
                            <td>City:</td><td><input type="text" name="reg_city" id="reg_city"/></td>
                        </tr>
                        <tr>
                            <td>Zip:</td><td><input type="text" name="reg_zip" id="reg_zip"/></td>
                        </tr>
                        <tr>
                            <td>State:</td><td><input type="text" name="reg_state" id="reg_state"/></td>
                        </tr>
                        <tr>
                            <td>Country:</td><td><input type="text" name="reg_country" id="reg_country"/></td>
                        </tr>
                        <tr>
                            <td>Installation Address:</td><td></td>
                        </tr>
                        <tr>
                            <td>Address:</td><td><input type="text" name="inst_address" id="inst_address"/></td>
                        </tr>
                        <tr>
                            <td>City:</td><td><input type="text" name="inst_city" id="inst_city"/></td>
                        </tr>
                        <tr>
                            <td>Zip:</td><td><input type="text" name="inst_zip" id="inst_zip"/></td>
                        </tr>
                        <tr>
                            <td>State:</td><td><input type="text" name="inst_state" id="inst_state"/></td>
                        </tr>
                        <tr>
                            <td>Country:</td><td><input type="text" name="inst_country" id="inst_country"/></td>
                        </tr>
                        <tr>
                            <td></td><td><input type="submit" name="adduser" value="Add User"/></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div style="clear: both"></div>
        </div>

        <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
    </div>

    </body>
    </html>