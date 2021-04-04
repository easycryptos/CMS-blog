<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if ($layout == "layout_2" || $layout == "layout_5"): ?>
    <!--Post list item-->
    <div class="post-item-horizontal">
        <div class="item-image">
            <a href="<?php echo generate_category_url($item->parent_category_slug, $item->category_slug); ?>">
                <span class="label-post-category">
					<?php echo html_escape($item->category_name); ?>
                </span>
            </a>
            <a href="<?php echo generate_post_url($item); ?>">
                <?php $this->load->view("post/_post_image", ['post_item' => $item, 'type' => 'image_slider']); ?>
            </a>
        </div>
        <div class="item-content">
            <h3 class="title">
                <a href="<?php echo generate_post_url($item); ?>">
                    <?php echo html_escape(character_limiter($item->title, 55, '...')); ?>
                </a>
            </h3>
            <?php $this->load->view("post/_post_meta", ['item' => $item]); ?>
            <p class="summary">
                <?php echo html_escape(character_limiter($item->summary, 130, '...')); ?>
            </p>
            <div class="post-buttons">
                <a href="<?php echo generate_post_url($item); ?>" class="pull-right read-more">
                    <?php echo html_escape(trans("readmore")); ?>
                    <i class="icon-arrow-right read-more-i" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
<?php elseif ($layout == "layout_3" || $layout == "layout_6"): ?>
    <div class="col-sm-6 col-xs-12 item-boxed-cnt">
        <div class="col-xs-12 post-item-boxed p0">
            <div class="item-image">
                <a href="<?php echo generate_category_url($item->parent_category_slug, $item->category_slug); ?>">
                    <span class="label-post-category">
                   	<?php echo html_escape($item->category_name); ?>
                    </span>
                </a>
                <a href="<?php echo generate_post_url($item); ?>">
                    <?php $this->load->view("post/_post_image", ['post_item' => $item, 'type' => 'image_slider']); ?>
                </a>
            </div>
            <div class="item-content">
                <h3 class="title">
                    <a href="<?php echo generate_post_url($item); ?>">
                        <?php echo html_escape(character_limiter($item->title, 50, '...')); ?>
                    </a>
                </h3>
                <?php $this->load->view("post/_post_meta", ['item' => $item]); ?>
                <p class="summary">
                    <?php echo html_escape(character_limiter($item->summary, 130, '...')); ?>
                </p>
                <div class="post-buttons">
                    <a href="<?php echo generate_post_url($item); ?>" class="pull-right read-more">
                        <?php echo html_escape(trans("readmore")); ?>
                        <i class="icon-arrow-right read-more-i" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="col-sm-12 post-item">
        <div class="row">
            <div class="post-image">
                <a href="<?php echo generate_post_url($item); ?>">
                    <?php $this->load->view("post/_post_image", ['post_item' => $item, 'type' => 'image_mid']); ?>
                </a>
            </div>
            <div class="post-footer">
                <div class="text-center">
                    <p class="default-post-label-category">
                        <a href="<?php echo generate_category_url($item->parent_category_slug, $item->category_slug); ?>">
                            <span class="label-post-category">
                          	<?php echo html_escape($item->category_name); ?>
                            </span>
                        </a>
                    </p>
                    <h3 class="title">
                        <a href="<?php echo generate_post_url($item); ?>">
                            <?php echo html_escape($item->title); ?>
                        </a>
                    </h3>
                    <?php $this->load->view("post/_post_meta", ['item' => $item]); ?>
                </div>
                <p class="summary text-center">
                    <?php echo html_escape($item->summary); ?>
                </p>

                <div class="post-buttons">
                    <a href="<?php echo generate_post_url($item); ?>" class="pull-right read-more">
                        <?php echo html_escape(trans("readmore")); ?>
                        <i class="icon-arrow-right read-more-i" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>