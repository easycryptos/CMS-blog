<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("site_font"); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_controller/set_site_font_post'); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata('mes_set_font'))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>

                <div class="form-group">
                    <label><?php echo trans("language"); ?></label>
                    <select name="lang_id" class="form-control" onchange="window.location.href = '<?php echo admin_url(); ?>' + 'font-settings?lang='+this.value;">
                        <?php foreach ($this->languages as $language): ?>
                            <option value="<?php echo $language->id; ?>" <?php echo ($selected_lang == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="label-sitemap"><?php echo trans('primary_font'); ?></label>
                    <select name="primary_font" class="form-control custom-select">
                        <?php foreach ($fonts as $font): ?>
                            <option value="<?php echo $font->id; ?>" <?php echo ($settings->primary_font == $font->id) ? 'selected' : ''; ?>><?php echo $font->font_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="label-sitemap"><?php echo trans('secondary_font'); ?></label>
                    <select name="secondary_font" class="form-control custom-select" style="width: 100%">
                        <?php foreach ($fonts as $font): ?>
                            <option value="<?php echo $font->id; ?>" <?php echo ($settings->secondary_font == $font->id) ? 'selected' : ''; ?>><?php echo $font->font_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("add_font"); ?></h3>
                <a href="https://fonts.google.com/" target="_blank" style="float: right;font-size: 16px;"><strong>Google Fonts&nbsp;<i class="icon-arrow-right"></i></strong></a>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_controller/add_font_post'); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata('mes_add_font'))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>

                <div class="form-group">
                    <label><?php echo trans("name"); ?></label>
                    <input type="text" class="form-control" name="font_name" placeholder="<?php echo trans("name"); ?>" maxlength="200" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                    <small>(E.g: Open Sans)</small>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans("url"); ?> </label>
                    <textarea name="font_url" class="form-control" placeholder="<?php echo trans("url"); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required></textarea>
                    <small>(E.g: <?php echo html_escape('<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">'); ?>)</small>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans("font_family"); ?> </label>
                    <input type="text" class="form-control" name="font_family" placeholder="<?php echo trans("font_family"); ?>" maxlength="500" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                    <small>(E.g: font-family: "Open Sans", Helvetica, sans-serif)</small>
                </div>
            </div>

            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('add_font'); ?></button>
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
                    <h3 class="box-title"><?php echo trans('fonts'); ?></h3>
                </div>
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="row">
                    <!-- include message block -->
                    <div class="col-sm-12">
                        <?php if (!empty($this->session->flashdata('mes_table'))):
                            $this->load->view('admin/includes/_messages');
                        endif; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dataTable" id="cs_datatable" role="grid"
                                   aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?php echo trans('id'); ?></th>
                                    <th><?php echo trans("name"); ?></th>
                                    <th><?php echo trans("font_family"); ?></th>
                                    <th class="max-width-120"><?php echo trans("options"); ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($fonts as $font): ?>
                                    <tr>
                                        <td><?php echo html_escape($font->id); ?></td>
                                        <td><?php echo html_escape($font->font_name); ?></td>
                                        <td><?php echo html_escape($font->font_family); ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                        type="button"
                                                        data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu options-dropdown">
                                                    <li>
                                                        <a href="<?php echo admin_url(); ?>update-font/<?php echo html_escape($font->id); ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="delete_item('admin_controller/delete_font_post','<?php echo $font->id; ?>','<?php echo trans("confirm_item"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
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
