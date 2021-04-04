<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
?>

<?php include(APPPATH . "config/database.php");
$hostname = @$db['default']['hostname'];
$database = @$db['default']['database'];
$username = @$db['default']['username'];

$root = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
$root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
$install_path = $root . "install";
?>

<?php if (empty($hostname) || empty($database) || empty($username)):
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Infinite</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet">
        <style>
            b, br {
                display: none;
            }

            html {
                height: 100%;
            }

            body {
                height: 100%;
                font-family: 'Open Sans', sans-serif;
                color: #fff !important;
                font-size: 15px;
                overflow: hidden;
            }

            .wrapper {
                width: 100%;
                height: 100%;
                position: relative;
                display: block;
            }

            .center {
                position: absolute;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                height: 400px;
                width: 400px;
                max-width: 100%;
                margin: auto;
                text-align: center;
            }

            .title {
                color: #555 !important;
                font-size: 102px;
                line-height: 102px;
                font-weight: 300;
                margin: 0;
            }

            .version {
                margin-bottom: 60px;
                color: #999;
            }

            .button {
                display: inline-block;
                text-align: center;
                vertical-align: middle;
                -ms-touch-action: manipulation;
                touch-action: manipulation;
                cursor: pointer;
                font-size: 16px;
                border-radius: 25px;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                color: #fff;
                text-decoration: none;
                height: 50px;
                line-height: 50px;
                padding: 0 80px;
            }

            .button {
                background-image: linear-gradient(to right, #02AAB0 0%, #00CDAC 51%, #02AAB0 100%)
            }

            .button:hover {
                background-position: right center;
            }

            @media only screen and (max-width: 768px) {
                .title {
                    font-size: 72px;
                    line-height: 72px;
                }
            }
        </style>
    </head>
    <body>

    <div class="wrapper">
        <div class="center">
            <h1 class="title">Infinite</h1>
            <p class="version">Version 4.0.2</p>
            <a href="<?php echo $install_path; ?>" class="button">Install</a>
        </div>
    </div>


    </body>
    </html>
    <?php exit();
endif; ?>


<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

    <h4>A PHP Error was encountered</h4>

    <p>Severity: <?php echo $severity; ?></p>
    <p>Message: <?php echo $message; ?></p>
    <p>Filename: <?php echo $filepath; ?></p>
    <p>Line Number: <?php echo $line; ?></p>

    <?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

        <p>Backtrace:</p>
        <?php foreach (debug_backtrace() as $error): ?>

            <?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

                <p style="margin-left:10px">
                    File: <?php echo $error['file'] ?><br/>
                    Line: <?php echo $error['line'] ?><br/>
                    Function: <?php echo $error['function'] ?>
                </p>

            <?php endif ?>

        <?php endforeach ?>

    <?php endif; ?>

</div>
