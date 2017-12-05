<!--<section class="cover">-->
<!--    <img src="<?php echo base_url('assets/public/img/slide/slide_1.jpg'); ?>">-->
<!--</section>-->

<section class="content news container test2">
    <div class="content_title page_list">
        <ul>
            <li><a href="<?php echo site_url('blog/list_information'); ?>"><?php echo $this->lang->line('blog_information'); ?></a></li>
            <li><a href="<?php echo site_url('blog/list_medicine'); ?>"><?php echo $this->lang->line('blog_medicine'); ?></a></li>
        </ul>
        <div class="line"></div>
    </div>

    <div class="news_post col-lg-9 col-xs-12">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="item">
                <img src="<?php echo empty($blog['description_image']) ? base_url('assets/public/img/no-intro-image.jpg') : base_url('assets/upload/blog/' . $blog['description_image']); ?>" alt="">
                <h3 class="brand_color post_title"><?php echo $blog['blog_title']; ?></h3>
                <p class="post_date">
                    <i class="fa fa-calendar-o"></i>
                    <?php echo $blog['created_at']; ?>
                </p>
                <p class="paragraph">
                    <?php echo $blog['blog_content']; ?>
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

            <?php if($latest_articles): ?>
                <?php foreach($latest_articles as $key => $item): ?>
                    <div class="item">
                        <div class="row">
                            <div class="col-lg-12">
                                <img src="<?php echo empty($item['description_image']) ? base_url('assets/public/img/no-intro-image.jpg') : base_url('assets/upload/blog/' . $item['description_image']); ?>" alt="">
                            </div>
                            <div class="col-lg-12">
                                <h3 class="post_title">
                                    <a class="brand_color" href="<?php echo base_url('blog/detail/' . $item['type'] . '/' . $item['blog_id']); ?>">
                                        <?php echo $item['title']; ?>
                                    </a>
                                </h3>
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

        <div class="news_side_item" id="news_side_2">
            <div class="side_title">
                <?php echo $this->lang->line('blog_most_viewed'); ?>
                <br>
                <div class="line"></div>
            </div>
            <?php if($most_viewed): ?>
                <?php foreach($most_viewed as $item): ?>
                    <div class="item">
                        <div class="row">
                            <div class="col-lg-12">
                                <img src="<?php echo empty($item['description_image']) ? base_url('assets/public/img/no-intro-image.jpg') : base_url('assets/upload/blog/' . $item['description_image']); ?>" alt="">
                            </div>
                            <div class="col-lg-12">
                                <h3 class="post_title">
                                    <a class="brand_color" href="<?php echo base_url('blog/detail/' . $item['type'] . '/' . $item['blog_id']); ?>">
                                        <?php echo $item['title']; ?>
                                    </a>
                                </h3>
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