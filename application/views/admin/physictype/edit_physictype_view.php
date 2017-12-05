<style>
    .checkout-wrapper{padding-top: 40px; padding-bottom:40px; background-color: #fafbfa;}
    .checkout{    background-color: #fff;
        border:1px solid #eaefe9;

        font-size: 14px;}
    .panel{margin-bottom: 0px;}
    .checkout-step {

        border-top: 1px solid #f2f2f2;
        color: #666;
        font-size: 14px;
        padding: 30px;
        position: relative;
    }

    .checkout-step-number {
        border-radius: 50%;
        border: 1px solid #666;
        display: inline-block;
        font-size: 12px;
        height: 32px;
        margin-right: 26px;
        padding: 6px;
        text-align: center;
        width: 32px;
    }
    .checkout-step-title{ font-size: 18px;
        font-weight: 500;
        vertical-align: middle;display: inline-block; margin: 0px;
    }

    .checout-address-step{}
    .checout-address-step .form-group{margin-bottom: 18px;display: inline-block;
        width: 100%;}

    .checkout-step-body{padding-left: 60px; padding-top: 30px;}

    .checkout-step-active{display: block;}
    .checkout-step-disabled{display: none;}

    .checkout-login{}
    .login-phone{display: inline-block;}
    .login-phone:after {
        content: '+91 - ';
        font-size: 14px;
        left: 36px;
    }
    .login-phone:before {
        content: "";
        font-style: normal;
        color: #333;
        font-size: 18px;
        left: 12px;
        display: inline-block;
        font: normal normal normal 14px/1 FontAwesome;
        font-size: inherit;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    .login-phone:after, .login-phone:before {
        position: absolute;
        top: 50%;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
    }
    .login-phone .form-control {
        padding-left: 68px;
        font-size: 14px;

    }
    .checkout-login .btn{height: 42px;     line-height: 1.8;}

    .otp-verifaction{margin-top: 30px;}
    .checkout-sidebar{background-color: #fff;
        border:1px solid #eaefe9; padding: 30px; margin-bottom: 30px;}
    .checkout-sidebar-merchant-box{background-color: #fff;
        border:1px solid #eaefe9; margin-bottom: 30px;}
    .checkout-total{border-bottom: 1px solid #eaefe9; padding-bottom: 10px;margin-bottom: 10px; }
    .checkout-invoice{display: inline-block;
        width: 100%;}
    .checout-invoice-title{    float: left; color: #30322f;}
    .checout-invoice-price{    float: right; color: #30322f;}
    .checkout-charges{display: inline-block;
        width: 100%;}
    .checout-charges-title{float: left; }
    .checout-charges-price{float: right;}
    .charges-free{color: #43b02a; font-weight: 600;}
    .checkout-payable{display: inline-block;
        width: 100%; color: #333;}
    .checkout-payable-title{float: left; }
    .checkout-payable-price{float: right;}

    .checkout-cart-merchant-box{ padding: 20px;display: inline-block;width: 100%; border-bottom: 1px solid #eaefe9;
        padding-bottom: 20px; }
    .checkout-cart-merchant-name{color: #30322f; float: left;}
    .checkout-cart-merchant-item{ float: right; color: #30322f; }
    .checkout-cart-products{}

    .checkout-cart-products .checkout-charges{ padding: 10px 20px;
        color: #333;}
    .checkout-cart-item{ border-bottom: 1px solid #eaefe9;
        box-sizing: border-box;
        display: table;
        font-size: 12px;
        padding: 22px 20px;
        width: 100%;}
    .checkout-item-list{}
    .checkout-item-count{ float: left; }
    .checkout-item-img{width: 60px; float: left;}
    .checkout-item-name-box{ float: left; }
    .checkout-item-title{ color: #30322f; font-size: 14px;  }
    .checkout-item-unit{  }
    .checkout-item-price{float: right;color: #30322f; font-size: 14px; font-weight: 600;}


    .checkout-viewmore-btn{padding: 10px; text-align: center;}

    .header-checkout-item{text-align: right; padding-top: 20px;}
    .checkout-promise-item {
        background-repeat: no-repeat;
        background-size: 14px;
        display: inline-block;
        margin-left: 20px;
        padding-left: 24px;
        color: #30322f;
    }
    .checkout-promise-item i{padding-right: 10px;color: #43b02a;}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            echo form_open_multipart('', array('class' => 'form-horizontal'));
            ?>
            <div id="accordion" class="checkout">
                <div class="panel checkout-step">
                    <div role="tab" id="headingTwo"> <span class="checkout-step-number">1</span>
                        <h4 class="checkout-step-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" > Tiếng Việt </a> </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="checkout-step-body">
                            <div class="row">
                                <div class="form-group">
                                    <?php
                                    echo form_label('Tiêu đề', 'title_vi');
                                    echo form_error('title_vi');
                                    echo form_input('title_vi', set_value('title_vi', $type['title_vi']), 'class="form-control"');
                                    ?>
                                </div>
                                <a class="collapsed btn btn-default" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Next</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel checkout-step">
                    <div role="tab" id="headingThree"> <span class="checkout-step-number">2</span>
                        <h4 class="checkout-step-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" > English </a> </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse">
                        <div class="checkout-step-body">
                            <div class="row">
                                <div class="form-group">
                                    <?php
                                    echo form_label('Title', 'title_en');
                                    echo form_error('title_en');
                                    echo form_input('title_en', set_value('title_en', $type['title_en']), 'class="form-control"');
                                    ?>
                                </div>
                                <a class="collapsed btn btn-default" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="form-group col-sm-12 text-right fix-bottom">
                <?php
                echo form_submit('submit', 'OK', 'class="btn btn-primary"');
                echo form_close();
                ?>
                <a class="btn btn-default btn-sm cancel" href="javascript:window.history.go(-1);">Back</a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo site_url('tinymce/tinymce.min.js'); ?>"></script>
<script>
    tinymce.init({
        selector: ".blog-content",
        theme: "modern",
        height: 200,
        relative_urls: false,
        remove_script_host: false,
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor responsivefilemanager"
        ],
        content_css: "css/content.css",
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | responsivefilemanager | print preview media fullpage | forecolor backcolor emoticons",
        style_formats: [
            {title: "Bold text", inline: "b"},
            {title: "Red text", inline: "span", styles: {color: "#ff0000"}},
            {title: "Red header", block: "h1", styles: {color: "#ff0000"}},
            {title: "Example 1", inline: "span", classes: "example1"},
            {title: "Example 2", inline: "span", classes: "example2"},
            {title: "Table styles"},
            {title: "Table row 1", selector: "tr", classes: "tablerow1"}
        ],
        external_filemanager_path: "<?php echo site_url('filemanager/'); ?>",
        filemanager_title: "Responsive Filemanager",
        external_plugins: {"filemanager": "<?php echo site_url('filemanager/plugin.min.js'); ?>"}
    });
</script>