<?php defined('BASEPATH') or exit('No direct script access allowed');

class Core_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //settings
        $global_data['general_settings'] = $this->settings_model->get_general_settings();
        $this->general_settings = $global_data['general_settings'];


        //set timezone
        if (!empty($this->general_settings->timezone)) {
            date_default_timezone_set($this->general_settings->timezone);
        }
        //lang base url
        $global_data['lang_base_url'] = base_url();
        //languages
        $global_data['languages'] = $this->language_model->get_active_languages();
        $this->languages = $global_data['languages'];
        //site lang
        $global_data['site_lang'] = $this->language_model->get_language($this->general_settings->site_lang);
        if (empty($global_data['site_lang'])) {
            $global_data['site_lang'] = $this->language_model->get_language('1');
        }
        $global_data['selected_lang'] = $global_data['site_lang'];

        //set language
        $lang_segment = $this->uri->segment(1);
        foreach ($global_data['languages'] as $lang) {
            if ($lang_segment == $lang->short_form) {
                if ($this->general_settings->multilingual_system == 1):
                    $global_data['selected_lang'] = $lang;
                    $global_data['lang_base_url'] = base_url() . $lang->short_form . "/";
                else:
                    redirect(base_url());
                endif;
            }
        }

        $this->selected_lang = $global_data['selected_lang'];
        $this->lang_base_url = $global_data['lang_base_url'];

        $global_data['rtl'] = false;
        if ($global_data['selected_lang']->text_direction == "rtl") {
            $global_data['rtl'] = true;
        }
        $this->rtl = $global_data['rtl'];

        //set lang base url
        if ($this->general_settings->site_lang == $global_data['selected_lang']->id) {
            $global_data['lang_base_url'] = base_url();
        } else {
            $global_data['lang_base_url'] = base_url() . $global_data['selected_lang']->short_form . "/";
        }

        //language translations
        $this->language_translations = $this->get_translation_array($this->selected_lang->id);

        $global_data['settings'] = $this->settings_model->get_settings($global_data['selected_lang']->id);
        $this->settings = $global_data['settings'];

        //selected layout
        $global_data['layout'] = $global_data['general_settings']->layout;
        $this->layout = $global_data['general_settings']->layout;

        //get site fonts
        $this->fonts = $this->settings_model->get_selected_fonts($this->settings);

        //check auth
        $this->auth_check = auth_check();
        if ($this->auth_check) {
            $this->auth_user = user();
            //update last seen
            $this->auth_model->update_last_seen();
        }
        //set site color
        $this->site_color = get_site_color();
        //set dark mode
        $this->dark_mode = check_dark_mode_enabled();

        $this->username_character_limit = 25;

        $this->load->vars($global_data);
    }

    public function get_translation_array($lang_id)
    {
        $translations = $this->language_model->get_language_translations($lang_id);
        $array = array();
        if (!empty($translations)) {
            foreach ($translations as $translation) {
                $array[$translation->label] = $translation->translation;
            }
        }
        //set custom error messages
        if (isset($array["form_validation_required"])) {
            $this->form_validation->set_message('required', $array["form_validation_required"]);
        }
        if (isset($array["form_validation_min_length"])) {
            $this->form_validation->set_message('min_length', $array["form_validation_min_length"]);
        }
        if (isset($array["form_validation_max_length"])) {
            $this->form_validation->set_message('max_length', $array["form_validation_max_length"]);
        }
        if (isset($array["form_validation_matches"])) {
            $this->form_validation->set_message('matches', $array["form_validation_matches"]);
        }
        if (isset($array["form_validation_is_unique"])) {
            $this->form_validation->set_message('is_unique', $array["form_validation_is_unique"]);
        }
        return $array;
    }

}

class Home_Core_Controller extends Core_Controller
{
    public function __construct()
    {
        parent::__construct();

        //maintenance mode
        if ($this->general_settings->maintenance_mode_status == 1) {
            if (!is_admin()) {
                $this->maintenance_mode();
            }
        }

        if ($this->input->method() == "post") {
            //set post language
            $lang_id = $this->input->post('sys_lang_id', true);
            if (!empty($lang_id)) {
                $this->selected_lang = $this->language_model->get_language($lang_id);
                $this->language_translations = $this->get_translation_array($lang_id);
                if ($this->general_settings->site_lang == $lang_id) {
                    $this->lang_base_url = base_url();
                } else {
                    $this->lang_base_url = base_url() . $this->selected_lang->short_form . "/";
                }
            }
        }

        //menu links
        $this->menu_links = $this->navigation_model->get_menu_links($this->selected_lang->id);
        //popular posts
        $this->popular_posts = get_cached_data('popular_posts');
        if (empty($this->popular_posts)) {
            $this->popular_posts = $this->post_model->get_popular_posts(5);
            set_cache_data('popular_posts', $this->popular_posts);
        }
        //our picks
        $this->our_picks = get_cached_data('our_picks');
        if (empty($this->our_picks)) {
            $this->our_picks = $this->post_model->get_our_picks(5);
            set_cache_data('our_picks', $this->our_picks);
        }
        //random posts
        $this->random_posts = get_cached_data('random_posts');
        if (empty($this->random_posts)) {
            $this->random_posts = $this->post_model->get_random_posts(10);
            set_cache_data('random_posts', $this->random_posts);
        }
        //tags
        $this->tags = get_cached_data('tags');
        if (empty($this->tags)) {
            $this->tags = $this->tag_model->get_random_tags();
            set_cache_data('tags', $this->tags);
        }

        $global_data['categories'] = $this->category_model->get_categories();
        $global_data['polls'] = $this->poll_model->get_polls();


        //recaptcha status
        $global_data['recaptcha_status'] = true;
        if (empty($this->general_settings->recaptcha_site_key) || empty($this->general_settings->recaptcha_secret_key)) {
            $global_data['recaptcha_status'] = false;
        }
        $this->recaptcha_status = $global_data['recaptcha_status'];


        $this->load->vars($global_data);
    }

    //verify recaptcha
    public function recaptcha_verify_request()
    {
        if (!$this->recaptcha_status) {
            return true;
        }

        $this->load->library('recaptcha');
        $recaptcha = $this->input->post('g-recaptcha-response');
        if (!empty($recaptcha)) {
            $response = $this->recaptcha->verifyResponse($recaptcha);
            if (isset($response['success']) && $response['success'] === true) {
                return true;
            }
        }
        return false;
    }

    public function paginate($url, $total_rows)
    {
        $per_page = $this->general_settings->pagination_per_page;
        //initialize pagination
        $page = clean_number($this->input->get('page'));
        if (empty($page) || $page < 0) {
            $page = 0;
        }
        if ($page != 0) {
            $page = $page - 1;
        }
        $config['num_links'] = 4;
        $config['base_url'] = $url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['reuse_query_string'] = true;
        $this->pagination->initialize($config);
        return array('per_page' => $per_page, 'offset' => $page * $per_page, 'current_page' => $page + 1);
    }

    //maintenance mode
    public function maintenance_mode()
    {
        $this->load->view('maintenance');
    }
}

class Admin_Core_Controller extends Core_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->auth_check) {
            redirect(admin_url() . 'login');
        }
    }

    public function paginate($url, $total_rows)
    {
        //initialize pagination
        $page = $this->security->xss_clean($this->input->get('page'));
        $per_page = $this->input->get('show', true);
        if (empty($page)) {
            $page = 0;
        }

        if ($page != 0) {
            $page = $page - 1;
        }

        if (empty($per_page)) {
            $per_page = 15;
        }

        $config['num_links'] = 4;
        $config['base_url'] = $url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['reuse_query_string'] = true;
        $this->pagination->initialize($config);

        return array('per_page' => $per_page, 'offset' => $page * $per_page);
    }
}

