<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome</title>
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
</head>
<body>
<div id="container">
    <div><h1>Welcome to INVIC Radis System</h1>
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
            </div><div  style="width:80%;float: left;">Content</div>
            <div style="clear: both"></div>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <!--<?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?>--></p>
</div>

</body>
</html>