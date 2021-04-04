<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

    <!--print error messages-->
<?php if ($this->session->flashdata('errors_form')): ?>
    <div class="form-group">
        <div class="error-message">
            <?php echo $this->session->flashdata('errors_form'); ?>
        </div>
    </div>
<?php endif; ?>

    <!--print custom error message-->
<?php if ($this->session->flashdata('error_form')): ?>
    <div class="form-group">
        <div class="margin-bottom-10">
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <h4>
                    <i class="icon fa fa-times"></i>
                    <?php echo $this->session->flashdata('error_form'); ?>
                </h4>
            </div>
        </div>
    </div>
<?php endif; ?>

    <!--print custom success message-->
<?php if ($this->session->flashdata('success_form')): ?>
    <div class="form-group">
        <div class="margin-bottom-10">
            <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>

                <h4>
                    <i class="icon fa fa-check"></i>
                    <?php echo $this->session->flashdata('success_form'); ?>
                </h4>
            </div>
        </div>
    </div>
<?php endif; ?>