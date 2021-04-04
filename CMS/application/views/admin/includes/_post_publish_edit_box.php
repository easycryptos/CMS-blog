<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo trans('publish'); ?></h3>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12 ">
                    <label><?php echo trans('date_publish'); ?></label>
                </div>
                <div class="col-sm-12">
                    <div class='input-group date' id='datetimepicker'>
                        <input type='text' class="form-control" name="date_published" placeholder="<?php echo trans("date_publish"); ?>" value="<?php echo $post->created_at; ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>/>
                        <span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <?php if ($post->status == 0): ?>
                <button type="submit" name="publish" value="1" class="btn btn-warning pull-right" style="margin-left: 10px;"><?php echo trans('publish'); ?></button>
            <?php endif; ?>
            <button type="submit" name="publish" value="0" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
        </div>
    </div>
</div>
