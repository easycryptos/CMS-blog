<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('add_image'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open_multipart('gallery_controller/add_gallery_image_post'); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages_form'); ?>
                <div class="form-group">
                    <label><?php echo trans("language"); ?></label>
                    <select name="lang_id" class="form-control" onchange="get_albums_by_lang(this.value);">
                        <?php foreach ($languages as $language): ?>
                            <option value="<?php echo $language->id; ?>" <?php echo ($site_lang->id == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><?php echo trans("album"); ?></label>
                    <select name="album_id" id="albums" class="form-control" required onchange="get_categories_by_albums(this.value);">
                        <option value=""><?php echo trans('select'); ?></option>
                        <?php foreach ($albums as $album): ?>
                            <option value="<?php echo $album->id; ?>"><?php echo $album->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('category'); ?></label>
                    <select id="categories" name="category_id" class="form-control">
                        <option value=""><?php echo trans('select'); ?></option>
                        <?php foreach ($categories as $item): ?>
                            <?php if ($item->id == old('category_id')): ?>
                                <option value="<?php echo html_escape($item->id); ?>" selected>
                                    <?php echo html_escape($item->name); ?></option>
                            <?php else: ?>
                                <option value="<?php echo html_escape($item->id); ?>"><?php echo html_escape($item->name); ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('title'); ?></label>
                    <input type="text" class="form-control"
                           name="title" id="title" placeholder="<?php echo trans('title'); ?>"
                           value="<?php echo old('title'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('image'); ?></label>
                    <div class="col-sm-12">
                        <div class="row">
                            <a class='btn btn-success btn-sm btn-file-upload'>
                                <?php echo trans('select_image'); ?>
                                <input type="file" id="Multifileupload" name="files[]" size="40" accept=".png, .jpg, .jpeg, .gif" multiple="multiple" required>
                            </a>
                            <span>(<?php echo trans("select_multiple_images"); ?>)</span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div id="MultidvPreview">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('add_image'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?php echo trans('gallery'); ?></h3>
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
                                    <th><?php echo trans('image'); ?></th>
                                    <th><?php echo trans('title'); ?></th>
                                    <th><?php echo trans('language'); ?></th>
                                    <th><?php echo trans('album'); ?></th>
                                    <th><?php echo trans('category'); ?></th>
                                    <th><?php echo trans('date'); ?></th>
                                    <th class="max-width-120"><?php echo trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($images as $item): ?>
                                    <tr>
                                        <td><?php echo html_escape($item->id); ?></td>
                                        <td>
                                            <div style="position: relative">
                                                <img src="<?php echo base_url() . html_escape($item->path_small); ?>" alt="" class="img-responsive" style="max-width: 140px; max-height: 140px;">
                                                <?php if ($item->is_album_cover): ?>
                                                    <label class="label label-success" style="position: absolute;left: 0;top: 0;"><?php echo trans("album_cover"); ?></label>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td><?php echo html_escape($item->title); ?></td>
                                        <td>
                                            <?php
                                            $lang = get_language($item->lang_id);
                                            if (!empty($lang)) {
                                                echo html_escape($lang->name);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $album = get_gallery_album($item->album_id);
                                            if (!empty($album)) {
                                                echo html_escape($album->name);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $category = get_gallery_category($item->category_id);
                                            if (!empty($category)) {
                                                echo html_escape($category->name);
                                            }
                                            ?>
                                        </td>
                                        <td class="nowrap"><?php echo formatted_date($item->created_at); ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                        type="button"
                                                        data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu options-dropdown">
                                                    <?php if ($item->is_album_cover == 0): ?>
                                                        <li>
                                                            <a href="javascript:void(0)" onclick="set_as_album_cover('<?php echo $item->id; ?>');"><i class="fa fa-check option-icon"></i><?php echo trans('set_as_album_cover'); ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <li>
                                                        <a href="<?php echo admin_url(); ?>update-gallery-image/<?php echo html_escape($item->id); ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="delete_item('gallery_controller/delete_gallery_image_post','<?php echo $item->id; ?>','<?php echo trans("confirm_image"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
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


