<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Small boxes (Stat box) -->
<div class="row">
	<div class="col-lg-3 col-xs-6">
		<!-- small box -->
		<div class="small-box admin-small-box bg-success">
			<div class="inner">
				<h3 class="increase-count"><?php echo $post_count; ?></h3>
				<a href="<?php echo admin_url(); ?>posts">
					<p><?php echo trans("posts"); ?></p>
				</a>
			</div>
			<div class="icon">
				<a href="<?php echo admin_url(); ?>posts">
					<i class="fa fa-file"></i>
				</a>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-xs-6">
		<!-- small box -->
		<div class="small-box admin-small-box bg-danger">
			<div class="inner">
				<h3 class="increase-count"><?php echo $pending_post_count; ?></h3>
				<a href="<?php echo admin_url(); ?>pending-posts">
					<p><?php echo trans("pending_posts"); ?></p>
				</a>
			</div>
			<div class="icon">
				<a href="<?php echo admin_url(); ?>pending-posts">
					<i class="fa fa-low-vision"></i>
				</a>
			</div>
		</div>
	</div>

	<div class="col-lg-3 col-xs-6">
		<!-- small box -->
		<div class="small-box admin-small-box bg-purple">
			<div class="inner">
				<h3 class="increase-count"><?php echo $draft_count; ?></h3>
				<a href="<?php echo admin_url(); ?>drafts">
					<p><?php echo trans("drafts"); ?></p>
				</a>
			</div>
			<div class="icon">
				<a href="<?php echo admin_url(); ?>drafts">
					<i class="fa fa-file-text-o"></i>
				</a>
			</div>
		</div>
	</div>
	<?php if (is_admin()): ?>
	<div class="col-lg-3 col-xs-6">
		<!-- small box -->
		<div class="small-box admin-small-box bg-warning">
			<div class="inner">
				<h3 class="increase-count"><?php echo $user_count; ?></h3>
				<a href="<?php echo admin_url(); ?>users">
					<p><?php echo trans("users"); ?></p>
				</a>
			</div>
			<div class="icon">
				<a href="<?php echo admin_url(); ?>users">
					<i class="fa fa-users"></i>
				</a>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
<?php if (is_admin()): ?>
	<div class="row">
		<div class="col-sm-12 no-padding">

			<?php if ($this->general_settings->comment_approval_system != 1): ?>
				<div class="col-lg-6 col-sm-12 col-xs-12">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title"><?php echo trans("comments"); ?></h3>
							<br>
							<small><?php echo trans("recently_added_comments"); ?></small>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i
										class="fa fa-minus"></i>
								</button>
								<button type="button" class="btn btn-box-tool" data-widget="remove"><i
										class="fa fa-times"></i>
								</button>
							</div>
						</div><!-- /.box-header -->

						<div class="box-body index-table">
							<div class="table-responsive">
								<table class="table no-margin">
									<thead>
									<tr>
										<th><?php echo trans("id"); ?></th>
										<th><?php echo trans("name"); ?></th>
										<th style="width: 60%"><?php echo trans("comment"); ?></th>
										<th style="min-width: 13%"><?php echo trans("date"); ?></th>
									</tr>
									</thead>
									<tbody>

									<?php foreach ($last_comments as $item): ?>

										<tr>
											<td> <?php echo html_escape($item->id); ?> </td>
											<td>
												<?php echo html_escape($item->name); ?>
											</td>
											<td style="width: 60%" class="break-word">
												<?php echo html_escape($item->comment); ?>
											</td>
											<td class="nowrap"><?php echo formatted_date($item->created_at); ?></td>
										</tr>

									<?php endforeach; ?>

									</tbody>
								</table>
							</div>
							<!-- /.table-responsive -->
						</div>

						<div class="box-footer clearfix">
							<a href="<?php echo admin_url(); ?>comments"
							   class="btn btn-sm btn-default btn-flat pull-right"><?php echo trans("view_all"); ?></a>
						</div>
					</div>
				</div>
			<?php else: ?>
				<div class="col-lg-6 col-sm-12 col-xs-12">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title"><?php echo trans("pending_comments"); ?></h3>
							<br>
							<small><?php echo trans("recently_added_unapproved_comments"); ?></small>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i
										class="fa fa-minus"></i>
								</button>
								<button type="button" class="btn btn-box-tool" data-widget="remove"><i
										class="fa fa-times"></i>
								</button>
							</div>
						</div><!-- /.box-header -->

						<div class="box-body index-table">
							<div class="table-responsive">
								<table class="table no-margin">
									<thead>
									<tr>
										<th><?php echo trans("id"); ?></th>
										<th><?php echo trans("name"); ?></th>
										<th style="width: 60%"><?php echo trans("comment"); ?></th>
										<th style="min-width: 13%"><?php echo trans("date"); ?></th>
									</tr>
									</thead>
									<tbody>

									<?php foreach ($last_pending_comments as $item): ?>

										<tr>
											<td> <?php echo html_escape($item->id); ?> </td>
											<td>
												<?php echo html_escape($item->name); ?>
											</td>
											<td style="width: 60%" class="break-word">
												<?php echo html_escape($item->comment); ?>
											</td>
											<td class="nowrap"><?php echo formatted_date($item->created_at); ?></td>
										</tr>

									<?php endforeach; ?>

									</tbody>
								</table>
							</div>
							<!-- /.table-responsive -->
						</div>

						<div class="box-footer clearfix">
							<a href="<?php echo admin_url(); ?>pending-comments"
							   class="btn btn-sm btn-default btn-flat pull-right"><?php echo trans("view_all"); ?></a>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<div class="col-lg-6 col-sm-12 col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><?php echo trans("contact_messages"); ?></h3>
						<br>
						<small><?php echo trans("recently_added_contact_messages"); ?></small>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i
									class="fa fa-minus"></i>
							</button>
							<button type="button" class="btn btn-box-tool" data-widget="remove"><i
									class="fa fa-times"></i>
							</button>
						</div>
					</div><!-- /.box-header -->

					<div class="box-body index-table">
						<div class="table-responsive">
							<table class="table no-margin">
								<thead>
								<tr>
									<th><?php echo trans("id"); ?></th>
									<th><?php echo trans("name"); ?></th>
									<th style="width: 60%"><?php echo trans("message"); ?></th>
									<th style="min-width: 13%"><?php echo trans("date"); ?></th>
								</tr>
								</thead>
								<tbody>

								<?php foreach ($last_contacts as $item): ?>

									<tr>
										<td>
											<?php echo html_escape($item->id); ?>
										</td>
										<td>
											<?php echo html_escape($item->name); ?>
										</td>
										<td style="width: 60%" class="break-word">
											<?php echo html_escape($item->message); ?>
										</td>
										<td class="nowrap"><?php echo formatted_date($item->created_at); ?></td>
									</tr>

								<?php endforeach; ?>

								</tbody>
							</table>
						</div>
						<!-- /.table-responsive -->
					</div>

					<div class="box-footer clearfix">
						<a href="<?php echo admin_url(); ?>contact-messages"
						   class="btn btn-sm btn-default btn-flat pull-right"><?php echo trans("view_all"); ?></a>
					</div>
				</div>
			</div>

		</div>


	</div>
	<!-- /.row -->

	<div class="row">
		<div class="col-sm-12 no-padding margin-bottom-20">
			<div class="col-lg-6 col-sm-12 col-xs-12">
				<!-- USERS LIST -->
				<div class="box box-danger">
					<div class="box-header with-border">
						<h3 class="box-title"><?php echo trans("users"); ?></h3>
						<br>
						<small><?php echo trans("recently_registered_users"); ?></small>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i
									class="fa fa-minus"></i>
							</button>
							<button type="button" class="btn btn-box-tool" data-widget="remove"><i
									class="fa fa-times"></i>
							</button>
						</div>
					</div>
					<!-- /.box-header -->
					<div class="box-body no-padding">
						<ul class="users-list clearfix">

							<?php foreach ($last_users as $item) : ?>
								<li>
									<a>
                                        <img src="<?php echo get_user_avatar($item); ?>" alt="user" class="img-responsive">
									</a>
									<a class="users-list-name"><?php echo html_escape($item->username); ?></a>
									<span class="users-list-date"><td class="nowrap"><?php echo formatted_date($item->created_at); ?></td></span>
								</li>

							<?php endforeach; ?>

						</ul>
						<!-- /.users-list -->
					</div>
					<!-- /.box-body -->
					<div class="box-footer text-center">
						<a href="<?php echo admin_url(); ?>users" class="btn btn-sm btn-default btn-flat pull-right"><?php echo trans("view_all"); ?></a>
					</div>
					<!-- /.box-footer -->
				</div>
				<!--/.box -->
			</div>
		</div>
	</div>
	<!-- /.row -->
<?php endif; ?>
