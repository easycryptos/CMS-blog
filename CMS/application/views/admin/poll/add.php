<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">

            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?php echo trans('add_poll'); ?></h3>
                </div>
                <div class="right">
                    <a href="<?php echo admin_url(); ?>polls" class="btn btn-success btn-add-new">
                        <i class="fa fa-bars"></i>
                        <?php echo trans('polls'); ?>
                    </a>
                </div>
            </div><!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('poll_controller/add_poll_post'); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>
                <div class="form-group">
                    <label><?php echo trans("language"); ?></label>
                    <select name="lang_id" class="form-control max-600">
                        <?php foreach ($languages as $language): ?>
                            <option value="<?php echo $language->id; ?>" <?php echo ($site_lang->id == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('question'); ?></label>
                    <textarea class="form-control text-area"
                              name="question" placeholder="<?php echo trans('question'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required><?php echo old('question'); ?></textarea>

                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('option_1'); ?></label>
                    <input type="text" class="form-control" name="option1" placeholder="<?php echo trans('option_1'); ?>"
                           value="<?php echo old('option1'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('option_2'); ?></label>
                    <input type="text" class="form-control" name="option2" placeholder="<?php echo trans('option_2'); ?>"
                           value="<?php echo old('option2'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('option_3'); ?></label>
                    <input type="text" class="form-control" name="option3" placeholder="<?php echo trans('option_3'); ?> (<?php echo trans('optional'); ?>)"
                           value="<?php echo old('option3'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('option_4'); ?></label>
                    <input type="text" class="form-control" name="option4" placeholder="<?php echo trans('option_4'); ?> (<?php echo trans('optional'); ?>)"
                           value="<?php echo old('option4'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('option_5'); ?></label>
                    <input type="text" class="form-control" name="option5" placeholder="<?php echo trans('option_5'); ?> (<?php echo trans('optional'); ?>)"
                           value="<?php echo old('option5'); ?>">
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('option_6'); ?></label>
                    <input type="text" class="form-control" name="option6" placeholder="<?php echo trans('option_6'); ?> (<?php echo trans('optional'); ?>)"
                           value="<?php echo old('option6'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('option_7'); ?></label>
                    <input type="text" class="form-control" name="option7" placeholder="<?php echo trans('option_7'); ?> (<?php echo trans('optional'); ?>)"
                           value="<?php echo old('option7'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('option_8'); ?></label>
                    <input type="text" class="form-control" name="option8" placeholder="<?php echo trans('option_8'); ?> (<?php echo trans('optional'); ?>)"
                           value="<?php echo old('option8'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('option_9'); ?></label>
                    <input type="text" class="form-control" name="option9" placeholder="<?php echo trans('option_9'); ?> (<?php echo trans('optional'); ?>)"
                           value="<?php echo old('option9'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('option_10'); ?></label>
                    <input type="text" class="form-control" name="option10" placeholder="<?php echo trans('option_10'); ?> (<?php echo trans('optional'); ?>)"
                           value="<?php echo old('option10'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('status'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="rb_status_1" name="status" value="1" class="square-purple" checked>
                            <label for="rb_status_1" class="cursor-pointer"><?php echo trans('active'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="rb_status_2" name="status" value="0" class="square-purple">
                            <label for="rb_status_2" class="cursor-pointer"><?php echo trans('inactive'); ?></label>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('add_poll'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>
</div>