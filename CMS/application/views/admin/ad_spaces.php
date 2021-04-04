<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo trans('ad_spaces'); ?></h3>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
					<!-- include message block -->
					<?php if (empty($this->session->flashdata("mes_adsense"))):
						$this->load->view('admin/includes/_messages');
					endif; ?>
                    <div class="form-group">
                        <label><?php echo trans('select_ad_spaces'); ?></label>
                        <select class="form-control custom-select" name="parent_id" onchange="window.location.href = '<?php echo admin_url(); ?>'+'ad-spaces?ad_space='+this.value;">
                            <?php foreach ($array_ad_spaces as $key => $value): ?>
                                <option value="<?php echo $key; ?>" <?php echo ($key == $ad_codes->ad_space) ? 'selected' : ''; ?>><?php echo $value; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <?php echo form_open_multipart('admin_controller/ad_spaces_post'); ?>

                    <input type="hidden" name="ad_space" value="<?php echo $ad_codes->ad_space; ?>">

                    <?php if ($ad_codes->ad_space == "sidebar_top" || $ad_codes->ad_space == "sidebar_bottom"): ?>
                        <div class="form-group">
                            <?php if (!empty($array_ad_spaces[$ad_codes->ad_space])): ?>
                                <h4><?php echo trans($ad_codes->ad_space . "_ad_space"); ?></h4>
                            <?php endif; ?>

                            <p><label class="control-label label bg-red">300x250 <?php echo trans('banner'); ?></label></p>
                            <div class="row row-ad-space">
                                <div class="col-sm-6">
                                    <label class="control-label"><?php echo trans('paste_ad_code'); ?></label>
                                    <textarea class="form-control text-area-adspace" name="ad_code_300"
                                              placeholder="<?php echo trans('paste_ad_code'); ?>"><?php echo $ad_codes->ad_code_300; ?></textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label"><?php echo trans('upload_your_banner'); ?></label>
                                    <input type="text" class="form-control" name="url_ad_code_300" placeholder="<?php echo trans('paste_ad_url'); ?>">
                                    <div class="row m-t-15">
                                        <div class="col-sm-12">
                                            <a class='btn bg-olive btn-sm btn-file-upload'>
                                                <?php echo trans('select_image'); ?>
                                                <input type="file" name="file_ad_code_300" size="40"
                                                       accept=".png, .jpg, .jpeg, .gif"
                                                       onchange="$('#upload-file-info2').html($(this).val());">
                                            </a>
                                        </div>
                                    </div>

                                    <span class='label label-info' id="upload-file-info2"></span>
                                </div>
                            </div>

                            <p><label class="control-label label bg-red">234x60 <?php echo trans('banner'); ?></label></p>
                            <div class="row row-ad-space">
                                <div class="col-sm-6">
                                    <label class="control-label"><?php echo trans('paste_ad_code'); ?></label>
                                    <textarea class="form-control text-area-adspace" name="ad_code_234"
                                              placeholder="<?php echo trans('paste_ad_code'); ?>"><?php echo $ad_codes->ad_code_234; ?></textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label"><?php echo trans('upload_your_banner'); ?></label>
                                    <input type="text" class="form-control" name="url_ad_code_234" placeholder="<?php echo trans('paste_ad_url'); ?>">
                                    <div class="row m-t-15">
                                        <div class="col-sm-12">
                                            <a class='btn bg-olive btn-sm btn-file-upload'>
                                                <?php echo trans('select_image'); ?>
                                                <input type="file" name="file_ad_code_234" size="40"
                                                       accept=".png, .jpg, .jpeg, .gif"
                                                       onchange="$('#upload-file-info3').html($(this).val());">
                                            </a>
                                        </div>
                                    </div>

                                    <span class='label label-info' id="upload-file-info3"></span>
                                </div>
                            </div>
                            <div class="row row-ad-space row-button">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                                </div>
                            </div>

                        </div>
                    <?php else: ?>
                        <div class="form-group">
                            <?php if (!empty($array_ad_spaces[$ad_codes->ad_space])): ?>
                                <h4><?php echo trans($ad_codes->ad_space . "_ad_space"); ?></h4>
                            <?php endif; ?>

                            <p><label class="control-label label bg-red">728x90 <?php echo trans('banner'); ?></label></p>
                            <div class="row row-ad-space">
                                <div class="col-sm-6">
                                    <label class="control-label"><?php echo trans('paste_ad_code'); ?></label>
                                    <textarea class="form-control text-area-adspace" name="ad_code_728"
                                              placeholder="<?php echo trans('paste_ad_code'); ?>"><?php echo $ad_codes->ad_code_728; ?></textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label"><?php echo trans('upload_your_banner'); ?></label>
                                    <input type="text" class="form-control" name="url_ad_code_728" placeholder="<?php echo trans('paste_ad_url'); ?>">
                                    <div class="row m-t-15">
                                        <div class="col-sm-12">
                                            <a class='btn bg-olive btn-sm btn-file-upload'>
                                                <?php echo trans('select_image'); ?>
                                                <input type="file" name="file_ad_code_728" size="40"
                                                       accept=".png, .jpg, .jpeg, .gif"
                                                       onchange="$('#upload-file-info1').html($(this).val());">
                                            </a>
                                        </div>
                                    </div>

                                    <span class='label label-info' id="upload-file-info1"></span>
                                </div>
                            </div>

                            <p><label class="control-label label bg-red">468x60 <?php echo trans('banner'); ?></label></p>
                            <div class="row row-ad-space">
                                <div class="col-sm-6">
                                    <label class="control-label"><?php echo trans('paste_ad_code'); ?></label>
                                    <textarea class="form-control text-area-adspace" name="ad_code_468"
                                              placeholder="<?php echo trans('paste_ad_code'); ?>"><?php echo $ad_codes->ad_code_468; ?></textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label"><?php echo trans('upload_your_banner'); ?></label>
                                    <input type="text" class="form-control" name="url_ad_code_468" placeholder="<?php echo trans('paste_ad_url'); ?>">
                                    <div class="row m-t-15">
                                        <div class="col-sm-12">
                                            <a class='btn bg-olive btn-sm btn-file-upload'>
                                                <?php echo trans('select_image'); ?>
                                                <input type="file" name="file_ad_code_468" size="40"
                                                       accept=".png, .jpg, .jpeg, .gif"
                                                       onchange="$('#upload-file-info2').html($(this).val());">
                                            </a>
                                        </div>
                                    </div>

                                    <span class='label label-info' id="upload-file-info2"></span>
                                </div>
                            </div>

                            <p><label class="control-label label bg-red">234x60 <?php echo trans('banner'); ?></label></p>
                            <div class="row row-ad-space">
                                <div class="col-sm-6">
                                    <label class="control-label"><?php echo trans('paste_ad_code'); ?></label>
                                    <textarea class="form-control text-area-adspace" name="ad_code_234"
                                              placeholder="<?php echo trans('paste_ad_code'); ?>"><?php echo $ad_codes->ad_code_234; ?></textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label"><?php echo trans('upload_your_banner'); ?></label>
                                    <input type="text" class="form-control" name="url_ad_code_234" placeholder="<?php echo trans('paste_ad_url'); ?>">
                                    <div class="row m-t-15">
                                        <div class="col-sm-12">
                                            <a class='btn bg-olive btn-sm btn-file-upload'>
                                                <?php echo trans('select_image'); ?>
                                                <input type="file" name="file_ad_code_234" size="40"
                                                       accept=".png, .jpg, .jpeg, .gif"
                                                       onchange="$('#upload-file-info3').html($(this).val());">
                                            </a>
                                        </div>
                                    </div>

                                    <span class='label label-info' id="upload-file-info3"></span>
                                </div>
                            </div>
                            <div class="row row-ad-space row-button">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                                </div>
                            </div>

                        </div>
                    <?php endif; ?>




                    <?php echo form_close(); ?>

                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>

	<div class="row">
		<div class="col-lg-6 col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo trans('google_adsense_code'); ?></h3>
				</div>
				<!-- /.box-header -->

				<!-- form start -->
				<?php echo form_open('admin_controller/google_adsense_code_post'); ?>
				<div class="box-body">
					<!-- include message block -->
					<?php if (!empty($this->session->flashdata("mes_adsense"))):
						$this->load->view('admin/includes/_messages');
					endif; ?>
					<div class="form-group">
						<textarea name="google_adsense_code" class="form-control" placeholder="<?php echo trans('google_adsense_code'); ?>" style="min-height: 140px;"><?php echo $general_settings->google_adsense_code; ?></textarea>
					</div>
				</div>

				<!-- /.box-body -->
				<div class="box-footer">
					<button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
				</div>
				<!-- /.box-footer -->
				<!-- /.box -->
				<?php echo form_close(); ?><!-- form end -->
			</div>
		</div>
	</div>

    <style>
        h4 {
            color: #0d6aad;
            text-align: left;
            font-weight: 600;
            margin-bottom: 15px;
            margin-top: 30px;
        }

        .row-ad-space {
            padding: 15px 0;
            background-color: #f7f7f7;
            margin-bottom: 20px;
        }

        .row-button {
            background-color: transparent !important;
            min-height: 60px;
        }
        textarea{
            resize: vertical;
            min-height: 80px;
        }
    </style>

<?php if ($site_lang->text_direction == "rtl"): ?>

    <style>
        h4 {
            text-align: right;
        }
    </style>
<?php endif; ?>
