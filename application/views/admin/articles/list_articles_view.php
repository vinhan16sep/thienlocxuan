<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
    <div class="row">
        <span><?php echo $this->session->flashdata('message'); ?></span>
    </div>
    <div class="row">
        <a type="button" href="<?php echo site_url('admin/articles/create'); ?>" class="btn btn-primary">ADD ARTICLE</a>
        <a type="button" class="btn btn-danger disabled">DELETE ALL SELECTED ARTICLE</a>
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
            echo '<td><b><a href="#">Project</a></b></td>';
            echo '<td><b>Operations</b></td>';
            echo '</tr>';
            if (!empty($articles)) {
                foreach ($articles as $article):
                    echo '<tr>';
                    echo '<td><input type="checkbox" class="checkbox" name="checkbox[' . $article['article_id'] . ']" value="' . $article['article_id'] . '" /></td>';
                    echo '<td>' . $article['article_id'] . '</td>';
                    echo '<td>' . $article['article_title'] . '</td>';
//                    echo '<td>';
                    ?>
                            <!--<img src="<?php echo base_url('assets/upload/news/thumbs/' . pathinfo($article['article_description_image'])['filename'] . '_thumb.' . pathinfo($article['article_description_image'])['extension']); ?>" />--> 
                    <?php
//                    echo '</td>';
                    echo '<td>' . $article['article_description'] . '</td>';
                    echo '<td><a href="' . site_url("admin/projects/edit/" . $article['project_id']) . '">' . $article['project_title'] . '</a></td>';
                    echo '<td>' . anchor('admin/articles/edit/' . $article['article_id'], '<span class="glyphicon glyphicon-pencil"></span>');
                    echo ' ' . anchor('admin/articles/delete/' . $article['article_id'], '<span class="glyphicon glyphicon-remove"></span>') . '</td>';
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
