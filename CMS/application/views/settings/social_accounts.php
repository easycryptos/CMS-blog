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

                        <?php echo form_open("profile_controller/social_accounts_post"); ?>

                        <div class="form-group">
                            <label class="control-label">Facebook <?php echo trans('url'); ?></label>
                            <input type="text" class="form-control form-input" name="facebook_url"
                                   placeholder="Facebook <?php echo trans('url'); ?>" value="<?php echo html_escape($user->facebook_url); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Twitter <?php echo trans('url'); ?></label>
                            <input type="text" class="form-control form-input"
                                   name="twitter_url" placeholder="Twitter <?php echo trans('url'); ?>"
                                   value="<?php echo html_escape($user->twitter_url); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Instagram <?php echo trans('url'); ?></label>
                            <input type="text" class="form-control form-input" name="instagram_url" placeholder="Instagram <?php echo trans('url'); ?>"
                                   value="<?php echo html_escape($user->instagram_url); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Pinterest <?php echo trans('url'); ?></label>
                            <input type="text" class="form-control form-input" name="pinterest_url" placeholder="Pinterest <?php echo trans('url'); ?>"
                                   value="<?php echo html_escape($user->pinterest_url); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Linkedin <?php echo trans('url'); ?></label>
                            <input type="text" class="form-control form-input" name="linkedin_url" placeholder="Linkedin <?php echo trans('url'); ?>"
                                   value="<?php echo html_escape($user->linkedin_url); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>

                        <div class="form-group">
                            <label class="control-label">VK <?php echo trans('url'); ?></label>
                            <input type="text" class="form-control form-input" name="vk_url"
                                   placeholder="VK <?php echo trans('url'); ?>" value="<?php echo html_escape($user->vk_url); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Telegram <?php echo trans('url'); ?></label>
                            <input type="text" class="form-control form-input" name="telegram_url"
                                   placeholder="Telegram <?php echo trans('url'); ?>"
                                   value="<?php echo html_escape($user->telegram_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Youtube <?php echo trans('url'); ?></label>
                            <input type="text" class="form-control form-input" name="youtube_url"
                                   placeholder="Youtube <?php echo trans('url'); ?>" value="<?php echo html_escape($user->youtube_url); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>

                        <button type="submit" class="btn btn-md btn-custom"><?php echo trans("save_changes") ?></button>
                        <?php echo form_close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.Section: main -->
