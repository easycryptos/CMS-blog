<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
	<div class="box-header with-border">
		<div class="left">
			<h3 class="box-title">
				<?php echo trans('files'); ?>
				<small class="small-title"><?php echo trans("files_exp"); ?></small>
			</h3>
		</div>
	</div><!-- /.box-header -->

	<div class="box-body">
		<div class="form-group m-0">
			<div class="row">
				<div class="col-sm-12">
					<a class='btn btn-sm bg-purple' data-toggle="modal" data-target="#file_manager">
						<?php echo trans('select_file'); ?>
					</a>
				</div>
				<div class="col-sm-12">
					<div class="post-selected-files">
						<?php
						if (!empty($post)):
							$files = get_post_files($post->id);
							if (!empty($files)):
								foreach ($files as $file): ?>
									<div id="post_selected_file_<?php echo $file->post_file_id; ?>" class="item">
										<div class="left">
											<i class="fa fa-file"></i>
										</div>
										<div class="center">
											<span><?php echo $file->file_name; ?></span>
										</div>
										<div class="right">
											<a href="javascript:void(0)" class="btn btn-sm btn-delete-selected-file-database" data-value="<?php echo $file->post_file_id; ?>"><i class="fa fa-times"></i></a></p>
										</div>
									</div>
								<?php endforeach;
							endif;
						endif; ?>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>



