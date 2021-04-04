<?php defined('BASEPATH') or exit('No direct script access allowed');

class Common_controller extends Core_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Admin Login
     */
    public function admin_login()
    {
        get_method();
        //check if logged in
        if ($this->auth_check) {
            if ($this->auth_user->role == 'user') {
                redirect(base_url());
            } else {
                redirect(admin_url());
            }
        }

        $data['title'] = trans("login");
        $data['description'] = trans("login") . " - " . $this->settings->site_title;
        $data['keywords'] = trans("login") . ', ' . $this->settings->application_name;
        $this->load->view('admin/login', $data);
    }

    /**
     * Admin Login Post
     */
    public function admin_login_post()
    {
        post_method();
        $this->load->library('bcrypt');
        //validate inputs
        $this->form_validation->set_rules('username', trans("username"), 'required|xss_clean|max_length[150]');
        $this->form_validation->set_rules('password', trans("form_password"), 'required|xss_clean|max_length[128]');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            redirect($this->agent->referrer());
        } else {
            $username = $this->input->post('username', true);
            $user = $this->auth_model->get_user_by_username($username);
            if (empty($user)) {
                $user = $this->auth_model->get_user_by_email($username);
            }
            if (!empty($user) && $user->role != 'admin' && $this->general_settings->maintenance_mode_status == 1) {
                $this->session->set_flashdata('error', "Site under construction! Please try again later.");
                redirect($this->agent->referrer());
            }
            if ($this->auth_model->login()) {
                redirect(admin_url());
            } else {
                //error
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("login_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Logout
     */
    public function logout()
    {
        get_method();
        $this->auth_model->logout();
        redirect($this->agent->referrer());
    }
}
