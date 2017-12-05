<section class="content drug container">
    <div class="page_list">
        <ul>
            <li><a href="<?php echo site_url('medicine'); ?>"><?php echo $this->lang->line('medicine'); ?></a></li>
            <li><a href="<?php echo site_url('product'); ?>"><?php echo $this->lang->line('list_product'); ?></a></li>
            <li><a href="<?php echo site_url('quotation'); ?>"><?php echo $this->lang->line('quotation'); ?></a></li>
            <li><a href="<?php echo site_url('partner'); ?>"><?php echo $this->lang->line('partner'); ?></a></li>
        </ul>
    </div>
    <div class="culture_content">
        <div class="content_title">
            <?php echo $this->lang->line('partner'); ?>
            <br>
            <div class="line"></div>
        </div>
        <?php if($partners): ?>
        <?php foreach($partners as $item): ?>
        <div class="row">
            <div class="drug_item col-lg-6 col-md-6 col-sm-6 col-xs-12 wow fadeInLeft">
                <img src="<?php echo base_url('assets/upload/partner/' . $item['image']); ?>">
            </div>
            <div class="drug_content col-lg-6 col-md-6 col-sm-6 col-xs-12 wow fadeInUp">
                <h1 class="brand_color post_title"><?php echo $item['name'] ?></h1>
                <p><?php echo substr($item['description'], 0, 200); ?> ...</p>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>
