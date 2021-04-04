<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Section: main -->
<section id="main">
    <div class="container">
        <div class="row">
            <!-- breadcrumb -->
            <div class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo trans("forgot_password"); ?></li>
                </ol>
            </div>

            <div class="page-content">
                <div class="col-xs-12 col-sm-6 col-md-4 center-box">
                    <div class="content page-contact page-login">

                        <h1 class="page-title text-center"><?php echo trans("forgot_password"); ?></h1>

                        <!-- include message block -->
                        <?php $this->load->view('partials/_messages'); ?>

                        <!-- form start -->
                        <?php echo form_open('auth_controller/forgot_password_post'); ?>

                        <div class="form-group has-feedback">
                            <input type="email" name="email" class="form-control"
                                   placeholder="<?php echo html_escape(trans("email")); ?>"
                                   required <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-block btn-custom">
                                <?php echo html_escape(trans("reset_password")); ?>
                            </button>
                        </div>
                        <?php echo form_close(); ?><!-- form end -->

                    </div>

                </div>

            </div>
        </div>
    </div>
</section>
<!-- /.Section: main -->



