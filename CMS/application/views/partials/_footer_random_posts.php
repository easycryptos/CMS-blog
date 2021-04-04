<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--Partial: Footer Random Posts-->
<div class="footer-widget f-widget-random">
    <div class="col-sm-12">
        <div class="row">
            <h4 class="title"><?php echo html_escape(trans("random_posts")); ?></h4>
            <div class="title-line"></div>
            <ul class="f-random-list">

                <!--List random posts-->
                <?php
                $count = 0;
                if (!empty($this->random_posts)):
                    foreach (array_reverse($this->random_posts) as $item):
                        if ($count < 3):?>
                            <li>
                                <div class="left">
                                    <a href="<?php echo lang_base_url() . html_escape($item->title_slug); ?>">
                                        <?php $this->load->view("post/_post_image", ['post_item' => $item, 'type' => 'image_small']); ?>
                                    </a>
                                </div>
                                <div class="right">
                                    <h5 class="title">
                                        <a href="<?php echo lang_base_url() . html_escape($item->title_slug); ?>">
                                            <?php echo html_escape(character_limiter($item->title, 55, '...')); ?>
                                        </a>
                                    </h5>
                                </div>
                            </li>
                        <?php endif;
                        $count++;
                    endforeach;
                endif; ?>

            </ul>
        </div>
    </div>
</div>
