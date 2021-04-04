<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('add_subcategory'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('category_controller/add_subcategory_post'); ?>

            <div class="box-body">

                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages_form'); ?>

                <div class="form-group">
                    <label><?php echo trans("language"); ?></label>
                    <select name="lang_id" class="form-control" onchange="get_top_categories_by_lang(this.value);">
                        <?php foreach ($languages as $language): ?>
                            <option value="<?php echo $language->id; ?>" <?php echo ($site_lang->id == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label><?php echo trans('category_name'); ?></label>
                    <input type="text" class="form-control" name="name" placeholder="<?php echo trans('category_name'); ?>"
                           value="<?php echo old('name'); ?>" maxlength="200" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('slug'); ?>
                        <small>(<?php echo trans('slug_exp'); ?>)</small>
                    </label>
                    <input type="text" class="form-control" name="slug" placeholder="<?php echo trans('slug'); ?>"
                           value="<?php echo old('slug'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('description'); ?> (<?php echo trans('meta_tag'); ?>)</label>
                    <input type="text" class="form-control" name="description"
                           placeholder="<?php echo trans('description'); ?> (<?php echo trans('meta_tag'); ?>)" value="<?php echo old('description'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)</label>
                    <input type="text" class="form-control" name="keywords"
                           placeholder="<?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)" value="<?php echo old('keywords'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label><?php echo trans('parent_category'); ?></label>
                    <select id="categories" class="form-control" name="parent_id" required>
                        <option value=""><?php echo trans('select'); ?></option>
                        <?php foreach ($top_categories as $item): ?>
                            <option value="<?php echo $item->id; ?>"><?php echo $item->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <label><?php echo trans('show_on_menu'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="rb_show_on_menu_1" name="show_on_menu" value="1" class="square-purple" checked>
                            <label for="rb_show_on_menu_1" class="cursor-pointer"><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="rb_show_on_menu_2" name="show_on_menu" value="0" class="square-purple">
                            <label for="rb_show_on_menu_2" class="cursor-pointer"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>
            </div>


            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('add_subcategory'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>


    <div class="col-lg-7 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <h3 class="box-title"><?php echo trans('subcategories'); ?></h3>
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
                                    <th><?php echo trans('category_name'); ?></th>
                                    <th><?php echo trans('language'); ?></th>
                                    <th><?php echo trans('parent_category'); ?></th>
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
                                            <?php
                                            if (!empty(helper_get_category($item->parent_id))) {
                                                echo html_escape(helper_get_category($item->parent_id)->name);
                                            } ?>
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
                                                        <a href="<?php echo admin_url(); ?>update-subcategory/<?php echo html_escape($item->id); ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="delete_item('category_controller/delete_category_post','<?php echo $item->id; ?>','<?php echo trans("confirm_category"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
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
