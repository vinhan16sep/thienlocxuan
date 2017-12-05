<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
    <div class="row modified-mode">
        <div class="col-lg-10 col-lg-offset-0">
            <h1>Edit project</h1>
            <?php
            echo form_open_multipart('', array('class' => 'form-horizontal'));
            ?>
            <div class="form-group">
                <?php
                echo form_label('Vị trí', 'description_from_page');
                echo form_error('description_from_page');
                echo form_input('description_from_page', set_value('description_from_page', $description['description_from_page']), 'class="form-control" disabled="disabled"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Description', 'description_content');
                echo form_error('description_content');
                echo form_textarea('description_content', set_value('description_content', $description['description_content']), 'class="form-control"');
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