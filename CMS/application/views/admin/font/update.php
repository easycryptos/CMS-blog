<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("update_font"); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_controller/update_font_post'); ?>
            <input type="hidden" name="id" value="<?php echo $font->id; ?>">
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata('mes_add_font'))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>

                <div class="form-group">
                    <label><?php echo trans("name"); ?></label>
                    <input type="text" class="form-control" name="font_name" value="<?php echo html_escape($font->font_name); ?>" placeholder="<?php echo trans("name"); ?>" maxlength="200" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                    <small>(E.g: Open Sans)</small>
                </div>

                <?php if ($font->is_default != 1): ?>
                    <div class="form-group">
                        <label class="control-label"><?php echo trans("url"); ?> </label>
                        <textarea name="font_url" class="form-control" placeholder="<?php echo trans("url"); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required><?php echo $font->font_url; ?></textarea>
                        <small>(E.g: <?php echo html_escape('<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">'); ?>)</small>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="font_url" value="">
                <?php endif; ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans("font_family"); ?> </label>
                    <input type="text" class="form-control" name="font_family" value="<?php echo html_escape($font->font_family); ?>" placeholder="<?php echo trans("font_family"); ?>" maxlength="500" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                    <small>(E.g: font-family: "Open Sans", Helvetica, sans-serif)</small>
                </div>
            </div>

            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans("save_changes"); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>
</div>
