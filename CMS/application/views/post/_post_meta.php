<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="post-meta">
    <p class="post-meta-inner">
    <span>
        <a href="<?php echo lang_base_url(); ?>profile/<?php echo html_escape($item->user_slug); ?>">
        <?php echo html_escape($item->username); ?>
        </a>
    </span>
        <span>
        <i class="icon-clock"></i>&nbsp;&nbsp;<?php echo helper_date_format($item->created_at); ?>
    </span>
        <?php if ($general_settings->comment_system == 1) : ?>
            <span>
        <i class="icon-comment"></i>&nbsp;
                <?php echo $item->comment_count; ?>
    </span>
        <?php endif; ?>
        <!--Show if enabled-->
        <?php if ($general_settings->show_pageviews == 1) : ?>
            <span>
        <i class="icon-eye"></i>&nbsp;
                <?php echo $item->hit; ?>
    </span>
        <?php endif; ?>
    </p>
</div>