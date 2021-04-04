<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box">
	<div class="box-header with-border">
		<div class="left">
			<h3 class="box-title"><?php echo trans('publish'); ?></h3>
		</div>
	</div><!-- /.box-header -->

	<div class="box-body">
		<div class="form-group">
			<?php if ($post_type == 'video'): ?>
				<button type="submit" name="status" value="1" class="btn btn-primary pull-right"><?php echo trans('add_video'); ?></button>
			<?php else: ?>
				<button type="submit" name="status" value="1" class="btn btn-primary pull-right"><?php echo trans('add_post'); ?></button>
			<?php endif; ?>
			<button type="submit" name="status" value="0" class="btn btn-warning btn-draft pull-right"><?php echo trans('save_draft'); ?></button>
		</div>
	</div>
</div>
