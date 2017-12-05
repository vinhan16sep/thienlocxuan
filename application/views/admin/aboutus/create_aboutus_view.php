<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
    <div class="row modified-mode">
        <div class="col-lg-10 col-lg-offset-0">
            <h1>Add About us</h1>
            <?php
            echo form_open_multipart('', array('class' => 'form-horizontal'));
            ?>
            <div class="form-group picture">
                <?php
                echo form_label('Title', 'aboutus_title');
                echo form_error('aboutus_title');
                echo form_input('aboutus_title', set_value('aboutus_title'), 'class="form-control"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Content', 'aboutus_content');
                echo form_error('aboutus_content');
                echo form_textarea('aboutus_content', set_value('aboutus_content', '', false), 'class="form-control aboutus-content"')
                ?>
            </div>
            <div class="form-group">
                <?php if ($over_aboutus && $over_aboutus == 1): ?>
                    <p>You have selected another post to display in about us page</p>
                <?php endif; ?>
                <?php
                echo form_label('Show this post?', 'aboutus_is_select');
                echo form_error('aboutus_is_select');
                echo form_dropdown('aboutus_is_select', array('0' => 'No', '1' => 'Yes'), set_value('aboutus_is_select', 0), 'class="form-control"');
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
        selector: ".aboutus-content",
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