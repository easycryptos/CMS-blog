<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="slider-container">
	<div id="post-details-slider" class="random-slider post-details-slider">
		<?php if (!empty($post->image_big)): ?>
			<div class="home-slider-boxed-item">
				<img src="<?php echo get_post_image($post, 'big'); ?>" alt="<?php echo html_escape($post->title); ?>" class="img-responsive"/>
			</div>
		<?php endif; ?>
		<?php if (!empty($additional_images)):
			foreach ($additional_images as $image):?>
				<!-- slider item -->
				<div class="home-slider-boxed-item">
					<img src="<?php echo base_url() . $image->image_path; ?>" alt="<?php echo html_escape($post->title); ?>" class="img-responsive"/>
				</div>
			<?php endforeach;
		endif; ?>
	</div>
	<div id="post-details-slider-nav" class="slider-nav random-slider-nav">
		<button class="prev"><i class="icon-arrow-left"></i></button>
		<button class="next"><i class="icon-arrow-right"></i></button>
	</div>
</div>
