<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo htmlspecialchars($title); ?> - <?php echo trans("admin"); ?>&nbsp;<?php echo htmlspecialchars($settings->site_title); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php if (empty($general_settings->favicon_path)): ?>
        <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>assets/img/favicon.png"/>
    <?php else: ?>
        <link rel="shortcut icon" type="image/png" href="<?php echo base_url() . html_escape($general_settings->favicon_path); ?>"/>
    <?php endif; ?>
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/font-awesome/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/AdminLTE.min.css">
    <!-- AdminLTE Skins -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/_all-skins.min.css">
    <!-- Datatables -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/datatables/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/datatables/jquery.dataTables_themeroller.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/icheck/square/purple.css">
    <!-- Page -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/pace/pace.min.css">
    <!-- Tags Input -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/tagsinput/jquery.tagsinput.min.css">
    <!-- File Manager css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/file-manager/file-manager-1.2.css">
    <!-- Custom css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
    <!-- Datetimepicker css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/custom.css">
    <script>var directionality = "ltr";</script>
    <?php if ($site_lang->text_direction == "rtl"): ?>
        <!-- RTL -->
        <link href="<?php echo base_url(); ?>assets/admin/css/rtl.css" rel="stylesheet"/>
        <script>directionality = "rtl";</script>
    <?php endif; ?>
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>assets/admin/js/jquery.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
        var csfr_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csfr_cookie_name = '<?php echo $this->config->item('csrf_cookie_name'); ?>';
        var base_url = '<?php echo base_url(); ?>';
    </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo admin_url(); ?>" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b><?php echo html_escape($settings->application_name); ?></b> <?php echo trans("panel"); ?></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <a class="btn btn-sm btn-success pull-left btn-site-prev" target="_blank" href="<?php echo base_url(); ?>"><i class="fa fa-eye"></i> <?php echo trans("view_site"); ?></a>
                    </li>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo get_user_avatar($this->auth_user); ?>" class="user-image" alt="">
                            <span class="hidden-xs"><?php echo $this->auth_user->username; ?> <i class="fa fa-caret-down"></i> </span>
                        </a>

                        <ul class="dropdown-menu  pull-right" role="menu" aria-labelledby="user-options">
                            <li>
                                <a href="<?php echo base_url(); ?>profile/<?php echo $this->auth_user->slug; ?>"><i class="fa fa-user"></i> <?php echo trans("profile"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>settings"><i class="fa fa-cog"></i> <?php echo trans("update_profile"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>settings/change-password"><i class="fa fa-lock"></i> <?php echo trans("change_password"); ?></a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?php echo base_url(); ?>logout"><i class="fa fa-sign-out"></i> <?php echo trans("logout"); ?></a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php echo get_user_avatar($this->auth_user); ?>" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?php echo html_escape($this->auth_user->username); ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> <?php echo trans("online"); ?></a>
                </div>
            </div>


            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header"><?php echo trans("main_navigation"); ?></li>
                <li class="nav-home">
                    <a href="<?php echo admin_url(); ?>">
                        <i class="fa fa-home"></i>
                        <span><?php echo trans("home"); ?></span>
                    </a>
                </li>
                <?php if (is_admin()): ?>
                    <li class="nav-themes">
                        <a href="<?php echo admin_url(); ?>themes">
                            <i class="fa fa-paint-brush" aria-hidden="true"></i> <span><?php echo trans("themes"); ?></span>
                        </a>
                    </li>
                    <li class="nav-navigation">
                        <a href="<?php echo admin_url(); ?>navigation">
                            <i class="fa fa-th"></i>
                            <span><?php echo trans("navigation"); ?></span>
                        </a>
                    </li>

                    <li class="treeview<?php is_admin_nav_active(['add-page', 'pages', 'update-page']); ?>">
                        <a href="#">
                            <i class="fa fa-leaf"></i> <span><?php echo trans("pages"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-add-page">
                                <a href="<?php echo admin_url(); ?>add-page"><?php echo trans("add_page"); ?></a>
                            </li>
                            <li class="nav-pages">
                                <a href="<?php echo admin_url(); ?>pages"><?php echo trans("pages"); ?></a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <li class="treeview<?php is_admin_nav_active(['posts', 'add-post', 'add-video', 'slider-posts', 'our-picks', 'pending-posts', 'update-post', 'drafts']); ?>">
                    <a href="#">
                        <i class="fa fa-file-text-o"></i> <span><?php echo trans("all_posts"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="nav-add-post">
                            <a href="<?php echo admin_url(); ?>add-post"><?php echo trans("add_post"); ?></a>
                        </li>
                        <li class="nav-add-video">
                            <a href="<?php echo admin_url(); ?>add-video"><?php echo trans("add_video"); ?></a>
                        </li>
                        <li class="nav-posts">
                            <a href="<?php echo admin_url(); ?>posts"><?php echo trans("all_posts"); ?></a>
                        </li>
                        <?php if (is_admin()): ?>
                            <li class="nav-slider-posts">
                                <a href="<?php echo admin_url(); ?>slider-posts"><?php echo trans("slider_posts"); ?></a>
                            </li>
                            <li class="nav-our-picks">
                                <a href="<?php echo admin_url(); ?>our-picks"><?php echo trans("our_picks"); ?></a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-pending-posts">
                            <a href="<?php echo admin_url(); ?>pending-posts"><?php echo trans("pending_posts"); ?></a>
                        </li>
                        <li class="nav-drafts">
                            <a href="<?php echo admin_url(); ?>drafts"><?php echo trans("drafts"); ?></a>
                        </li>
                    </ul>
                </li>
                <?php if (is_admin()): ?>
                    <li class="treeview<?php is_admin_nav_active(['categories', 'subcategories', 'update-category', 'update-subcategory']); ?>">
                        <a href="#">
                            <i class="fa fa-folder-open"></i> <span><?php echo trans("categories"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-categories">
                                <a href="<?php echo admin_url(); ?>categories">
                                    <?php echo trans("categories"); ?>
                                </a>
                            </li>
                            <li class="nav-subcategories">
                                <a href="<?php echo admin_url(); ?>subcategories">
                                    <?php echo trans("subcategories"); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview<?php is_admin_nav_active(['add-poll', 'polls', 'update-poll']); ?>">
                        <a href="#">
                            <i class="fa fa-list"></i> <span><?php echo trans("polls"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-add-poll">
                                <a href="<?php echo admin_url(); ?>add-poll"><?php echo trans("add_poll"); ?></a>
                            </li>
                            <li class="nav-polls">
                                <a href="<?php echo admin_url(); ?>polls"><?php echo trans("polls"); ?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview<?php is_admin_nav_active(['gallery', 'gallery-albums', 'gallery-categories', 'update-gallery-image', 'update-gallery-album', 'update-gallery-category']); ?>">
                        <a href="#">
                            <i class="fa fa-image"></i> <span><?php echo trans("gallery"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-gallery">
                                <a href="<?php echo admin_url(); ?>gallery"><?php echo trans("images"); ?></a>
                            </li>
                            <li class="nav-gallery-albums">
                                <a href="<?php echo admin_url(); ?>gallery-albums"><?php echo trans("albums"); ?></a>
                            </li>
                            <li class="nav-gallery-categories">
                                <a href="<?php echo admin_url(); ?>gallery-categories"><?php echo trans("categories"); ?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview<?php is_admin_nav_active(['pending-comments', 'comments']); ?>">
                        <a href="#">
                            <i class="fa fa-comments"></i> <span><?php echo trans("comments"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-pending-comments">
                                <a href="<?php echo admin_url(); ?>pending-comments"><?php echo trans("pending_comments"); ?></a>
                            </li>
                            <li class="nav-comments">
                                <a href="<?php echo admin_url(); ?>comments"><?php echo trans("approved_comments"); ?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview<?php is_admin_nav_active(['import-feed', 'update-feed', 'feeds']); ?>">
                        <a href="#">
                            <i class="fa fa-rss"></i> <span><?php echo trans("rss_feeds"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-import-feed">
                                <a href="<?php echo admin_url(); ?>import-feed"><?php echo trans("import_rss_feed"); ?></a>
                            </li>
                            <li class="nav-feeds">
                                <a href="<?php echo admin_url(); ?>feeds"><?php echo trans("rss_feeds"); ?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview<?php is_admin_nav_active(['send-email-subscribers', 'subscribers']); ?>">
                        <a href="#">
                            <i class="fa fa-envelope"></i> <span><?php echo trans("newsletter"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-send-email-subscribers">
                                <a href="<?php echo admin_url(); ?>send-email-subscribers"><?php echo trans("send_email_subscribers"); ?></a>
                            </li>
                            <li class="nav-subscribers">
                                <a href="<?php echo admin_url(); ?>subscribers"><?php echo trans("subscribers"); ?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview<?php is_admin_nav_active(['add-user', 'users']); ?>">
                        <a href="#">
                            <i class="fa fa-users"></i> <span><?php echo trans("users"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-add-user">
                                <a href="<?php echo admin_url(); ?>add-user"><?php echo trans("add_user"); ?></a>
                            </li>
                            <li class="nav-users">
                                <a href="<?php echo admin_url(); ?>users"><?php echo trans("users"); ?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-contact-messages">
                        <a href="<?php echo admin_url(); ?>contact-messages">
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                            <span><?php echo trans("contact_messages"); ?></span>
                        </a>
                    </li>
                    <li class="nav-ad-spaces">
                        <a href="<?php echo admin_url(); ?>ad-spaces?type=index_top">
                            <i class="fa fa-dollar" aria-hidden="true"></i>
                            <span><?php echo trans("ad_spaces"); ?></span>
                        </a>
                    </li>
                    <li class="nav-social-login">
                        <a href="<?php echo admin_url(); ?>social-login"><i class="fa fa-share-alt"></i>
                            <span><?php echo trans("social_login_settings"); ?></span>
                        </a>
                    </li>
                    <li class="nav-email-settings">
                        <a href="<?php echo admin_url(); ?>email-settings">
                            <i class="fa fa-cog"></i>
                            <span><?php echo trans("email_settings"); ?></span>
                        </a>
                    </li>
                    <li class="nav-font-settings">
                        <a href="<?php echo admin_url(); ?>font-settings">
                            <i class="fa fa-font" aria-hidden="true"></i>
                            <span><?php echo trans("font_settings"); ?></span>
                        </a>
                    </li>
                    <li class="nav-language-settings">
                        <a href="<?php echo admin_url(); ?>language-settings">
                            <i class="fa fa-language"></i>
                            <span><?php echo trans("language_settings"); ?></span>
                        </a>
                    </li>
                    <li class="nav-seo-tools">
                        <a href="<?php echo admin_url(); ?>seo-tools"><i class="fa fa-wrench"></i>
                            <span><?php echo trans("seo_tools"); ?></span>
                        </a>
                    </li>
                    <li class="nav-cache-system">
                        <a href="<?php echo admin_url(); ?>cache-system">
                            <i class="fa fa-database"></i>
                            <span><?php echo trans("cache_system"); ?></span>
                        </a>
                    </li>
                    <li class="nav-settings">
                        <a href="<?php echo admin_url(); ?>settings">
                            <i class="fa fa-cogs"></i>
                            <span><?php echo trans("settings"); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
    <?php
    $segment2 = @$this->uri->segment(2);
    $segment3 = @$this->uri->segment(3);

    $uri_string = $segment2;
    if (!empty($segment3)) {
        $uri_string .= '-' . $segment3;
    } ?>
    <style>
        <?php if(!empty($uri_string)):
        echo '.nav-'.$uri_string.' > a{color: #fff !important;}';
        else:
        echo '.nav-home > a{color: #fff !important;}';
        endif;?>
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
