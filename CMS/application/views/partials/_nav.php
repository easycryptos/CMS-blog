<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $menu_limit = $general_settings->menu_limit; ?>
<!--navigation-->
<div class="nav-desktop">
    <div class="collapse navbar-collapse navbar-left">
        <ul class="nav navbar-nav">
            <li class="<?php echo ($active_page == 'index' || $active_page == "") ? 'active' : ''; ?>">
                <a href="<?php echo lang_base_url(); ?>">
                    <?php echo trans("home"); ?>
                </a>
            </li>
            <?php
            $total_item = 1;
            $i = 1;
            if (!empty($this->menu_links)):
                foreach ($this->menu_links as $menu_item):
                    if ($menu_item->item_location == "header" && $menu_item->item_parent_id == "0"):
                        if ($i < $menu_limit):
                            $sub_links = get_sub_menu_links($this->menu_links, $menu_item->item_id, $menu_item->item_type);
                            if (!empty($sub_links)): ?>
                                <li class="dropdown <?php echo ($active_page == $menu_item->item_slug) ? 'active' : ''; ?>">
                                    <a class="dropdown-toggle disabled" data-toggle="dropdown" href="<?php echo generate_menu_item_url($menu_item); ?>">
                                        <?php echo html_escape($menu_item->item_name); ?>
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu top-dropdown">
                                        <?php foreach ($sub_links as $sub_item): ?>
                                            <li>
                                                <a role="menuitem" href="<?php echo generate_menu_item_url($sub_item); ?>">
                                                    <?php echo html_escape($sub_item->item_name); ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php else: ?>
                                <li class="<?php echo (!empty($active_page) && $active_page == $menu_item->item_slug) ? 'active' : ''; ?>">
                                    <a href="<?php echo generate_menu_item_url($menu_item); ?>">
                                        <?php echo html_escape($menu_item->item_name); ?>
                                    </a>
                                </li>
                            <?php endif;
                            $i++;
                        endif;
                        $total_item++;
                    endif;
                endforeach;
            endif; ?>

            <?php
            if ($total_item > $menu_limit): ?>
                <li class="dropdown">
                    <a class="dropdown-toggle dropdown-more" data-toggle="dropdown" href="#">
                        <i class="icon-ellipsis-h more-sign"></i>
                    </a>
                    <ul class="dropdown-menu top-dropdown">
                        <?php
                        $i = 1;
                        if (!empty($this->menu_links)):
                            foreach ($this->menu_links as $menu_item):
                                if ($menu_item->item_location == "header" && $menu_item->item_parent_id == "0"):
                                    if ($i >= $menu_limit):
                                        $sub_links = get_sub_menu_links($this->menu_links, $menu_item->item_id, $menu_item->item_type);
                                        if (!empty($sub_links)): ?>
                                            <li class="li-sub-dropdown">
                                                <a class="dropdown-toggle disabled" data-toggle="dropdown" href="<?php echo generate_menu_item_url($menu_item); ?>">
                                                    <?php echo html_escape($menu_item->item_name); ?>&nbsp;<span class="caret"></span>
                                                </a>
                                                <ul class="dropdown-menu sub-dropdown">
                                                    <?php foreach ($sub_links as $sub_item): ?>
                                                        <li>
                                                            <a role="menuitem" href="<?php echo generate_menu_item_url($sub_item); ?>">
                                                                <?php echo html_escape($sub_item->item_name); ?>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </li>
                                        <?php else: ?>
                                            <li>
                                                <a href="<?php echo generate_menu_item_url($menu_item); ?>">
                                                    <?php echo html_escape($menu_item->item_name); ?>
                                                </a>
                                            </li>
                                        <?php endif;
                                    endif;
                                    $i++;
                                endif;
                            endforeach;
                        endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>

        <ul class="nav navbar-nav nav-right">
            <?php if ($this->auth_check) : ?>
                <li class="dropdown profile-dropdown nav-item-right">
                    <a href="#" class="dropdown-toggle image-profile-drop" data-toggle="dropdown"
                       aria-expanded="false">
                        <img src="<?php echo get_user_avatar($this->auth_user); ?>" alt="<?php echo html_escape($this->auth_user->username); ?>">
                        <?php echo html_escape(character_limiter($this->auth_user->username, 20, '...')); ?>&nbsp;
                        <i class="icon-arrow-down"></i>
                    </a>
                    <ul class="dropdown-menu top-dropdown">
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
                    <li class="nav-item-right <?php echo ($active_page == 'login') ? 'active' : ''; ?>">
                        <a href="<?php echo lang_base_url(); ?>login">
                            <?php echo html_escape(trans("login")); ?>
                        </a>
                    </li>
                    <li class="nav-item-right <?php echo ($active_page == 'register') ? 'active' : ''; ?>">
                        <a href="<?php echo lang_base_url(); ?>register">
                            <?php echo html_escape(trans("register")); ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            <li class="nav-item-right">
                <a href="#" data-toggle="modal-search" id="search_button" class="search-icon"><i class="icon-search"></i></a>
            </li>
        </ul>
    </div>
</div>
