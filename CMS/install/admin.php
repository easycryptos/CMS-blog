<?php
error_reporting(0);
require_once 'functions.php';
require_once 'includes//Bcrypt.php';

$cls = new Bcrypt();

if (isset($_POST["btn_admin"])) {

    $license_code = $_POST["license_code"];
    $purchase_code = $_POST["purchase_code"];

    if (!isset($license_code) || !isset($purchase_code)) {
        header("Location: index.php");
        exit();
    }

    $timezone = trim($_POST['timezone']);
    $admin_username = trim($_POST['admin_username']);
    $admin_email = trim($_POST['admin_email']);
    $admin_password = trim($_POST['admin_password']);

    $password = $cls->hash_password($admin_password);
    $slug = str_slug($admin_username);

    /* Database Credentials */
    defined("DB_HOST") ? null : define("DB_HOST", @$_COOKIE["db_host"]);
    defined("DB_USER") ? null : define("DB_USER", @$_COOKIE["db_user"]);
    defined("DB_PASS") ? null : define("DB_PASS", @$_COOKIE["db_password"]);
    defined("DB_NAME") ? null : define("DB_NAME", @$_COOKIE["db_name"]);

    /* Connect */
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $connection->query("SET CHARACTER SET utf8");
    $connection->query("SET NAMES utf8");

    /* check connection */
    if (mysqli_connect_errno()) {
        $error = 0;
    } else {
        $token = uniqid("", TRUE);
        $token = str_replace(".", "-", $token);
        $token = $token . "-" . rand(10000000, 99999999);
        mysqli_query($connection, "INSERT INTO users (username, slug, email, password, token, role, status, user_type) VALUES ('" . $admin_username . "', '" . $slug . "', '" . $admin_email . "','" . $password . "','" . $token . "', 'admin', 1, 'registered')");
        mysqli_query($connection, "UPDATE general_settings SET inf_key='" . $license_code . "', purchase_code='" . $purchase_code . "', timezone='" . $timezone . "' WHERE id='1'");

        /* close connection */
        mysqli_close($connection);

        $redir = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
        $redir .= "://" . $_SERVER['HTTP_HOST'];
        $redir .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
        $redir = str_replace('install/', '', $redir);
        header("refresh:5;url=" . $redir);
        $success = 1;
    }

} else {
    $license_code = $_GET["license_code"];
    $purchase_code = $_GET["purchase_code"];

    if (!isset($license_code) || !isset($purchase_code)) {
        header("Location: index.php");
        exit();
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Infinite - Installer</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700" rel="stylesheet">
    <!-- Font-awesome CSS -->
    <link href="../assets/admin/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-sm-12 col-md-offset-2">

            <div class="row">
                <div class="col-sm-12 logo-cnt">
                    <h1>Infinite</h1>
                    <p>Welcome to the Installer</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">

                    <div class="install-box">


                        <div class="steps">
                            <div class="step-progress">
                                <div class="step-progress-line" data-now-value="100" data-number-of-steps="5" style="width: 100%;"></div>
                            </div>
                            <div class="step">
                                <div class="step-icon"><i class="fa fa-code"></i></div>
                                <p>Start</p>
                            </div>
                            <div class="step">
                                <div class="step-icon"><i class="fa fa-gear"></i></div>
                                <p>System Requirements</p>
                            </div>
                            <div class="step">
                                <div class="step-icon"><i class="fa fa-folder-open"></i></div>
                                <p>Folder Permissions</p>
                            </div>
                            <div class="step">
                                <div class="step-icon"><i class="fa fa-database"></i></div>
                                <p>Database</p>
                            </div>
                            <div class="step active">
                                <div class="step-icon"><i class="fa fa-user"></i></div>
                                <p>Admin</p>
                            </div>
                        </div>

                        <div class="messages">
                            <?php if (isset($error)) { ?>
                                <div class="alert alert-danger">
                                    <strong>Connect failed! Please check your database credentials.</strong>
                                </div>
                            <?php } ?>
                            <?php if (isset($success)) { ?>
                                <div class="alert alert-success">
                                    <strong>Completing installation... Please wait!</strong>
                                </div>
                            <?php } ?>
                        </div>
                        <?php if (isset($success)) { ?>
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="spinner">
                                        <div class="rect1"></div>
                                        <div class="rect2"></div>
                                        <div class="rect3"></div>
                                        <div class="rect4"></div>
                                        <div class="rect5"></div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="step-contents">
                            <div class="tab-1">
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                    <input type="hidden" name="license_code" value="<?php echo $license_code; ?>">
                                    <input type="hidden" name="purchase_code" value="<?php echo $purchase_code; ?>">
                                    <div class="tab-content">
                                        <div class="tab_1">
                                            <h1 class="step-title">Settings</h1>
                                            <div class="form-group">
                                                <label for="email">Timezone</label>
                                                <select name="timezone" class="form-control" required style="min-height: 44px;">
                                                    <option value="">Select Your Timezone</option>
                                                    <?php $timezones = timezone_identifiers_list();
                                                    if (!empty($timezones)):
                                                        foreach ($timezones as $timezone):?>
                                                            <option value="<?php echo $timezone; ?>"><?php echo $timezone; ?></option>
                                                        <?php endforeach;
                                                    endif; ?>
                                                </select>
                                                <br>
                                            </div>
                                            <h1 class="step-title">Admin Account</h1>
                                            <div class="form-group">
                                                <label for="email">Username</label>
                                                <input type="text" class="form-control form-input" name="admin_username" placeholder="Username" value="<?php echo @$admin_username; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control form-input" name="admin_email" placeholder="Email" value="<?php echo @$admin_email; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Password</label>
                                                <input type="text" class="form-control form-input" name="admin_password" placeholder="Password" value="<?php echo @$admin_password; ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="buttons">
                                        <a href="database.php?license_code=<?php echo $license_code; ?>&purchase_code=<?php echo $purchase_code; ?>" class="btn btn-success btn-custom pull-left">Prev</a>
                                        <button type="submit" name="btn_admin" class="btn btn-success btn-custom pull-right">Finish</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

