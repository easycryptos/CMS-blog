<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-4 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('add_album'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('gallery_controller/add_gallery_album_post'); ?>

            <input type="hidden" name="parent_id" value="0">

            <div class="box-body">

                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages_form'); ?>
                <div class="form-group">
                    <label><?php echo trans("language"); ?></label>
                    <select name="lang_id" class="form-control">
                        <?php foreach ($languages as $language): ?>
                            <option value="<?php echo $language->id; ?>" <?php echo ($site_lang->id == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><?php echo trans('album_name'); ?></label>
                    <input type="text" class="form-control" name="name" placeholder="<?php echo trans('album_name'); ?>"
                           value="<?php echo old('name'); ?>" maxlength="200" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>
            </div>

            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('add_album'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>


    <div class="col-lg-8 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <h3 class="box-title"><?php echo trans('gallery_albums'); ?></h3>
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
                            <table class="table table-bordered table-striped dataTable" id="cs_datatable_lang" role="grid"
                                   aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?php echo trans('id'); ?></th>
                                    <th><?php echo trans('album_name'); ?></th>
                                    <th><?php echo trans('language'); ?></th>
                                    <th class="max-width-120"><?php echo trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($categories as $item): ?>
                                    <tr>
                                        <td><?php echo html_escape($item->id); ?></td>
                                        <td><?php echo html_escape($item->name); ?></td>
                                        <td>
                                            <?php
                                            $lang = get_language($item->lang_id);
                                            if (!empty($lang)) {
                                                echo html_escape($lang->name);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                        type="button"
                                                        data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu options-dropdown">
                                                    <li>
                                                        <a href="<?php echo admin_url(); ?>update-gallery-album/<?php echo html_escape($item->id); ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="delete_item('gallery_controller/delete_gallery_album_post','<?php echo $item->id; ?>','<?php echo trans("confirm_album"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>
