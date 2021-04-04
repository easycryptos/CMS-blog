<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Section: main -->
<section id="main">
	<div class="container">
		<div class="row">
			<!-- breadcrumb -->
			<div class="page-breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
					<li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>settings"><?php echo trans("settings"); ?></a></li>
					<li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
				</ol>
			</div>
			<div class="page-content">
				<div class="col-sm-12">
					<h1 class="page-title"><?php echo trans("settings"); ?></h1>
				</div>
				<div class="col-sm-12 col-md-3">
					<!-- load profile nav -->
					<?php $this->load->view("settings/_setting_tabs"); ?>
				</div>

				<div class="col-sm-12 col-md-9">
					<div class="profile-tab-content">
						<!-- include message block -->
						<?php $this->load->view('partials/_messages'); ?>
						<?php echo form_open_multipart("profile_controller/change_password_post", ['id' => 'form_validate']); ?>
						<?php if (!empty($user->password)): ?>
							<div class="form-group">
								<label><?php echo trans("old_password"); ?></label>
								<input type="password" name="old_password" class="form-control form-input" value="<?php echo old("old_password"); ?>" placeholder="<?php echo trans("old_password"); ?>" required>
							</div>
							<input type="hidden" value="1" name="is_pass_exist">
						<?php else: ?>
							<input type="hidden" value="0" name="is_pass_exist">
						<?php endif; ?>
						<div class="form-group">
							<label><?php echo trans("password"); ?></label>
							<input type="password" name="password" class="form-control form-input" value="<?php echo old("password"); ?>" placeholder="<?php echo trans("password"); ?>" required>
						</div>
						<div class="form-group">
							<label><?php echo trans("confirm_password"); ?></label>
							<input type="password" name="password_confirm" class="form-control form-input" value="<?php echo old("password_confirm"); ?>" placeholder="<?php echo trans("confirm_password"); ?>" required>
						</div>

						<button type="submit" class="btn btn-md btn-custom"><?php echo trans("change_password") ?></button>
						<?php echo form_close(); ?>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /.Section: main -->
