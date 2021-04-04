<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if (isset($post_item)):
	$post_image_url = "";
	$post_image_bg = base_url() . "assets/img/bg_slider.png";
	$video_icon_class = "post-icon-lg";
	if ($type == 'home_slider') {
		$post_image_url = get_post_image($post_item, 'slider');
	} elseif ($type == 'home_slider_second') {
		$post_image_url = get_post_image($post_item, 'mid');
		$post_image_bg = base_url() . "assets/img/bg_mid.png";
	} elseif ($type == 'random_slider') {
		$post_image_url = get_post_image($post_item, 'slider');
		$video_icon_class = "post-icon-md";
	}
	if (!empty($post_item->image_url) || $post_item->image_mime == 'gif' || $post_item->post_type == 'video'):?>
		<div class="external-image-container">
			<?php if ($post_item->post_type == 'video'): ?>
				<img src="<?php echo base_url(); ?>assets/img/icon_play.svg" alt="icon" class="post-icon <?php echo $video_icon_class; ?>"/>
			<?php endif; ?>
			<img src="<?php echo $post_image_bg; ?>" class="img-responsive" alt="fixer">
			<img src="<?php echo $post_image_bg; ?>" data-lazy="<?php echo $post_image_url; ?>" class="img-responsive img-slider img-external" alt="<?php echo html_escape($post_item->title); ?>">
		</div>
	<?php else: ?>
		<img src="<?php echo $post_image_bg; ?>" class="img-responsive" alt="fixer">
		<img src="<?php echo $post_image_bg; ?>" data-lazy="<?php echo $post_image_url; ?>" class="img-responsive img-slider img-external" alt="<?php echo html_escape($post_item->title); ?>">
	<?php endif;
endif; ?>