<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
	<div class="col-sm-12">
		<div class="box box-primary">
			<div class="box-header with-border">

			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<!-- include message block -->
				<?php $this->load->view('admin/includes/_messages'); ?>

                <?php echo form_open('admin_controller/set_mode_post'); ?>
                    <ul class="nav nav-tabs layout-nav-tabs">
                        <li class="<?php echo ($general_settings->dark_mode == 0) ? 'active' : ''; ?>">
                            <button type="submit" name="dark_mode" value="0"><?php echo trans("light_mode"); ?></button>
                        </li>
                        <li class="<?php echo ($general_settings->dark_mode == 1) ? 'active' : ''; ?>">
                            <button type="submit" name="dark_mode" value="1"><?php echo trans("dark_mode"); ?></button>
                        </li>
                    </ul>
                <?php echo form_close(); ?>

				<div class="tab-content tab-content-layout-items">
					<div id="light_mode" class="tab-pane fade in active">
						<input type="hidden" name="layout" id="light_layout" value="<?php echo $general_settings->layout; ?>">
						<div class="row row-layout-items">
							<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 layout-item <?php echo ($general_settings->layout == 'layout_1') ? 'active' : ''; ?>" data-val="layout_1" onclick="set_theme('layout_1');">
								<img src="<?php echo base_url(); ?>assets/admin/img/layout_1.jpg" alt="" class="img-responsive">
								<button type="button" class="btn btn-block"><?php echo ($general_settings->layout == 'layout_1') ? trans("activated") : trans("activate"); ?></button>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 layout-item <?php echo ($general_settings->layout == 'layout_2') ? 'active' : ''; ?>" data-val="layout_2" onclick="set_theme('layout_2');">
								<img src="<?php echo base_url(); ?>assets/admin/img/layout_2.jpg" alt="" class="img-responsive">
								<button type="button" class="btn btn-block"><?php echo ($general_settings->layout == 'layout_2') ? trans("activated") : trans("activate"); ?></button>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 layout-item <?php echo ($general_settings->layout == 'layout_3') ? 'active' : ''; ?>" data-val="layout_3" onclick="set_theme('layout_3');">
								<img src="<?php echo base_url(); ?>assets/admin/img/layout_3.jpg" alt="" class="img-responsive">
								<button type="button" class="btn btn-block"><?php echo ($general_settings->layout == 'layout_3') ? trans("activated") : trans("activate"); ?></button>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 layout-item <?php echo ($general_settings->layout == 'layout_4') ? 'active' : ''; ?>" data-val="layout_4" onclick="set_theme('layout_4');">
								<img src="<?php echo base_url(); ?>assets/admin/img/layout_4.jpg" alt="" class="img-responsive">
								<button type="button" class="btn btn-block"><?php echo ($general_settings->layout == 'layout_4') ? trans("activated") : trans("activate"); ?></button>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 layout-item <?php echo ($general_settings->layout == 'layout_5') ? 'active' : ''; ?>" data-val="layout_5" onclick="set_theme('layout_5');">
								<img src="<?php echo base_url(); ?>assets/admin/img/layout_5.jpg" alt="" class="img-responsive">
								<button type="button" class="btn btn-block"><?php echo ($general_settings->layout == 'layout_5') ? trans("activated") : trans("activate"); ?></button>
							</div>
							<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 layout-item <?php echo ($general_settings->layout == 'layout_6') ? 'active' : ''; ?>" data-val="layout_6" onclick="set_theme('layout_6');">
								<img src="<?php echo base_url(); ?>assets/admin/img/layout_6.jpg" alt="" class="img-responsive">
								<button type="button" class="btn btn-block"><?php echo ($general_settings->layout == 'layout_6') ? trans("activated") : trans("activate"); ?></button>
							</div>
						</div>
					</div>
				</div>

			</div>
			<!-- /.box-body -->
			<div class="box-footer">
			</div>
		</div>
		<!-- /.box -->
	</div>
</div>

<script>
    function set_theme(layout) {
        var data = {
            'layout': layout
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "admin_controller/set_theme_post",
            data: data,
            success: function (response) {
                location.reload();
            }
        });
    }
</script>


