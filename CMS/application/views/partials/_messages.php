<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--print error messages-->
<?php if ($this->session->flashdata('errors')): ?>
	<div class="form-group">
		<div class="error-message">
			<?php echo $this->session->flashdata('errors'); ?>
		</div>
	</div>
<?php endif; ?>

<!--print custom error message-->
<?php if ($this->session->flashdata('error')): ?>
	<div class="form-group">
		<div class="error-message">
			<p><?php echo $this->session->flashdata('error'); ?></p>
		</div>
	</div>
<?php endif; ?>

<!--print custom success message-->
<?php if ($this->session->flashdata('success')): ?>
	<div class="form-group">
		<div class="success-message">
			<p>
				<i class="icon-check"></i>
				<?php echo $this->session->flashdata('success'); ?>
			</p>
		</div>
	</div>
<?php endif; ?>
