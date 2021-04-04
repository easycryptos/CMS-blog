<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!--user profile info-->
<div class="profile-details">
    <div class="left">
        <img src="<?php echo get_user_avatar($user); ?>" alt="<?php echo html_escape($user->username); ?>" class="img-profile">
    </div>
    <div class="right">
        <div class="row-custom">
            <h1 class="username"><?php echo html_escape($user->username); ?></h1>
        </div>
        <div class="row-custom">
            <p class="p-last-seen">
                <span class="last-seen <?php echo (is_user_online($user->last_seen)) ? 'last-seen-online' : ''; ?>"> <i class="icon-circle"></i> <?php echo trans("last_seen"); ?>&nbsp;<?php echo time_ago($user->last_seen); ?></span>
            </p>
        </div>

        <div class="row-custom">
            <p class="description">
                <?php echo html_escape($user->about_me); ?>
            </p>
        </div>

        <div class="row-custom user-contact">
            <span class="info"><?php echo trans("member_since"); ?>&nbsp;<?php echo helper_date_format($user->created_at); ?></span>
            <?php if ($user->show_email_on_profile): ?>
                <span class="info"><i class="icon-envelope"></i><?php echo html_escape($user->email); ?></span>
            <?php endif; ?>
        </div>

        <div class="row-custom profile-buttons">
            <?php if ($this->auth_check): ?>
                <?php if ($this->auth_user->id != $user->id): ?>
                    <!--form follow-->
                    <?php echo form_open('profile_controller/follow_unfollow_user', ['class' => 'form-inline']); ?>
                    <input type="hidden" name="following_id" value="<?php echo $user->id; ?>">
                    <?php if (is_user_follows($user->id, $this->auth_user->id)): ?>
                        <button class="btn btn-md btn-custom btn-follow"><i class="icon-user-plus"></i><?php echo trans("unfollow"); ?></button>
                    <?php else: ?>
                        <button class="btn btn-md btn-custom btn-follow"><i class="icon-user-plus"></i><?php echo trans("follow"); ?></button>
                    <?php endif; ?>
                    <?php echo form_close(); ?>
                <?php endif; ?>
            <?php else: ?>
                <a href="<?php echo lang_base_url(); ?>login" class="btn btn-md btn-custom btn-follow"><i class="icon-user-plus"></i><?php echo trans("follow"); ?></a>
            <?php endif; ?>
            <div class="social">
                <ul>
                    <?php if (!empty($user->facebook_url)): ?>
                        <li><a href="<?php echo $user->facebook_url; ?>" target="_blank"><i class="icon-facebook"></i></a></li>
                    <?php endif;
                    if (!empty($user->twitter_url)): ?>
                        <li><a href="<?php echo $user->twitter_url; ?>" target="_blank"><i class="icon-twitter"></i></a></li>
                    <?php endif;
                    if (!empty($user->instagram_url)): ?>
                        <li><a href="<?php echo $user->instagram_url; ?>" target="_blank"><i class="icon-instagram"></i></a></li>
                    <?php endif;
                    if (!empty($user->pinterest_url)): ?>
                        <li><a href="<?php echo $user->pinterest_url; ?>" target="_blank"><i class="icon-pinterest"></i></a></li>
                    <?php endif;
                    if (!empty($user->linkedin_url)): ?>
                        <li><a href="<?php echo $user->linkedin_url; ?>" target="_blank"><i class="icon-linkedin"></i></a></li>
                    <?php endif;
                    if (!empty($user->vk_url)): ?>
                        <li><a href="<?php echo $user->vk_url; ?>" target="_blank"><i class="icon-vk"></i></a></li>
                    <?php endif;
                    if (!empty($user->telegram_url)): ?>
                        <li><a href="<?php echo $user->telegram_url; ?>" target="_blank"><i class="icon-telegram"></i></a></li>
                    <?php endif;
                    if (!empty($user->youtube_url)): ?>
                        <li><a href="<?php echo $user->youtube_url; ?>" target="_blank"><i class="icon-youtube"></i></a></li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </div>
</div>
