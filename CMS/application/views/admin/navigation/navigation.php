<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-sm-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo trans("add_link"); ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php echo form_open('admin_controller/add_menu_link_post'); ?>

                    <div class="box-body">
                        <!-- include message block -->
                        <?php if (empty($this->session->flashdata("mes_menu_limit"))):
                            $this->load->view('admin/includes/_messages_form');
                        endif; ?>
                        <div class="form-group">
                            <label><?php echo trans("language"); ?></label>
                            <select name="lang_id" class="form-control" onchange="get_menu_links_by_lang(this.value);">
                                <?php foreach ($languages as $language): ?>
                                    <option value="<?php echo $language->id; ?>" <?php echo ($site_lang->id == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans("title"); ?></label>
                            <input type="text" class="form-control" name="title" placeholder="<?php echo trans("title"); ?>"
                                   value="<?php echo old('title'); ?>"
                                   maxlength="200" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        </div>

                        <div class="form-group">
                            <label><?php echo trans("link"); ?></label>
                            <input type="text" class="form-control" name="link" placeholder="<?php echo trans("link"); ?>"
                                   value="<?php echo old('link'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>

                        <div class="form-group">
                            <label><?php echo trans('order'); ?></label>
                            <input type="number" class="form-control" name="page_order"
                                   placeholder="<?php echo trans('order'); ?>" value="1"
                                   min="1" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('parent_link'); ?></label>
                            <select id="parent_links" name="parent_id" class="form-control">
                                <option value="0"><?php echo trans('none'); ?></option>
                                <?php foreach ($menu_items as $menu_item): ?>
                                    <?php if ($menu_item->item_lang_id == $this->selected_lang->id && $menu_item->item_type != "category" && $menu_item->item_location == "header" && $menu_item->item_parent_id == "0"): ?>
                                        <option value="<?php echo $menu_item->item_id; ?>"><?php echo $menu_item->item_name; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4 col-xs-12">
                                    <label><?php echo trans('show_on_menu'); ?></label>
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" id="rb_show_on_menu_1" name="page_active" value="1" class="square-purple" checked>
                                    <label for="rb_show_on_menu_1" class="cursor-pointer"><?php echo trans('yes'); ?></label>
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" id="rb_show_on_menu_2" name="page_active" value="0" class="square-purple">
                                    <label for="rb_show_on_menu_2" class="cursor-pointer"><?php echo trans('no'); ?></label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right"><?php echo trans('add_link'); ?></button>
                    </div>
                    <!-- /.box-footer -->
                    <?php echo form_close(); ?><!-- form end -->
                </div>
            </div>

            <!-- /.box -->
            <div class="col-sm-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo trans("menu_limit"); ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php echo form_open('admin_controller/menu_limit_post'); ?>

                    <div class="box-body">
                        <!-- include message block -->
                        <?php if (!empty($this->session->flashdata("mes_menu_limit"))):
                            $this->load->view('admin/includes/_messages_form');
                        endif; ?>

                        <div class="form-group">
                            <label><?php echo trans('menu_limit'); ?></label>
                            <input type="number" class="form-control" name="menu_limit" placeholder="<?php echo trans('menu_limit'); ?>" value="<?php echo $general_settings->menu_limit; ?>" min="1" max="99999" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit"
                                class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                    </div>
                    <!-- /.box-footer -->
                    <?php echo form_close(); ?><!-- form end -->
                </div>
            </div>

        </div>

    </div>


    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <h3 class="box-title"><?php echo trans('navigation'); ?></h3>
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
                            <table class="table table-bordered table-striped dataTable" id="cs_datatable_lang" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th style="max-width: 75px;"><?php echo trans('order'); ?></th>
                                    <th><?php echo trans('title'); ?></th>
                                    <th><?php echo trans('parent_link'); ?></th>
                                    <th class="th-lang"><?php echo trans('language'); ?></th>
                                    <th><?php echo trans('visibility'); ?></th>
                                    <th class="max-width-120"><?php echo trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($menu_items as $menu_item): ?>
                                    <?php if ($menu_item->item_location == "header"): ?>
                                        <tr>
                                            <td><?php echo $menu_item->item_order; ?></td>
                                            <td>
                                                <?php echo html_escape($menu_item->item_name);

                                                if ($menu_item->item_type == "category"): ?>
                                                    <span class="nav-item-type">(<?php echo trans("category"); ?>)</span>
                                                <?php elseif ($menu_item->item_type == "page" && empty($menu_item->item_link)): ?>
                                                    <span class="nav-item-type">(<?php echo trans("page"); ?>)</span>
                                                <?php else: ?>
                                                    <span class="nav-item-type">(<?php echo trans("link"); ?>)</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php $parent = helper_get_parent_link($menu_item->item_parent_id, $menu_item->item_type); ?>
                                                <?php if (!empty($parent)): ?>
                                                    <?php if ($menu_item->item_type == "page"):
                                                        echo $parent->title;
                                                    endif; ?>
                                                    <?php if ($menu_item->item_type == "category"):
                                                        echo $parent->name;
                                                    endif; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $lang = get_language($menu_item->item_lang_id);
                                                if (!empty($lang)) {
                                                    echo html_escape($lang->name);
                                                } ?>
                                            </td>
                                            <td>
                                                <?php if ($menu_item->item_visibility == 0): ?>
                                                    <label class="label label-danger"><i class="fa fa-eye"></i></label>
                                                <?php else: ?>
                                                    <label class="label label-success"><i class="fa fa-eye"></i></label>
                                                <?php endif; ?>
                                            </td>

                                            <?php if ($menu_item->item_type == "category"): ?>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                                type="button"
                                                                data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu options-dropdown">
                                                            <li>
                                                                <a href="<?php echo admin_url(); ?>update-category/<?php echo $menu_item->item_id; ?>?redirect_url=<?php echo admin_url(); ?>navigation"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" onclick="delete_item('category_controller/delete_category_post','<?php echo $menu_item->item_id; ?>','<?php echo trans("confirm_category"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            <?php elseif ($menu_item->item_type == "page" && empty($menu_item->item_link)): ?>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu options-dropdown">
                                                            <li>
                                                                <a href="<?php echo admin_url(); ?>update-page/<?php echo $menu_item->item_id; ?>?redirect_url=<?php echo admin_url(); ?>navigation"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" onclick="delete_item('page_controller/delete_page_post','<?php echo $menu_item->item_id; ?>','<?php echo trans("confirm_page"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            <?php else: ?>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                                type="button"
                                                                data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu options-dropdown">
                                                            <li>
                                                                <a href="<?php echo admin_url(); ?>update-menu-link/<?php echo $menu_item->item_id; ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" onclick="delete_item('admin_controller/delete_navigation_post','<?php echo $menu_item->item_id; ?>','<?php echo trans("confirm_link"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endif; ?>
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
