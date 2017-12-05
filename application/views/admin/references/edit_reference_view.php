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
                $sort_options = array();
                for($i = 1; $i <= $count; $i++){
                    $sort_options[$i] = $i;
                }
                echo form_label('Sorting', 'reference_sorting');
                echo form_error('reference_sorting');
                echo form_dropdown('reference_sorting', $sort_options, set_value('reference_sorting', $reference['sorting']), 'class="form-control"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Category', 'reference_category');
                echo form_error('reference_category');
                echo form_dropdown('reference_category', array('0' => '', '1' => 'Film', '2' => 'Recent', '3' => 'TVC', '4' => 'Dubbing'), set_value('reference_category', $reference['filter']), 'class="form-control"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Title', 'reference_title');
                echo form_error('reference_title');
                echo form_input('reference_title', set_value('reference_title', $reference['title']), 'class="form-control"');
                ?>
            </div>
            <div class="form-group picture">
                <?php
                echo form_label('Image', 'reference_image');
                echo form_error('reference_image');
                echo form_upload('reference_image', set_value('reference_image'), 'class="form-control"');
                ?>
                <label>Current image: <?php echo $reference['image']; ?></label>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Item URL', 'reference_url');
                echo form_error('reference_url');
                echo form_input('reference_url', set_value('reference_url', $reference['url']), 'class="form-control"');
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
<script type="text/javascript" src="<?php echo site_url('tinymce/tinymce.min.js'); ?>"></script>
<script>
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        height: 200,
        relative_urls: false,
        remove_script_host: false,
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor responsivefilemanager"
        ],
        content_css: "css/content.css",
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | responsivefilemanager | print preview media fullpage | forecolor backcolor emoticons",
        style_formats: [
            {title: "Bold text", inline: "b"},
            {title: "Red text", inline: "span", styles: {color: "#ff0000"}},
            {title: "Red header", block: "h1", styles: {color: "#ff0000"}},
            {title: "Example 1", inline: "span", classes: "example1"},
            {title: "Example 2", inline: "span", classes: "example2"},
            {title: "Table styles"},
            {title: "Table row 1", selector: "tr", classes: "tablerow1"}
        ],
        external_filemanager_path: "<?php echo site_url('filemanager/'); ?>",
        filemanager_title: "Responsive Filemanager",
        external_plugins: {"filemanager": "<?php echo site_url('filemanager/plugin.min.js'); ?>"}
    });
</script>