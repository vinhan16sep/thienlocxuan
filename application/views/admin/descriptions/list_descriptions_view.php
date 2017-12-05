<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
    <div class="row">
        <span><?php echo $this->session->flashdata('message'); ?></span>
    </div>
    <div class="row">
        <div class="col-lg-12" style="margin-top: 10px;">
            <?php
            echo '<table class="table table-hover table-bordered table-condensed">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Vị trí</th>';
                echo '<th>Nội dung</th>';
                echo '<th>Operations</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                foreach($descriptions as $key => $description){
                    echo '<tr>';
                    echo '<td>' . $description['description_from_page'] . '</td>';
                    echo '<td>' . $description['description_content'] . '</td>';
                    echo '<td>' . anchor('admin/descriptions/edit/' . $description['description_id'], '<span class="glyphicon glyphicon-pencil"></span>') . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
            echo '</table>';
            ?>
        </div>
    </div>  
</div>
