<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="<?php echo $this->selected_lang->short_form ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo xss_clean($title); ?> - <?php echo xss_clean($settings->site_title); ?></title>
    <meta name="description" content="<?php echo xss_clean($description); ?>"/>
    <meta name="keywords" content="<?php echo xss_clean($keywords); ?>"/>
    <meta name="author" content="Codingest"/>
    <meta name="robots" content="all"/>
    <meta name="revisit-after" content="1 Days"/>
    <meta property="og:locale" content="<?php echo $this->selected_lang->language_code ?>"/>
    <meta property="og:site_name" content="<?php echo $settings->application_name; ?>"/>
<?php if (isset($page_type)): ?>
    <meta property="og:type" content="<?php echo $og_type; ?>"/>
    <meta property="og:title" content="<?php echo xss_clean($post->title); ?>"/>
    <meta property="og:description" content="<?php echo xss_clean($post->summary); ?>"/>
    <meta property="og:url" content="<?php echo $og_url; ?>"/>
    <meta property="og:image" content="<?php echo $og_image; ?>"/>
    <meta property="og:image:width" content="750"/>
    <meta property="og:image:height" content="415"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:site" content="<?php echo $settings->application_name; ?>"/>
    <meta name="twitter:title" content="<?php echo xss_clean($post->title); ?>"/>
    <meta name="twitter:description" content="<?php echo xss_clean($post->summary); ?>"/>
    <meta name="twitter:image" content="<?php echo $og_image; ?>"/>
<?php foreach ($og_tags as $tag): ?>
    <meta property="article:tag" content="<?php echo $tag->tag; ?>"/>
<?php endforeach; ?>
<?php else: ?>
    <meta property="og:image" content="<?php echo get_logo($general_settings); ?>"/>
    <meta property="og:image:width" content="180"/>
    <meta property="og:image:height" content="50"/>
    <meta property="og:type" content=website/>
    <meta property="og:title" content="<?php echo xss_clean($title); ?> - <?php echo xss_clean($settings->site_title); ?>"/>
    <meta property="og:description" content="<?php echo xss_clean($description); ?>"/>
    <meta property="og:url" content="<?php echo base_url(); ?>"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:site" content="<?php echo $settings->application_name; ?>"/>
    <meta name="twitter:title" content="<?php echo xss_clean($title); ?> - <?php echo xss_clean($settings->site_title); ?>"/>
    <meta name="twitter:description" content="<?php echo xss_clean($description); ?>"/>
    <meta name="twitter:image" content="<?php echo get_logo($general_settings); ?>"/>
<?php endif; ?>
    <link rel="canonical" href="<?php echo current_url(); ?>"/>
<?php if ($general_settings->multilingual_system == 1):
foreach ($languages as $language):
if ($language->id == $site_lang->id):?>
    <link rel="alternate" hreflang="<?php echo $language->language_code ?>" href="<?php echo base_url(); ?>"/>
<?php else: ?>
    <link rel="alternate" hreflang="<?php echo $language->language_code ?>" href="<?php echo base_url() . $language->short_form . "/"; ?>"/>
<?php endif; endforeach; endif; ?>
<?php if (empty($general_settings->favicon_path)): ?>
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>assets/img/favicon.png"/>
<?php else: ?>
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url() . html_escape($general_settings->favicon_path); ?>"/>
<?php endif;?>
    <?php echo !empty($this->fonts->primary_font_url) ? $this->fonts->primary_font_url : '';?>
    <?php echo !empty($this->fonts->secondary_font_url) ? $this->fonts->secondary_font_url : ''; ?>

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/font-icons/css/icons.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="<?php echo base_url(); ?>assets/vendor/slick/slick.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/css/magnific-popup.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/css/style-4.0.min.css" rel="stylesheet"/>
<?php if ($this->dark_mode == 1) : ?>
    <link href="<?php echo base_url(); ?>assets/css/dark.min.css" rel="stylesheet"/>
<?php endif;
if (empty($this->site_color) || $this->site_color == 'default') : ?>
    <link href="<?php echo base_url(); ?>assets/css/colors/default.min.css" rel="stylesheet"/>
<?php else : ?>
    <link href="<?php echo base_url(); ?>assets/css/colors/<?php echo html_escape($this->site_color); ?>.min.css" rel="stylesheet"/>
<?php endif;
if ($selected_lang->text_direction == "rtl"): ?>
    <link href="<?php echo base_url(); ?>assets/css/rtl.min.css" rel="stylesheet"/>
<?php endif;?>
    <?php $this->load->view('partials/_font_style');?>
    <?php echo $general_settings->custom_css_codes; ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Jquery -->
    <script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.min.js"></script>
    <?php echo $general_settings->google_adsense_code; ?>
<?php if ($selected_lang->text_direction == "rtl"): ?><script>var rtl = true;</script><?php else: ?><script>var rtl = false;</script><?php endif; ?>

</head>
<body>
<!-- header -->
<header id="header">
    <nav class="navbar navbar-inverse" role="banner">
        <div class="container nav-container">
            <div class="navbar-header logo-cnt">
                <a class="navbar-brand" href="<?php echo lang_base_url(); ?>">
                    <img src="<?php echo get_logo($general_settings); ?>" alt="logo">
                </a>
            </div>
            <?php
            $active_page = uri_string();
            if ($general_settings->site_lang != $selected_lang->id) {
                $active_page = $this->uri->segment(2);
            }
            $this->load->view("partials/_nav.php", ['active_page' => $active_page]); ?>
        </div>
        <div class="mobile-nav-container">
            <?php $this->load->view("partials/_nav_mobile.php", ['active_page' => $active_page]); ?>
        </div>
    </nav><!--/nav-->
    <!--search modal-->
    <div class="modal-search">
        <?php echo form_open(lang_base_url() . 'search', ['method' => 'get']); ?>
        <div class="container">
            <input type="text" name="q" class="form-control" maxlength="300" pattern=".*\S+.*"
                   placeholder="<?php echo html_escape(trans("search_exp")); ?>" required <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
            <i class="icon-close s-close"></i>
        </div>
        <?php echo form_close(); ?>
    </div><!-- /.modal-search -->
</header>
<!-- /.header-->
<div id="overlay_bg" class="overlay-bg"></div>