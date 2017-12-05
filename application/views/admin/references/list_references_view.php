<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
    <div class="row">
        <span><?php echo $this->session->flashdata('message'); ?></span>
    </div>
    <div class="row">
        <a type="button" href="<?php echo site_url('admin/references/create'); ?>" class="btn btn-primary">ADD REFERENCE</a>
        <a type="button" class="btn btn-danger disabled">DELETE ALL SELECTED REFERENCES</a>
    </div>
    <div class="row">
        <div class="col-lg-12" style="margin-top: 10px;">
            <?php
            echo '<table class="table table-hover table-bordered table-condensed">';
            echo '<tr>';
            echo '<td><input type="checkbox" class="check-all" id="check-all" /></td>';
            echo '<td><b><a href="#">ID</a></b></td>';
            echo '<td><b><a href="#">Sorting</a></b></td>';
            echo '<td><b><a href="#">Title</a></b></td>';
            echo '<td><b><a href="#">Filter</a></b></td>';
            echo '<td><b>Operations</b></td>';
            echo '</tr>';
            if (!empty($references)) {
            	$filter = array('0' => '', '1' => 'Film', '2' => 'Recent', '3' => 'TVC', '4' => 'Dubbing');
                foreach ($references as $reference):
                    echo '<tr>';
                    echo '<td><input type="checkbox" class="checkbox" name="checkbox[' . $reference['id'] . ']" value="' . $reference['id'] . '" /></td>';
                    echo '<td>' . $reference['id'] . '</td>';
                    echo '<td>' . $reference['sorting'] . '</td>';
                    echo '<td>' . $reference['title'] . '</td>';
                    echo '<td>' . $filter[$reference['filter']] . '</td>';
                    echo '<td>' . anchor('admin/references/edit/' . $reference['id'], '<span class="">Update</span>');
                    echo '&nbsp;&nbsp;&nbsp;';
                    echo ' ' . anchor('admin/references/delete/' . $reference['id'], '<span style="color: red;" class="">Delete</span>') . '</td>';
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