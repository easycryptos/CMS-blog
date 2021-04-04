<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="slider-container">
	<div class="container-fluid">
		<div class="row">
			<div class="home-slider-fixer">
				<div class="col-sl">
					<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAooAAAGxAQMAAADf7wU8AAAAA1BMVEVHcEyC+tLSAAAAAXRSTlMAQObYZgAAADlJREFUGBntwTEBAAAAwiD7p14JT2AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAwFOMYwAB7fFpjAAAAABJRU5ErkJggg==" alt="img">
				</div>
				<div class="col-sl col-sl-2"></div>
				<div class="col-sl col-sl-3"></div>
				<div class="col-sl col-sl-4"></div>
			</div>
		</div>
	</div>

	<div class="home-slider-container">
		<div id="home-slider" class="home-slider">
			<?php if (!empty($this->slider_posts)): $i=0;
				foreach ($this->slider_posts as $item) : ?>
					<!-- slider item -->
					<div class="home-slider-item dd<?php echo $i; ?>">
						<a href="<?php echo generate_post_url($item); ?>">
							<?php $this->load->view("post/_post_image_slider", ['post_item' => $item, 'type' => 'home_slider']); ?>
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
				<?php $i++; endforeach;
			endif; ?>
		</div>
		<div id="home-slider-nav" class="slider-nav">
			<button class="prev"><i class="icon-arrow-left"></i></button>
			<button class="next"><i class="icon-arrow-right"></i></button>
		</div>
	</div>
</div>
