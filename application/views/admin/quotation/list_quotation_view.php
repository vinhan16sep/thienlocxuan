<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/public/lightbox.css'); ?>">
<style>
    td.td-image img{
        width: 300px;
    }

    .table > tbody > tr > td.no_border{
        border-top:none;
    }

    #preview{
        position:absolute;
        background:#F5878B;
        padding:5px;
        display:none;
        color:#fff;
        z-index: 9999;
    }
</style>

<div class="container">
    <h3>Danh sách yêu cầu đang chờ duyệt</h3>
    <div class="row">
        <span><?php echo $this->session->flashdata('message'); ?></span>
    </div>
    <div class="row">
        <div class="col-lg-12" style="margin-top: 10px;">
            <!--            --><?php
            //            echo '<table class="table table-hover table-bordered table-condensed">';
            //            echo '<tr>';
            //            echo '<td><b><a href="#">Name</a></b></td>';
            //            echo '<td><b><a href="#">Email</a></b></td>';
            //            echo '<td><b><a href="#">Phone</a></b></td>';
            //            echo '<td><b><a href="#">Image</a></b></td>';
            //            echo '</tr>';
            //            if (!empty($quotations)) {
            //                foreach ($quotations as $item):
            //                    echo '<tr>';
            //                    echo '<td>' . $item['name'] . '</td>';
            //                    echo '<td>' . $item['email'] . '</td>';
            //                    echo '<td>' . $item['phone'] . '</td>';
            //                    echo '<td>';
            //                    ?>
            <!--                    <img src="--><?php //echo base_url('assets/upload/quotation/thumb/' . pathinfo($item['image'])['filename'] . '_thumb.' . pathinfo($item['image'])['extension']); ?><!--" />-->
            <!--                    --><?php
            //                    echo '</td>';
            //                    echo '</tr>';
            //                endforeach;
            //            }else {
            //                echo '<tr class="odd"><td colspan="9">No records</td></tr>';
            //            }
            //            echo '</table>';
            //            ?>
            <table class="table">
                <tr>
                    <td><strong> Họ tên khách hàng </strong></td>
                    <td><strong> Email </strong></td>
                    <td><strong> Số điện thoại </strong></td>
                    <td><strong> Ảnh giấy chứng nhận GPP </strong></td>
                    <td><strong> Tin nhắn </strong></td>
                    <td><strong> Hành động </strong></td>
                </tr>
            <?php
            if (!empty($quotations)) {
                foreach ($quotations as $item):
                    if($item['status'] == 1){
                        $status = 'Đã gửi báo giá';
                    }elseif($item['status'] == 2){
                        $status = 'Đã từ chối gửi báo giá';
                    }else{
                        $status = 'Đang chờ duyệt';
                    }
                    echo '<tr>';
                    echo '<td>' . $item['name'] . '</td>';
                    echo '<td>' . $item['email'] . '</td>';
                    echo '<td>' . $item['phone'] . '</td>';
                    ?>
                    <td class="td-image">
                        <a class="example-image-link" data-lightbox="example-1" href="<?php echo base_url('assets/upload/quotation/thumb/' . pathinfo($item['image'])['filename'] . '_thumb.' . pathinfo($item['image'])['extension']); ?>">
                            <img class="example-image" src="<?php echo base_url('assets/upload/quotation/thumb/' . pathinfo($item['image'])['filename'] . '_thumb.' . pathinfo($item['image'])['extension']); ?>" />
                        </a>
                    </td>
                    <?php
                    echo '<td><button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#' . $item['id'] . '" aria-expanded="false" aria-controls="messageContent">';
                    echo 'Xem tin nhắn';
                    echo '</button></td>';

            ?>

                    <?php
                    echo form_open_multipart();
                    
                    $hidden_name = array(
                        'type'  => 'hidden',
                        'name'  => 'hidden_name',
                        'id'    => 'hidden_name' . $item['id'],
                        'value' => $item['name'],
                        'class' => 'hidden_name'
                    );
                    echo form_input($hidden_name);

                    $hidden_email = array(
                        'type'  => 'hidden',
                        'name'  => 'hidden_email',
                        'id'    => 'hidden_email' . $item['id'],
                        'value' => $item['email'],
                        'class' => 'hidden_email'
                    );
                    echo form_input($hidden_email);
                    

                    echo '<td>';
                    if($item['status'] == 0){
                        echo '<button type="button" onclick="workflow(' . $item['id'] . ', $(this).attr(\'id\'));" class="btn btn-success" id="approve">Đồng ý</button>';
                        echo '&nbsp&nbsp&nbsp';
                        echo '<button type="button" onclick="workflow(' . $item['id'] . ', $(this).attr(\'id\'));" class="btn btn-danger" id="reject">Từ chối</button>';
                    }
                    echo '</td>';
                    echo '</tr>';

                    echo form_close();
                    echo '<tr>';
                    echo '<td colspan="6" class="no_border">';
                    echo '<div class="collapse" id="' . $item['id'] . '">';
                    echo '<strong>Tin nhắn của khách hàng: </strong>' . $item['content']  ;
                    echo '</div>';
                    echo '</td>';
                    echo '</tr>';

                endforeach;
            }else {
                echo '<tr class="odd"><td colspan="9">No records</td></tr>';
            }
            ?>
            </table>


            <div class="col-md-6 col-md-offset-5">
                <?php echo $page_links; ?>
            </div>

        </div>
    </div>
</div>
<script>
    function workflow(id, action){
        var name = $('#hidden_name' + id).val();
        var email = $('#hidden_email' + id).val();
        
        var confirm_message = (action == 'approve') ? 'Đồng ý gửi báo giá?' : 'Từ chối gửi báo giá?';
        if(confirm(confirm_message)){
            var url = '<?php echo base_url('admin/quotation/workflow'); ?>';

            $.ajax({
                url: url,
                method: 'post',
                dataType: 'json',
                data: {
                    action: action,
                    id: id,
                    name: name,
                    email: email
                },
                success: function(res){
                    console.log(res);
                    if(res.message == 'Success'){
                        if(res.data.action == 'approve'){
                            alert('Báo giá đã gửi');
                        }else{
                            alert('Đã từ chối gửi báo giá');
                        }
                    }
                    location.reload();
                },
                error: function(){

                }
            });
        };
    }
</script>
<script src="<?php echo base_url('assets/public/js/lightbox.js') ?>"></script>

