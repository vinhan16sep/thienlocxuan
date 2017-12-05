<section class="content contact container">
    <div class="contact_content">
        <div class="map" id="map">
        </div>
        <div class="contact_form">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <p><?php echo $this->lang->line('contact_us'); ?></p>
                <h3 class="brand_color post_title"><?php echo $this->lang->line('company_name'); ?></h3>
                <p class="paragraph">
                    <?php echo $this->lang->line('contact_address_1'); ?>
                    <br>
                    <?php echo $this->lang->line('contact_address_2'); ?>
                    <br>
                    <?php echo $this->lang->line('company_phone'); ?>
                </p>
            </div>
            <?php
            echo form_open_multipart('contact/send_mail', array('class' => 'form-horizontal', 'id' => 'contact-form'));
            ?>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <table class="table">
                    <tr>
                        <td>
                            <?php
                            echo form_label($this->lang->line('contact_name') . '(*)', 'name');
                            echo form_error('name');
                            echo form_input('name', set_value('name'), 'class="form-control contact_name" placeholder="' . $this->lang->line('contact_name') . '"');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            echo form_label($this->lang->line('contact_email') . '(*)', 'email');
                            echo form_error('email');
                            echo form_input('email', set_value('email'), 'class="form-control" placeholder="' . $this->lang->line('contact_email') . '"');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            echo form_label($this->lang->line('contact_phone') . '(*)', 'phone');
                            echo form_error('phone');
                            echo form_input('phone', set_value('phone'), 'class="form-control" placeholder="' . $this->lang->line('contact_phone') . '"');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            echo form_label($this->lang->line('contact_wishing') . '(*)', 'wishing');
                            echo form_error('wishing');
                            echo form_input('wishing', set_value('wishing'), 'class="form-control" placeholder="' . $this->lang->line('contact_wishing') . '"');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            echo form_label($this->lang->line('contact_content') . '(*)', 'content');
                            echo form_error('content');
                            echo form_textarea('content', set_value('content'), 'class="form-control" placeholder="' . $this->lang->line('contact_content') . '"');
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
            <?php
            echo form_close();
            ?>
        </div>
    </div>

</section>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVldQrvD6TdflBLsoI9eNdXBUwHFwvp-c&callback=initMap">
</script>
<script>
    function initMap() {
        var uluru = {lat: 21.0015408, lng: 105.8060209};
        var iconBase = {
        }

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: uluru,
            scrollwheel: false,
            styles: [
                
            ]
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map,
            icon: "assets/public/img/marker.png"
        });
    }
</script>