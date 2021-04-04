<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo $title; ?> - <?php echo $language->name; ?></h3>
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
                    <?php $this->load->view('admin/language/_filter_translations'); ?>
                    <?php echo form_open('language_controller/update_translations_post'); ?>
                    <input type="hidden" name="lang_id" value="<?php echo $language->id; ?>">
                    <table class="table table-bordered table-striped dataTable">
                        <thead>
                        <tr role="row">
                            <th><?php echo trans('id'); ?></th>
                            <th><?php echo trans('phrase'); ?></th>
                            <th><?php echo trans('label'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($translations as $item): ?>
                            <tr class="tr-phrase">
                                <td style="width: 50px;"><?php echo $item->id; ?></td>
                                <td style="width: 40%;"><input type="text" class="form-control" value="<?php echo $item->label; ?>" <?php echo ($language->text_direction == "rtl") ? 'dir="rtl"' : ''; ?> readonly></td>
                                <td style="width: 60%;"><input type="text" name="<?php echo $item->id; ?>" data-label="<?php echo $item->id; ?>" data-lang="<?php echo $item->lang_id; ?>" class="form-control input_translation" value="<?php echo $item->translation; ?>" <?php echo ($language->text_direction == "rtl") ? 'dir="rtl"' : ''; ?>></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary pull-right">
                        <?php echo trans("save_changes"); ?>
                    </button>
                    <?php echo form_close(); ?>
                </div>
                <?php if (empty($translations)): ?>
                    <p class="text-center">
                        <?php echo trans("no_records_found"); ?>
                    </p>
                <?php endif; ?>

                <div class="col-sm-12 table-ft">
                    <div class="row text-center">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .item-table-filter {
        width: 300px;
        max-width: 100%;
    }
</style>