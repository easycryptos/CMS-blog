<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo trans('polls'); ?></h3>
        </div>
        <div class="right">
            <a href="<?php echo admin_url(); ?>add-poll" class="btn btn-success btn-add-new">
                <i class="fa fa-plus"></i>
                <?php echo trans('add_poll'); ?>
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
                            <th><?php echo trans('question'); ?></th>
                            <th><?php echo trans('language'); ?></th>
                            <th><?php echo trans('status'); ?></th>
                            <th><?php echo trans('date'); ?></th>
                            <th class="max-width-120"><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($polls as $item): ?>
                            <tr>
                                <td><?php echo html_escape($item->id); ?></td>
                                <td class="break-word"><?php echo html_escape($item->question); ?>&nbsp;&nbsp;&nbsp;
                                    <button class="btn btn-info btn-xs" data-toggle="modal"
                                            data-target="#pollModal<?php echo html_escape($item->id); ?>"><?php echo trans('view_results'); ?>
                                    </button>
                                </td>
                                <td>
                                    <?php
                                    $lang = get_language($item->lang_id);
                                    if (!empty($lang)) {
                                        echo html_escape($lang->name);
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if ($item->status == 1): ?>
                                        <label class="label label-success"><?php echo trans('active'); ?></label>
                                    <?php else: ?>
                                        <label class="label label-danger"><?php echo trans('inactive'); ?></label>
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
                                                <a href="<?php echo admin_url(); ?>update-poll/<?php echo html_escape($item->id); ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_item('poll_controller/delete_poll_post','<?php echo $item->id; ?>','<?php echo trans("confirm_poll"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
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


<?php foreach ($polls as $poll): ?>

    <!-- Modal -->
    <div id="pollModal<?php echo $poll->id; ?>" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo html_escape($poll->question); ?></h4>
                </div>

                <div class="modal-body">
                    <div class="poll">

                        <div class="result">
                            <?php $total_vote = get_total_vote_count($poll->id); ?>

                            <p class="total-vote text-center"><strong><?php echo trans('total_vote'); ?><?php echo $total_vote; ?></strong></p>

                            <?php for ($i = 1; $i <= 10; $i++):
                                $option = "option" . $i;

                                $percent = 0;

                                if (!empty($poll->$option)):
                                    $option_vote = get_option_vote_count($poll->id, $option);

                                    if ($total_vote > 0) {
                                        $percent = round(($option_vote * 100) / $total_vote, 1);
                                    }

                                    ?>

                                    <span><?php echo html_escape($poll->$option); ?></span>

                                    <?php if ($percent == 0): ?>
                                    <div class="progress">
                                        <span><?php echo $percent; ?>&nbsp;%</span>
                                        <div class="progress-bar progress-bar-0" role="progressbar" aria-valuenow="<?php echo $total_vote; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $percent; ?>%"></div>
                                    </div>
                                <?php else: ?>
                                    <div class="progress">
                                        <span><?php echo $percent; ?>&nbsp;%</span>
                                        <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $total_vote; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $percent; ?>%"></div>
                                    </div>
                                <?php endif; ?>

                                <?php
                                endif;
                            endfor; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo trans('close'); ?></button>
                </div>


            </div>

        </div>
    </div>

<?php endforeach; ?>

<style>
    .poll .result .progress span {
        font-size: 13px;
        font-weight: 600;
        line-height: 20px;
        position: absolute;
        right: 15px;
    }
</style>
