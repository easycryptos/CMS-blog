<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="widget-title">
	<h4 class="title"><?php echo html_escape(trans("random_posts")); ?></h4>
</div>
<div class="col-sm-12 widget-body">
	<div class="row">
        <?php if (!empty($this->random_posts)):?>
		<div class="slider-container">
			<div class="random-slider-fixer">
				<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAooAAAGxAQMAAADf7wU8AAAAA1BMVEVHcEyC+tLSAAAAAXRSTlMAQObYZgAAADlJREFUGBntwTEBAAAAwiD7p14JT2AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwFOMYwAB7fFpjAAAAABJRU5ErkJggg==" alt="img">
			</div>
			<div class="random-slider-container">
				<div id="random-slider" class="random-slider">
					<?php $count = 0;
						foreach ($this->random_posts as $item) :
							if ($count < 5): ?>
								<!-- slider item -->
								<div class="home-slider-boxed-item">
									<a href="<?php echo generate_post_url($item); ?>">
										<?php $this->load->view("post/_post_image_slider", ['post_item' => $item, 'type' => 'random_slider']); ?>
									</a>
									<div class="item-info redirect-onclik" data-url="<?php echo generate_post_url($item); ?>">
										<a href="<?php echo generate_category_url($item->parent_category_slug, $item->category_slug); ?>">
										<span class="label label-danger label-slider-category">
											<?php echo html_escape($item->category_name); ?>
										</span>
										</a>
										<h3 class="title">
											<a href="<?php echo generate_post_url($item); ?>">
												<?php echo html_escape(character_limiter($item->title, 70, '...')); ?>
											</a>
										</h3>
									</div>
								</div>
							<?php
							endif;
							$count++;
						endforeach; ?>
				</div>
				<div id="random-slider-nav" class="slider-nav random-slider-nav">
					<button class="prev"><i class="icon-arrow-left"></i></button>
					<button class="next"><i class="icon-arrow-right"></i></button>
				</div>
			</div>
		</div>
        <?php endif; ?>
	</div>
</div>
