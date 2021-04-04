<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Modal -->
<div id="image_file_manager" class="modal fade modal-file-manager" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><?php echo trans('images'); ?></h4>
				<div class="file-manager-search">
					<input type="text" id="input_search_image" class="form-control" placeholder="<?php echo trans("search"); ?>">
				</div>
			</div>
			<div class="modal-body">
				<div class="file-manager">
					<div class="file-manager-left">

						<div class="dm-uploader-container">
							<div id="drag-and-drop-zone-image" class="dm-uploader text-center">
                                <p class="file-manager-file-types">
                                    <span>JPG</span>
                                    <span>JPEG</span>
                                    <span>PNG</span>
                                    <span>GIF</span>
                                </p>
								<p class="dm-upload-icon">
									<i class="fa fa-cloud-upload"></i>
								</p>
								<p class="dm-upload-text"><?php echo trans("drag_drop_files_here"); ?></p>
								<p class="text-center">
									<button class="btn btn-default btn-browse-files"><?php echo trans('browse_files'); ?></button>
								</p>

								<a class='btn btn-md dm-btn-select-files'>
									<input type="file" name="file" size="40" multiple="multiple">
								</a>
								<ul class="dm-uploaded-files" id="files-image"></ul>
							</div>
						</div>

					</div>

					<div class="file-manager-right">
						<div class="file-manager-content">
							<div class="col-sm-12">
								<div class="row">
									<div id="image_file_upload_response">
										<?php foreach ($images as $image): ?>
											<div class="col-file-manager" id="img_col_id_<?php echo $image->id; ?>">
												<div class="file-box" data-file-id="<?php echo $image->id; ?>" data-file-path="<?php echo $image->image_mid; ?>" data-file-path-editor="<?php echo $image->image_big; ?>">
													<div class="image-container">
														<img src="<?php echo base_url() . $image->image_slider; ?>" alt="" class="img-responsive">
													</div>
													<?php if (!empty($image->file_name)): ?>
														<span class="file-name"><?php echo limit_character($image->file_name . "." . $image->image_mime, 25, '..'); ?></span>
													<?php endif; ?>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<input type="hidden" id="selected_img_file_id">
					<input type="hidden" id="selected_img_file_path">
				</div>
			</div>

			<div class="modal-footer">
				<div class="file-manager-footer">
					<button type="button" id="btn_img_delete" class="btn btn-danger pull-left btn-file-delete"><i class="fa fa-trash"></i>&nbsp;&nbsp;<?php echo trans('delete'); ?></button>
					<button type="button" id="btn_img_select" class="btn bg-olive btn-file-select"><i class="fa fa-check"></i>&nbsp;&nbsp;<?php echo trans('select_image'); ?></button>
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo trans('close'); ?></button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- File item template -->
<script type="text/html" id="files-template-image">
	<li class="media">
		<img class="preview-img" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="bg">
		<div class="media-body">
			<div class="progress">
				<div class="dm-progress-waiting"><?php echo trans("waiting"); ?></div>
				<div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
		</div>
	</li>
</script>

<script>
    var txt_processing = "<?php echo trans("txt_processing"); ?>";
    $(function () {
        $('#drag-and-drop-zone-image').dmUploader({
            url: '<?php echo base_url(); ?>file_controller/upload_image_file',
            queue: true,
            allowedTypes: 'image/*',
            extFilter: ["jpg", "jpeg", "png", "gif"],
            extraData: function (id) {
                return {
                    "file_id": id,
                    "<?php echo $this->security->get_csrf_token_name(); ?>": $.cookie(csfr_cookie_name)
                };
            },
            onDragEnter: function () {
                this.addClass('active');
            },
            onDragLeave: function () {
                this.removeClass('active');
            },
            onInit: function () {
            },
            onComplete: function (id) {
            },
            onNewFile: function (id, file) {
                ui_multi_add_file(id, file, "image");
                if (typeof FileReader !== "undefined") {
                    var reader = new FileReader();
                    var img = $('#uploaderFile' + id).find('img');

                    reader.onload = function (e) {
                        img.attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            },
            onBeforeUpload: function (id) {
                $('#uploaderFile' + id + ' .dm-progress-waiting').hide();
                ui_multi_update_file_progress(id, 0, '', true);
                ui_multi_update_file_status(id, 'uploading', 'Uploading...');
            },
            onUploadProgress: function (id, percent) {
                ui_multi_update_file_progress(id, percent);
            },
            onUploadSuccess: function (id, data) {
                document.getElementById("uploaderFile" + id).remove();
                refresh_images();
                ui_multi_update_file_status(id, 'success', 'Upload Complete');
                ui_multi_update_file_progress(id, 100, 'success', false);
            },
            onUploadError: function (id, xhr, status, message) {
                if (message == "Not Acceptable") {
                    $("#uploaderFile" + id).remove();
                    $(".error-message-img-upload").show();
                    $(".error-message-img-upload p").html("");
                    setTimeout(function () {
                        $(".error-message-img-upload").fadeOut("slow");
                    }, 4000)
                }
            },
            onFallbackMode: function () {
            },
            onFileSizeError: function (file) {
            },
            onFileTypeError: function (file) {
            },
            onFileExtError: function (file) {
            },
        });
    });
</script>
