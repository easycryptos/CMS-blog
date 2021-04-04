<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if (isset($post_item)):
	if ($type == 'image_slider') {
		$img_url = get_post_image($post_item, 'slider');
		$bg = base_url() . "assets/img/bg_slider.png";
		$icon = "post-icon-md";
	} elseif ($type == 'image_small') {
		$img_url = get_post_image($post_item, 'small');
		$bg = base_url() . "assets/img/bg_small.png";
		$icon = "post-icon-sm";
	} else {
		$img_url = get_post_image($post_item, 'mid');
		$bg = base_url() . "assets/img/bg_mid.png";
		$icon = "post-icon-md";
	}
	if (!empty($post_item->image_url) || $post_item->image_mime == 'gif' || $post_item->post_type == 'video'):?>
		<div class="external-image-container">
			<?php if ($post_item->post_type == 'video'): ?>
				<img src="<?php echo base_url(); ?>assets/img/icon_play.svg" alt="icon" class="post-icon <?php echo $icon; ?>"/>
			<?php endif; ?>
			<img src="<?php echo $bg; ?>" class="img-responsive" alt="<?php echo html_escape($post_item->title); ?>">
			<img src="<?php echo $bg; ?>" data-src="<?php echo $img_url; ?>" alt="<?php echo html_escape($post_item->title); ?>" class="lazyload img-external" onerror='<?php echo $bg; ?>'>
		</div>
	<?php else: ?>
		<img src="<?php echo $bg; ?>" data-src="<?php echo $img_url; ?>" class="lazyload img-responsive" alt="<?php echo html_escape($post_item->title); ?>" onerror="javascript:this.src='<?php echo $bg; ?>'">
	<?php endif;
endif; ?>
