<section class="content drug container test">
    <div class="page_list">
        <ul>
            <li><a href="<?php echo site_url('physic'); ?>"><?php echo $this->lang->line('medicine'); ?></a></li>
            <li><a href="<?php echo site_url('product'); ?>"><?php echo $this->lang->line('list_product'); ?></a></li>
            <li><a href="<?php echo site_url('quotation'); ?>"><?php echo $this->lang->line('quotation'); ?></a></li>
            <li><a href="<?php echo site_url('partner'); ?>"><?php echo $this->lang->line('partner'); ?></a></li>
        </ul>
    </div>
    
    <div class="drug_list_content">
        <div class="content_title">
            <?php echo $this->lang->line('medicine'); ?>
            <br>
            <div class="line"></div>
        </div>
        <div class="drug_choice">
            <div class="drug_choice-left col-lg-3 col-md-3 col-sm-4 col-xs-12">
                <select class="form-control" id="drug-type">
                    <option value="0" selected="selected"><?php echo $this->lang->line('product_type'); ?></option>
                    <?php foreach($types as $type): ?>
                        <option value="<?php echo $type['type_id']; ?>"><?php echo $type['title']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="drug_choice-right col-lg-3 col-md-3 col-sm-4 col-xs-12">
                <select class="form-control" id="drug-effect">
                    <option value="0" selected="selected"><?php echo $this->lang->line('product_group'); ?></option>
                    <?php foreach($groups as $group): ?>
                        <option value="<?php echo $group['group_id']; ?>"><?php echo $group['title']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-4 col-xs-12">
                &nbsp;
            </div>
        </div>

        <div class="drug_list">
            <?php if($physics): ?>
                <?php foreach($physics as $item): ?>
                    <div class="drug_list_item col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="drug_list_inner">
                            <img src="<?php echo empty($item['description_image']) ? base_url('assets/public/img/no-intro-image.jpg') : base_url('assets/upload/physic/' . $item['description_image']); ?>">
                            <a href="<?php echo site_url('physic/detail/' . $item['physic_id']); ?>">
                                <h4 class="brand_color post_title"><?php echo $item['title']; ?></h4>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>

</section>
<script>
    $('#drug-type').change(function(){
        var url = '<?php echo site_url('physic/filter_product') ?>';
        var base_path = '<?php echo base_url('assets/upload/physic/') ?>';
        var detail_url = '<?php echo site_url('physic/detail/'); ?>';
        $('.drug_list').html('');
        $.ajax({
            method: 'GET',
            url: url,
            data: {
                type: $('#drug-type').val(),
                group: $('#drug-effect').val()
            },
            success: function(res){
                var html = '';
                $.each($.parseJSON(res), function(key, item){
                    html += '<div class="drug_list_item col-lg-3 col-md-3 col-sm-6 col-xs-12">';
                    html += '<div class="drug_list_inner">';
                    html += '<img src="' + base_path + item.description_image + '">';
                    html += '<a href="' + detail_url + item.physic_id + '">';
                    html += '<h4 class="brand_color post_title">' + item.title + '</h4>';
                    html += '</a>';
                    html += '</div></div>';
                });
                $('.drug_list').html(html);
            },
            error: function(){
                alert('ERROR');
            }
        });
    });

    $('#drug-effect').change(function(){
        var url = '<?php echo site_url('physic/filter_product') ?>';
        var base_path = '<?php echo base_url('assets/upload/physic/') ?>';
        var detail_url = '<?php echo site_url('physic/detail/'); ?>';
        $('.drug_list').html('');
        $.ajax({
            method: 'GET',
            url: url,
            data: {
                type: $('#drug-type').val(),
                group: $('#drug-effect').val()
            },
            success: function(res){
                var html = '';
                $.each($.parseJSON(res), function(key, item){
                    html += '<div class="drug_list_item col-lg-3 col-md-3 col-sm-6 col-xs-12">';
                    html += '<div class="drug_list_inner">';
                    html += '<img src="' + base_path + item.description_image + '">';
                    html += '<a href="' + detail_url + item.physic_id + '">';
                    html += '<h4 class="brand_color post_title">' + item.title + '</h4>';
                    html += '</a>';
                    html += '</div></div>';
                });
                $('.drug_list').html(html);
            },
            error: function(){
                alert('ERROR');
            }
        });
    });
</script>