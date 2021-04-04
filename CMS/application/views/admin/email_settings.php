<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- form start -->

<div class="row">
    <?php echo form_open('admin_controller/email_settings_post'); ?>
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('email_settings'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- include message block -->
                <?php
                $message = $this->session->flashdata('submit');
                if (!empty($message) && $message == "email") {
                    $this->load->view('admin/includes/_messages');
                }
                ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('mail_library'); ?></label>
                    <select name="mail_library" class="form-control" onchange="window.location.href = '<?php echo admin_url(); ?>email-settings?library='+this.value;">
                        <option value="swift" <?php echo ($library == "swift") ? "selected" : ""; ?>>Swift Mailer</option>
                        <option value="php" <?php echo ($library == "php") ? "selected" : ""; ?>>PHP Mailer</option>
                        <option value="codeigniter" <?php echo ($library == "codeigniter") ? "selected" : ""; ?>>CodeIgniter Mail</option>
                    </select>
                </div>

				<div class=" form-group">
					<label class="control-label"><?php echo trans('protocol'); ?></label>
					<select name="mail_protocol" class="form-control">
						<option value="smtp" <?php echo ($general_settings->mail_protocol == "smtp") ? "selected" : ""; ?>><?php echo trans('smtp'); ?></option>
						<?php if ($library == "codeigniter"): ?>
							<option value="mail" <?php echo ($general_settings->mail_protocol == "mail") ? "selected" : ""; ?>><?php echo trans('mail'); ?></option>
						<?php endif; ?>
					</select>
				</div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('title'); ?></label>
                    <input type="text" class="form-control" name="mail_title"
                           placeholder="<?php echo trans('title'); ?>" value="<?php echo html_escape($general_settings->mail_title); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('host'); ?></label>
                    <input type="text" class="form-control" name="mail_host"
                           placeholder="<?php echo trans('host'); ?>" value="<?php echo html_escape($general_settings->mail_host); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('port'); ?></label>
                    <input type="text" class="form-control" name="mail_port"
                           placeholder="<?php echo trans('port'); ?>" value="<?php echo html_escape($general_settings->mail_port); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('username'); ?></label>
                    <input type="text" class="form-control" name="mail_username"
                           placeholder="<?php echo trans('username'); ?>" value="<?php echo html_escape($general_settings->mail_username); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('password'); ?></label>
                    <input type="password" class="form-control" name="mail_password"
                           placeholder="<?php echo trans('password'); ?>" value="<?php echo html_escape($general_settings->mail_password); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('email_template'); ?></label>
                    <div class="row m-b-15 m-t-15">
                        <div class="category-block-box" style="width: 320px; height: 320px;margin-left: 15px;">
                            <div class="col-sm-12 text-center m-b-15">
                                <input type="radio" name="block_type" value="block-1" class="square-purple" checked>
                            </div>
                            <img src="<?php echo base_url(); ?>assets/admin/img/email-template-1.png" alt="" class="img-responsive">
                        </div>
                    </div>
                </div>

                <div class="callout" style="max-width: 500px;margin-top: 30px;">
                    <h4><?php echo trans('gmail_smtp'); ?></h4>
                    <p><?php echo trans("gmail_warning"); ?></p>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="email" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->

        </div>
    </div>
    <?php echo form_close(); ?><!-- form end -->

    <?php echo form_open('admin_controller/email_options_post'); ?>
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('email_options'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- include message block -->
                <?php
                if (!empty($message) && $message == "options") {
                    $this->load->view('admin/includes/_messages');
                } ?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans('email_option_contact_messages'); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="send_email_contact_messages" value="1" id="send_email_contact_messages_1" class="square-purple" <?php echo ($general_settings->send_email_contact_messages == '1') ? 'checked' : ''; ?>>
                            <label for="send_email_contact_messages_1" class="option-label"><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="send_email_contact_messages" value="0" id="send_email_contact_messages_2" class="square-purple" <?php echo ($general_settings->send_email_contact_messages == '0') ? 'checked' : ''; ?>>
                            <label for="send_email_contact_messages_2" class="option-label"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('email'); ?> (<?php echo trans("admin_emails_will_send"); ?>)</label>
                    <input type="text" class="form-control" name="mail_options_account"
                           placeholder="<?php echo trans('email'); ?>" value="<?php echo html_escape($general_settings->mail_options_account); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="verification" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?><!-- form end -->

</div>


<style>
    h4 {
        color: #0d6aad;
        font-weight: 600;
        margin-bottom: 15px;
        margin-top: 30px;
    }

    .col-option {
        margin-top: 5px;
    }
</style>
