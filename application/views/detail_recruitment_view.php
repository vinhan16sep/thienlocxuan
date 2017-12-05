<section class="cover">
    <img src="<?php echo base_url('assets/public/img/slide/slide_1.jpg'); ?>">
</section>

<section class="content news container">
    <div class="news_post col-lg-9 col-xs-12">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="item">
                <img src="<?php echo empty($recruitment['description_image']) ? base_url('assets/public/img/no-intro-image.jpg') : base_url('assets/upload/recruitment/' . $recruitment['description_image']); ?>" alt="">
                <h3 class="brand_color post_title"><?php echo $recruitment['recruitment_title']; ?></h3>
                <p class="post_date">
                    <i class="fa fa-calendar-o"></i>
                    <?php echo $recruitment['created_at']; ?>
                </p>
                <p class="paragraph">
                    <?php echo $recruitment['recruitment_content']; ?>
                </p>
            </div>
        </div>
    </div>
    <div class="news_side col-lg-3 col-xs-12">
        <div class="news_side_item" id="news_side_1">
            <div class="side_title">
                <?php echo $this->lang->line('blog_latest_articles'); ?>
                <br>
                <div class="line"></div>
            </div>

            <?php if($latest_recruitment): ?>
                <?php foreach($latest_recruitment as $key => $item): ?>
                    <div class="item">
                        <div class="row">
                            <div class="col-lg-12">
                                <img src="<?php echo empty($item['description_image']) ? base_url('assets/public/img/no-intro-image.jpg') : base_url('assets/upload/recruitment/' . $item['description_image']); ?>" alt="">
                            </div>
                            <div class="col-lg-12">
                                <h3 class="brand_color post_title"><?php echo $item['title']; ?></h3>
                                <p class="post_date">
                                    <i class="fa fa-calendar-o"></i>
                                    <?php echo $item['created_at']; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

</section>