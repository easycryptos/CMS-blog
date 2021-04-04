<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if ($this->auth_check): ?>
	<form id="make_comment_registered">
		<input type="hidden" name="parent_id" value="0">
		<input type="hidden" name="post_id" value="<?php echo $post->id; ?>">
		<div class="form-group">
			<textarea name="comment" class="form-control form-input form-textarea" placeholder="<?php echo trans("leave_your_comment"); ?>"></textarea>
		</div>
		<button type="submit" class="btn btn-md btn-custom"><?php echo trans("post_comment"); ?></button>
		<div id="message-comment-result" class="message-comment-result"></div>
	</form>
<?php else: ?>
	<form id="make_comment">
		<input type="hidden" name="parent_id" value="0">
		<input type="hidden" name="post_id" value="<?php echo $post->id; ?>">
		<div class="form-row">
			<div class="row">
				<div class="form-group col-md-6">
					<label><?php echo trans("name"); ?></label>
					<input type="text" name="name" class="form-control form-input" maxlength="40" placeholder="<?php echo trans("name"); ?>">
				</div>
				<div class="form-group col-md-6">
					<label><?php echo trans("email"); ?></label>
					<input type="email" name="email" class="form-control form-input" maxlength="100" placeholder="<?php echo trans("email"); ?>">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label><?php echo trans("comment"); ?></label>
			<textarea name="comment" class="form-control form-input form-textarea" maxlength="4999" placeholder="<?php echo trans("leave_your_comment"); ?>"></textarea>
		</div>
		<?php generate_recaptcha(); ?>
		<button type="submit" class="btn btn-md btn-custom"><?php echo trans("post_comment"); ?></button>
		<div id="message-comment-result" class="message-comment-result"></div>
	</form>
<?php endif; ?>
