<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('update_category'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('category_controller/update_gallery_category_post'); ?>

            <input type="hidden" name="id" value="<?php echo html_escape($category->id); ?>">

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>
                <div class="form-group">
                    <label><?php echo trans("language"); ?></label>
                    <select name="lang_id" class="form-control" onchange="get_albums_by_lang(this.value);">
                        <?php foreach ($languages as $language): ?>
                            <option value="<?php echo $language->id; ?>" <?php echo ($category->lang_id == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><?php echo trans("album"); ?></label>
                    <select name="album_id" id="albums" class="form-control" required>
                        <option value=""><?php echo trans('select'); ?></option>
                        <?php foreach ($albums as $album): ?>
                            <option value="<?php echo $album->id; ?>" <?php echo ($category->album_id == $album->id) ? 'selected' : ''; ?>><?php echo $album->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><?php echo trans('category_name'); ?></label>
                    <input type="text" class="form-control" name="name" placeholder="<?php echo trans('category_name'); ?>"
                           value="<?php echo html_escape($category->name); ?>" maxlength="200" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>
            </div>

            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>

</div>
