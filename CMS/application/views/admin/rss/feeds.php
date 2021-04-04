<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="box">

            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?php echo trans('rss_feeds'); ?></h3>
                </div>
                <div class="right">
                    <a href="<?php echo admin_url(); ?>import-feed" class="btn btn-success btn-add-new">
                        <i class="fa fa-plus"></i>
                        <?php echo trans('import_rss_feed'); ?>
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
                            <table class="table table-bordered table-striped dataTable" id="cs_datatable_lang" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?php echo trans('id'); ?></th>
                                    <th><?php echo trans('feed_name'); ?></th>
                                    <th><?php echo trans('feed_url'); ?></th>
                                    <th><?php echo trans('language'); ?></th>
                                    <th><?php echo trans('category'); ?></th>
                                    <th><?php echo trans('posts'); ?></th>
                                    <th><?php echo trans('auto_update'); ?></th>
                                    <th></th>
                                    <th class="max-width-120"><?php echo trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($feeds as $item): ?>
                                    <tr>
                                        <td><?php echo html_escape($item->id); ?></td>
                                        <td><?php echo html_escape($item->feed_name); ?></td>
                                        <td style="white-space: pre-wrap;word-break: break-all;"><?php echo html_escape($item->feed_url); ?></td>
                                        <td>
                                            <?php
                                            $lang = get_language($item->lang_id);
                                            if (!empty($lang)) {
                                                echo html_escape($lang->name);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php $category_array = get_category_array($item->category_id);
                                            if (!empty($category_array)):
                                                if (!empty($category_array['parent_category'])): ?>
                                                    <label class="label label-info label-table m-r-5">
                                                        <?php echo html_escape($category_array['parent_category']->name); ?>
                                                    </label>
                                                <?php endif;
                                                if (!empty($category_array['subcategory'])): ?>
                                                    <label class="label label-default label-table m-r-5">
                                                        <?php echo html_escape($category_array['subcategory']->name); ?>
                                                    </label>
                                                <?php endif;
                                            endif; ?>
                                        </td>
                                        <td><?php echo get_feed_posts_count($item->id); ?></td>
                                        <td>
                                            <?php if ($item->auto_update == 1): ?>
                                                <label class="label bg-olive"><?php echo trans('yes'); ?></label>
                                            <?php else: ?>
                                                <label class="label label-default"><?php echo trans('no'); ?></label>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <!--Form delete category-->
                                            <?php echo form_open('rss_controller/check_feed_posts'); ?>

                                            <input type="hidden" name="id" value="<?php echo html_escape($item->id); ?>">

                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fa fa-refresh "></i>&nbsp;&nbsp;<?php echo trans("update"); ?>
                                            </button>

                                            <?php echo form_close(); ?><!--Form end-->
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
                                                        <a href="<?php echo admin_url(); ?>update-feed/<?php echo html_escape($item->id); ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="delete_item('rss_controller/delete_feed_post','<?php echo $item->id; ?>','<?php echo trans("confirm_item"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
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
        <div class="alert alert-danger alert-large" style="max-width: 1000px;">
            <strong><?php echo trans("warning"); ?></strong>&nbsp;&nbsp;<?php echo trans("msg_rss_warning"); ?>
        </div>

        <div class="callout" style="margin-top: 30px;background-color: #fff; border-color:#00c0ef;max-width: 600px;">
            <h4>Cron Job</h4>

            <p><strong>http://domain.com/cron/update-feeds</strong></p>
            <small><?php echo trans('msg_cron_feed'); ?></small>
        </div>
    </div>
</div>
