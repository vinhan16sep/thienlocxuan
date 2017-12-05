<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
    <div class="row">
        <span><?php echo $this->session->flashdata('message'); ?></span>
    </div>
    <div class="row">
        <a type="button" href="<?php echo site_url('admin/projects/create'); ?>" class="btn btn-primary">ADD PROJECTS</a>
        <a type="button" class="btn btn-danger disabled">DELETE ALL SELECTED PROJECTS</a>
    </div>
    <div class="row">
        <div class="col-lg-12" style="margin-top: 10px;">
            <?php
            echo '<table class="table table-hover table-bordered table-condensed">';
            echo '<tr>';
            echo '<td><input type="checkbox" class="check-all" id="check-all" /></td>';
            echo '<td><b><a href="#">ID</a></b></td>';
            echo '<td><b><a href="#">Title</a></b></td>';
//            echo '<td><b><a href="#">Image</a></b></td>';
            echo '<td><b><a href="#">Description</a></b></td>';
            echo '<td><b><a href="#">Main project?</a></b></td>';
            echo '<td><b>Operations</b></td>';
            echo '</tr>';
            if (!empty($projects)) {
                foreach ($projects as $project):
                    echo '<tr>';
                    echo '<td><input type="checkbox" class="checkbox" name="checkbox[' . $project['project_id'] . ']" value="' . $project['project_id'] . '" /></td>';
                    echo '<td>' . $project['project_id'] . '</td>';
                    echo '<td>' . $project['project_title'] . '</td>';
//                    echo '<td>';
                    ?>
                            <!--<img src="<?php echo base_url('assets/upload/news/thumbs/' . pathinfo($project['project__description_image'])['filename'] . '_thumb.' . pathinfo($project['project_description_image'])['extension']); ?>" />--> 
                    <?php
//                    echo '</td>';
                    echo '<td>' . $project['project_description'] . '</td>';
                    echo '<td>' . (($project['project_is_main'] == 1) ? 'Yes' : 'No') . '</td>';
                    echo '<td>' . anchor('admin/projects/edit/' . $project['project_id'], '<span class="glyphicon glyphicon-pencil"></span>');
                    echo ' ' . anchor('admin/projects/delete/' . $project['project_id'], '<span class="glyphicon glyphicon-remove"></span>') . '</td>';
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
</div>
