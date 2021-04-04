<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box">
	<div class="box-header with-border">
		<div class="left">
			<h3 class="box-title"><?php echo trans('post_details'); ?></h3>
		</div>
	</div><!-- /.box-header -->

	<div class="box-body">
		<!-- include message block -->
		<?php $this->load->view('admin/includes/_messages'); ?>

		<div class="form-group">
			<label class="control-label"><?php echo trans('title'); ?></label>
			<input type="text" class="form-control" name="title" placeholder="<?php echo trans('title'); ?>"
				   value="<?php echo old('title'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
		</div>

		<div class="form-group">
			<label class="control-label"><?php echo trans('slug'); ?>
				<small>(<?php echo trans('slug_exp'); ?>)</small>
			</label>
			<input type="text" class="form-control" name="title_slug" placeholder="<?php echo trans('slug'); ?>"
				   value="<?php echo old('title_slug'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
		</div>

		<div class="form-group">
			<label class="control-label"><?php echo trans('summary'); ?> & <?php echo trans("description"); ?> (<?php echo trans('meta_tag'); ?>)</label>
			<textarea class="form-control text-area"
					  name="summary" placeholder="<?php echo trans('summary'); ?> & <?php echo trans("description"); ?> (<?php echo trans('meta_tag'); ?>)" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>><?php echo old('summary'); ?></textarea>
		</div>

		<div class="form-group">
			<label class="control-label"><?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)</label>
			<input type="text" class="form-control" name="keywords"
				   placeholder="<?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)" value="<?php echo old('keywords'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
		</div>

		<?php if (is_admin()): ?>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-3 col-xs-12">
						<label><?php echo trans('add_slider'); ?></label>
					</div>
					<div class="col-md-2 col-sm-4 col-xs-12 col-option">
						<input type="checkbox" name="is_slider" value="1" class="square-purple">
					</div>
				</div>
			</div>
		<?php else: ?>
			<input type="hidden" name="is_slider" value="0">
		<?php endif; ?>

		<?php if (is_admin()): ?>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-3 col-xs-12">
						<label><?php echo trans('add_picked'); ?></label>
					</div>
					<div class="col-md-2 col-sm-4 col-xs-12 col-option">
						<input type="checkbox" name="is_picked" value="1" class="square-purple">
					</div>
				</div>
			</div>
		<?php else: ?>
			<input type="hidden" name="is_picked" value="0">
		<?php endif; ?>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-3 col-xs-12">
					<label><?php echo trans('show_only_registered'); ?></label>
				</div>
				<div class="col-md-2 col-sm-4 col-xs-12 col-option">
					<input type="checkbox" name="need_auth" value="1" class="square-purple">
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-12">
					<label class="control-label"><?php echo trans('tags'); ?></label>
					<input id="tags_1" type="text" name="tags" class="form-control tags"/>
					<small>(<?php echo trans('type_tag'); ?>)</small>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-sm-12">
					<label class="control-label"><?php echo trans('optional_url'); ?></label>
					<input type="text" class="form-control"
						   name="optional_url" placeholder="<?php echo trans('optional_url'); ?>"
						   value="<?php echo old('optional_url'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
				</div>
			</div>
		</div>


	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<label class="control-label"><?php echo trans('content'); ?></label>
		<div class="row">
			<div class="col-sm-12 editor-buttons">
				<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#image_file_manager" data-image-type="editor"><i class="fa fa-image"></i>&nbsp;&nbsp;&nbsp;<?php echo trans("add_image"); ?></button>
			</div>
		</div>
		<textarea class="tinyMCE form-control" name="content"><?php echo old('content'); ?></textarea>
	</div>
</div>

