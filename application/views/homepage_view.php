<section class="main_content">
    <div id="slide_top" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <?php if(!empty($banners)): ?>
                <?php foreach($banners as $key => $item): ?>
                    <li data-target="#slide_top" data-slide-to="<?php echo $key; ?>" class="<?php echo ($key == 0) ? 'active' : ''; ?>"></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <?php if($banners): ?>
            <?php foreach($banners as $key => $item): ?>
            <div class="item <?php echo ($key == 0) ? 'active' : ''; ?>">
                <a href="<?php echo $item['url']; ?>"><img src="<?php echo base_url('assets/upload/banner/' . $item['image']); ?>" alt="..."></a>
                <div class="carousel-caption">
                    <h3></p><?php echo $item['text']; ?></h3>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#slide_top" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#slide_top" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</section>

<section class="content index_about container">
    <div class="content_title">
        <?php echo $this->lang->line('index_about'); ?>
        <br>
        <div class="line"></div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3 class="brand_color post_title">Tên của sản phẩm</h3>
            <p class="post_subtitle">Giới thiệu về sản phẩm</p>
            <p class="paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras in nulla pulvinar, ultrices nulla sed, mattis felis. Proin turpis lorem, tincidunt a tincidunt aliquet, scelerisque et lectus. Morbi interdum nisl dolor, id cursus leo laoreet ut. Phasellus arcu quam, varius a maximus quis, sodales vitae eros. Pellentesque tincidunt massa ut elementum auctor. Aenean odio quam, feugiat vitae fringilla vitae, mattis sit amet orci. Mauris tempor purus odio, id pulvinar elit condimentum quis.</p>
            <p class="paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras in nulla pulvinar, ultrices nulla sed, mattis felis. Proin turpis lorem, tincidunt a tincidunt aliquet, scelerisque et lectus. Morbi interdum nisl dolor, id cursus leo laoreet ut. Phasellus arcu quam, varius a maximus quis, sodales vitae eros. Pellentesque tincidunt massa ut elementum auctor. Aenean odio quam, feugiat vitae fringilla vitae, mattis sit amet orci. Mauris tempor purus odio, id pulvinar elit condimentum quis.</p>

            <a class="btn btn-default hvr-sweep-to-right" role="button" href="<?php echo site_url('introduce/history'); ?>">
                <?php echo $this->lang->line('readmore'); ?> <i class="fa fa-angle-double-right"></i>
            </a>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <img src="<?php echo base_url('assets/public/img/about.jpg'); ?>" alt="">
        </div>
    </div>
    <div class="row quick_intro">
        <div class="item col-lg-3 col-md-3 col-sm-3 col-xs-6">
            <i class="fa fa-heart fa-3x brand_color"></i>
            <h4><?php echo $this->lang->line('index_about_1'); ?></h4>
        </div>
        <div class="item col-lg-3 col-md-3 col-sm-3 col-xs-6">
            <i class="fa fa-thumbs-up fa-3x brand_color"></i>
            <h4><?php echo $this->lang->line('index_about_2'); ?></h4>
        </div>
        <div class="item col-lg-3 col-md-3 col-sm-3 col-xs-6">
            <i class="fa fa-check-square-o fa-3x brand_color"></i>
            <h4><?php echo $this->lang->line('index_about_3'); ?></h4>
        </div>
        <div class="item col-lg-3 col-md-3 col-sm-3 col-xs-6">
            <i class="fa fa-user fa-3x brand_color"></i>
            <h4><?php echo $this->lang->line('index_about_4'); ?></h4>
        </div>
    </div>
</section>

<section class="index_product container">
    <div class="content_title">
        Sản phẩm thuốc nổi bật
        <br>
        <div class="line"></div>
    </div>
    <div id="slide_physic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators hidden-xs">
            <?php if($specials[1]): ?>
                <?php for($i = 0; $i < count($specials[1]); $i++){ ?>
                    <li data-target="#slide_physic" data-slide-to="<?php echo $i; ?>" <?php echo ($i == 0) ? 'class="active"' : ''; ?>></li>
                <?php } ?>
            <?php endif; ?>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <?php if($specials[1]): ?>
                <?php foreach($specials[1] as $key => $physic): ?>
                    <div class="item <?php echo ($key == 0) ? 'active col-lg-12' : ''; ?>">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <img src="<?php echo base_url('assets/upload/physic/' . $physic['data']['description_image']); ?>">
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <h3 class="brand_color post_title"><?php echo $physic['data']['physic_title']; ?></h3>
                                <p class="post_subtitle">Giới thiệu về sản phẩm</p>
                                <p class="paragraph"><?php echo substr($physic['data']['physic_content'], 0, 150); ?></p>

                                <a class="brand_color" href="<?php echo site_url('physic/detail/' . $physic['id']); ?>">
                                    <h4>Xem thêm <i class="fa fa-angle-double-right"></i></h4>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<section class="index_product container">
    <div class="content_title">
        Thực phẩm chức năng nổi bật
        <br>
        <div class="line"></div>
    </div>
    <div id="slide_product" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators hidden-xs">
            <?php if($specials[0]): ?>
            <?php for($i = 0; $i < count($specials[0]); $i++){ ?>
                <li data-target="#slide_product" data-slide-to="<?php echo $i; ?>" <?php echo ($i == 0) ? 'class="active"' : ''; ?>></li>
            <?php } ?>
            <?php endif; ?>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <?php if($specials[0]): ?>
            <?php foreach($specials[0] as $key => $product): ?>
            <div class="item <?php echo ($key == 0) ? 'active col-lg-12' : ''; ?>">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <img src="<?php echo base_url('assets/upload/product/' . $product['data']['description_image']); ?>">
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <h3 class="brand_color post_title"><?php echo $product['data']['product_title']; ?></h3>
                        <p class="post_subtitle">Giới thiệu về sản phẩm</p>
                        <p class="paragraph"><?php echo substr($product['data']['product_content'], 0, 150); ?></p>

                        <a class="brand_color" href="<?php echo site_url('product/detail/' . $product['id']); ?>">
                            <h4>Xem thêm <i class="fa fa-angle-double-right"></i></h4>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!--<section class="content index_break container-fluid">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 hidden-xs content_left">
            <img src="<?php echo base_url('assets/public/img/about.jpg'); ?>">
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 content_right">
            <div class="content_title">
                Giới thiệu nhanh về công ty
                <br>
                <div class="line"></div>
            </div>
            <div class="col-lg-6">
                <h3 class="brand_color post_title">Tên của sản phẩm</h3>
                <p class="post_subtitle">Giới thiệu về sản phẩm</p>
                <p class="paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras in nulla pulvinar, ultrices nulla sed, mattis felis. Proin turpis lorem, tincidunt a tincidunt aliquet, scelerisque et lectus. Morbi interdum nisl dolor, id cursus leo laoreet ut. Phasellus arcu quam, varius a maximus quis, sodales vitae eros. Pellentesque tincidunt massa ut elementum auctor. Aenean odio quam, feugiat vitae fringilla vitae, mattis sit amet orci. Mauris tempor purus odio, id pulvinar elit condimentum quis.</p>
            </div>
            <div class="col-lg-6">
                <h3 class="brand_color post_title">Tên của sản phẩm</h3>
                <p class="post_subtitle">Giới thiệu về sản phẩm</p>
                <p class="paragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras in nulla pulvinar, ultrices nulla sed, mattis felis. Proin turpis lorem, tincidunt a tincidunt aliquet, scelerisque et lectus. Morbi interdum nisl dolor, id cursus leo laoreet ut. Phasellus arcu quam, varius a maximus quis, sodales vitae eros. Pellentesque tincidunt massa ut elementum auctor. Aenean odio quam, feugiat vitae fringilla vitae, mattis sit amet orci. Mauris tempor purus odio, id pulvinar elit condimentum quis.</p>
            </div>
        </div>
    </div>
</section>-->

<section class="content index_news container">
    <div class="content_title">
        <?php echo $this->lang->line('index_news'); ?>
        <br>
        <div class="line"></div>
    </div>

    <div class="row">
        <div class="hot_news col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <img src="<?php echo base_url('assets/upload/blog/' . $blogs[0]['description_image']); ?>" alt="">
            <h3 class="brand_color post_title"><?php echo $blogs[0]['title']; ?></h3>
            <p class="post_date">
                <i class="fa fa-calendar-o"></i>
                <?php echo $blogs[0]['created_at']; ?>
            </p>
            <p class="paragraph"><?php echo substr($blogs[0]['description'], 0, 100); ?>...</p>
            <a class="btn btn-default hvr-sweep-to-right" href="<?php echo base_url('blog/detail/' . $blogs[0]['type'] . '/' . $blogs[0]['blog_id']); ?>" role="button">
                <?php echo $this->lang->line('readmore'); ?> <i class="fa fa-angle-double-right"></i>
            </a>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div id="slide_news" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <?php if($blogs && count($blogs) > 3): ?>
                <ol class="carousel-indicators hidden-xs">
                    <li data-target="#slide_news" data-slide-to="0" class="active"></li>
                    <?php if($blogs && count($blogs) > 3): ?>
                    <li data-target="#slide_news" data-slide-to="1"></li>
                    <?php endif; ?>
                </ol>
                <?php endif; ?>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <?php if($blogs && count($blogs) > 1): ?>
                    <div class="item active">
                        <?php foreach($blogs as $key => $item): ?>
                        <?php if($key > 0 && $key < 4): ?>
                        <div class="news_related row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <img src="<?php echo base_url('assets/upload/blog/' . $item['description_image']); ?>" alt="...">
                            </div>

                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <h3 class="brand_color post_title"><?php echo $item['title']; ?></h3>
                                <p class="post_date">
                                    <i class="fa fa-calendar-o"></i>
                                    <?php echo $item['created_at']; ?>
                                </p>
                                <p class="paragraph"><?php echo substr($item['description'], 0, 50); ?>...</p>

                                <a class="btn btn-default hvr-sweep-to-right" href="<?php echo base_url('blog/detail/' . $item['type'] . '/' . $item['blog_id']); ?>" role="button">
                                    <?php echo $this->lang->line('readmore'); ?> <i class="fa fa-angle-double-right"></i>
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <?php if($blogs && count($blogs) > 4): ?>
                    <div class="item">
                        <?php foreach($blogs as $key => $item): ?>
                            <?php if($key > 3 && $key < 7): ?>
                                <div class="news_related row">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <img src="<?php echo base_url('assets/upload/blog/' . $item['description_image']); ?>" alt="...">
                                    </div>

                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                        <h3 class="brand_color post_title"><?php echo $item['title']; ?></h3>
                                        <p class="post_date">
                                            <i class="fa fa-calendar-o"></i>
                                            <?php echo $item['created_at']; ?>
                                        </p>
                                        <p class="paragraph"><?php echo substr($item['description'], 0, 50); ?>...</p>

                                        <a class="btn btn-default hvr-sweep-to-right" href="<?php echo base_url('blog/detail/' . $item['type'] . '/' . $item['blog_id']); ?>" role="button">
                                            <?php echo $this->lang->line('readmore'); ?> <i class="fa fa-angle-double-right"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>


            </div>
        </div>
    </div>

</section>