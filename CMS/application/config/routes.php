<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
include_once "route_slugs.php";

$general_settings = $this->config->item('general_settings');
$languages = $this->config->item('languages');

//routes
$r_admin = $custom_slug_array["admin"];

$route['default_controller'] = 'home_controller';
$route['404_override'] = 'home_controller/error_404';
$route['translate_uri_dashes'] = FALSE;
$route['index'] = 'home_controller/index';
$route['error-404'] = 'home_controller/error_404';

$route['gallery'] = 'home_controller/gallery';
$route['gallery/album/(:num)'] = 'home_controller/gallery_album/$1';
$route['contact'] = 'home_controller/contact';
$route['profile/(:any)'] = 'profile_controller/profile/$1';
$route['tag/(:any)'] = 'home_controller/tag/$1';
$route['reading-list'] = 'home_controller/reading_list';
$route['search'] = 'home_controller/search';

//rss routes
$route['rss-feeds'] = 'home_controller/rss_feeds';
$route['rss/posts'] = 'home_controller/rss_all_posts';
$route['rss/popular-posts'] = 'home_controller/rss_popular_posts';
$route['rss/category/(:any)'] = 'home_controller/rss_by_category/$1';

//auth routes
$route['login'] = 'auth_controller/login';
$route['admin/login'] = 'auth_controller/admin_login';
$route['register'] = 'auth_controller/register';
$route['profile-update'] = 'auth_controller/update_profile';
$route['change-password'] = 'auth_controller/change_password';
$route['forgot-password'] = 'auth_controller/forgot_password';
$route['reset-password'] = 'auth_controller/reset_password';
$route['logout'] = 'common_controller/logout';

//profile routes
$route['settings'] = 'profile_controller/update_profile';
$route['settings/social-accounts'] = 'profile_controller/social_accounts';
$route['settings/visual-settings'] = 'profile_controller/visual_settings';
$route['settings/change-password'] = 'profile_controller/change_password';
$route["unsubscribe"] = "auth_controller/unsubscribe";
$route["cron/update-sitemap"] = "cron_controller/update_sitemap";
$route["cron/update-feeds"] = "cron_controller/check_feed_posts";
$route["run-internal-cron"] = "ajax_controller/run_internal_cron";

$route['connect-with-facebook'] = 'auth_controller/connect_with_facebook';
$route['facebook-callback'] = 'auth_controller/facebook_callback';
$route['connect-with-google'] = 'auth_controller/connect_with_google';
$route['download-file'] = 'home_controller/download_post_file';

$route['category/(:any)'] = 'home_controller/category_old/$1';

$route['add-remove-reading-list']['POST'] = 'home_controller/add_remove_from_reading_list_post';

/*
 *
 * ADMIN ROUTES
 *
 */
//admin
$route[$r_admin] = 'admin_controller/index';
$route[$r_admin . "/login"] = 'common_controller/admin_login';
/*navigation routes*/
$route[$r_admin . '/navigation'] = 'admin_controller/navigation';
$route[$r_admin . "/update-menu-link/(:num)"] = 'admin_controller/update_menu_link/$1';

$route[$r_admin . '/themes'] = 'admin_controller/themes';

//page
$route[$r_admin . "/add-page"] = 'page_controller/add_page';
$route[$r_admin . "/update-page/(:num)"] = 'page_controller/update_page/$1';
$route[$r_admin . "/pages"] = 'page_controller/pages';

//category
$route[$r_admin . "/categories"] = 'category_controller/categories';
$route[$r_admin . "/categories"] = 'category_controller/categories';
$route[$r_admin . "/subcategories"] = 'category_controller/subcategories';
$route[$r_admin . "/update-category/(:num)"] = 'category_controller/update_category/$1';
$route[$r_admin . "/update-subcategory/(:num)"] = 'category_controller/update_subcategory/$1';

//post
$route[$r_admin . "/add-post"] = 'post_controller/add_post';
$route[$r_admin . "/add-video"] = 'post_controller/add_video';
$route[$r_admin . "/posts"] = 'post_controller/posts';
$route[$r_admin . "/slider-posts"] = 'post_controller/slider_posts';
$route[$r_admin . "/featured-posts"] = 'post_controller/featured_posts';
$route[$r_admin . "/our-picks"] = 'post_controller/our_picks';
$route[$r_admin . "/pending-posts"] = 'post_controller/pending_posts';
$route[$r_admin . "/drafts"] = 'post_controller/drafts';
$route[$r_admin . "/update-post/(:num)"] = 'post_controller/update_post/$1';
$route[$r_admin . "/import-posts"] = 'post_controller/import_posts';

//rss
$route[$r_admin . "/import-feed"] = 'rss_controller/import_feed';
$route[$r_admin . "/feeds"] = 'rss_controller/feeds';
$route[$r_admin . "/update-feed/(:num)"] = 'rss_controller/update_feed/$1';

//poll
$route[$r_admin . "/add-poll"] = 'poll_controller/add_poll';
$route[$r_admin . "/polls"] = 'poll_controller/polls';
$route[$r_admin . "/update-poll/(:num)"] = 'poll_controller/update_poll/$1';

//gallery
$route[$r_admin . "/gallery-categories"] = 'category_controller/gallery_categories';
$route[$r_admin . "/gallery-albums"] = 'gallery_controller/gallery_albums';
$route[$r_admin . "/update-gallery-category/(:num)"] = 'category_controller/update_gallery_category/$1';
$route[$r_admin . "/update-gallery-album/(:num)"] = 'gallery_controller/update_gallery_album/$1';
$route[$r_admin . "/gallery"] = 'gallery_controller/gallery';
$route[$r_admin . "/update-gallery-image/(:num)"] = 'gallery_controller/update_gallery_image/$1';

$route[$r_admin . '/comments'] = 'admin_controller/comments';
$route[$r_admin . '/pending-comments'] = 'admin_controller/pending_comments';
$route[$r_admin . '/contact-messages'] = 'admin_controller/contact_messages';
$route[$r_admin . '/ad-spaces'] = 'admin_controller/ad_spaces';
//newsletter
$route[$r_admin . "/send-email-subscribers"] = 'admin_controller/send_email_subscribers';
$route[$r_admin . "/subscribers"] = 'admin_controller/subscribers';

$route[$r_admin . "/add-user"] = 'admin_controller/add_user';
$route[$r_admin . "/users"] = 'admin_controller/users';

$route[$r_admin . "/seo-tools"] = 'admin_controller/seo_tools';
$route[$r_admin . "/email-settings"] = 'admin_controller/email_settings';
//font
$route[$r_admin . "/font-settings"] = 'admin_controller/font_settings';
$route[$r_admin . "/update-font/(:num)"] = 'admin_controller/update_font/$1';

//language
$route[$r_admin . "/language-settings"] = 'language_controller/languages';
$route[$r_admin . "/update-language/(:num)"] = 'language_controller/update_language/$1';
$route[$r_admin . "/translations/(:num)"] = 'language_controller/translations/$1';
$route[$r_admin . "/settings"] = 'admin_controller/settings';

$route[$r_admin . "/cache-system"] = 'admin_controller/cache_system';
$route[$r_admin . "/social-login"] = 'admin_controller/social_login_settings';


/*
*-------------------------------------------------------------------------------------------------
* DYNAMIC ROUTES
*-------------------------------------------------------------------------------------------------
*/
foreach ($languages as $language) {
	if ($language->status == 1 && $general_settings->site_lang != $language->id) {
		$key = $language->short_form;
		$route[$key] = "home_controller/index";
		$route[$key . '/error-404'] = 'home_controller/error_404';
		$route[$key . '/gallery'] = 'home_controller/gallery';
		$route[$key . '/gallery/album/(:num)'] = 'home_controller/gallery_album/$1';
		$route[$key . '/contact'] = 'home_controller/contact';
		$route[$key . '/profile/(:any)'] = 'profile_controller/profile/$1';
		$route[$key . '/tag/(:any)'] = 'home_controller/tag/$1';
		$route[$key . '/reading-list'] = 'home_controller/reading_list';
		$route[$key . '/search'] = 'home_controller/search';
		$route[$key . '/rss-feeds'] = 'home_controller/rss_feeds';
		$route[$key . '/rss/posts'] = 'home_controller/rss_all_posts';
		$route[$key . '/rss/popular-posts'] = 'home_controller/rss_popular_posts';
		$route[$key . '/rss/category/(:any)'] = 'home_controller/rss_by_category/$1';
		$route[$key . '/login'] = 'auth_controller/login';
		$route[$key . '/register'] = 'auth_controller/register';
		$route[$key . '/profile-update'] = 'auth_controller/update_profile';
		$route[$key . '/change-password'] = 'auth_controller/change_password';
		$route[$key . '/forgot-password'] = 'auth_controller/forgot_password';
		$route[$key . '/reset-password'] = 'auth_controller/reset_password';
		$route[$key . '/logout'] = 'common_controller/logout';
		$route[$key . '/settings'] = 'profile_controller/update_profile';
		$route[$key . '/settings/social-accounts'] = 'profile_controller/social_accounts';
        $route[$key . '/settings/visual-settings'] = 'profile_controller/visual_settings';
		$route[$key . '/settings/change-password'] = 'profile_controller/change_password';
		$route[$key . '/unsubscribe'] = "auth_controller/unsubscribe";
		$route[$key . '/category/(:any)'] = 'home_controller/category_old/$1';
		$route[$key . '/(:any)/(:any)']['GET'] = 'home_controller/subcategory/$1/$2';
		$route[$key . '/(:any)']['GET'] = 'home_controller/any/$1';
	}
}

$route['(:any)/(:any)']['GET'] = 'home_controller/subcategory/$1/$2';
$route['(:any)']['GET'] = 'home_controller/any/$1';



