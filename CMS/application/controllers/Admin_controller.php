<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check auth
        if (!is_admin() && !is_author()) {
            redirect(admin_url() . 'login');
        }
    }


    /**
     * Index Page
     */
    public function index()
    {
        $data['title'] = trans("index");

        $data['user_count'] = $this->auth_model->get_user_count();
        $data['last_comments'] = $this->comment_model->get_last_comments(5);
        $data['last_pending_comments'] = $this->comment_model->get_last_pedding_comments(5);
        $data['last_contacts'] = $this->contact_model->get_last_contact_messages();
        $data['last_users'] = $this->auth_model->get_last_users();
        $data['pending_post_count'] = $this->post_admin_model->get_pending_posts_count();
        $data['post_count'] = $this->post_admin_model->get_posts_count();
        $data['draft_count'] = $this->post_admin_model->get_drafts_count();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Navigation
     */
    public function navigation()
    {
        prevent_author();

        $data['title'] = trans("navigation");
        $data['menu_items'] = $this->navigation_model->get_all_menu_links();
        
        $data['lang_search_column'] = 3;

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/navigation/navigation', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add Menu Link Post
     */
    public function add_menu_link_post()
    {
        //validate inputs
        $this->form_validation->set_rules('title', trans("title"), 'required|xss_clean|max_length[500]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors_form', validation_errors());
            $this->session->set_flashdata('form_data', $this->navigation_model->input_values());
            redirect($this->agent->referrer());
        } else {
            if ($this->navigation_model->add_link()) {
                $this->session->set_flashdata('success_form', trans("link") . " " . trans("msg_suc_added"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('form_data', $this->navigation_model->input_values());
                $this->session->set_flashdata('error_form', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Update Menu Link
     */
    public function update_menu_link($id)
    {
        prevent_author();

        $data['title'] = trans("navigation");

        $data['page'] = $this->page_model->get_page_by_id($id);
        if (empty($data['page'])) {
            redirect($this->agent->referrer());
        }
        $data['menu_items'] = $this->navigation_model->get_menu_links($this->selected_lang->id);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/navigation/update_navigation', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update Menü Link Post
     */
    public function update_menu_link_post()
    {
        //validate inputs
        $this->form_validation->set_rules('title', trans("title"), 'required|xss_clean|max_length[500]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors_form', validation_errors());
            $this->session->set_flashdata('form_data', $this->navigation_model->input_values());
            redirect($this->agent->referrer());
        } else {
            $id = $this->input->post('id', true);

            if ($this->navigation_model->update_link($id)) {
                $this->session->set_flashdata('success', trans("link") . " " . trans("msg_suc_updated"));
                redirect(admin_url() . "navigation");
            } else {
                $this->session->set_flashdata('form_data', $this->navigation_model->input_values());
                $this->session->set_flashdata('error_form', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Delete Navigation Post
     */
    public function delete_navigation_post()
    {
        $id = $this->input->post('id', true);
        $data["page"] = $this->page_model->get_page_by_id($id);

        //check if exists
        if (empty($data['page'])) {
            redirect($this->agent->referrer());
        }

        if ($this->page_model->delete($id)) {
            $this->session->set_flashdata('success', trans("link") . " " . trans("msg_suc_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }


    /**
     * Menu Limit Post
     */
    public function menu_limit_post()
    {
        if ($this->navigation_model->update_menu_limit()) {
            $this->session->set_flashdata('success_form', trans("menu_limit") . " " . trans("msg_suc_updated"));
            $this->session->set_flashdata("mes_menu_limit", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('form_data', $this->navigation_model->input_values());
            $this->session->set_flashdata("mes_menu_limit", 1);
            $this->session->set_flashdata('error_form', trans("msg_error"));
            redirect($this->agent->referrer());
        }

    }

    //get menu links by language
    public function get_menu_links_by_lang()
    {
        $lang_id = $this->input->post('lang_id', true);
        if (!empty($lang_id)):
            $menu_items = $this->navigation_model->get_menu_links($lang_id);
            foreach ($menu_items as $menu_item):
                if ($menu_item->item_type != "category" && $menu_item->item_location == "header" && $menu_item->item_parent_id == "0"):
                    echo '<option value="' . $menu_item->item_id . '">' . $menu_item->item_name . '</option>';
                endif;
            endforeach;
        endif;
    }


    /**
     * Themes
     */
    public function themes()
    {
        prevent_author();

        $data['title'] = trans("themes");
        $data['general_settings'] = $this->settings_model->get_general_settings();
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/themes', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Set Mode Post
     */
    public function set_mode_post()
    {
        $this->settings_model->set_mode();
        redirect($this->agent->referrer());
    }

    /**
     * Set Theme Post
     */
    public function set_theme_post()
    {
        $this->settings_model->set_theme();
        redirect($this->agent->referrer());
    }

    /**
     * Comments
     */
    public function comments()
    {
        prevent_author();

        $data['title'] = trans("approved_comments");
        $data['comments'] = $this->comment_model->get_approved_comments();
        $data['top_button_text'] = trans("pending_comments");
        $data['top_button_url'] = admin_url() . "pending-comments";
        $data['show_approve_button'] = false;
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/comments', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Pending Comments
     */
    public function pending_comments()
    {
        prevent_author();

        $data['title'] = trans("pending_comments");
        $data['comments'] = $this->comment_model->get_pending_comments();
        $data['top_button_text'] = trans("approved_comments");
        $data['top_button_url'] = admin_url() . "comments";
        
        $data['show_approve_button'] = true;

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/comments', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Aprrove Comment Post
     */
    public function approve_comment_post()
    {
        $id = $this->input->post('id', true);

        if ($this->comment_model->approve_comment($id)) {
            $this->session->set_flashdata('success', trans("msg_comment_approved"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }


    /**
     * Delete Comment Post
     */
    public function delete_comment_post()
    {
        $id = $this->input->post('id', true);

        if ($this->comment_model->delete_comment($id)) {
            $this->session->set_flashdata('success', trans("comment") . " " . trans("msg_suc_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Delete Selected Comments
     */
    public function delete_selected_comments()
    {
        $comment_ids = $this->input->post('comment_ids', true);
        $this->comment_model->delete_multi_comments($comment_ids);
    }

    /**
     * Approve Selected Comments
     */
    public function approve_selected_comments()
    {
        $comment_ids = $this->input->post('comment_ids', true);
        $this->comment_model->approve_multi_comments($comment_ids);
    }

    /**
     * Contact Messages
     */
    public function contact_messages()
    {
        prevent_author();

        $data['title'] = trans("contact_messages");
        $data['messages'] = $this->contact_model->get_contact_messages();
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/contact_messages', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Delete Contact Message Post
     */
    public function delete_contact_message_post()
    {
        $id = $this->input->post('id', true);

        if ($this->contact_model->delete_contact_message($id)) {
            $this->session->set_flashdata('success', trans("message") . " " . trans("msg_suc_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }


    /**
     * Ads
     */
    public function ad_spaces()
    {
        prevent_author();

        $data['title'] = trans("ad_spaces");

        $data['ad_space'] = $this->input->get('ad_space', true);

        if (empty($data['ad_space'])) {
            redirect(admin_url() . "ad-spaces?ad_space=index_top");
        }
        $data['ad_codes'] = $this->ad_model->get_ad_codes($data['ad_space']);
        
        if (empty($data['ad_codes'])) {
            redirect(admin_url() . "ad-spaces");
        }

        $data["array_ad_spaces"] = array(
            "index_top" => trans("index_top_ad_space"),
            "index_bottom" => trans("index_bottom_ad_space"),
            "post_top" => trans("post_top_ad_space"),
            "post_bottom" => trans("post_bottom_ad_space"),
            "category_top" => trans("category_top_ad_space"),
            "category_bottom" => trans("category_bottom_ad_space"),
            "tag_top" => trans("tag_top_ad_space"),
            "tag_bottom" => trans("tag_bottom_ad_space"),
            "search_top" => trans("search_top_ad_space"),
            "search_bottom" => trans("search_bottom_ad_space"),
            "profile_top" => trans("profile_top_ad_space"),
            "profile_bottom" => trans("profile_bottom_ad_space"),
            "reading_list_top" => trans("reading_list_top_ad_space"),
            "reading_list_bottom" => trans("reading_list_bottom_ad_space"),
            "sidebar_top" => trans("sidebar_top_ad_space"),
            "sidebar_bottom" => trans("sidebar_bottom_ad_space"),
        );

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/ad_spaces', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Ads Post
     */
    public function ad_spaces_post()
    {
        prevent_author();

        $ad_space = $this->input->post('ad_space', true);

        if ($this->ad_model->update_ad_spaces($ad_space)) {
            $this->session->set_flashdata('success', trans("ad_spaces") . " " . trans("msg_suc_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        redirect(admin_url() . "ad-spaces?ad_space=" . $ad_space);
    }

    /**
     * Google Adsense Code Post
     */
    public function google_adsense_code_post()
    {
        if ($this->ad_model->update_google_adsense_code()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata('mes_adsense', 1);
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata('mes_adsense', 1);
        }
        redirect($this->agent->referrer());
    }

    /**
     * Settings
     */
    public function settings()
    {
        prevent_author();

        $data["selected_lang"] = $this->input->get("lang", true);
        
        if (empty($data["selected_lang"])) {
            $data["selected_lang"] = $this->general_settings->site_lang;
            redirect(admin_url() . "settings?lang=" . $data["selected_lang"]);
        }
        $data['title'] = trans("settings");
        $data['form_settings'] = $this->settings_model->get_settings($data["selected_lang"]);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/settings', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update Settings Post
     */
    public function settings_post()
    {
        prevent_author();

        if ($this->settings_model->update_settings()) {
            $this->settings_model->update_general_settings();

            $admin_panel_link = $this->input->post('admin_panel_link', true);
            $this->settings_model->update_admin_panel_link($admin_panel_link);
            $this->session->set_flashdata('success', trans("settings") . " " . trans("msg_suc_updated"));

        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        $this->session->set_flashdata("mes_settings", 1);
        redirect($this->agent->referrer());
    }

    /**
     * Recaptcha Settings Post
     */
    public function recaptcha_settings_post()
    {
        prevent_author();
        if ($this->settings_model->update_recaptcha_settings()) {
            $this->session->set_flashdata('success', trans("settings") . " " . trans("msg_suc_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        $this->session->set_flashdata("mes_recaptcha", 1);
        redirect($this->agent->referrer());
    }

    /**
     * Maintenance Mode Post
     */
    public function maintenance_mode_post()
    {
        prevent_author();
        if ($this->settings_model->update_maintenance_mode_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        $this->session->set_flashdata("mes_maintenance", 1);
        redirect($this->agent->referrer());
    }


    /**
     * Seo Tools
     */
    public function seo_tools()
    {
        prevent_author();

        $data['title'] = trans("seo_tools");

        $data["selected_lang"] = $this->input->get("lang", true);
        
        if (empty($data["selected_lang"])) {
            $data["selected_lang"] = $this->general_settings->site_lang;
            redirect(admin_url() . "seo-tools?lang=" . $data["selected_lang"]);
        }
        $data['settings'] = $this->settings_model->get_settings($data["selected_lang"]);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/seo_tools', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Seo Tools Post
     */
    public function seo_tools_post()
    {
        prevent_author();

        if ($this->settings_model->update_seo_settings()) {
            $this->session->set_flashdata('success', trans("seo_options") . " " . trans("msg_suc_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    /**
     * Social Login Settings
     */
    public function social_login_settings()
    {
        prevent_author();
        $data['title'] = trans("social_login_settings");
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/social_login_settings', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Social Login Facebook Post
     */
    public function social_login_facebook_post()
    {
        prevent_author();
        if ($this->settings_model->update_social_facebook_settings()) {
            $this->session->set_flashdata('msg_social_facebook', '1');
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }

    }

    /**
     * Social Login Google Post
     */
    public function social_login_google_post()
    {
        prevent_author();
        if ($this->settings_model->update_social_google_settings()) {
            $this->session->set_flashdata('msg_social_google', '1');
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }

    }


    /**
     * Cache System
     */
    public function cache_system()
    {
        prevent_author();

        $data['title'] = trans("cache_system");
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/cache_system', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Cache System Post
     */
    public function cache_system_post()
    {
        if ($this->input->post('action', true) == "reset") {
            reset_cache_data();
            $this->session->set_flashdata('success', trans("msg_reset_cache"));
        } else {
            if ($this->settings_model->update_cache_system()) {
                $this->session->set_flashdata('success', trans("msg_updated"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }
        }
        redirect($this->agent->referrer());
    }

    /**
     * Font Options
     */
    public function font_options()
    {
        prevent_author();

        $data['title'] = trans("font_options");
        $data['fonts'] = $this->config->item('fonts_array');
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/font_options', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Font Options Post
     */
    public function font_options_post()
    {
        if ($this->settings_model->update_fonts()) {
            $this->session->set_flashdata('success', trans("font_options") . " " . trans("msg_suc_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('form_data', $this->settings_model->input_values());
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }


    /*
    * Email Settings
    */
    public function email_settings()
    {
        prevent_author();

        $data['title'] = trans("email_settings");
        
        $data['general_settings'] = $this->settings_model->get_general_settings();
        $data["library"] = $this->input->get('library');
        if (empty($data["library"])) {
            $data["library"] = "swift";
            if (!empty($this->general_settings->mail_library)) {
                $data["library"] = $this->general_settings->mail_library;
            }
            redirect(admin_url() . "email-settings?library=" . $data["library"]);
        }


        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/email_settings', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Email Settings Post
     */
    public function email_settings_post()
    {
        if ($this->settings_model->update_email_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata('submit', $this->input->post('submit', true));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata('submit', $this->input->post('submit', true));
            redirect($this->agent->referrer());
        }
    }

    /**
     * Email Options Post
     */
    public function email_options_post()
    {
        if ($this->settings_model->update_email_options()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata('submit', "options");
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata('submit', "options");
            redirect($this->agent->referrer());
        }
    }

    /**
     * Users
     */
    public function users()
    {
        //check if admin
        if ($this->auth_model->is_admin() == false) {
            redirect('login');
        }

        $data['title'] = trans("users");
        $data['users'] = $this->auth_model->get_users();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/users/users', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add User
     */
    public function add_user()
    {
        $data['title'] = trans("add_user");

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/users/add_user');
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add User Post
     */
    public function add_user_post()
    {
        //validate inputs
        $this->form_validation->set_rules('username', trans("username"), 'required|xss_clean|min_length[4]|max_length[100]');
        $this->form_validation->set_rules('email', trans("email"), 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('password', trans("password"), 'required|xss_clean|min_length[4]|max_length[50]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            redirect($this->agent->referrer());
        } else {
            $email = $this->input->post('email', true);
            $username = $this->input->post('username', true);
            //is username unique
            if (!$this->auth_model->is_unique_username($username)) {
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("msg_username_unique_error"));
                redirect($this->agent->referrer());
            }
            //is email unique
            if (!$this->auth_model->is_unique_email($email)) {
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("email_unique_error"));
                redirect($this->agent->referrer());
            }

            //add user
            if ($this->auth_model->add_user()) {
                $this->session->set_flashdata('success', trans("msg_user_added"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }

            redirect($this->agent->referrer());
        }
    }


    /**
     * Change User Role
     */
    public function change_user_role_post()
    {
        //check if admin
        if ($this->auth_model->is_admin() == false) {
            redirect('login');
        }

        $id = $this->input->post('user_id', true);
        $role = $this->input->post('role', true);

        $user = $this->auth_model->get_user($id);

        //check if exists
        if (empty($user)) {
            redirect($this->agent->referrer());
        } else {
            if ($this->auth_model->change_user_role($id, $role)) {
                $this->session->set_flashdata('success', trans("msg_role_changed"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * User Options Post
     */
    public function user_options_post()
    {
        prevent_author();

        //check if admin
        if (is_admin() == false) {
            redirect('login');
        }

        $option = $this->input->post('option', true);
        $id = $this->input->post('id', true);

        //if option ban
        if ($option == 'ban') {
            if ($this->auth_model->ban_user($id)) {
                $this->session->set_flashdata('success', trans("msg_user_banned"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }

        //if option remove ban
        if ($option == 'remove_ban') {
            if ($this->auth_model->remove_user_ban($id)) {
                $this->session->set_flashdata('success', trans("msg_ban_removed"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Delete User Post
     */
    public function delete_user_post()
    {
        prevent_author();
        $id = $this->input->post('id', true);

        if ($this->auth_model->delete_user($id)) {
            $this->session->set_flashdata('success', trans("user") . " " . trans("msg_suc_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }


    /**
     * Send Email to Subscribers
     */
    public function send_email_subscribers()
    {
        prevent_author();

        $data['title'] = trans("send_email_subscribers");

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/newsletter/send_email', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Newsletter Send Email Post
     */
    public function send_email_subscribers_post()
    {
        $this->load->model("email_model");

        $subject = $this->input->post('subject', true);
        $message = $this->input->post('message', false);

        $data['subscribers'] = $this->newsletter_model->get_subscribers();

        foreach ($data['subscribers'] as $item) {
            //send email
            $result = true;
            if (!$this->email_model->send_email_newsletter($item, $subject, $message)) {
                $result = false;
            }
        }

        if ($result) {
            $this->session->set_flashdata('success', trans("msg_email_sent"));
        }
        redirect($this->agent->referrer());
    }


    /**
     * Subscribers
     */
    public function subscribers()
    {
        prevent_author();

        $data['title'] = trans("subscribers");
        $data['subscribers'] = $this->newsletter_model->get_subscribers();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/newsletter/subscribers', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Delete Subscriber Post
     */
    public function delete_subscriber_post()
    {
        $id = $this->input->post('id', true);

        $data['subscriber'] = $this->newsletter_model->get_subscriber_by_id($id);

        if (empty($data['subscriber'])) {
            redirect($this->agent->referrer());
        }

        if ($this->newsletter_model->delete_from_subscribers($id)) {
            $this->session->set_flashdata('success', trans("msg_subscriber_deleted"));
            $this->session->set_flashdata("mes_subscriber_delete", 1);
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_subscriber_delete", 1);
        }
    }

    /**
     * Font Settings
     */
    public function font_settings()
    {
        prevent_author();

        $data["selected_lang"] = $this->input->get("lang", true);
        if (empty($data["selected_lang"])) {
            $data["selected_lang"] = $this->general_settings->site_lang;
            redirect(admin_url() . "font-settings?lang=" . $data["selected_lang"]);
        }

        $data['title'] = trans("font_settings");
        $data['fonts'] = $this->settings_model->get_fonts();
        $data['settings'] = $this->settings_model->get_settings($data["selected_lang"]);
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/font/fonts', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add Font Post
     */
    public function add_font_post()
    {
        prevent_author();
        if ($this->settings_model->add_font()) {
            $this->session->set_flashdata('success', trans("msg_item_added"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        $this->session->set_flashdata('mes_add_font', 1);
        redirect($this->agent->referrer());
    }

    /**
     * Set Site Font Post
     */
    public function set_site_font_post()
    {
        prevent_author();
        if ($this->settings_model->set_site_font()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        $this->session->set_flashdata('mes_set_font', 1);
        redirect($this->agent->referrer());
    }

    /**
     * Update Font
     */
    public function update_font($id)
    {
        prevent_author();
        $data['title'] = trans("update_font");
        $data['font'] = $this->settings_model->get_font($id);
        if (empty($data['font'])) {
            redirect(admin_url() . "font-settings");
        }

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/font/update', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Update Font Post
     */
    public function update_font_post()
    {
        prevent_author();
        $id = $this->input->post('id', true);
        if ($this->settings_model->update_font($id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        $this->session->set_flashdata('mes_table', 1);
        redirect(admin_url() . "font-settings?lang=" . $this->general_settings->site_lang);
    }

    /**
     * Delete Font Post
     */
    public function delete_font_post()
    {
        prevent_author();
        $id = $this->input->post('id', true);
        if ($this->settings_model->delete_font($id)) {
            $this->session->set_flashdata('success', trans("msg_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        $this->session->set_flashdata('mes_table', 1);
    }

}
