<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--Partial: Popular Posts-->
<div class="widget-title widget-popular-posts-title">
	<h4 class="title"><?php echo html_escape(trans("our_picks")); ?></h4>
</div>

<div class="col-sm-12 widget-body">
	<div class="row">
		<ul class="widget-list w-our-picks-list">

			<!--List  popular posts-->
			<?php
			if (!empty($this->our_picks)):
				foreach ($this->our_picks as $item): ?>
					<li>
						<div class="post-image">
							<a href="<?php echo generate_category_url($item->parent_category_slug, $item->category_slug); ?>">
                            <span class="label-post-category">
                                <?php echo html_escape($item->category_name); ?>
                            </span>
							</a>
							<a href="<?php echo generate_post_url($item); ?>">
								<?php $this->load->view("post/_post_image", ['post_item' => $item, 'type' => 'image_mid']); ?>
							</a>
						</div>

						<h3 class="title">
							<a href="<?php echo generate_post_url($item); ?>">
								<?php echo html_escape(character_limiter($item->title, 55, '...')); ?>
							</a>
						</h3>
						<?php $this->load->view("post/_post_meta", ['item' => $item]); ?>

					</li>
				<?php endforeach;
			endif; ?>

		</ul>
	</div>
</div>
