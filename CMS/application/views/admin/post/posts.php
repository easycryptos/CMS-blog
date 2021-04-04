<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo $title; ?></h3>
        </div>
        <div class="right">
            <div class="dropdown">
                <button class="btn btn-success btn-add-new dropdown-toggle"
                        type="button"
                        data-toggle="dropdown"><i class="fa fa-plus"></i><?php echo trans('add_post'); ?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" style="left: -20px;">
                    <li><a href="<?php echo admin_url(); ?>add-post"><?php echo trans('add_post'); ?></a></li>
                    <li><a href="<?php echo admin_url(); ?>add-video"><?php echo trans('add_video'); ?></a></li>
                </ul>
            </div>
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
                    <table class="table table-bordered table-striped" role="grid">
                        <?php $this->load->view('admin/includes/_filter_posts'); ?>
                        <thead>
                        <tr role="row">
                            <th width="20"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
                            <th width="20"><?php echo trans('id'); ?></th>
                            <th><?php echo trans('post'); ?></th>
                            <th><?php echo trans('post_type'); ?></th>
                            <th><?php echo trans('language'); ?></th>
                            <th><?php echo trans('category'); ?></th>
                            <th><?php echo trans('author'); ?></th>
                            <th></th>
                            <?php if ($list_type == "slider_posts"): ?>
                                <th><?php echo trans('slider_order'); ?></th>
                            <?php endif; ?>
                            <th><?php echo trans('date'); ?></th>
                            <th class="max-width-120"><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($posts as $item):
                            $lang = get_language($item->lang_id); ?>
                            <tr>
                                <td><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?php echo $item->id; ?>"></td>
                                <td><?php echo html_escape($item->id); ?></td>
                                <td>
                                    <div class="post-item-table">
                                        <a href="<?php echo generate_post_url($item, generate_base_url($lang)); ?>" target="_blank">
                                            <div class="post-image">
                                                <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo get_post_image($item, 'small'); ?>" alt="" class="lazyload img-responsive"/>
                                            </div>
                                            <?php echo html_escape($item->title); ?>
                                        </a>
                                    </div>
                                </td>
                                <td><?php echo trans($item->post_type); ?></td>
                                <td>
                                    <?php if (!empty($lang)) {
                                        echo html_escape($lang->name);
                                    } ?>
                                </td>
                                <td>
                                    <?php
                                    $category_array = get_category_array($item->category_id);
                                    if (!empty($category_array['parent_category'])):?>
                                        <label class="label label-table m-r-5 bg-primary">
                                            <?php echo html_escape($category_array['parent_category']->name); ?>
                                        </label>
                                    <?php endif;
                                    if (!empty($category_array['subcategory'])):?>
                                        <label class="label label-table m-r-5 bg-gray">
                                            <?php echo html_escape($category_array['subcategory']->name); ?>
                                        </label>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php $author = get_user($item->user_id);
                                    if (!empty($author)): ?>
                                        <a href="<?php echo base_url(); ?>profile/<?php echo html_escape($author->slug); ?>" target="_blank" class="table-link">
                                            <strong><?php echo html_escape($author->username); ?></strong>
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td class="td-post-sp">
                                    <?php if ($item->visibility == 1): ?>
                                        <label class="label label-success label-table"><i class="fa fa-eye"></i></label>
                                    <?php else: ?>
                                        <label class="label label-danger label-table"><i class="fa fa-eye"></i></label>
                                    <?php endif; ?>

                                    <?php if ($item->is_slider): ?>
                                        <label class="label bg-olive label-table"><?php echo trans('slider'); ?></label>
                                    <?php endif; ?>

                                    <?php if ($item->is_picked): ?>
                                        <label class="label bg-aqua label-table"><?php echo trans('our_picks'); ?></label>
                                    <?php endif; ?>

                                    <?php if ($item->need_auth): ?>
                                        <label class="label label-warning label-table"><?php echo trans('only_registered'); ?></label>
                                    <?php endif; ?>

                                </td>
                                <?php if ($list_type == "slider_posts"): ?>
                                    <td>
                                        <?php echo form_open('post_controller/home_slider_posts_order_post'); ?>
                                        <div class="slider-order">
                                            <div class="slider-order-left">
                                                <input type="hidden" name="id"
                                                       value="<?php echo html_escape($item->id); ?>">
                                                <input type="number" name="slider_order" class="form-control"
                                                       value="<?php echo html_escape($item->slider_order); ?>" min="1" max="99999">
                                            </div>
                                            <div class="slider-order-right">
                                                <button type="submit" class="btn btn-sm btn-success"><i
                                                            class="fa fa-check"></i></button>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </td>
                                <?php endif; ?>
                                <td class="nowrap"><?php echo formatted_date($item->created_at); ?></td>

                                <td>
                                    <!-- form post options -->
                                    <?php echo form_open('post_controller/post_options_post'); ?>
                                    <input type="hidden" name="id" value="<?php echo html_escape($item->id); ?>">

                                    <div class="dropdown">
                                        <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                type="button"
                                                data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu options-dropdown">
                                            <li>
                                                <a href="<?php echo admin_url(); ?>update-post/<?php echo html_escape($item->id); ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                            </li>
                                            <?php if (is_admin()): ?>
                                                <?php if ($item->is_slider == 1): ?>
                                                    <li>
                                                        <button type="submit" name="option" value="add-remove-from-slider" class="btn-list-button">
                                                            <i class="fa fa-times option-icon"></i><?php echo trans('remove_slider'); ?>
                                                        </button>
                                                    </li>
                                                <?php else: ?>
                                                    <li>
                                                        <button type="submit" name="option" value="add-remove-from-slider" class="btn-list-button">
                                                            <i class="fa fa-plus option-icon"></i><?php echo trans('add_slider'); ?>
                                                        </button>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if ($item->is_picked == 1): ?>
                                                    <li>
                                                        <button type="submit" name="option" value="add-remove-from-picked" class="btn-list-button">
                                                            <i class="fa fa-times option-icon"></i><?php echo trans('remove_picked'); ?>
                                                        </button>
                                                    </li>
                                                <?php else: ?>
                                                    <li>
                                                        <button type="submit" name="option" value="add-remove-from-picked" class="btn-list-button">
                                                            <i class="fa fa-plus option-icon"></i><?php echo trans('add_picked'); ?>
                                                        </button>
                                                    </li>
                                                <?php endif; ?>

                                            <?php endif; ?>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_item('post_controller/delete_post','<?php echo $item->id; ?>','<?php echo trans("confirm_post"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                            </li>
                                        </ul>
                                    </div>

                                    <?php echo form_close(); ?><!-- form end -->
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>

                    <div class="col-sm-12 table-ft">
                        <div class="row">

                            <div class="pull-right">
                                <?php echo $this->pagination->create_links(); ?>
                            </div>

                            <?php if (count($posts) > 0): ?>
                                <div class="pull-left">
                                    <button class="btn btn-sm btn-danger btn-table-delete" onclick="delete_selected_posts('<?php echo trans("confirm_posts"); ?>');"><?php echo trans('delete'); ?></button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>

<style>
    .options-dropdown {
        left: -40px;
    }
</style>
