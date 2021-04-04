<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--Partial: Popular Posts-->
<div class="widget-title widget-popular-posts-title">
    <h4 class="title"><?php echo html_escape(trans("popular_posts")); ?></h4>
</div>

<div class="col-sm-12 widget-body">
    <div class="row">
        <ul class="widget-list w-popular-list">

            <!--List  popular posts-->
            <?php if (!empty($this->popular_posts)):
                foreach ($this->popular_posts as $item): ?>
                    <li>
                        <div class="left">
                            <a href="<?php echo generate_post_url($item); ?>">
                                <?php $this->load->view("post/_post_image", ['post_item' => $item, 'type' => 'image_small']); ?>
                            </a>
                        </div>
                        <div class="right">
                            <h3 class="title">
                                <a href="<?php echo generate_post_url($item); ?>">
                                    <?php echo html_escape(character_limiter($item->title, 55, '...')); ?>
                                </a>
                            </h3>
                            <?php $this->load->view("post/_post_meta", ['item' => $item]); ?>
                        </div>
                    </li>
                <?php endforeach;
            endif; ?>
        </ul>
    </div>
</div>
