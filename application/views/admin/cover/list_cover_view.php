<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
    img{width:100%;}
</style>
<div class="container">
    <div class="row">
        <span><?php echo $this->session->flashdata('message'); ?></span>
    </div>
    <div class="row">
        <!--<a type="button" href="<?php echo site_url('admin/cover/create'); ?>" class="btn btn-primary">ADD NEW</a>-->
    </div>
    <div class="row">
        <div class="col-lg-12" style="margin-top: 10px;">
            <?php
            echo '<table class="table table-hover table-bordered table-condensed">';
            echo '<tr>';
            echo '<td><b><a href="#">Title</a></b></td>';
            echo '<td><b><a href="#">Image</a></b></td>';
            echo '<td><b>Operations</b></td>';
            echo '</tr>';
            if (!empty($covers)) {
                foreach ($covers as $item):
                    echo '<tr>';
                    echo '<td>' . $item['text'] . '</td>';
                    echo '<td><img src="' . site_url('assets/upload/cover/' . $item['image']) . '" /></td>';
                    echo '<td>';
                    echo '<a href="' . base_url('admin/cover/edit/' . $item['id']) . '">';
                    echo '<span class="glyphicon glyphicon-pencil"></span>';
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
</div>\
