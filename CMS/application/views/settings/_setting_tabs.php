<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="profile-tabs">
    <ul class="nav">
        <li class="nav-item <?php echo ($active_tab == 'update_profile') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?php echo lang_base_url(); ?>settings">
                <span><?php echo trans("update_profile"); ?></span>
            </a>
        </li>
        <li class="nav-item <?php echo ($active_tab == 'social_accounts') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?php echo lang_base_url(); ?>settings/social-accounts">
                <span><?php echo trans("social_accounts"); ?></span>
            </a>
        </li>
        <li class="nav-item <?php echo ($active_tab == 'visual_settings') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?php echo lang_base_url();?>settings/visual-settings">
                <span><?php echo trans("visual_settings"); ?></span>
            </a>
        </li>
        <li class="nav-item <?php echo ($active_tab == 'change_password') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?php echo lang_base_url(); ?>settings/change-password">
                <span><?php echo trans("change_password"); ?></span>
            </a>
        </li>
    </ul>
</div>