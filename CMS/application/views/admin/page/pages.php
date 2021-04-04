<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo trans('pages'); ?></h3>
        </div>
        <div class="right">
            <a href="<?php echo admin_url(); ?>add-page" class="btn btn-success btn-add-new">
                <i class="fa fa-plus"></i>
                <?php echo trans('add_page'); ?>
            </a>
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
                            <th><?php echo trans('title'); ?></th>
                            <th><?php echo trans('language'); ?></th>
                            <th><?php echo trans('location'); ?></th>
                            <th><?php echo trans('visibility'); ?></th>
                            <th><?php echo trans('page_type'); ?></th>
                            <th><?php echo trans('date_added'); ?></th>
                            <th class="max-width-120"><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($pages as $item): ?>
                            <?php if (empty($item->link)): ?>
                                <tr>
                                    <td><?php echo html_escape($item->id); ?></td>
                                    <td><?php echo html_escape($item->title); ?></td>
                                    <td>
                                        <?php if ($item->slug == "posts" || $item->slug == "register" || $item->slug == "login" || $item->slug == "login" || $item->slug == "reset-password" || $item->slug == "change-password" || $item->slug == "profile-update" || $item->slug == "rss-feeds" || $item->slug == "reading-list"):
                                            echo trans("shared");
                                        else:

                                            $lang = get_language($item->lang_id);
                                            if (!empty($lang)) {
                                                echo html_escape($lang->name);
                                            }
                                        endif;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (html_escape($item->location) == "header"):
                                            echo trans('header');
                                        elseif (html_escape($item->location) == "footer"):
                                            echo trans('footer');
                                        else:
                                            echo "-";
                                        endif;
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($item->page_active == 1): ?>
                                            <label class="label label-success"><i class="fa fa-eye"></i></label>
                                        <?php else: ?>
                                            <label class="label label-danger"><i class="fa fa-eye"></i></label>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($item->is_custom == 1): ?>
                                            <label class="label bg-teal"><?php echo trans('custom'); ?></label>
                                        <?php else: ?>
                                            <label class="label label-default"><?php echo trans('default'); ?></label>
                                        <?php endif; ?>
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
                                                <li>
                                                    <a href="<?php echo admin_url(); ?>update-page/<?php echo html_escape($item->id); ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="delete_item('page_controller/delete_page_post','<?php echo $item->id; ?>','<?php echo trans("confirm_page"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
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
