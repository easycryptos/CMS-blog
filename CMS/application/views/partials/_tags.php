<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--Partial: Tags-->
<div class="widget-title">
    <h4 class="title"><?php echo html_escape(trans("tags")); ?></h4>
</div>
<div class="col-sm-12 widget-body">
    <div class="row">
        <ul class="widget-list w-tag-list">
            <!--List  tags-->
            <?php foreach ($this->tags as $item): ?>
                <li>
                    <a href="<?php echo lang_base_url() . 'tag/' . html_escape($item->tag_slug); ?>">
                        <?php echo html_escape($item->tag); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>