<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Poll_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();

        //check auth
        if (!is_admin()) {
            redirect(admin_url() . 'login');
        }
    }


    /**
     * Add Poll
     */
    public function add_poll()
    {
        $data['title'] = trans("add_poll");
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/poll/add', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Add Poll Post
     */
    public function add_poll_post()
    {
        //validate inputs
        $this->form_validation->set_rules('question', trans("question"), 'required|xss_clean');
        $this->form_validation->set_rules('option1', trans("option_1"), 'required|xss_clean');
        $this->form_validation->set_rules('option2', trans("option_2"), 'required|xss_clean');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->poll_model->input_values());
            redirect($this->agent->referrer());
        } else {
            if ($this->poll_model->add()) {
                $this->session->set_flashdata('success', trans("poll") . " " . trans("msg_suc_added"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('form_data', $this->poll_model->input_values());
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Polls
     */
    public function polls()
    {
        $data['title'] = trans("polls");
        $data['polls'] = $this->poll_model->get_all_polls();
        $data['lang_search_column'] = 2;
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/poll/polls', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update Poll
     */
    public function update_poll($id)
    {

        $data['title'] = trans("update_poll");

        //find poll
        $data['poll'] = $this->poll_model->get_poll($id);
        //poll not found
        if (empty($data['poll'])) {
            redirect($this->agent->referrer());
        }

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/poll/update', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update Poll Post
     */
    public function update_poll_post()
    {
        //validate inputs
        $this->form_validation->set_rules('question', trans("question"), 'required|xss_clean');
        $this->form_validation->set_rules('option1', trans("option_1"), 'required|xss_clean');
        $this->form_validation->set_rules('option2', trans("option_2"), 'required|xss_clean');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->poll_model->input_values());
            redirect($this->agent->referrer());
        } else {
            //get id
            $id = $this->input->post('id', true);

            if ($this->poll_model->update($id)) {
                $this->session->set_flashdata('success', trans("poll") . " " . trans("msg_suc_updated"));
                redirect(admin_url() . 'polls');
            } else {
                $this->session->set_flashdata('form_data', $this->poll_model->input_values());
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Delete Poll Post
     */
    public function delete_poll_post()
    {

        $id = $this->input->post('id', true);

        $poll = $this->poll_model->get_poll($id);

        if (empty($poll)) {
            redirect($this->agent->referrer());
        }

        if ($this->poll_model->delete($id)) {
            $this->session->set_flashdata('success', trans("poll") . " " . trans("msg_suc_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

}
