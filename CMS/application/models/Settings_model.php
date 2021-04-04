<?php defined('BASEPATH') or exit('No direct script access allowed');

class Settings_model extends CI_Model
{
    //update settings
    public function update_settings()
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'application_name' => $this->input->post('application_name', true),
            'facebook_url' => add_https($this->input->post('facebook_url', true)),
            'twitter_url' => add_https($this->input->post('twitter_url', true)),
            'instagram_url' => add_https($this->input->post('instagram_url', true)),
            'pinterest_url' => add_https($this->input->post('pinterest_url', true)),
            'linkedin_url' => add_https($this->input->post('linkedin_url', true)),
            'vk_url' => add_https($this->input->post('vk_url', true)),
            'youtube_url' => add_https($this->input->post('youtube_url', true)),
            'telegram_url' => add_https($this->input->post('telegram_url', true)),
            'optional_url_button_name' => $this->input->post('optional_url_button_name', true),
            'about_footer' => $this->input->post('about_footer', true),
            'copyright' => $this->input->post('copyright', true),
            'contact_text' => $this->input->post('contact_text', false),
            'contact_address' => $this->input->post('contact_address', true),
            'contact_email' => $this->input->post('contact_email', true),
            'contact_phone' => $this->input->post('contact_phone', true),
            'cookies_warning' => $this->input->post('cookies_warning', true),
            'cookies_warning_text' => $this->input->post('cookies_warning_text', true)
        );

        $this->db->where('lang_id', $data['lang_id']);
        return $this->db->update('settings', $data);
    }

    //update general settings
    public function update_general_settings()
    {
        $data = array(
            'timezone' => $this->input->post('timezone', true),
            'multilingual_system' => $this->input->post('multilingual_system', true),
            'registration_system' => $this->input->post('registration_system', true),
            'approve_posts_before_publishing' => $this->input->post('approve_posts_before_publishing', true),
            'comment_system' => $this->input->post('comment_system', true),
            'comment_approval_system' => $this->input->post('comment_approval_system', true),
            'facebook_comment' => $this->input->post('facebook_comment', false),
            'slider_active' => $this->input->post('slider_active', true),
            'emoji_reactions' => $this->input->post('emoji_reactions', true),
            'show_pageviews' => $this->input->post('show_pageviews', true),
            'show_rss' => $this->input->post('show_rss', true),
            'file_manager_show_all_files' => $this->input->post('file_manager_show_all_files', true),
            'pagination_per_page' => $this->input->post('pagination_per_page', true),
            'site_color' => $this->input->post('site_color', true),
            'custom_css_codes' => $this->input->post('custom_css_codes', false),
            'custom_javascript_codes' => $this->input->post('custom_javascript_codes', false)
        );


        $this->load->model('upload_model');
        $logo_path = $this->upload_model->logo_upload('logo');
        $mobile_logo_path = $this->upload_model->logo_upload('mobile_logo');
        $favicon_path = $this->upload_model->favicon_upload('favicon');
        if (!empty($logo_path)) {
            $data["logo_path"] = $logo_path;
        }
        if (!empty($mobile_logo_path)) {
            $data["mobile_logo_path"] = $mobile_logo_path;
        }
        if (!empty($favicon_path)) {
            $data["favicon_path"] = $favicon_path;
        }

        //update admin site color
        $data_user['site_color'] = $data["site_color"];
        $this->db->where('id', $this->auth_user->id);
        $this->db->update('users', $data_user);

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //get settings
    public function get_settings($lang_id)
    {
        $this->db->where('lang_id', $lang_id);
        $query = $this->db->get('settings');
        return $query->row();
    }

    //set mode
    public function set_mode()
    {
        $data = array(
            'dark_mode' => $this->input->post('dark_mode', true)
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //set theme
    public function set_theme()
    {
        $data = array(
            'layout' => $this->input->post('layout', true)
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }


    //update recaptcha settings
    public function update_recaptcha_settings()
    {
        $data = array(
            'recaptcha_site_key' => $this->input->post('recaptcha_site_key', true),
            'recaptcha_secret_key' => $this->input->post('recaptcha_secret_key', true),
            'recaptcha_lang' => $this->input->post('recaptcha_lang', true),
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update maintenance mode settings
    public function update_maintenance_mode_settings()
    {
        $data = array(
            'maintenance_mode_title' => $this->input->post('maintenance_mode_title', true),
            'maintenance_mode_description' => $this->input->post('maintenance_mode_description', true),
            'maintenance_mode_status' => $this->input->post('maintenance_mode_status', true),
        );

        if (empty($data["maintenance_mode_status"])) {
            $data["maintenance_mode_status"] = 0;
        }

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //get settings
    public function get_general_settings()
    {
        $this->db->where('id', 1);
        $query = $this->db->get('general_settings');
        return $query->row();
    }

    //update fonts
    public function update_fonts()
    {
        $data = array(
            'primary_font' => $this->input->post('primary_font', true),
            'secondary_font' => $this->input->post('secondary_font', true)
        );
        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update seo settings
    public function update_seo_settings()
    {
        $general = array(
            'google_analytics' => $this->input->post('google_analytics', false),
        );

        $this->db->where('id', 1);
        $this->db->update('general_settings', $general);

        $data = array(
            'site_title' => $this->input->post('site_title', true),
            'home_title' => $this->input->post('home_title', true),
            'site_description' => $this->input->post('site_description', true),
            'keywords' => $this->input->post('keywords', true),
        );

        $lang_id = $this->input->post('lang_id', true);

        $this->db->where('lang_id', $lang_id);
        return $this->db->update('settings', $data);
    }

    //update social facebook settings
    public function update_social_facebook_settings()
    {
        $data = array(
            'facebook_app_id' => trim($this->input->post('facebook_app_id', true)),
            'facebook_app_secret' => trim($this->input->post('facebook_app_secret', true))
        );

        //update
        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update social google settings
    public function update_social_google_settings()
    {
        $data = array(
            'google_client_id' => trim($this->input->post('google_client_id', true)),
            'google_client_secret' => trim($this->input->post('google_client_secret', true))
        );

        //update
        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update cache system
    public function update_cache_system()
    {
        $data = array(
            'cache_system' => $this->input->post('cache_system', true),
            'refresh_cache_database_changes' => $this->input->post('refresh_cache_database_changes', true),
            'cache_refresh_time' => $this->input->post('cache_refresh_time', true) * 60
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update email settings
    public function update_email_settings()
    {
        $data = array(
            'mail_library' => $this->input->post('mail_library', true),
            'mail_protocol' => $this->input->post('mail_protocol', true),
            'mail_title' => $this->input->post('mail_title', true),
            'mail_host' => $this->input->post('mail_host', true),
            'mail_port' => $this->input->post('mail_port', true),
            'mail_username' => $this->input->post('mail_username', true),
            'mail_password' => $this->input->post('mail_password', true),
        );

        //update
        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update email options
    public function update_email_options()
    {
        $data = array(
            'send_email_contact_messages' => $this->input->post('send_email_contact_messages', true),
            'mail_options_account' => $this->input->post('mail_options_account', true)
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update admin panel link
    public function update_admin_panel_link($link)
    {
        $link = str_slug($link);
        if (empty($link)) {
            $link = "admin";
        }
        $start = '<?php defined("BASEPATH") OR exit("No direct script access allowed");' . PHP_EOL;
        $keys = '$custom_slug_array["admin"] = "' . $link . '";';
        $end = '?>';

        $content = $start . $keys . $end;

        file_put_contents(FCPATH . "application/config/route_slugs.php", $content);
    }

    //get selected fonts
    public function get_selected_fonts($settings)
    {
        $pf_id = clean_number($settings->primary_font);
        $sf_id = clean_number($settings->secondary_font);
        $sql = "SELECT font_url AS primary_font_url, font_family AS primary_font_family, 
                (SELECT font_url FROM fonts WHERE id = ?) AS secondary_font_url,
                (SELECT font_family FROM fonts WHERE id = ?) AS secondary_font_family                          
                FROM fonts WHERE id = ?";
        $query = $this->db->query($sql, array($sf_id, $sf_id, $pf_id));
        return $query->row();
    }

    //get fonts
    public function get_fonts()
    {
        $query = $this->db->query("SELECT * FROM fonts ORDER BY font_name");
        return $query->result();
    }

    //get font
    public function get_font($id)
    {
        $sql = "SELECT * FROM fonts WHERE id =  ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->row();
    }

    //add font
    public function add_font()
    {
        $data = array(
            'font_name' => $this->input->post('font_name', true),
            'font_url' => $this->input->post('font_url', false),
            'font_family' => $this->input->post('font_family', true),
            'is_default' => 0
        );
        return $this->db->insert('fonts', $data);
    }

    //set site font
    public function set_site_font()
    {
        $lang_id = $this->input->post('lang_id', true);
        $data = array(
            'primary_font' => $this->input->post('primary_font', true),
            'secondary_font' => $this->input->post('secondary_font', true)
        );
        $this->db->where('lang_id', clean_number($lang_id));
        return $this->db->update('settings', $data);
    }

    //update font
    public function update_font($id)
    {
        $data = array(
            'font_name' => $this->input->post('font_name', true),
            'font_url' => $this->input->post('font_url', false),
            'font_family' => $this->input->post('font_family', true)
        );
        $this->db->where('id', clean_number($id));
        return $this->db->update('fonts', $data);
    }

    //delete font
    public function delete_font($id)
    {
        $font = $this->get_font($id);
        if (!empty($font)) {
            $this->db->where('id', $font->id);
            return $this->db->delete('fonts');
        }
        return false;
    }

    //delete old sessions
    function delete_old_sessions()
    {
        $this->db->query("DELETE FROM ci_sessions WHERE timestamp < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 3 DAY))");
    }

}
