<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!doctype html>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- InstanceBeginEditable name="doctitle" -->
    <title>Thiên Lộc Xuân</title>
    <!-- InstanceEndEditable -->
    <link rel="shortcut icon" type="image/png" href="<?php echo site_url('assets/public/img/favicon16.png'); ?>"/>

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:900" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/public/css/bootstrap.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/public/css/font-awesome.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/public/css/hover.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/public/style.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/public/css/responsive.css'); ?>">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="<?php echo site_url('assets/public/js/bootstrap.js'); ?>"></script>
</head>

<body>
<header class="header">
    <section class="navigator_top brand_bg">
        <div class="container center-block">
            <ul class="col-lg-11">
                <!--<li><a href="#">Tuyển dụng</a></li>
                <li>|</li>
                <li><a href="#">Khỏe từ thiên nhiên</a></li>
                <li>|</li>
                <li><a href="#">Điều khoản sử dụng</a></li>
                <li>|</li>
                <li><a href="#">Liên hệ</a></li>
                <li>|</li>
                <li><a href="#"><i class="fa fa-envelope"></i> Email</a></li>-->
            </ul>
            <?php
                $url_en = '';
                $url_vi = '';

                switch($current_link){
                    case 'list_information':
                        $url_en = base_url() . 'en/' . 'blog/list_information';
                        $url_vi = base_url() . 'vi/' . 'blog/list_information';
                        break;
                    case 'list_medicine':
                        $url_en = base_url() . 'en/' . 'blog/list_medicine';
                        $url_vi = base_url() . 'vi/' . 'blog/list_medicine';
                        break;
                    case 'blog_detail':
                        $url_en = base_url() . 'en/' . 'blog/detail/' . $type . '/' . $blog_id;
                        $url_vi = base_url() . 'vi/' . 'blog/detail/' . $type . '/' . $blog_id;
                        break;
                    case 'medicine':
                        $url_en = base_url() . 'en/' . 'medicine';
                        $url_vi = base_url() . 'vi/' . 'medicine';
                        break;
                    case 'quotation':
                        $url_en = base_url() . 'en/' . 'quotation';
                        $url_vi = base_url() . 'vi/' . 'quotation';
                        break;
                    case 'list_physic':
                        $url_en = base_url() . 'en/' . 'physic';
                        $url_vi = base_url() . 'vi/' . 'physic';
                        break;
                    case 'physic_detail':
                        $url_en = base_url() . 'en/' . 'physic/detail/' . $physic_id;
                        $url_vi = base_url() . 'vi/' . 'physic/detail/' . $physic_id;
                        break;
                    case 'list_product':
                        $url_en = base_url() . 'en/' . 'product';
                        $url_vi = base_url() . 'vi/' . 'product';
                        break;
                    case 'product_detail':
                        $url_en = base_url() . 'en/' . 'product/detail/' . $product_id;
                        $url_vi = base_url() . 'vi/' . 'product/detail/' . $product_id;
                        break;
                    case 'partner':
                        $url_en = base_url() . 'en/' . 'partner';
                        $url_vi = base_url() . 'vi/' . 'partner';
                        break;
                    case 'list_recruitment':
                        $url_en = base_url() . 'en/' . 'recruitment';
                        $url_vi = base_url() . 'vi/' . 'recruitment';
                        break;
                    case 'recruitment_detail':
                        $url_en = base_url() . 'en/' . 'recruitment/detail/' . $recruitment_id;
                        $url_vi = base_url() . 'vi/' . 'recruitment/detail/' . $recruitment_id;
                        break;
                    case 'contact':
                        $url_en = base_url() . 'en/' . 'contact';
                        $url_vi = base_url() . 'vi/' . 'contact';
                        break;
                    case 'history':
                        $url_en = base_url() . 'en/' . 'introduce/history';
                        $url_vi = base_url() . 'vi/' . 'introduce/history';
                        break;
                    case 'duty':
                        $url_en = base_url() . 'en/' . 'introduce/duty';
                        $url_vi = base_url() . 'vi/' . 'introduce/duty';
                        break;
                    case 'structure':
                        $url_en = base_url() . 'en/' . 'introduce/structure';
                        $url_vi = base_url() . 'vi/' . 'introduce/structure';
                        break;
                    case 'culture':
                        $url_en = base_url() . 'en/' . 'introduce/culture';
                        $url_vi = base_url() . 'vi/' . 'introduce/culture';
                        break;
                    default:
                        $url_en = base_url() . 'en';
                        $url_vi = base_url() . 'vi';
                        break;
                }
            ?>
            <ul class="col-lg-12">
                <li><a href="<?php echo $url_en; ?>"><img src="<?php echo base_url('assets/public/img/en.png'); ?>" alt=""></a></li>
                <li>|</li>
                <li><a href="<?php echo $url_vi; ?>"><img src="<?php echo base_url('assets/public/img/vi.png'); ?>" alt=""></a></li>
            </ul>
        </div>
    </section>
    <section class="nav_bar">
        <div class="container-fluid center-block">
            <div class="logo col-lg-5 col-md-5 col-sm-12 col-xs-12">
                <a href="<?php echo base_url() . '' . 'vi' ; ?>"><img src="<?php echo base_url('assets/public/img/logo.png'); ?>" alt=""></a>
                <!--<a href="<?php echo base_url() . '/' . $lang ; ?>"><img src="<?php echo base_url('assets/public/img/logo.png'); ?>" alt=""></a>-->

            </div>
            <div id="accordion" aria-multiselectable="true" role="tablist">
                <div class="top_menu col-lg-7 col-md-7 col-sm-12 col-xs-12" id="top_menu" >
                    <a class="sub_menu_hover" role="button" data-toggle="collapse" data-parent="#accordion" href="#sub_1" aria-expanded="false" aria-controls="sub_1">
                        <?php echo $this->lang->line('about_us'); ?>
                    </a>

                    <a class="sub_menu_hover" role="button" data-toggle="collapse" data-parent="#accordion" href="#sub_2" aria-expanded="false" aria-controls="sub_2">
                        <?php echo $this->lang->line('product'); ?>
                    </a>

                    <a class="sub_menu_hover" role="button" data-toggle="collapse" data-parent="#accordion" href="#sub_3" aria-expanded="false" aria-controls="sub_3">
                        <?php echo $this->lang->line('blog'); ?>
                    </a>

                    <a class="sub_menu_hover" role="button" href="<?php echo site_url('recruitment'); ?>">
                        <?php echo $this->lang->line('recruit'); ?>
                    </a>
                    <a class="sub_menu_hover" role="button"  href="<?php echo site_url('contact'); ?>">
                        <?php echo $this->lang->line('contact'); ?>
                    </a>
                    <a class="sub_menu_hover" role="button" data-toggle="collapse" data-parent="#accordion" href="#sub_4" aria-expanded="false" aria-controls="sub_4">
                        <i class="fa fa-search"></i>
                    </a>

                    <div class="collapse-group">
                    <div class="collapse" id="sub_1">
                        <div class="well clearfix sub_menu">
                            <div class="sub_img hidden-xs">
                                <img src="<?php echo base_url('assets/public/img/about.jpg'); ?>">
                            </div>
                            <div class="sub_intro">
                                <p class="post_subtitle"><?php echo $this->lang->line('sub_1'); ?></p>
                                <p class="paragraph">
                                    <?php if($lang == 'vi'): ?>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                    <?php elseif($lang == 'en'): ?>
                                        Consectetur adipiscing elit.
                                    <?php  endif; ?>
                                </p>
                                <a href="<?php echo site_url('introduce/history'); ?>"><?php echo $this->lang->line('readmore'); ?> <i class="fa fa-angle-double-right"></i> </a>
                                <ul>
                                    <li><a href="<?php echo site_url('introduce/history'); ?>"><?php echo $this->lang->line('history'); ?></a></li>
                                    <li><a href="<?php echo site_url('introduce/duty'); ?>"><?php echo $this->lang->line('duty'); ?></a></li>
                                    <li><a href="<?php echo site_url('introduce/structure'); ?>"><?php echo $this->lang->line('structure'); ?></a></li>
                                    <li><a href="<?php echo site_url('introduce/culture'); ?>"><?php echo $this->lang->line('culture'); ?></a></li>
                                </ul>
                            </div>
<!--                            <div class="sub_list">-->
<!--                                <ul>-->
<!--                                    <li><a href="--><?php //echo site_url('introduce/history'); ?><!--">--><?php //echo $this->lang->line('history'); ?><!--</a></li>-->
<!--                                    <li><a href="--><?php //echo site_url('introduce/duty'); ?><!--">--><?php //echo $this->lang->line('duty'); ?><!--</a></li>-->
<!--                                    <li><a href="--><?php //echo site_url('introduce/structure'); ?><!--">--><?php //echo $this->lang->line('structure'); ?><!--</a></li>-->
<!--                                    <li><a href="--><?php //echo site_url('introduce/culture'); ?><!--">--><?php //echo $this->lang->line('culture'); ?><!--</a></li>-->
<!--                                </ul>-->
<!--                            </div>-->
                        </div>
                    </div>
                    <div class="collapse" id="sub_2">
                        <div class="well clearfix sub_menu">
                            <div class="sub_img hidden-xs">
                                <img src="<?php echo base_url('assets/public/img/about.jpg'); ?>">
                            </div>
                            <div class="sub_intro">
                                <p class="post_subtitle"><?php echo $this->lang->line('sub_2'); ?></p>
                                <p class="paragraph">
                                    <?php if($lang == 'vi'): ?>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                    <?php elseif($lang == 'en'): ?>
                                        Consectetur adipiscing elit
                                    <?php  endif; ?>
                                </p>
                                <a href="<?php echo site_url('physic'); ?>"><?php echo $this->lang->line('readmore'); ?> <i class="fa fa-angle-double-right"></i> </a>
                                <ul>
                                    <li><a href="<?php echo site_url('physic'); ?>"><?php echo $this->lang->line('medicine'); ?></a></li>
                                    <li><a href="<?php echo site_url('product'); ?>"><?php echo $this->lang->line('list_product'); ?></a></li>
                                    <li><a href="<?php echo site_url('quotation'); ?>"><?php echo $this->lang->line('quotation'); ?></a></li>
                                    <li><a href="<?php echo site_url('partner'); ?>"><?php echo $this->lang->line('partner'); ?></a></li>
                                </ul>
                            </div>
<!--                            <div class="sub_list">-->
<!--                                <ul>-->
<!--                                    <li><a href="--><?php //echo site_url('medicine'); ?><!--">--><?php //echo $this->lang->line('medicine'); ?><!--</a></li>-->
<!--                                    <li><a href="--><?php //echo site_url('product'); ?><!--">--><?php //echo $this->lang->line('list_product'); ?><!--</a></li>-->
<!--                                    <li><a href="--><?php //echo site_url('product'); ?><!--">--><?php //echo $this->lang->line('quotation'); ?><!--</a></li>-->
<!--                                    <li><a href="--><?php //echo site_url('partner'); ?><!--">--><?php //echo $this->lang->line('partner'); ?><!--</a></li>-->
<!--                                </ul>-->
<!--                            </div>-->
                        </div>
                    </div>
                    <div class="collapse" id="sub_3">
                        <div class="well clearfix sub_menu">
                            <div class="sub_img hidden-xs">
                                <img src="<?php echo base_url('assets/public/img/about.jpg'); ?>">
                            </div>
                            <div class="sub_intro">
                                <p class="post_subtitle"><?php echo $this->lang->line('sub_3'); ?></p>
                                <p class="paragraph">
                                    <?php if($lang == 'vi'): ?>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                    <?php elseif($lang == 'en'): ?>
                                        Consectetur adipiscing elit
                                    <?php  endif; ?>
                                </p>
                                <a href="<?php echo site_url('blog/list_information'); ?>"><?php echo $this->lang->line('readmore'); ?> <i class="fa fa-angle-double-right"></i> </a>
                                <ul>
                                    <li><a href="<?php echo site_url('blog/list_information'); ?>"><?php echo $this->lang->line('blog_information'); ?></a></li>
                                    <li><a href="<?php echo site_url('blog/list_medicine'); ?>"><?php echo $this->lang->line('blog_medicine'); ?></a></li>
                                </ul>
                            </div>
<!--                            <div class="sub_list">-->
<!--                                <ul>-->
<!--                                    <li><a href="--><?php //echo site_url('blog/list_information'); ?><!--">--><?php //echo $this->lang->line('blog_information'); ?><!--</a></li>-->
<!--                                    <li><a href="--><?php //echo site_url('blog/list_medicine'); ?><!--">--><?php //echo $this->lang->line('blog_medicine'); ?><!--</a></li>-->
<!--                                </ul>-->
<!--                            </div>-->
                        </div>
                    </div>
                    <div class="collapse" id="sub_4">
                        <div class="well clearfix sub_menu">
                            <form action="http://thienlocxuan.com.vn/search" method="get">
                            <!--<?php  echo form_open_multipart('http://thienlocxuan.com.vn/search'); ?>-->
                            <div class="col-lg-12 col-md-12 col-xs-12 sub_search">
                                <div class="input-group">
                                    <?php echo form_input('text', set_value('text'), 'class="form-control" placeholder="Tìm kiếm..."'); ?>
                                    <span class="input-group-btn">
                                        <?php echo form_submit('submit', 'OK', 'class="btn btn-default" style="height: 40px;"'); ?>
                                    </span>
                                </div>
                            </div>
                            </form>
                            <!--<?php  echo form_close(); ?>-->
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</header>