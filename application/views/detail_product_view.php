<section class="content drug container">

    <div class="drug_post">
        <div class="drug_post_content row">
            <div class="drug_list_item col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <?php if(!empty($product['description_image'])): ?>
                <img src="<?php echo base_url('assets/upload/product/' . $product['description_image']); ?>">
                <?php else: ?>
                <img src="<?php echo base_url('assets/public/img/no-intro-image.jpg'); ?>">
                <?php endif; ?>
            </div>
            <div class="drug_list_item col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h2 class="brand_color post_title"><?php echo $product['product_title']; ?></h2>
                <p><?php echo $product['group_name']; ?></p>
            </div>

        </div>
        <div>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#drug_info" aria-controls="home" role="tab" data-toggle="tab"><?php echo $this->lang->line('product_information'); ?></a></li>
                <li role="presentation"><a href="#drug_faq" aria-controls="profile" role="tab" data-toggle="tab"><?php echo $this->lang->line('product_faq'); ?></a></li>
                <li role="presentation"><a href="#drug_askus" aria-controls="messages" role="tab" data-toggle="tab"><?php echo $this->lang->line('product_question'); ?></a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="drug_info">
                    <table class="table">
                        <tr>
                            <td>
                                <h3 class="post_title"><?php echo $this->lang->line('product_content'); ?></h3>

                                <!--<?php echo $product['product_content']; ?>-->
                                <?php echo $product['product_presentation']; ?>
    							<p class="post_subtitle"><?php echo $this->lang->line('product_ingredients'); ?></p>
    
    							<?php echo $product['product_ingredients']; ?>
    							
    							<p class="post_subtitle"><?php echo $this->lang->line('product_attribution'); ?></p>
    
    							<?php echo $product['product_attribution']; ?>
    							
    							<p class="post_subtitle"><?php echo $this->lang->line('product_dosage'); ?></p>
    							<?php echo $product['product_dosage']; ?>
    							
    							<p class="post_subtitle"><?php echo $this->lang->line('product_contraindicating'); ?></p>
    
    							<?php echo $product['product_contraindicating']; ?>
    							
    							<p class="post_subtitle"><?php echo $this->lang->line('product_expired'); ?>: <?php echo $product['product_expired']; ?></p>
    							<p class="post_subtitle"><?php echo $this->lang->line('product_certification'); ?>: <?php echo $product['product_certification']; ?></p>
    							<!--<p class="post_subtitle">Giá bán: 100.000 VNĐ/ hộp</p>-->
                            </td>
                        </tr>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane" id="drug_faq">
                    <?php echo $product['product_faq']; ?>
                </div>
                <div role="tabpanel" class="tab-pane" id="drug_askus">
                    <p><?php echo $this->lang->line('contact_greeting'); ?></p>
                    <table class="table">
                        <tr>
                            <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="inputName"><?php echo $this->lang->line('contact_name'); ?> (*)</label>
                                <input type="text" class="form-control" id="inputName" placeholder="<?php echo $this->lang->line('contact_name'); ?> ...">
                            </td>
                            <td class="col-lg-8 col-md-8 col-sm-8 col-xs-12" rowspan="3">
                                <label for="inputName"><?php echo $this->lang->line('contact_content'); ?>(*)</label>
                                <textarea class="form-control" id="inputQuestion" placeholder="<?php echo $this->lang->line('contact_content_placeholder'); ?>" rows="6" ></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="inputName"><?php echo $this->lang->line('contact_email'); ?> (*)</label>
                                <input type="text" class="form-control" id="inputEmail" placeholder="<?php echo $this->lang->line('contact_email'); ?> ...">
                            </td>
                        </tr>
                        <tr>
                            <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="inputName"><?php echo $this->lang->line('contact_phone'); ?> (*)</label>
                                <input type="text" class="form-control" id="inputPhoneNumber" placeholder="<?php echo $this->lang->line('contact_phone'); ?> ...">
                            </td>
                        </tr>
                        <tr>
                            <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="inputName"><?php echo $this->lang->line('contact_wishing'); ?> (*)</label>
                                <input type="text" class="form-control" id="inputProduct" placeholder="<?php echo $this->lang->line('contact_wishing'); ?> ...">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button class="btn btn-default hvr-sweep-to-right" type="submit">
                                    <?php echo $this->lang->line('contact_send'); ?>
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>

</section>