<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo trans('video'); ?></h3>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="form-group">
            <label class="control-label"><?php echo trans('video_url'); ?><br>
                <small>(Youtube, Vimeo, Dailymotion, Facebook)</small>
            </label>
            <input type="text" class="form-control" name="video_url" id="video_url" placeholder="<?php echo trans('video_url'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
            <a href="javascript:void(0)" class="btn btn-sm btn-info pull-right btn-get-embed" onclick="get_video_from_url();"><?php echo trans('get_video'); ?></a>
        </div>

        <div class="form-group m-t-45">
            <label class="control-label video-embed-lbl"><?php echo trans('video_embed_code'); ?></label>
            <textarea class="form-control text-embed"
                      name="video_embed_code" id="video_embed_code" placeholder="<?php echo trans('video_embed_code'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>><?php echo old('video_embed_code'); ?></textarea>
        </div>

        <iframe src="" id="video_embed_preview" frameborder="0" allow="encrypted-media" allowfullscreen class="video-embed-preview"></iframe>

    </div>
</div>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo trans('video_thumbnails'); ?></h3>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="form-group m0">
            <label class="control-label"><?php echo trans('video_image'); ?></label>
            <div class="row">
                <div class="col-sm-12">
                    <a class='btn btn-sm bg-purple' data-toggle="modal" data-target="#image_file_manager" data-image-type="video_thumbnail">
                        <?php echo trans('select_image'); ?>
                    </a>
                </div>
                <div class="col-sm-12 m-t-15 m-b-10">
                    <img id="selected_image_file" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="" class="img-responsive"/>
                    <input type="hidden" name="post_image_id">
                </div>
                <div class="col-sm-12 m-b-10">
                    <label><?php echo trans('or'); ?><br></label>
                </div>
                <div class="col-sm-12 m-b-15">
                    <input type="text" class="form-control" name="image_url" id="video_thumbnail_url" placeholder="<?php echo trans('add_image_url'); ?>"
                           value="<?php echo old('image_url'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>
            </div>
        </div>
    </div>
</div>
