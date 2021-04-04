<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
	<div class="box-header with-border">
		<div class="left">
			<h3 class="box-title"><?php echo $title; ?></h3>
		</div>
		<div class="right">
			<a href="<?php echo $top_button_url; ?>" class="btn btn-success btn-add-new">
				<i class="fa fa-bars"></i>
				<?php echo $top_button_text; ?>
			</a>
		</div>
	</div><!-- /.box-header -->

	<div class="box-body">
		<div class="row">
			<!-- include message block -->
			<div class="col-sm-12">
				<?php $this->load->view('admin/includes/_messages'); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table table-bordered table-striped dataTable" id="cs_datatable" role="grid" aria-describedby="example1_info">
						<thead>
						<tr role="row">
							<th width="20" class="table-no-sort" style="text-align: center !important;"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
							<th width="20"><?php echo trans('id'); ?></th>
							<th><?php echo trans('name'); ?></th>
							<th><?php echo trans('email'); ?></th>
							<th><?php echo trans('comment'); ?></th>
							<th style="min-width: 20%"><?php echo trans('post'); ?></th>
							<th style="min-width: 10%"><?php echo trans('date'); ?></th>
							<th class="max-width-120"><?php echo trans('options'); ?></th>
						</tr>
						</thead>
						<tbody>

						<?php foreach ($comments as $item): ?>
							<tr>
								<td style="text-align: center !important;"><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?php echo $item->id; ?>"></td>
								<td><?php echo html_escape($item->id); ?></td>
								<td><?php echo html_escape($item->name); ?></td>
								<td><?php echo html_escape($item->email); ?></td>
								<td class="break-word"><?php echo html_escape($item->comment); ?></td>
								<td>
									<?php $post = $this->post_model->get_post_by_id($item->post_id);
									if (!empty($post)):?>
										<a href="<?php echo generate_post_url($post); ?>" target="_blank"><?php echo html_escape($post->title); ?></a>
									<?php endif; ?>
								</td>
								<td class="nowrap"><?php echo formatted_date($item->created_at); ?></td>
								<td>
									<?php echo form_open('admin_controller/approve_comment_post'); ?>
									<input type="hidden" name="id" value="<?php echo $item->id; ?>">
									<div class="dropdown">
										<button class="btn bg-purple dropdown-toggle btn-select-option"
												type="button"
												data-toggle="dropdown"><?php echo trans('select_option'); ?>
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu options-dropdown">
											<?php if ($item->status != 1): ?>
												<li>
													<button type="submit"><i class="fa fa-check option-icon"></i><?php echo trans("approve"); ?></button>
												</li>
											<?php endif; ?>
											<li>
												<a href="javascript:void(0)" onclick="delete_item('admin_controller/delete_comment_post','<?php echo $item->id; ?>','<?php echo trans("confirm_comment"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
											</li>
										</ul>
									</div>
									<?php echo form_close(); ?><!-- form end -->
								</td>
							</tr>

						<?php endforeach; ?>

						</tbody>
					</table>
				</div>

				<div class="col-sm-12">
					<div class="row">
						<div class="pull-left">
							<button class="btn btn-sm btn-danger btn-table-delete" onclick="delete_selected_comments('<?php echo trans("confirm_comments"); ?>');"><?php echo trans('delete'); ?></button>
							<?php if ($show_approve_button == true): ?>
								<button class="btn btn-sm btn-success btn-table-delete" onclick="approve_selected_comments();"><?php echo trans('approve'); ?></button>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- /.box-body -->
</div>
