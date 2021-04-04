<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Section: main -->
<section id="main">
    <div class="container">
        <div class="row">
            <!-- breadcrumb -->
            <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                    <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>settings"><?php echo trans("settings"); ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
                </ol>
            </div>

            <div class="page-content">
                <div class="col-sm-12">
                    <h1 class="page-title"><?php echo trans("settings"); ?></h1>
                </div>
                <div class="col-sm-12 col-md-3">
                    <!-- load profile nav -->
                    <?php $this->load->view("settings/_setting_tabs"); ?>
                </div>
                <div class="col-sm-12 col-md-9">
                    <div class="profile-tab-content">
                        <!-- include message block -->
                        <?php $this->load->view('partials/_messages'); ?>

                        <?php echo form_open_multipart("profile_controller/update_profile_post", ['id' => 'form_validate']); ?>
                        <div class="form-group">
                            <div class="row m-b-10">
                                <div class="col-sm-12">
                                    <img src="<?php echo get_user_avatar($user); ?>" alt="<?php echo $user->username; ?>" class="form-avatar">
                                </div>
                            </div>
                            <div class="row m-b-10">
                                <div class="col-sm-12">
                                    <a class='btn btn-md btn-info btn-file-upload btn-profile-file-upload'>
                                        <?php echo trans('select_image'); ?>
                                        <input type="file" name="file" size="40" accept=".png, .jpg, .jpeg, .gif" onchange="$('#upload-file-info').html($(this).val().replace(/.*[\/\\]/, '..'));">
                                    </a>
                                </div>
                            </div>
                            <p class='label label-info' id="upload-file-info"></p>
                        </div>

                        <div class="form-group m-t-30">
                            <label><?php echo trans("email"); ?></label>
                            <input type="email" name="email" class="form-control form-input" value="<?php echo html_escape($user->email); ?>" placeholder="<?php echo trans("email_address"); ?>" required>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans("username"); ?></label>
                            <input type="text" name="username" class="form-control form-input" value="<?php echo html_escape($user->username); ?>" placeholder="<?php echo trans("username"); ?>" maxlength="<?php echo $this->username_character_limit; ?>" required>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans("slug"); ?></label>
                            <input type="text" name="slug" class="form-control form-input" value="<?php echo html_escape($user->slug); ?>" placeholder="<?php echo trans("slug"); ?>" required>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans("about_me"); ?></label>
                            <textarea name="about_me" class="form-control form-textarea" placeholder="<?php echo trans("about_me"); ?>"><?php echo html_escape($user->about_me); ?></textarea>
                        </div>
						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<label><?php echo trans('show_email_on_profile'); ?></label>
								</div>
								<div class="col-md-4 col-sm-4 col-option">
									<label class="custom-checkbox custom-radio">
										<input type="radio" name="show_email_on_profile" value="1" <?php echo ($user->show_email_on_profile == 1) ? 'checked' : ''; ?> required>
										<span class="checkbox-icon"><i class="icon-check"></i></span>
										<span><?php echo trans("yes"); ?></span>
									</label>
								</div>
								<div class="col-md-4 col-sm-4 col-option">
									<label class="custom-checkbox custom-radio">
										<input type="radio" name="show_email_on_profile" value="0" <?php echo ($user->show_email_on_profile == 0) ? 'checked' : ''; ?> required>
										<span class="checkbox-icon"><i class="icon-check"></i></span>
										<span><?php echo trans("no"); ?></span>
									</label>
								</div>
							</div>
						</div>

                        <button type="submit" name="submit" value="update" class="btn btn-md btn-custom"><?php echo trans("save_changes") ?></button>
                        <?php echo form_close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.Section: main -->
