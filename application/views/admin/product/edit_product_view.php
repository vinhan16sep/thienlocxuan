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
    .form-horizontal .form-group{
        margin-left: 0;
        margin-right: 0;
    }
</style>
<div class="container">
    <?php
    echo form_open_multipart('', array('class' => 'form-horizontal'));
    ?>
    <div class="row">
        <div class="col-md-12">
            <span class="checkout-step-number">1</span>
            <h4 class="checkout-step-title">Basic Info</h4>
            <div class="form-group">
                <?php
                echo form_label('Loại sản phẩm / Type', 'product_type');
                echo form_error('product_type');
                echo form_dropdown('product_type', $types, set_value('product_type', $product['type_id']), 'class="form-control"');
                ?>
            </div>
            <div class="form-group" >
                <?php
                echo form_label('Nhóm sản phẩm / Groups', 'product_group');
                echo form_error('product_group');
                echo form_dropdown('product_group', $groups, set_value('product_group', $product['group_id']), 'class="form-control"');
                ?>
            </div>
            <div class="form-group picture">
                <?php
                echo form_label('Ảnh đại diện / Picture (600 x 470px)', 'picture');
                echo form_error('picture');
                echo form_upload('picture', set_value('picture'), 'class="form-control"');
                ?>
            </div>
            <div class="form-group" >
                <label>Sản phẩm đặc biệt</label>
                <div class="checkbox">
                    <label>
                        <?php
                        //echo form_label('Sản phẩm đặc biệt', 'is_special');
                        echo form_error('is_special');
                        echo form_checkbox('is_special', 1, $product['is_special'] == 1 ? true : false, 'id="is_special"') . 'Sản phẩm đưa lên trang chủ';
                        ?>
                    </label>
                </div>

            </div>
        </div>

        <div class="col-md-6">
            <div role="tab" id="headingThree"> <span class="checkout-step-number">2</span>
                <h4 class="checkout-step-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" > Tiếng Việt </a> </h4>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Tiêu đề', 'title_vi');
                echo form_error('title_vi');
                echo form_input('title_vi', set_value('title_vi', $product['title_vi']), 'class="form-control"');
                ?>
            </div>
            <!--<div class="form-group description">
                <?php
                echo form_label('Tóm tắt', 'description_vi');
                echo form_error('description_vi');
                echo form_textarea('description_vi', set_value('description_vi', $product['description_vi']), 'class="form-control"');
                ?>
            </div>-->
            <div class="form-group">
                <?php
                echo form_label('Nội dung', 'content_vi');
                echo form_error('content_vi');
                echo form_textarea('content_vi', set_value('content_vi', $product['content_vi'], false), 'class="form-control product-content"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Câu hỏi thường gặp', 'faq_vi');
                echo form_error('faq_vi');
                echo form_textarea('faq_vi', set_value('faq_vi', $product['faq_vi'], false), 'class="form-control product-content"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Thành phần', 'ingredients_vi');
                echo form_error('ingredients_vi');
                echo form_textarea('ingredients_vi', set_value('ingredients_vi', $product['ingredients_vi'], false), 'class="form-control product-content"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Chỉ định', 'attribution_vi');
                echo form_error('attribution_vi');
                echo form_textarea('attribution_vi', set_value('attribution_vi', $product['attribution_vi'], false), 'class="form-control product-content"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Liều dùng', 'dosage_vi');
                echo form_error('dosage_vi');
                echo form_textarea('dosage_vi', set_value('dosage_vi', $product['dosage_vi']), 'class="form-control" id="inputDosage" rows="3"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Chống chỉ định', 'contraindicating_vi');
                echo form_error('contraindicating_vi');
                echo form_textarea('contraindicating_vi', set_value('contraindicating_vi', $product['contraindicating_vi']), 'class="form-control" id="inputContraindicating" rows="3"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Hạn sử dụng', 'expired_vi');
                echo form_error('expired_vi');
                echo form_textarea('expired_vi', set_value('expired_vi', $product['expired_vi']), 'class="form-control" id="inputExpiredDay" rows="3"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Chứng nhận', 'certification_vi');
                echo form_error('certification_vi');
                echo form_textarea('certification_vi', set_value('certification_vi', $product['certification_vi']), 'class="form-control" id="inputCertification" rows="3"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Quy cách đóng gói', 'presentation_vi');
                echo form_error('presentation_vi');
                echo form_textarea('presentation_vi', set_value('presentation_vi', $product['presentation_vi']), 'class="form-control" id="inputPresentation" rows="3"');
                ?>
            </div>
        </div>
        <div class="col-md-6">
            <div role="tab" id="headingThree"> <span class="checkout-step-number">3</span>
                <h4 class="checkout-step-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" > English </a> </h4>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Title', 'title_en');
                echo form_error('title_en');
                echo form_input('title_en', set_value('title_en', $product['title_en']), 'class="form-control"');
                ?>
            </div>
            <!--<div class="form-group description">
                <?php
                echo form_label('Description', 'description_en');
                echo form_error('description_en');
                echo form_textarea('description_en', set_value('description_en', $product['description_en']), 'class="form-control"');
                ?>
            </div>-->
            <div class="form-group">
                <?php
                echo form_label('Content', 'content_en');
                echo form_error('content_en');
                echo form_textarea('content_en', set_value('content_en', $product['content_en'], false), 'class="form-control product-content"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('FAQ', 'faq_en');
                echo form_error('faq_en');
                echo form_textarea('faq_en', set_value('faq_en', $product['faq_en'], false), 'class="form-control product-content"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Thành phần', 'ingredients_en');
                echo form_error('ingredients_en');
                echo form_textarea('ingredients_en', set_value('ingredients_en', $product['ingredients_en'], false), 'class="form-control product-content"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Chỉ định', 'attribution_en');
                echo form_error('attribution_en');
                echo form_textarea('attribution_en', set_value('attribution_en', $product['attribution_en'], false), 'class="form-control product-content"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Liều dùng', 'dosage_en');
                echo form_error('dosage_en');
                echo form_textarea('dosage_en', set_value('dosage_en', $product['dosage_en']), 'class="form-control" id="inputDosage" rows="3"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Chống chỉ định', 'contraindicating_en');
                echo form_error('contraindicating_en');
                echo form_textarea('contraindicating_en', set_value('contraindicating_en', $product['contraindicating_en']), 'class="form-control" id="inputContraindicating" rows="3"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Hạn sử dụng', 'expired_en');
                echo form_error('expired_en');
                echo form_textarea('expired_en', set_value('expired_en', $product['expired_en']), 'class="form-control" id="inputExpiredDay" rows="3"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Chứng nhận', 'certification_en');
                echo form_error('certification_en');
                echo form_textarea('certification_en', set_value('certification_en', $product['certification_en']), 'class="form-control" id="inputCertification" rows="3"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Quy cách đóng gói', 'presentation_en');
                echo form_error('presentation_en');
                echo form_textarea('presentation_en', set_value('presentation_en', $product['presentation_en']), 'class="form-control" id="inputPresentation" rows="3"');
                ?>
            </div>
        </div>

        <div class="form-group col-sm-12 text-right fix-bottom">
            <?php
                echo form_submit('submit', 'OK', 'class="btn btn-primary"');
                echo form_close();
                ?>
                <a class="btn btn-default btn-sm cancel" href="javascript:window.history.go(-1);">Back</a>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript" src="<?php echo site_url('tinymce/tinymce.min.js'); ?>"></script>
<script>
    tinymce.init({
        selector: ".product-content",
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