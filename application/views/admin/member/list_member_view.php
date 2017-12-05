<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
    <div class="row">
        <span><?php echo $this->session->flashdata('message'); ?></span>
    </div>
    <?php echo form_open_multipart(); ?>
    <div class="row">
        <a type="button" href="<?php echo site_url('admin/member/create'); ?>" class="btn btn-primary">ADD NEW</a>
    </div>
    <div class="row">
        <div class="col-lg-12" style="margin-top: 10px;">
            <?php
            echo '<table class="table table-hover table-bordered table-condensed">';
            echo '<tr>';
            echo '<td><b><a href="#">Họ tên</a></b></td>';
            echo '<td><b><a href="#">Chức vụ</a></b></td>';
            echo '<td><b>Operations</b></td>';
            echo '</tr>';
            if (!empty($members)) {
                foreach ($members as $item):
                    echo '<tr>';
                    echo '<td>' . anchor('admin/member/edit/' . $item['id'],  $item['data']['member_name'] . '</td>');
                    echo '<td>' . $item['role'] . '</td>';
                    echo '<td>';
                    echo '<a href="' . base_url('admin/member/edit/' . $item['id']) . '">';
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
                            echo anchor('admin/member/delete/' . $item['member_id'][0], 'OK');
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
            var url = '<?php echo base_url('admin/member/delete'); ?>';

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