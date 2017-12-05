<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
    td.td-image img{
        width: 300px;
    }

    .table > tbody > tr > td.no_border{
        border-top:none;
    }
</style>

<div class="container">
    <h3>Danh sách yêu cầu đã được chấp nhận</h3>
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
                </tr>
            <?php
            if (!empty($quotations)) {
                foreach ($quotations as $item):
                    echo '<tr>';
                    echo '<td>' . $item['name'] . '</td>';
                    echo '<td>' . $item['email'] . '</td>';
                    echo '<td>' . $item['phone'] . '</td>';
                    ?>
                    <td class="td-image">
                        <img src="<?php echo base_url('assets/upload/quotation/thumb/' . pathinfo($item['image'])['filename'] . '_thumb.' . pathinfo($item['image'])['extension']); ?>" />
                    </td>
                    <?php
                    echo '<td><button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#' . $item['id'] . '" aria-expanded="false" aria-controls="messageContent">';
                    echo 'Xem tin nhắn';
                    echo '</button></td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td colspan="5" class="no_border">';
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

