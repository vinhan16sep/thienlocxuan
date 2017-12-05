<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
        <meta name="author" content="GeeksLabs">
        <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
        <link rel="shortcut icon" href="img/favicon.png">

        <title><?php echo $page_title; ?></title>

        <!-- Bootstrap CSS -->    
        <link type="text/css" rel="stylesheet" href="<?php echo site_url('assets/public/css/bootstrap.css'); ?>">
        <!-- bootstrap theme -->
        <!--<link type="text/css" rel="stylesheet" href="<?php echo site_url('assets/admin/css/bootstrap-theme.css'); ?>">-->
        <!--external css-->
        <!-- font icon -->
        <link type="text/css" href="<?php echo site_url('assets/admin/css/elegant-icons-style.css'); ?>" rel="stylesheet" />
        <link href="<?php echo site_url('assets/admin/css/font-awesome.css'); ?>" rel="stylesheet" />    
        <link href="<?php echo site_url('assets/admin/css/font-awesome.min.css'); ?>" rel="stylesheet" />
        <!-- Custom styles -->
        <link href="<?php echo site_url('assets/admin/css/style.css'); ?>" rel="stylesheet">
        <link href="<?php echo site_url('assets/admin/css/style-responsive.css'); ?>" rel="stylesheet" />	
        <link href="<?php echo site_url('assets/admin/css/jquery-ui-1.10.4.min.css'); ?>" rel="stylesheet">
        <style>
            .row .col-md-12, .row .col-md-6{
                margin-bottom: 15px;
            }
            .fix-bottom{
                position: fixed;
                top:60px;
                right: 0;
                width: 50%;
                padding: 15px;
                opacity: 1;
            }

            .container .row{
                padding-bottom: 65px;
            }
            
            .modified-mode input[type="submit"], a.cancel{
                width: 20% !important;
                margin-top: 3px;
            }

            .btn{
                margin-bottom: 7px;
            }
        </style>
        <!-- javascripts -->
        <script src="<?php echo site_url('assets/admin/js/jquery.js'); ?>"></script>
        <script src="<?php echo site_url('assets/admin/js/jquery-ui-1.10.4.min.js'); ?>"></script>
        <script src="<?php echo site_url('assets/admin/js/jquery-1.8.3.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo site_url('assets/admin/js/jquery-ui-1.9.2.custom.min.js'); ?>"></script>
        <!-- bootstrap -->
        <script src="<?php echo site_url('assets/admin/js/bootstrap.min.js'); ?>"></script>
        <!-- nice scroll -->
        <script src="<?php echo site_url('assets/admin/js/jquery.scrollTo.min.js'); ?>"></script>
        <script src="<?php echo site_url('assets/admin/js/jquery.nicescroll.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/admin/js/owl.carousel.js'); ?>" ></script>
        <script src="<?php echo site_url('assets/admin/js/jquery.rateit.min.js'); ?>"></script>
        <!-- custom select -->
        <script src="<?php echo site_url('assets/admin/js/jquery.customSelect.min.js'); ?>" ></script>

        <!--custome script for all page-->
        <script src="<?php echo site_url('assets/admin/js/scripts.js'); ?>"></script>
        <!-- custom script for this page-->
        <script src="<?php echo site_url('assets/admin/js/jquery.autosize.min.js'); ?>"></script>
        <script src="<?php echo site_url('assets/admin/js/jquery.placeholder.min.js'); ?>"></script>
        <script src="<?php echo site_url('assets/admin/js/gdp-data.js'); ?>"></script>
        <script src="<?php echo site_url('assets/admin/js/jquery.slimscroll.min.js'); ?>"></script>

        <script src="<?php echo site_url('assets/admin/js/admin/users.js'); ?>"></script>
        <script src="<?php echo site_url('assets/admin/js/admin/groups.js'); ?>"></script>
        <script src="<?php echo site_url('assets/admin/js/admin/languages.js'); ?>"></script>
        <script src="<?php echo site_url('assets/admin/js/admin/dashboard.js'); ?>"></script>
    </head>

    <body>
        <?php
        if ($this->ion_auth->logged_in()) {
            ?>
            <!-- container section start -->
            <section id="container" class="">


                <header class="header dark-bg">
                    <div class="toggle-nav">
                        <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
                    </div>

                    <!--logo start-->
                    <a href="<?php echo site_url('admin'); ?>" class="logo">Thien Loc Xuan <span class="lite">Admin</span></a>
                    <!--logo end-->

                    <div class="nav search-row" id="top_menu">
                        <!--  search form start -->
                        <ul class="nav top-menu">                    
                            <!--<li>
                                <form class="navbar-form">
                                    <input class="form-control" placeholder="Search" type="text">
                                </form>
                            </li>-->
                        </ul>
                        <!--  search form end -->                
                    </div>

                    <div class="top-nav notification-row">
                        <!-- notificatoin dropdown start-->
                        <ul class="nav pull-right top-menu">

                            <!-- task notificatoin start -->

                            <!-- alert notification end-->
                            <!-- user login dropdown start-->
                            <li class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <!--
                                    <span class="profile-ava">
                                        <img alt="" src="<?php echo site_url('assets/admin/img/images.jpeg'); ?>">
                                    </span>
                                    -->
                                    <span class="username"><?php echo $this->ion_auth->user()->row()->email; ?></span>
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu extended logout">
                                    <div class="log-arrow-up"></div>
                                    <li class="eborder-top">
                                        <!--<a href="<?php echo site_url('admin/user/profile'); ?>"><i class="icon_profile"></i> My Profile</a>-->
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('admin/user/logout'); ?>"><i class="icon_key_alt"></i> Log Out</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- user login dropdown end -->
                        </ul>
                        <!-- notificatoin dropdown end-->
                    </div>
                </header>
            <?php } ?>
            <!--header end-->