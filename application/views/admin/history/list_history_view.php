<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
    <div class="row">
        <span><?php echo $this->session->flashdata('message'); ?></span>
    </div>
    <?php echo form_open_multipart(); ?>
    <div class="row">
        <a type="button" href="<?php echo site_url('admin/history/create'); ?>" class="btn btn-primary">ADD NEW</a>
        <a type="button" onclick="delete_all('<?php echo base_url('admin/history/delete_multiple') ?>');" class="btn btn-danger">DELETE ALL SELECTED ITEMS</a>
    </div>
    <div class="row">
        <div class="col-lg-12" style="margin-top: 10px;">
            <?php
            echo '<table class="table table-hover table-bordered table-condensed">';
            echo '<tr>';
            echo '<td><input type="checkbox" class="check-all" id="check-all" /></td>';
            echo '<td><b><a href="#">Year</a></b></td>';
            echo '<td><b>Operations</b></td>';
            echo '</tr>';
            if (!empty($histories)) {
                foreach ($histories as $item):
                    echo '<tr>';
                        echo '<td><input type="checkbox" id="' . $item['id'] . '" class="checkbox" name="checkbox[' . $item['id'] . ']" /></td>';
                        echo '<td>' . anchor('admin/history/edit/' . $item['id'],   $item['year'])  . '</td>';
                        echo '<td>';
                    echo '<a href="' . base_url('admin/history/edit/' . $item['id']) . '">';
                        echo '<span class="glyphicon glyphicon-pencil"></span>';
                        echo '</a>';
                        echo '<a href="javascript:void(0);" onclick="deleteItem(' . $item['id'] . ')">';
                        echo '<span class="glyphicon glyphicon-remove"></span>';
                        echo '</a>';
                        echo '</td>';
                    echo '</tr>';
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
    <?php echo form_close(); ?>
</div>
<script>
    function deleteItem(id){
        if(confirm('Chắc chắn xoá?')){
            var url = '<?php echo base_url('admin/history/delete'); ?>';

            $.ajax({
                url: url,
                method: 'get',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function(res){
                    console.log(res);
                    if(res.message == 'Success'){
                        alert('Xoá thành công');
                        location.reload();
                    }else{
                        alert('Xoá thất bại');
                    }
                },
                error: function(){

                }
            });
        }
    }
</script>
