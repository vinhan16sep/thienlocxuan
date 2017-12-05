<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
    <div class="row modified-mode">
        <div class="col-lg-10 col-lg-offset-0">
            <h1>Edit article</h1>
            <?php
            echo form_open_multipart('', array('class' => 'form-horizontal'));
            ?>
            <div class="form-group">
                <?php
                echo form_label('Project', 'article_project');
                echo form_error('article_project');
                echo form_dropdown('article_project', $list_projects, $article['article_project_id'], 'class="form-control"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Title', 'article_title');
                echo form_error('article_title');
                echo form_input('article_title', set_value('article_title', $article['article_title']), 'class="form-control"');
                ?>
            </div>
            <div class="form-group picture">
                <?php
                echo form_label('Picture', 'article_picture');
                echo form_error('article_picture');
                echo form_upload('article_picture', set_value('article_picture'), 'class="form-control"');
                echo '<span>Current description image: <p style="color:red">' . $article['article_description_image'] . '</p></span>';
                echo '<img src="' . base_url('assets/upload/articles/' . $article['article_description_image']) . '" >';
                ?>
            </div>
            <div class="form-group description">
                <?php
                echo form_label('Description', 'article_description');
                echo form_error('article_description');
                echo form_textarea('article_description', set_value('article_description', $article['article_description']), 'class="form-control"');
                ?>
            </div>
            <div class="form-group">
                <?php
                echo form_label('Content', 'article_content');
                echo form_error('article_content');
                echo form_textarea('article_content', set_value('article_content', $article['article_content'], false), 'class="form-control article-content"')
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
        selector: ".article-content",
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