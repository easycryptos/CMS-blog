<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $menu_limit = $general_settings->menu_limit; ?>
<div class="nav-mobile-header">
    <div class="container-fluid">
        <div class="row">
            <div class="mobile-header-container">
                <div class="mobile-menu-button">
                    <a href="javascript:void(0)" class="btn-open-mobile-nav"><i class="icon-menu"></i></a>
                </div>
                <div class="mobile-logo">
                    <a href="<?php echo lang_base_url(); ?>"><img src="<?php echo get_mobile_logo($general_settings); ?>" alt="logo"></a>
                </div>
                <div class="mobile-button-buttons">
                    <a href="javascript:void(0)" id="mobile_search_button" class="search-icon"><i class="icon-search"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="navMobile" class="nav-mobile">
    <div class="nav-mobile-logo">
        <a href="<?php echo lang_base_url(); ?>"><img src="<?php echo get_logo($general_settings); ?>" alt="logo"></a>
    </div>
    <a href="javascript:void(0)" class="btn-close-mobile-nav"><i class="icon-close"></i></a>
    <div class="nav-mobile-inner">
        <div class="row">
            <div class="col-sm-12">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="<?php echo lang_base_url(); ?>" class="nav-link"><?php echo trans("home"); ?></a>
                    </li>

                    <?php if (!empty($this->menu_links)):
                        foreach ($this->menu_links as $menu_item):
                            if ($menu_item->item_location == "header" && $menu_item->item_parent_id == "0"):
                                $sub_links = get_sub_menu_links($this->menu_links, $menu_item->item_id, $menu_item->item_type);
                                if (!empty($sub_links)): ?>
                                    <li class="nav-item dropdown">
                                        <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="<?php echo generate_menu_item_url($menu_item); ?>">
                                            <?php echo html_escape($menu_item->item_name); ?>
                                            <i class="icon-arrow-down"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <?php if ($menu_item->item_type == "category"): ?>
                                                <li class="nav-item">
                                                    <a role="menuitem" href="<?php echo generate_menu_item_url($menu_item); ?>" class="nav-link">
                                                        <?php echo trans("all"); ?>
                                                    </a>
                                                </li>
                                            <?php endif;
                                            foreach ($sub_links as $sub_item): ?>
                                                <li class="nav-item">
                                                    <a role="menuitem" href="<?php echo generate_menu_item_url($sub_item); ?>" class="nav-link">
                                                        <?php echo html_escape($sub_item->item_name); ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                <?php else: ?>
                                    <li class="nav-item">
                                        <a href="<?php echo generate_menu_item_url($menu_item); ?>" class="nav-link">
                                            <?php echo html_escape($menu_item->item_name); ?>
                                        </a>
                                    </li>
                                <?php endif;
                            endif;
                        endforeach;
                    endif; ?>

                    <?php if ($this->auth_check) : ?>
                        <li class="dropdown profile-dropdown nav-item">
                            <a href="#" class="dropdown-toggle image-profile-drop nav-link" data-toggle="dropdown" aria-expanded="false">
                                <img src="<?php echo get_user_avatar($this->auth_user); ?>" alt="<?php echo html_escape($this->auth_user->username); ?>">
                                <?php echo html_escape(character_limiter($this->auth_user->username, 20, '...')); ?>&nbsp;
                                <i class="icon-arrow-down"></i>
                            </a>

                            <ul class="dropdown-menu">
                                <?php if (is_admin() || is_author()): ?>
                                    <li>
                                        <a href="<?php echo admin_url(); ?>">
                                            <i class="icon-dashboard"></i>&nbsp;
                                            <?php echo html_escape(trans("admin_panel")); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <a href="<?php echo lang_base_url(); ?>profile/<?php echo $this->auth_user->slug; ?>">
                                        <i class="icon-user"></i>&nbsp;
                                        <?php echo html_escape(trans("profile")); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo lang_base_url(); ?>reading-list">
                                        <i class="icon-star-o"></i>&nbsp;
                                        <?php echo html_escape(trans("reading_list")); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo lang_base_url(); ?>settings">
                                        <i class="icon-settings"></i>&nbsp;
                                        <?php echo html_escape(trans("settings")); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo lang_base_url(); ?>logout">
                                        <i class="icon-logout"></i>&nbsp;
                                        <?php echo trans("logout"); ?>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else : ?>
                        <?php if ($general_settings->registration_system == 1): ?>
                            <li class="nav-item">
                                <a href="<?php echo lang_base_url(); ?>login" class="nav-link">
                                    <?php echo trans("login"); ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo lang_base_url(); ?>register" class="nav-link">
                                    <?php echo trans("register"); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if ($general_settings->multilingual_system == 1 && count($languages) > 1): ?>
                    <div class="dropdown dropdown-mobile-languages dropup">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                            <i class="icon-language"></i>
                            <?php echo html_escape($selected_lang->name); ?>&nbsp;<span class="icon-arrow-down"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-lang">
                            <?php
                            foreach ($languages as $language):
                                $lang_url = base_url() . $language->short_form . "/";
                                if ($language->id == $this->general_settings->site_lang) {
                                    $lang_url = base_url();
                                } ?>
                                <li>
                                    <a href="<?php echo $lang_url; ?>" class="<?php echo ($language->id == $selected_lang->id) ? 'selected' : ''; ?> ">
                                        <?php echo html_escape($language->name); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>



