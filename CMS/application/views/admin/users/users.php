<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo trans('users'); ?></h3>
        </div>
    </div><!-- /.box-header -->

    <!-- include message block -->
    <div class="col-sm-12">
        <?php $this->load->view('admin/includes/_messages'); ?>
    </div>

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTable" id="cs_datatable" role="grid"
                           aria-describedby="example1_info">
                        <thead>
                        <tr role="row">
                            <th width="20"><?php echo trans('id'); ?></th>
                            <th><?php echo trans('avatar'); ?></th>
                            <th><?php echo trans('username'); ?></th>
                            <th><?php echo trans('email'); ?></th>
                            <th><?php echo trans('role'); ?></th>
                            <th><?php echo trans('status'); ?></th>
                            <th><?php echo trans('date_added'); ?></th>
                            <th class="max-width-120"><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo html_escape($user->id); ?></td>
                                <td>
                                    <img src="<?php echo get_user_avatar($user); ?>" alt="user" class="img-responsive" style="width: 70px; border-radius: 1px;">
                                </td>
                                <td><?php echo html_escape($user->username); ?></td>
                                <td><?php echo html_escape($user->email); ?></td>
                                <td>
                                    <?php if ($user->role == "admin"): ?>
                                        <label class="label bg-olive"><?php echo trans('admin'); ?></label>
                                    <?php elseif ($user->role == "author"): ?>
                                        <label class="label label-warning"><?php echo trans('author'); ?></label>
                                    <?php else: ?>
                                        <label class="label label-default"><?php echo trans('user'); ?></label>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($user->status == 1): ?>
                                        <label class="label label-success"><?php echo trans('active'); ?></label>
                                    <?php else: ?>
                                        <label class="label label-danger"><?php echo trans('banned'); ?></label>
                                    <?php endif; ?>
                                </td>
                                <td class="nowrap"><?php echo formatted_date($user->created_at); ?></td>

                                <td>
                                    <?php echo form_open('admin_controller/user_options_post'); ?>
                                    <input type="hidden" name="id" value="<?php echo html_escape($user->id); ?>">

                                    <div class="dropdown">
                                        <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                type="button"
                                                data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu options-dropdown">
                                            <li>
                                                <button type="button" class="btn-list-button" data-toggle="modal" data-target="#myModal"
                                                        onclick="$('#modal_user_id').val('<?php echo html_escape($user->id); ?>');">
                                                    <i class="fa fa-user option-icon"></i><?php echo trans('change_user_role'); ?>
                                                </button>
                                            </li>
                                            <?php if ($user->status == "1"): ?>
                                                <li>
                                                    <button type="submit" name="option" value="ban" class="btn-list-button">
                                                        <i class="fa fa-stop-circle option-icon"></i><?php echo trans('ban_user'); ?>
                                                    </button>
                                                </li>
                                            <?php else: ?>
                                                <li>
                                                    <button type="submit" name="option" value="remove_ban" class="btn-list-button">
                                                        <i class="fa fa-stop-circle option-icon"></i><?php echo trans('remove_ban'); ?>
                                                    </button>
                                                </li>
                                            <?php endif; ?>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_item('admin_controller/delete_user_post','<?php echo $user->id; ?>','<?php echo trans("confirm_user"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                            </li>
                                        </ul>
                                    </div>

                                    <?php echo form_close(); ?><!-- form end -->
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


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo trans('change_user_role'); ?></h4>
            </div>
            <?php echo form_open('admin_controller/change_user_role_post'); ?>
            <div class="modal-body">
                <div class="form-group">

                    <div class="row">
                        <input type="hidden" name="user_id" id="modal_user_id" value="">


                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="role_admin" name="role" value="admin" class="square-purple" checked>
                            <label for="role_admin" class="cursor-pointer"><?php echo trans('admin'); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="role_author" name="role" value="author" class="square-purple">
                            <label for="role_author" class="cursor-pointer"><?php echo trans('author'); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="role_user" name="role" value="user" class="square-purple">
                            <label for="role_user" class="cursor-pointer"><?php echo trans('user'); ?></label>
                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"><?php echo trans('save'); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo trans('close'); ?></button>
            </div>

            <?php echo form_close(); ?><!-- form end -->
        </div>

    </div>
</div>