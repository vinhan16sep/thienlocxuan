<section class="content contact container">
    <div class="contact_content">
        <div class="page_list">
            <ul>
                <li><a href="<?php echo site_url('physic'); ?>"><?php echo $this->lang->line('medicine'); ?></a></li>
                <li><a href="<?php echo site_url('product'); ?>"><?php echo $this->lang->line('list_product'); ?></a></li>
                <li><a href="<?php echo site_url('quotation'); ?>"><?php echo $this->lang->line('quotation'); ?></a></li>
                <li><a href="<?php echo site_url('partner'); ?>"><?php echo $this->lang->line('partner'); ?></a></li>
            </ul>

        </div>

        <?php
        echo form_open_multipart('', array('class' => 'form-horizontal'));
        ?>
        <div class="contact_form">
            <div class="row">

            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-md-offset-2">
                <span style="color: red;"><?php echo $this->session->flashdata('message'); ?></span>
                <table class="table">
                    <tr>
                        <td>
                            <?php
                            echo form_label($this->lang->line('contact_name'). '(*)', 'name');
                            echo form_error('name');
                            echo form_input('name', set_value('name'), 'class="form-control"');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            echo form_label($this->lang->line('contact_email'). '(*)', 'email');
                            echo form_error('email');
                            echo form_input('email', set_value('email'), 'class="form-control"');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            echo form_label($this->lang->line('contact_phone'). '(*)', 'phone');
                            echo form_error('phone');
                            echo form_input('phone', set_value('phone'), 'class="form-control"');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            echo form_label('Image'. '(*)', 'image');
                            echo form_error('image');
                            echo form_upload('image', set_value('image'), 'class="form-control"');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            echo form_label($this->lang->line('contact_content') . '(*)', 'content');
                            echo form_error('content');
                            echo form_textarea('content', set_value('content'), 'class="form-control" placeholder="' . $this->lang->line('contact_content_placeholder') . '"');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            echo form_submit('submit', $this->lang->line('contact_send'), 'class="btn btn-default hvr-sweep-to-right"');
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php
        echo form_close();
        ?>
    </div>

</section>