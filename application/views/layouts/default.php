<!Doctype html>
<html>
    <head>
        <title>Welcome to DoctorJi</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Styles -->
        <link href="<?php echo $assets_base_url;?>css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?php echo $assets_base_url;?>css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?php echo $assets_base_url;?>css/style.css" rel="stylesheet" type="text/css" media="all" />
    <!-- //Styles-->
    </head>
    <body>
        <header>
            <nav class="navbar navbar-main">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header header-brand-container">
                        <button type="button" class="navbar-toggle collapsed pull-left main-menu-togggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <i class="fa fa-bars"></i>
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                         </button>
                        <a class="navbar-brand" href="<?php echo base_url();?>"><img src="<?php echo $assets_base_url;?>images/logo.png" alt="DoctorJI" class="img-responsive" id="header-logo"></a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="pull-right top-header-links">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#" class="cart"><svg class="cart-symbol" width="16" height="16"><path d="M15.32 2.405H4.887C3 2.405 2.46.805 2.46.805L2.257.21C2.208.085 2.083 0 1.946 0H.336C.1 0-.064.24.024.46l.644 1.945L3.11 9.767c.047.137.175.23.32.23h8.418l-.493 1.958H3.768l.002.003c-.017 0-.033-.003-.05-.003-1.06 0-1.92.86-1.92 1.92s.86 1.92 1.92 1.92c.99 0 1.805-.75 1.91-1.712l5.55.076c.12.922.91 1.636 1.867 1.636 1.04 0 1.885-.844 1.885-1.885 0-.866-.584-1.593-1.38-1.814l2.423-8.832c.12-.433-.206-.86-.655-.86" fill="#0ea28f" data-reactid="57"></path></svg><!-- react-text: 58 --><span class="hidden-xs cart-title">CART</span><!-- /react-text --><span class="item-count badge badge-bc">0</span></a></li>
                            <li>
                                <?php if(!isset ($_SESSION['user_web'])){?><a style="padding:0px" href="<?php echo base_url();?>user/login"><button class="btn login-button" data-toggle="modal" data-target="#myModal12">
   <span class="hidden-xs">LOGIN/REGISTER</span><i class="fa fa-user visible-xs"></i></button></a><?php }else{?>
   <a style="padding:0px" href="<?php echo base_url();?>user/logout"><button class="btn login-button" data-toggle="modal" data-target="#myModal12">
   <span class="hidden-xs">LOGOUT</span><i class="fa fa-user visible-xs"></i></button></a><?php }?>
                            </li>
                        </ul>
                    </div><!-- //.navbar-collapse -->
                  </div><!-- //.container-fluid -->
                </nav>
        </header>
    <!-- //header -->
        <div class="main container-fluid">
            <div class="row">
                <div class="col-sm-2 no-padding-left">
                    <aside class="sidebar-left-collapse collapse navbar-collapse doc-left-nav" id="bs-example-navbar-collapse-1">
                        <div class="sidebar-links">
                            <div class="">
                                <a href="<?php echo base_url();?>doctor/bookings">
                                    <i class="fa fa-bookmark-o icon-grey"></i>My Bookings
                                </a>
                            </div>
                            <div class="selected">
                                <a href="<?php echo base_url();?>doctor/appointments">
                                    <i class="fa fa-history icon-grey"></i>Appointments
                                </a>
                            </div>
                            <div class="">
                                <a href="#">
                                    <i class="fa fa-hospital-o icon-grey"></i>Availability
                                </a>
                            </div>
                            <div class="">
                                <a href="<?php echo base_url();?>bbank/raisedrequests">
                                    <i class="fa fa-keyboard-o icon-grey"></i>Raise Blood Req
                                </a>
                            </div>
                            <div class="">
                                <a href="#">
                                    <i class="fa fa-plus icon-grey"></i>Medicines
                                </a>
                            </div>
                        </div>
                    </aside>
                </div>
                <div class="col-sm-10">
                    <div class="row">
                    <div class="col-sm-9 no-padding-desktop">
                    <div class="main-container">
                        <?php echo $content;?>                        
                    </div>
                </div>
                <div class="col-sm-3 no-padding-right padding-mob-contaner">
                    <div class="right-bar">
                        <h2>OFFERS FOR YOU</h2>
                        <div class="ola-snap mt-md">
                            <a href="#">
                                <img src="<?php echo $assets_base_url;?>images/ccd.png" class="ola-banner-img img-responsive">
                            </a>
                           <p class="add-title">CAFE COFFE DAY</p>
                           <p class="p-small">15% Cashback on minimum bill of Rs. 350</p>
                        </div>
                        <div class="deals mt-md">
                            <img src="<?php echo $assets_base_url;?>images/hp.png" class="img-responsive">
                             <p class="add-title">HP PETROL PUMPS</p>
                            <p class="p-small">15% Cashback on minimum bill of Rs. 350</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
        <!-- //main -->
        <footer id="footerWrapper">
            <section id="mainFooter">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-9">
                                     <div class="row footer-navigation">
                                         <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-xs-6">
                                                        <ul>
                                                            <li class="title">Pellentesque</li>
                                                            <li><a href="#" title="Lorum">Lorem</a></li>
                                                            <li><a href="#" title="Aliquam">Aliquam</a></li>
                                                            <li><a href="#" title="Morbi in sem quis dui placerat ornare">Morbi</a></li>
                                                            <li><a href="#" title="Praesent dapibus, neque id cursus faucibus">Praesent</a></li>
                                                            <li><a href="#" title="Pellentesque fermentum dolor">Pellentesque</a></li>
                                                            <li><a href="#" title="Lorum">Lorem</a></li>
                                                            <li><a href="#" title="Aliquam">Aliquam</a></li>
                                                            <li><a href="#" title="Morbi in sem quis dui placerat ornare">Morbi</a></li>
                                                            <li><a href="#" title="Praesent dapibus, neque id cursus faucibus">Praesent</a></li>
                                                            <li><a href="#" title="Pellentesque fermentum dolor">Pellentesque</a></li>
                                                        </ul>
                                                </div>
                                                 <div class="col-xs-6">
                                                        <ul>
                                                            <li class="title">Praesent</li>
                                                            <li><a href="#" title="Lorum">Lorem</a></li>
                                                            <li><a href="#" title="Aliquam">Aliquam</a></li>
                                                            <li><a href="#" title="Morbi in sem quis dui placerat ornare">Morbi</a></li>
                                                            <li><a href="#" title="Praesent dapibus, neque id cursus faucibus">Praesent</a></li>
                                                            <li><a href="#" title="Pellentesque fermentum dolor">Pellentesque</a></li>
                                                            <li><a href="#" title="Lorum">Lorem</a></li>
                                                            <li><a href="#" title="Aliquam">Aliquam</a></li>
                                                            <li><a href="#" title="Morbi in sem quis dui placerat ornare">Morbi</a></li>
                                                            <li><a href="#" title="Praesent dapibus, neque id cursus faucibus">Praesent</a></li>
                                                            <li><a href="#" title="Pellentesque fermentum dolor">Pellentesque</a></li>
                                                        </ul>
                                                </div>
                                                </div>
                                         </div>
                                         <div class="col-sm-6">
                                            <div class="row">
                                         <div class="col-xs-6">
                                                <ul>
                                                    <li class="title">Aliquam</li>
                                                    <li><a href="#" title="Lorum">Lorem</a></li>
                                                    <li><a href="#" title="Aliquam">Aliquam</a></li>
                                                    <li><a href="#" title="Morbi in sem quis dui placerat ornare">Morbi</a></li>
                                                    <li><a href="#" title="Praesent dapibus, neque id cursus faucibus">Praesent</a></li>
                                                    <li><a href="#" title="Pellentesque fermentum dolor">Pellentesque</a></li>
                                                    <li><a href="#" title="Lorum">Lorem</a></li>
                                                    <li><a href="#" title="Aliquam">Aliquam</a></li>
                                                    <li><a href="#" title="Morbi in sem quis dui placerat ornare">Morbi</a></li>
                                                    <li><a href="#" title="Praesent dapibus, neque id cursus faucibus">Praesent</a></li>
                                                    <li><a href="#" title="Pellentesque fermentum dolor">Pellentesque</a></li>
                                                </ul>
                                        </div>
                                         <div class="col-xs-6">
                                                <ul>
                                                    <li class="title">Pellentesque</li>
                                                    <li><a href="#" title="Lorum">Lorem</a></li>
                                                    <li><a href="#" title="Aliquam">Aliquam</a></li>
                                                    <li><a href="#" title="Morbi in sem quis dui placerat ornare">Morbi</a></li>
                                                    <li><a href="#" title="Praesent dapibus, neque id cursus faucibus">Praesent</a></li>
                                                    <li><a href="#" title="Pellentesque fermentum dolor">Pellentesque</a></li>
                                                    <li><a href="#" title="Lorum">Lorem</a></li>
                                                    <li><a href="#" title="Aliquam">Aliquam</a></li>
                                                    <li><a href="#" title="Morbi in sem quis dui placerat ornare">Morbi</a></li>
                                                    <li><a href="#" title="Praesent dapibus, neque id cursus faucibus">Praesent</a></li>
                                                    <li><a href="#" title="Pellentesque fermentum dolor">Pellentesque</a></li>
                                                </ul>
                                        </div>
                                             </div>
                                         </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                        <ul class="socialNetwork">
                                            <li><a href="#" class="tips" title="follow me on Facebook"><i class="fa fa-facebook iconRounded"></i></a></li>
                                            <li><a href="#" class="tips" title="follow me on Twitter"><i class="fa fa-twitter iconRounded"></i></a></li>
                                            <li><a href="#" class="tips" title="follow me on Google+"><i class="fa fa-google-plus iconRounded" aria-hidden="true" ></i></a></li>
                                            <li><a href="#" class="tips" title="follow me on Linkedin"><i class="fa fa-linkedin iconRounded"></i></a></li>
                                            <li><a href="#" class="tips" title="follow me on Dribble"><i class="fa fa-dribbble iconRounded"></i></a></li>
                                        </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </section>
                <section id="footerRights">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <p>Copyright � 2016 <a href="#" target="blank">DoctorJI</a> / All rights reserved.</p>
                            </div>
                        </div>
                    </div>
                </section>
        </footer>
        <div id="bpopup_div" style="display:none"></div>
          <!-- //footer -->
        <!-- Login Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                �</button>
                            <h4 class="modal-title" id="myModalLabel"><img src="images/logo.png" alt="DoctorJI" class="img-responsive" id="modal-logo"
                               </h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs modal-nav-tabs">
                                        <li class="active"><a href="#Login" data-toggle="tab">LOGIN</a></li>
                                        <li><a href="#Registration" data-toggle="tab">REGISTER</a></li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="Login">
                                            <form role="form" class="form-horizontal">
                                            <div class="form-group">
                                                <label for="email" class="col-sm-2 control-label">
                                                    Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control" id="email1" placeholder="Email" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1" class="col-sm-2 control-label">
                                                    Password</label>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control" id="exampleInputPassword1" placeholder="Email" />
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="Registration">
                                            <form role="form" class="form-horizontal">
                                                <div class="form-group">
                                                    <label for="email" class="col-sm-2 control-label">
                                                        Name</label>
                                                    <div class="col-sm-10">
                                                         <input type="text" class="form-control" placeholder="Name" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email" class="col-sm-2 control-label">
                                                        Email</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" class="form-control" id="email" placeholder="Email" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="mobile" class="col-sm-2 control-label">
                                                        Mobile</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" class="form-control" id="mobile" placeholder="Mobile" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password" class="col-sm-2 control-label">
                                                        Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" class="form-control" id="password" placeholder="Password" />
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="row">
                                 <div class="col-sm-2">
                                </div>
                                <div class="col-sm-10">
                                        <button type="button" class="btn login-button btn-lg">
                                            Save &amp; Continue</button>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      <!-- //Login Modal -->
    <!-- Scripts -->
        <script type="text/javascript" src="<?php echo $assets_base_url;?>js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo $assets_base_url;?>js/bootstrap.min.js"></script>
        <script type='text/javascript' src="<?php echo $assets_base_url;?>js/bpopup/jquery.bpopup.min.js"></script>
        <script type="text/javascript">
            $(function () {
                var links = $('.sidebar-links > div');
                links.on('click', function () {
                    links.removeClass('selected');
                    $(this).addClass('selected');
                });
                //$('#myModal').modal('show');
             });
     </script>
     <!-- //Scripts -->
    </body>
</html>