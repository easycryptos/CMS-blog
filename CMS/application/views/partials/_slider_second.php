<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="slider-container">
	<div class="home-slider-boxed-container">
		<div class="home-slider-boxed-fixer">
			<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAu4AAAGfAQMAAAA6RcVwAAAAA1BMVEVHcEyC+tLSAAAAAXRSTlMAQObYZgAAADxJREFUGBntwQENAAAAwiD7p34PBwwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA4E2aAQABq8lSAgAAAABJRU5ErkJggg==" class="img-responsive" alt="img">
		</div>
		<div id="home-slider-boxed" class="home-slider-boxed">
			<?php if (!empty($this->slider_posts)):
				foreach ($this->slider_posts as $item) : ?>
					<!-- slider item -->
					<div class="home-slider-boxed-item">
						<a href="<?php echo generate_post_url($item); ?>">
							<?php $this->load->view("post/_post_image_slider", ['post_item' => $item, 'type' => 'home_slider_second']); ?>
						</a>
						<div class="item-info redirect-onclik" data-url="<?php echo generate_post_url($item); ?>">
							<a href="<?php echo generate_category_url($item->parent_category_slug, $item->category_slug); ?>">
							<span class="label label-danger label-slider-category">
								<?php echo html_escape($item->category_name); ?>
							</span>
							</a>
							<h2 class="title">
								<a href="<?php echo generate_post_url($item); ?>">
									<?php echo html_escape(character_limiter($item->title, 70, '...')); ?>
								</a>
							</h2>
							<?php $this->load->view("post/_post_meta", ['item' => $item]); ?>
						</div>
					</div>
				<?php endforeach;
			endif; ?>
		</div>
		<div id="home-slider-boxed-nav" class="slider-nav">
			<button class="prev"><i class="icon-arrow-left"></i></button>
			<button class="next"><i class="icon-arrow-right"></i></button>
		</div>
	</div>
</div>
