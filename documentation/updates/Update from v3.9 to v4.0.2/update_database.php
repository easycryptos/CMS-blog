<?php
define('BASEPATH', "/");
define('ENVIRONMENT', 'production');
require_once "application/config/database.php";
$license_code = '';
$purchase_code = '';

if (file_exists('license.php')) {
    include 'license.php';
}

if (!function_exists('curl_init')) {
    $error = 'cURL is not available on your server! Please enable cURL to continue the installation. You can read the documentation for more information.';
    exit();
}

//set database credentials
$database = $db['default'];
$db_host = $database['hostname'];
$db_name = $database['database'];
$db_user = $database['username'];
$db_password = $database['password'];

/* Connect */
$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);
$connection->query("SET CHARACTER SET utf8");
$connection->query("SET NAMES utf8");
if (!$connection) {
    $error = "Connect failed! Please check your database credentials.";
}

if (isset($_POST["btn_submit"])) {
	$license_code = 'license_code';
	$purchase_code = 'purchase_code';
	update($license_code, $purchase_code, $connection);
	sleep(1);
	/* close connection */
	mysqli_close($connection);
	$success = 'The update has been successfully completed! Please delete the "update_database.php" file.';
}

function update($license_code, $purchase_code, $connection)
{
    update_39_to_40($license_code, $purchase_code, $connection);
}

function update_39_to_40($license_code, $purchase_code, $connection)
{
    $table_sessions = "CREATE TABLE IF NOT EXISTS `ci_sessions` (
    `id` varchar(128) NOT NULL,
    `ip_address` varchar(45) NOT NULL,
    `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
    `data` blob NOT NULL,
    KEY `ci_sessions_timestamp` (`timestamp`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_fonts = "CREATE TABLE `fonts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `font_name` varchar(255) DEFAULT NULL,
    `font_url` varchar(2000) DEFAULT NULL,
    `font_family` varchar(500) DEFAULT NULL,
    `is_default` tinyint(1) DEFAULT '0'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_language_translations = "CREATE TABLE `language_translations` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `lang_id` smallint(6) DEFAULT NULL,
    `label` varchar(255) DEFAULT NULL,
    `translation` varchar(500) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_rss_feeds = "CREATE TABLE `rss_feeds` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `lang_id` int(11) DEFAULT 1,
    `feed_name` varchar(500) DEFAULT NULL,
    `feed_url` varchar(1000) DEFAULT NULL,
    `post_limit` smallint(6) DEFAULT NULL,
    `category_id` int(11) DEFAULT NULL,
    `image_saving_method` varchar(30) DEFAULT 'url',
    `generate_keywords_from_title` tinyint(1) NOT NULL DEFAULT 1,
    `auto_update` tinyint(1) DEFAULT 1,
    `read_more_button` tinyint(1) DEFAULT 1,
    `read_more_button_text` varchar(255) DEFAULT 'Read More',
    `user_id` int(11) DEFAULT NULL,
    `add_posts_as_draft` tinyint(1) DEFAULT 0,
    `is_cron_updated` tinyint(1) NOT NULL DEFAULT 0,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";


    mysqli_query($connection, $table_sessions);
    mysqli_query($connection, $table_fonts);
    mysqli_query($connection, $table_language_translations);
    mysqli_query($connection, $table_rss_feeds);
    sleep(1);
    mysqli_query($connection, "ALTER TABLE files ADD COLUMN `user_id` INT(11) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `file_manager_show_all_files` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE general_settings DROP COLUMN `primary_font`;");
    mysqli_query($connection, "ALTER TABLE general_settings DROP COLUMN `secondary_font`;");
    mysqli_query($connection, "ALTER TABLE general_settings DROP COLUMN `text_editor_lang`;");
    mysqli_query($connection, "ALTER TABLE general_settings DROP COLUMN `emoji_reactions_type`;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `maintenance_mode_title` VARCHAR(500) DEFAULT 'Coming Soon!';");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `maintenance_mode_description` VARCHAR(5000);");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `maintenance_mode_status` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `sitemap_frequency` VARCHAR(30) DEFAULT 'monthly';");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `sitemap_last_modification` VARCHAR(30) DEFAULT 'server_response';");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `sitemap_priority` VARCHAR(30) DEFAULT 'automatically';");
    mysqli_query($connection, "ALTER TABLE general_settings CHANGE `head_code` `custom_css_codes` MEDIUMTEXT;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `custom_javascript_codes` MEDIUMTEXT;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `last_cron_update` TIMESTAMP;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `version` VARCHAR(30) DEFAULT '4.0';");
    mysqli_query($connection, "ALTER TABLE images ADD COLUMN `user_id` INT(11);");
    mysqli_query($connection, "ALTER TABLE languages ADD COLUMN `text_editor_lang` VARCHAR(20) DEFAULT 'en';");
    mysqli_query($connection, "ALTER TABLE posts ADD COLUMN `title_hash` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE posts ADD COLUMN `feed_id` INT(11);");
    mysqli_query($connection, "ALTER TABLE posts ADD COLUMN `post_url` VARCHAR(1000);");
    mysqli_query($connection, "ALTER TABLE posts ADD COLUMN `show_post_url` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE settings ADD COLUMN `primary_font` SMALLINT(6) DEFAULT 19;");
    mysqli_query($connection, "ALTER TABLE settings ADD COLUMN `secondary_font` SMALLINT(6) DEFAULT 25;");
    mysqli_query($connection, "ALTER TABLE settings ADD COLUMN `telegram_url` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE settings ADD COLUMN `youtube_url` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE users ADD COLUMN `site_color` VARCHAR(30) DEFAULT 'default';");
    mysqli_query($connection, "ALTER TABLE users ADD COLUMN `site_mode` VARCHAR(10) DEFAULT 'light';");
    mysqli_query($connection, "ALTER TABLE users ADD COLUMN `telegram_url` VARCHAR(500);");

    //add fonts
    $sql_fonts = "INSERT INTO `fonts` (`id`, `font_name`, `font_url`, `font_family`, `is_default`) VALUES
(1, 'Arial', NULL, 'font-family: Arial, Helvetica, sans-serif', 1),
(2, 'Arvo', '<link href=\"https://fonts.googleapis.com/css?family=Arvo:400,700&display=swap\" rel=\"stylesheet\">\r\n', 'font-family: \"Arvo\", Helvetica, sans-serif', 0),
(3, 'Averia Libre', '<link href=\"https://fonts.googleapis.com/css?family=Averia+Libre:300,400,700&display=swap\" rel=\"stylesheet\">\r\n', 'font-family: \"Averia Libre\", Helvetica, sans-serif', 0),
(4, 'Bitter', '<link href=\"https://fonts.googleapis.com/css?family=Bitter:400,400i,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Bitter\", Helvetica, sans-serif', 0),
(5, 'Cabin', '<link href=\"https://fonts.googleapis.com/css?family=Cabin:400,500,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Cabin\", Helvetica, sans-serif', 0),
(6, 'Cherry Swash', '<link href=\"https://fonts.googleapis.com/css?family=Cherry+Swash:400,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Cherry Swash\", Helvetica, sans-serif', 0),
(7, 'Encode Sans', '<link href=\"https://fonts.googleapis.com/css?family=Encode+Sans:300,400,500,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Encode Sans\", Helvetica, sans-serif', 0),
(8, 'Helvetica', NULL, 'font-family: Helvetica, sans-serif', 1),
(9, 'Hind', '<link href=\"https://fonts.googleapis.com/css?family=Hind:300,400,500,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">', 'font-family: \"Hind\", Helvetica, sans-serif', 0),
(10, 'Josefin Sans', '<link href=\"https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Josefin Sans\", Helvetica, sans-serif', 0),
(11, 'Kalam', '<link href=\"https://fonts.googleapis.com/css?family=Kalam:300,400,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Kalam\", Helvetica, sans-serif', 0),
(12, 'Khula', '<link href=\"https://fonts.googleapis.com/css?family=Khula:300,400,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Khula\", Helvetica, sans-serif', 0),
(13, 'Lato', '<link href=\"https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">', 'font-family: \"Lato\", Helvetica, sans-serif', 0),
(14, 'Lora', '<link href=\"https://fonts.googleapis.com/css?family=Lora:400,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Lora\", Helvetica, sans-serif', 0),
(15, 'Merriweather', '<link href=\"https://fonts.googleapis.com/css?family=Merriweather:300,400,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Merriweather\", Helvetica, sans-serif', 0),
(16, 'Montserrat', '<link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Montserrat\", Helvetica, sans-serif', 0),
(17, 'Mukta', '<link href=\"https://fonts.googleapis.com/css?family=Mukta:300,400,500,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Mukta\", Helvetica, sans-serif', 0),
(18, 'Nunito', '<link href=\"https://fonts.googleapis.com/css?family=Nunito:300,400,600,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Nunito\", Helvetica, sans-serif', 0),
(19, 'Open Sans', '<link href=\"https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Open Sans\", Helvetica, sans-serif', 0),
(20, 'Oswald', '<link href=\"https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Oswald\", Helvetica, sans-serif', 0),
(21, 'Oxygen', '<link href=\"https://fonts.googleapis.com/css?family=Oxygen:300,400,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Oxygen\", Helvetica, sans-serif', 0),
(22, 'Poppins', '<link href=\"https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Poppins\", Helvetica, sans-serif', 0),
(23, 'PT Sans', '<link href=\"https://fonts.googleapis.com/css?family=PT+Sans:400,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"PT Sans\", Helvetica, sans-serif', 0),
(24, 'Raleway', '<link href=\"https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Raleway\", Helvetica, sans-serif', 0),
(25, 'Roboto', '<link href=\"https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Roboto\", Helvetica, sans-serif', 0),
(26, 'Roboto Condensed', '<link href=\"https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Roboto Condensed\", Helvetica, sans-serif', 0),
(27, 'Roboto Slab', '<link href=\"https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,500,600,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Roboto Slab\", Helvetica, sans-serif', 0),
(28, 'Rokkitt', '<link href=\"https://fonts.googleapis.com/css?family=Rokkitt:300,400,500,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Rokkitt\", Helvetica, sans-serif', 0),
(29, 'Source Sans Pro', '<link href=\"https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Source Sans Pro\", Helvetica, sans-serif', 0),
(30, 'Titillium Web', '<link href=\"https://fonts.googleapis.com/css?family=Titillium+Web:300,400,600,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">', 'font-family: \"Titillium Web\", Helvetica, sans-serif', 0),
(31, 'Ubuntu', '<link href=\"https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext\" rel=\"stylesheet\">', 'font-family: \"Ubuntu\", Helvetica, sans-serif', 0),
(32, 'Verdana', NULL, 'font-family: Verdana, Helvetica, sans-serif', 1);";
    mysqli_query($connection, $sql_fonts);
    sleep(1);

    //add language translations
    $sql = "SELECT * FROM languages ORDER BY id";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $path = "old/application/language/" . $row["folder_name"] . "/site_lang.php";
        if (file_exists($path)) {
            include $path;
            if (!empty($lang)) {
                foreach ($lang as $key => $value) {
                    $insert_translation = "INSERT INTO `language_translations` (`lang_id`, `label`, `translation`) 
                    VALUES (" . $row["id"] . ", '" . $key . "' , '" . $value . "')";
                    mysqli_query($connection, $insert_translation);
                }
            }
        }
    }
    mysqli_query($connection, "ALTER TABLE languages DROP COLUMN `folder_name`;");

    //add new translations
    $p = array();
    $p["import_rss_feed"] = "Import RSS Feed";
    $p["feed_name"] = "Feed Name";
    $p["feed_url"] = "Feed URL";
    $p["number_of_posts_import"] = "Number of Posts to Import";
    $p["show_images_from_original_source"] = "Show Images from Original Source";
    $p["download_images_my_server"] = "Download Images to My Server";
    $p["auto_update"] = "Auto Update";
    $p["show_read_more_button"] = "Show Read More Button";
    $p["add_posts_as_draft"] = "Add Posts as Draft";
    $p["read_more_button_text"] = "Read More Button Text";
    $p["update"] = "Update";
    $p["msg_rss_warning"] = "If you chose to download the images to your server, adding posts will take more time and will use more resources. If you see any problems, increase 'max_execution_time' and 'memory_limit' values from your server settings.";
    $p["msg_cron_feed"] = "With this URL you can automatically update your feeds.";
    $p["update_rss_feed"] = "Update Rss Feed";
    $p["feed"] = "Feed";
    $p["generate_keywords_from_title"] = "Generate Keywords from Title";
    $p["confirm_item"] = "Are you sure you want to delete this item?";
    $p["file_manager"] = "File Manager";
    $p["show_all_files"] = "Show all Files";
    $p["show_only_own_files"] = "Show Only Users Own Files";
    $p["maintenance_mode"] = "Maintenance Mode";
    $p["msg_cron_sitemap"] = "With this URL you can automatically update your sitemap.";
    $p["custom_css_codes"] = "Custom CSS Codes";
    $p["custom_javascript_codes"] = "Custom JavaScript Codes";
    $p["custom_css_codes_exp"] = "These codes will be added to the header of the site.";
    $p["custom_javascript_codes_exp"] = "These codes will be added to the footer of the site.";
    $p["font_settings"] = "Font Settings";
    $p["site_font"] = "Site Font";
    $p["add_font"] = "Add Font";
    $p["font_family"] = "Font Family";
    $p["fonts"] = "Fonts";
    $p["update_font"] = "Update Font";
    $p["msg_item_added"] = "Item successfully added!";

    //add new phrases
    $sql = "SELECT * FROM languages ORDER BY id";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($result)) {
        if (!empty($p)) {
            foreach ($p as $key => $value) {
                $insert_new_translation = "INSERT INTO `language_translations` (`lang_id`, `label`, `translation`) 
                    VALUES (" . $row["id"] . ", '" . $key . "' , '" . $value . "')";
                mysqli_query($connection, $insert_new_translation);
            }
        }
    }

    //add keys
    mysqli_query($connection, "ALTER TABLE categories ADD INDEX idx_lang_id (lang_id);");
    mysqli_query($connection, "ALTER TABLE categories ADD INDEX idx_parent_id (parent_id);");
    mysqli_query($connection, "ALTER TABLE comments ADD INDEX idx_parent_id (parent_id);");
    mysqli_query($connection, "ALTER TABLE comments ADD INDEX idx_post_id (post_id);");
    mysqli_query($connection, "ALTER TABLE comments ADD INDEX idx_user_id (user_id);");
    mysqli_query($connection, "ALTER TABLE comments ADD INDEX idx_status (status);");
    mysqli_query($connection, "ALTER TABLE files ADD INDEX idx_user_id (user_id);");
    mysqli_query($connection, "ALTER TABLE followers ADD INDEX idx_following_id (following_id);");
    mysqli_query($connection, "ALTER TABLE followers ADD INDEX idx_follower_id (follower_id);");
    mysqli_query($connection, "ALTER TABLE images ADD INDEX idx_user_id (user_id);");
    mysqli_query($connection, "ALTER TABLE language_translations ADD INDEX idx_lang_id (lang_id);");
    mysqli_query($connection, "ALTER TABLE posts ADD INDEX idx_lang_id (lang_id);");
    mysqli_query($connection, "ALTER TABLE posts ADD INDEX idx_user_id (user_id);");
    mysqli_query($connection, "ALTER TABLE posts ADD INDEX idx_category_id (category_id);");
    mysqli_query($connection, "ALTER TABLE posts ADD INDEX idx_is_slider (is_slider);");
    mysqli_query($connection, "ALTER TABLE posts ADD INDEX idx_is_picked (is_picked);");
    mysqli_query($connection, "ALTER TABLE posts ADD INDEX idx_visibility (visibility);");
    mysqli_query($connection, "ALTER TABLE posts ADD INDEX idx_status (status);");
    mysqli_query($connection, "ALTER TABLE posts ADD INDEX idx_created_at (created_at);");
    mysqli_query($connection, "ALTER TABLE tags ADD INDEX idx_post_id (post_id);");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Infinite - Update Wizard</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700" rel="stylesheet">
    <!-- Font-awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #444 !important;
            font-size: 14px;

            background: #007991; /* fallback for old browsers */
            background: -webkit-linear-gradient(to left, #007991, #6fe7c2); /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to left, #007991, #6fe7c2); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }

        .logo-cnt {
            text-align: center;
            color: #fff;
            padding: 60px 0 60px 0;
        }

        .logo-cnt .logo {
            font-size: 42px;
            line-height: 42px;
        }

        .logo-cnt p {
            font-size: 22px;
        }

        .install-box {
            width: 100%;
            padding: 30px;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            margin: auto;
            background-color: #fff;
            border-radius: 4px;
            display: block;
            float: left;
            margin-bottom: 100px;
        }

        .form-input {
            box-shadow: none !important;
            border: 1px solid #ddd;
            height: 44px;
            line-height: 44px;
            padding: 0 20px;
        }

        .form-input:focus {
            border-color: #239CA1 !important;
        }

        .btn-custom {
            background-color: #239CA1 !important;
            border-color: #239CA1 !important;
            border: 0 none;
            border-radius: 4px;
            box-shadow: none;
            color: #fff !important;
            font-size: 16px;
            font-weight: 300;
            height: 40px;
            line-height: 40px;
            margin: 0;
            min-width: 105px;
            padding: 0 20px;
            text-shadow: none;
            vertical-align: middle;
        }

        .btn-custom:hover, .btn-custom:active, .btn-custom:focus {
            background-color: #239CA1;
            border-color: #239CA1;
            opacity: .8;
        }

        .tab-content {
            width: 100%;
            float: left;
            display: block;
        }

        .tab-footer {
            width: 100%;
            float: left;
            display: block;
        }

        .buttons {
            display: block;
            float: left;
            width: 100%;
            margin-top: 30px;
        }

        .title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
            margin-top: 0;
            text-align: center;
        }

        .sub-title {
            font-size: 14px;
            font-weight: 400;
            margin-bottom: 30px;
            margin-top: 0;
            text-align: center;
        }

        .alert {
            text-align: center;
        }

        .alert strong {
            font-weight: 500 !important;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-sm-12 col-md-offset-2">

            <div class="row">
                <div class="col-sm-12 logo-cnt">
                    <h1>Infinite</h1>
                    <p>Welcome to the Update Wizard</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="install-box">
                        <h2 class="title">Update from v3.9 to v4.0.2</h2>
                        <br><br>
                        <div class="messages">
                            <?php if (!empty($error)) { ?>
                                <div class="alert alert-danger">
                                    <strong><?php echo $error; ?></strong>
                                </div>
                            <?php } ?>
                            <?php if (!empty($success)) { ?>
                                <div class="alert alert-success">
                                    <strong><?php echo $success; ?></strong>
                                    <style>.alert-info {
                                            display: none;
                                        }</style>
                                </div>
                            <?php } ?>
                        </div>
                        <?php
                        if (empty($success)):
                            if (empty($license_array) || empty($license_array["purchase_code"]) || empty($license_array["license_code"])): ?>
                                <div class="alert alert-info" role="alert">
                                    You can get your license code from our support system: <a href="https://codingest.net/" target="_blank"><strong>https://codingest.net</strong></a>
                                </div>
                            <?php endif;
                        endif; ?>
                        <div class="step-contents">
                            <div class="tab-1">
                                <?php if (empty($success)): ?>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                        <div class="tab-content">
                                            <div class="tab_1">
                                                <?php if (empty($license_array) || empty($license_array["purchase_code"]) || empty($license_array["license_code"])): ?>
                                                    <div class="form-group">
                                                        <label for="email">License Code</label>
                                                        <textarea name="license_code" class="form-control form-input" style="resize: vertical; min-height: 80px; height: 80px; line-height: 24px;padding: 10px;" placeholder="Enter License Code" required><?php echo $license_code; ?></textarea>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="tab-footer text-center">
                                            <button type="submit" name="btn_submit" class="btn-custom">Update My Database</button>
                                        </div>
                                    </form>
                                <?php endif; ?>
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
