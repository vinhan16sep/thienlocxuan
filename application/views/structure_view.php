<section class="content structure container">
        <div class="page_list">
            <ul>
                <li><a href="<?php echo site_url('introduce/history'); ?>"><?php echo $this->lang->line('history'); ?></a></li>
                <li><a href="<?php echo site_url('introduce/duty'); ?>"><?php echo $this->lang->line('duty'); ?></a></li>
                <li><a href="<?php echo site_url('introduce/structure'); ?>"><?php echo $this->lang->line('structure'); ?></a></li>
                <li><a href="<?php echo site_url('introduce/culture'); ?>"><?php echo $this->lang->line('culture'); ?></a></li>
            </ul>

        </div>

        <div class="structure_cover">
            <img src="<?php echo base_url('assets/public/img/slide/slide_2.jpg'); ?>">
        </div>
        <div class="structure_content">
            <div class="content_title">
                Cơ cấu tổ chức
                <br>
                <div class="line"></div>
            </div>
            
            <?php
                $type = array(
                    0 => 'Giám đốc',
                    1 => 'Phó Giám đốc',
                    2 => 'Nhân viên'
                );
            ?>
            
            <div class="member">
                <?php if(!empty($director)): ?>
                <div class="row">
                    <div class="item col-lg-3 col-md-3 col-sm-3 col-xs-4">
                        <?php
                            echo '<img src="' . site_url('assets/upload/member/' . $director['image']) . '">';
                            echo '<h3>' . $director['name'] . '</h3>';
                            echo '<h5>' . $type[$director['role']] . '</h5>';
                        ?>
                    </div>    
                </div>
                <?php endif; ?>
                <?php if(!empty($vice_director)): ?>
                <div class="row">
                    <?php foreach($vice_director as $vice_director): ?>
                    <div class="item col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <?php
                            echo '<img src="' . site_url('assets/upload/member/' . $vice_director['image']) . '">';
                            echo '<h3>' . $vice_director['name'] . '</h3>';
                            echo '<h5>' . $type[$vice_director['role']] . '</h5>';
                        ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <?php if(!empty($members)): ?>
                <div class="row">
                    <?php foreach($members as $member): ?>
                    <div class="item col-lg-2 col-md-2 col-sm-2 col-xs-3">
                        <?php
                            echo '<img src="' . site_url('assets/upload/member/' . $member['image']) . '">';
                            echo '<h3>' . $member['name'] . '</h3>';
                            echo '<h5>' . $type[$member['role']] . '</h5>';
                        ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            
        </div>

    </section>