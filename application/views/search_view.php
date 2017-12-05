<section class="content vision container">
    <div class="content_title">
        <?php echo $this->lang->line('searchResult'); ?>
        <br>
        <div class="line"></div>
    </div>
    
    <?php if($result['physics']): ?>
    <?php foreach($result['physics'] as $key => $value): ?>
        <div class="searchItem col-md-12 col-sm-12 col-xs-12">
            <a class="brand_color" href="<?php echo site_url('physic/detail/' . $value['physic_id']); ?>">
                <h4><?php echo $value['title']; ?></h4>
            </a>
            <p class="paragraph"><?php echo substr($value['description'], 0, 200); ?></p>
        </div>
    <?php endforeach; ?>
    <?php endif; ?>

    <?php if($result['products']): ?>
        <?php foreach($result['products'] as $key => $value): ?>
            <div class="searchItem col-md-12 col-sm-12 col-xs-12">
                <a class="brand_color" href="<?php echo site_url('product/detail/' . $value['product_id']); ?>">
                    <h4><?php echo $value['title']; ?></h4>
                </a>
                <p class="paragraph"><?php echo substr($value['description'], 0, 200); ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if($result['blogs']): ?>
        <?php foreach($result['blogs'] as $key => $value): ?>
            <div class="searchItem col-md-12 col-sm-12 col-xs-12">
                <a class="brand_color" href="<?php echo site_url('blog/detail/' . $value['type'] . '/' . $value['blog_id']); ?>">
                    <h4><?php echo $value['title']; ?></h4>
                </a>
                <p class="paragraph"><?php echo substr($value['description'], 0, 200); ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>