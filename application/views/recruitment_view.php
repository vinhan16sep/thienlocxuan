<section class="cover">
    <img src="<?php echo base_url('assets/upload/cover/' . $cover['image']); ?>">
</section>

<section class="content recruitment container">
    <div class="recruiment_post container">
        <?php if($recruitments): ?>
            <?php foreach($recruitments as $recruitment): ?>
                <div class="recuitment_item col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="recuitment_inner">
                        <img src="<?php echo empty($recruitment['description_image']) ? base_url('assets/public/img/no-intro-image.jpg') : base_url('assets/upload/recruitment/' . $recruitment['description_image']); ?>">
                        <h3><?php echo $recruitment['title']; ?></h3>
                        <p><?php echo ($recruitment['status'][0] == 0) ? $this->lang->line('recruitment_expired') : $this->lang->line('recruitment_recruiting'); ?></p>
                        <a class="btn btn-default hvr-sweep-to-right" href="<?php echo site_url('recruitment/detail/' . $recruitment['recruitment_id']); ?>" role="button">
                            <?php echo $this->lang->line('recruitment_readmore') ?> <i class="fa fa-angle-double-right"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</section>