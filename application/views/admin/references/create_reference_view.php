<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
    <div class="row modified-mode">
        <div class="col-lg-10 col-lg-offset-0">
            <h1>Add project</h1>
            <?php
            echo form_open_multipart('', array('class' => 'form-horizontal'));
            ?>
            <div class="form-group">
                <?php
                $sort_options = array();
                for($i = 1; $i <= $count + 1; $i++){
                    $sort_options[$i] = $i;
                }
                echo form_label('Sorting', 'reference_sorting');
                echo form_error('reference_sorting');
                echo form_dropdown('reference_sorting', $sort_options, set_value('reference_sorting', $count + 1), 'class="form-control"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Category', 'reference_category');
                echo form_error('reference_category');
                echo form_dropdown('reference_category', array('0' => '', '1' => 'Film', '2' => 'Recent', '3' => 'TVC', '4' => 'Dubbing'), set_value('reference_category', 0), 'class="form-control"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Title', 'reference_title');
                echo form_error('reference_title');
                echo form_input('reference_title', set_value('reference_title'), 'class="form-control"');
                ?>
            </div>
            <div class="form-group picture">
                <?php
                echo form_label('Image', 'reference_image');
                echo form_error('reference_image');
                echo form_upload('reference_image', set_value('reference_image'), 'class="form-control"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Item URL', 'reference_url');
                echo form_error('reference_url');
                echo form_input('reference_url', set_value('reference_url'), 'class="form-control"');
                ?>
            </div>
            <br>
            <div class="form-group col-sm-12 text-right">
                <?php
                echo form_submit('submit', 'OK', 'class="btn btn-primary"');
                echo form_close();
                ?>
                <a class="btn btn-default cancel" href="javascript:window.history.go(-1);">Go back</a>
            </div>
        </div>
    </div>
</div>