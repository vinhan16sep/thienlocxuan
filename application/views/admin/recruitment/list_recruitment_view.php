<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
    <div class="row">
        <span><?php echo $this->session->flashdata('message'); ?></span>
    </div>
    <?php echo form_open_multipart(); ?>
    <div class="row">
        <a type="button" href="<?php echo site_url('admin/recruitment/create'); ?>" class="btn btn-primary">ADD NEW</a>
        <a type="button" onclick="delete_all('<?php echo base_url('admin/recruitment/delete_multiple') ?>');" class="btn btn-danger">DELETE ALL SELECTED ITEMS</a>
    </div>
    <div class="row">
        <?php
        echo form_open_multipart('', array('class' => 'form-horizontal'));
        ?>
        <label>Tìm kiếm</label>
        <div class="input-group">
            <?php
            echo form_error('keywords');
            echo form_input('keywords', set_value('keywords'), 'class="form-control"');
            echo '<div class="input-group-btn">';

            echo '<button class="btn btn-primary" type="submit" name="search" value="search">Search!</button>';
            echo '<a class="btn btn-default" href="' . base_url('admin/recruitment/reset') . '" role="button">Reset tìm kiếm</a>';
            echo '</div>';
            ?>

        </div>

        <?php echo form_close(); ?>
    </div>
    <div class="row">
        <div class="col-lg-12" style="margin-top: 10px;">
            <?php
            echo '<table class="table table-hover table-bordered table-condensed">';
            echo '<tr>';
            echo '<td><input type="checkbox" class="check-all" id="check-all" /></td>';
            echo '<td><b><a href="#">Title</a></b></td>';
            echo '<td><b><a href="#">Status</a></b></td>';
            echo '<td><b>Operations</b></td>';
            echo '</tr>';
            if (!empty($recruitments)) {
                foreach ($recruitments as $item):
                    echo '<tr>';
                    echo '<td><input type="checkbox" id="' . $item['id'] . '" class="checkbox" name="checkbox[' . $item['id'] . ']" /></td>';
                    echo '<td>' . anchor('admin/recruitment/edit/' . $item['id'],  str_replace('|||', ' | ', $item['data']['recruitment_title']) . '</td>');
                    ?>
                    <td><span><?php echo $item['status']; ?></span></td>
                    <?php
                    echo '<td>';
                    echo '<a href="' . base_url('admin/recruitment/edit/' . $item['id']) . '">';
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
            <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Xóa dữ liệu</h4>
                        </div>
                        <div class="modal-body">
                            Bạn có chắc xóa dữ liệu chưa?
                            <br>
                            <?php
                            echo anchor('admin/recruitment/delete/' . $item['recruitment_id'][0], '<button class="btn btn-default" type="submit">Đồng ý</button>');
                            echo ' ';
                            echo '<button type="button" class="btn btn-default btn-primary" data-dismiss="modal">Không</button>';
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-primary" data-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script>
    function deleteItem(id){
        if(confirm('Chắc chắn xoá?')){
            var url = '<?php echo base_url('admin/recruitment/delete'); ?>';

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