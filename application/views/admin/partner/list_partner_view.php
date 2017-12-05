<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
    img{width:500px;}
</style>
<div class="container">
    <div class="row">
        <span><?php echo $this->session->flashdata('message'); ?></span>
    </div>
    <div class="row">
        <a type="button" href="<?php echo site_url('admin/partner/create'); ?>" class="btn btn-primary">ADD NEW</a>
    </div>
    <div class="row">
        <div class="col-lg-12" style="margin-top: 10px;">
            <?php
            echo '<table class="table table-hover table-bordered table-condensed">';
            echo '<tr>';
            echo '<td><b><a href="#">Name</a></b></td>';
            echo '<td><b><a href="#">Image</a></b></td>';
            echo '<td><b>Operations</b></td>';
            echo '</tr>';
            if (!empty($partners)) {
                foreach ($partners as $item):
                    echo '<tr>';
                    echo '<td>' . str_replace('|||', ' | ', $item['data']['partner_name']) . '</td>';
                    echo '<td><img src="' . site_url('assets/upload/partner/' . $item['data']['image']) . '" /></td>';
                    echo '<td>';
                    echo '<a href="' . base_url('admin/partner/edit/' . $item['id']) . '">';
                    echo '<span class="glyphicon glyphicon-pencil"></span>';
                    echo '</a>';
                    echo '<a href="javascript:void(0);" onclick="confirmDelete(' . $item['id'] . ')">';
                    echo '<span class="glyphicon glyphicon-remove"></span>';
                    echo '</a>';
                    echo '</td>';
                endforeach;
            }else {
                echo '<tr class="odd"><td colspan="9">No records</td></tr>';
            }
            echo '</table>';
            ?>
            <div class="col-md-6 col-md-offset-5">
                <?php echo $page_links; ?>
            </div>
        </div>
    </div>
</div>
<script>
    var url = '<?php echo base_url('admin/partner/delete') ?>';

    function confirmDelete(id){
        if (confirm('Chắc chắn xoá?')) {
            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    id: id
                },
                success: function(res){
                    alert('Image ' + res.image + ' has deleted successful');
                    location.reload();
                },
                error: function(){
                    alert('Delete unsuccessful');
                }
            });
        } else {
            return false;
        }
    }

</script>
