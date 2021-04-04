<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Error</title>
	<!-- Bootstrap -->
	<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<style>
		.alert-heading {
			font-size: 22px;
		}

		.error {
			max-width: 800px;
			margin: 0 auto;
			margin-top: 60px;
		}

		.alert {
			padding: 30px !important;
		}

		.code-block {
			background-color: #ffecec;
			width: 100%;
			padding: 10px;
		}
	</style>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<?php if (!file_exists("..htaccess")): ?>
				<div class="error">
					<div class="alert alert-danger">
						<h4 class="alert-heading"><i class="fa fa-warning"></i> .htaccess Error!</h4>
						<hr>
						<div>
							.htaccess file does not exist on main directory of your site. You can find this file in the main directory of script files. You need to upload this file to your site.
							Depending on the operating system you are using, such setting files may be hidden in your computer. In this case, you may not see this file.<br><br>
							If you can't see this file, you can create a new file named ".htaccess" in the main directory of your site and you can paste the following codes to your .htaccess file.<br><br>

							<strong>.htaccess file:</strong><br>
							<div class="code-block">
								RewriteEngine On<br>
								RewriteCond %{REQUEST_FILENAME} !-f<br>
								RewriteCond %{REQUEST_FILENAME} !-d<br>
								RewriteRule ^(.*)$ index.php?/$1 [L]<br>
							</div>
						</div>
					</div>
				</div>
				<?php exit();
			endif; ?>
			<?php if (phpversion() < 5.6): ?>
				<div class="error">
					<div class="alert alert-danger">
						<h4 class="alert-heading"><i class="fa fa-warning"></i> PHP Version Error!</h4>
						<hr>
						<div>
							Your current PHP version is <strong><?php echo phpversion(); ?></strong>. You have to use PHP 5.6 or a higher version (7.0, 7.1, 7.2, 7.3) to run the script.<br>
							You can change the PHP version from the PHP settings on your server.
						</div>
					</div>
				</div>
				<?php exit();
			endif; ?>
			<?php if (!extension_loaded('curl')): ?>
				<div class="error">
					<div class="alert alert-danger">
						<h4 class="alert-heading"><i class="fa fa-warning"></i> cURL PHP Extension is Not Enabled!</h4>
						<hr>
						<div>
							cURL is not active on your server. You have to enable cURL extension in your PHP settings.
						</div>
					</div>
				</div>
				<?php exit();
			endif; ?>
			<?php if (!extension_loaded('curl')): ?>
				<div class="error">
					<div class="alert alert-danger">
						<h4 class="alert-heading"><i class="fa fa-warning"></i> cURL PHP Extension is Not Enabled!</h4>
						<hr>
						<div>
							cURL is not active on your server. You have to enable cURL extension in your PHP settings.
						</div>
					</div>
				</div>
				<?php exit();
			endif; ?>
		</div>
	</div>
</div>
</body>
</html>
