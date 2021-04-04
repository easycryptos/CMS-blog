<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if ($this->auth_check): ?>
	<div class="sub-comment-form-registered">
		<div class="row">
			<div class="col-sm-12">
				<form id="make_subcomment_registered_<?php echo $parent_comment->post_id; ?>">
					<div class="form-group">
						<textarea name="comment" class="form-control form-input form-textarea form-comment-text" maxlength="4999" placeholder="<?php echo trans("leave_your_comment"); ?>"></textarea>
					</div>
					<input type="hidden" name="parent_id" value="<?php echo $parent_comment->id; ?>">
					<input type="hidden" name="post_id" value="<?php echo $parent_comment->post_id; ?>">
					<input type="hidden" name="limit" value="<?php echo $comment_limit; ?>">
					<button type="button" class="btn btn-sm btn-custom btn-subcomment-registered" data-comment-id="<?php echo $parent_comment->post_id; ?>"><?php echo trans("post_comment"); ?></button>
				</form>
				<div id="message-subcomment-result-<?php echo $parent_comment->post_id; ?>"></div>
			</div>
		</div>
	</div>
<?php else: ?>
	<div class="sub-comment-form">
		<div class="row">
			<div class="col-sm-12">
				<form id="make_subcomment_<?php echo $parent_comment->post_id; ?>">
					<div class="form-row">
						<div class="row">
							<div class="form-group col-md-6">
								<label><?php echo trans("name"); ?></label>
								<input type="text" name="name" class="form-control form-input form-comment-name" maxlength="40" placeholder="<?php echo trans("name"); ?>">
							</div>
							<div class="form-group col-md-6">
								<label><?php echo trans("email"); ?></label>
								<input type="email" name="email" class="form-control form-input form-comment-email" maxlength="100" placeholder="<?php echo trans("email"); ?>">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label><?php echo trans("comment"); ?></label>
						<textarea name="comment" class="form-control form-input form-textarea form-comment-text" maxlength="4999" placeholder="<?php echo trans("leave_your_comment"); ?>"></textarea>
					</div>
					<?php generate_recaptcha(); ?>
					<input type="hidden" name="limit" value="<?php echo $comment_limit; ?>">
					<input type="hidden" name="parent_id" value="<?php echo $parent_comment->id; ?>">
					<input type="hidden" name="post_id" value="<?php echo $parent_comment->post_id; ?>">
					<button type="button" class="btn btn-sm btn-custom btn-subcomment" data-comment-id="<?php echo $parent_comment->post_id; ?>"><?php echo trans("post_comment"); ?></button>
				</form>
				<div id="message-subcomment-result-<?php echo $parent_comment->post_id; ?>"></div>
			</div>
		</div>
	</div>
<?php endif; ?>


