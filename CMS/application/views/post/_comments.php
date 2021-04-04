<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<input type="hidden" value="<?php echo $comment_limit; ?>" id="post_comment_limit">
<div class="row">
	<div class="col-sm-12">
		<div class="comments">
			<?php if ($comment_count > 0): ?>
				<div class="row-custom comment-total">
					<label class="label-comment"><?php echo trans("comments"); ?> (<?php echo $comment_count; ?>)</label>
				</div>
			<?php endif; ?>
			<ul class="comment-list">
				<?php foreach ($comments as $comment):
					$comment_user = null;
					if (!empty($comment->user_id)) {
						$comment_user = get_user($comment->user_id);
					} ?>
					<li>
						<div class="left">
							<?php if (!empty($comment_user)): ?>
								<a href="<?php echo generate_profile_url($comment_user); ?>">
									<img src="<?php echo get_user_avatar_by_id($comment->user_id); ?>" alt="<?php echo html_escape($comment->name); ?>">
								</a>
							<?php else: ?>
								<img src="<?php echo get_user_avatar_by_id($comment->user_id); ?>" alt="<?php echo html_escape($comment->name); ?>">
							<?php endif; ?>
						</div>
						<div class="right">
							<div class="row-custom">
								<?php if (!empty($comment_user)): ?>
									<a href="<?php echo generate_profile_url($comment_user); ?>">
										<span class="username"><?php echo html_escape($comment->name); ?></span>
									</a>
								<?php else: ?>
									<span class="username"><?php echo html_escape($comment->name); ?></span>
								<?php endif; ?>
							</div>
							<div class="row-custom comment">
								<?php echo html_escape($comment->comment); ?>
							</div>
							<div class="row-custom">
								<span class="date"><?php echo time_ago($comment->created_at); ?></span>
								<a href="javascript:void(0)" class="btn-reply" onclick="show_comment_box('<?php echo $comment->id; ?>');"><i class="icon-reply"></i> <?php echo trans('reply'); ?></a>
								<?php if ($this->auth_check):
									if ($comment->user_id == $this->auth_user->id || $this->auth_user->role == "admin"): ?>
										<a href="javascript:void(0)" class="btn-delete-comment" onclick="delete_comment('<?php echo $comment->id; ?>','<?php echo $post->id; ?>','<?php echo trans("confirm_comment"); ?>');"><?php echo trans("delete"); ?></a>
									<?php endif;
								endif; ?>
							</div>
							<div id="sub_comment_form_<?php echo $comment->id; ?>" class="row-custom row-sub-comment visible-sub-comment">
							</div>
							<div class="row-custom row-sub-comment">
								<!-- include subcomments -->
								<?php $this->load->view('post/_subcomments', ['parent_comment' => $comment]); ?>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>

	<?php if ($comment_count > $comment_limit): ?>
		<div id="load_comment_spinner" class="col-sm-12 load-more-spinner">
			<div class="row">
				<div class="spinner">
					<div class="bounce1"></div>
					<div class="bounce2"></div>
					<div class="bounce3"></div>
				</div>
			</div>
		</div>

		<div class="col-sm-12">
			<button type="button" class="btn-load-more" onclick="load_more_comment('<?php echo $post->id; ?>');">
				<?php echo trans("load_more_comments"); ?>
			</button>
		</div>
	<?php endif; ?>
</div>
