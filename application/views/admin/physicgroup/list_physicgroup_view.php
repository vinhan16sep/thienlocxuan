<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
    <div class="row">
        <span><?php echo $this->session->flashdata('message'); ?></span>
    </div>
    <?php echo form_open_multipart(); ?>
    <div class="row">
        <a type="button" href="<?php echo site_url('admin/physicgroup/create'); ?>" class="btn btn-primary">ADD NEW</a>
        <a type="button" onclick="delete_all('<?php echo base_url('admin/physicgroup/delete_multiple') ?>');" class="btn btn-danger">DELETE ALL SELECTED ITEMS</a>
    </div>
    <div class="row">
        <div class="col-lg-12" style="margin-top: 10px;">
            <?php
            echo '<table class="table table-hover table-bordered table-condensed">';
            echo '<tr>';
            echo '<td><input type="checkbox" class="check-all" id="check-all" /></td>';
            echo '<td><b><a href="#">Title</a></b></td>';
            echo '<td><b>Operations</b></td>';
            echo '</tr>';
            if (!empty($group)) {
                foreach ($group as $item):
                    echo '<tr>';
                    echo '<td><input type="checkbox" id="' . $item['id'] . '" class="checkbox" name="checkbox[' . $item['id'] . ']" value="' . $item['group_title'] . '" /></td>';
                    echo '<td>' . anchor('admin/physicgroup/edit/' . $item['id'],  $item['group_title'] . '</td>');
                    //echo '<td>' . $item['group_title'] . '</td>';
                    echo '<td>' . anchor('admin/physicgroup/edit/' . $item['id'], '<span class="glyphicon glyphicon-pencil"></span>');
                    //echo ' ' . anchor('admin/group/delete/' . $item['id'], '<span class="glyphicon glyphicon-remove"></span>') . '</td>';
                    echo ' ' . anchor('admin/physicgroup/edit/' . $item['id'], '<span data-toggle="modal" data-target="#confirm" class="glyphicon glyphicon-erase"></span>' . '</td>');
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
                            echo anchor('admin/physicgroup/delete/' . $item['id'], '<button class="btn btn-default" type="submit">Đồng ý</button>');
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
