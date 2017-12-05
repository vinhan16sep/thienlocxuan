<section class="content history container">
    <div class="page_list">
        <ul>
            <li><a href="<?php echo site_url('introduce/history'); ?>"><?php echo $this->lang->line('history'); ?></a></li>
            <li><a href="<?php echo site_url('introduce/duty'); ?>"><?php echo $this->lang->line('duty'); ?></a></li>
            <li><a href="<?php echo site_url('introduce/structure'); ?>"><?php echo $this->lang->line('structure'); ?></a></li>
            <li><a href="<?php echo site_url('introduce/culture'); ?>"><?php echo $this->lang->line('culture'); ?></a></li>
        </ul>
    </div>
    <section class="cover">
        <img src="<?php echo base_url('assets/public/img/slide/slide_1.jpg'); ?>">
    </section>

    <div class="history_list container">
        <div class="content_title">
            <?php echo $this->lang->line('history_title'); ?>
            <br>
            <div class="line"></div>
        </div>
        <div class="history_line"></div>
        
        <section id="cd-timeline" class="cd-container">
            <?php if($histories): ?>
            <?php foreach($histories as $history): ?>
            <div class="cd-timeline-block">
                <div class="cd-timeline-img"></div> <!-- cd-timeline-img -->
                
                <div class="cd-timeline-content">
                    <p><?php echo $history['content']; ?></p>
                    <span class="cd-date"><?php echo $history['year']; ?></span>
                </div> <!-- cd-timeline-content -->
                
            </div> <!-- cd-timeline-block -->
            <?php endforeach; ?>
            <?php endif; ?>
        </section> <!-- cd-timeline -->
        
    </div>
</section>

<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/public/css/history.css'); ?>">
<script src="<?php echo base_url('assets/public/js/timeline.js'); ?>"></script>
