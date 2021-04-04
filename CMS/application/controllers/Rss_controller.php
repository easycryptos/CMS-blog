<?php defined('BASEPATH') or exit('No direct script access allowed');

class Rss_controller extends Admin_Core_Controller
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
     * Import Feed
     */
    public function import_feed()
    {
        $data['title'] = trans("import_rss_feed");
        $data['parent_categories'] = $this->category_model->get_categories_by_lang($this->selected_lang->id);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/rss/import_feed', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Import Feed Post
     */
    public function import_feed_post()
    {
        if ($this->rss_model->add_feed()) {
            $last_id = $this->db->insert_id();
            $this->rss_model->add_feed_posts($last_id);

            $this->session->set_flashdata('success', trans("feed") . " " . trans("msg_suc_added"));
            reset_cache_data_on_change();
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    /**
     * RSS Feeds
     */
    public function feeds()
    {
        $data['title'] = trans("rss_feeds");
        $data['feeds'] = $this->rss_model->get_feeds();
        $data['lang_search_column'] = 3;

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/rss/feeds', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Update RSS Feed
     */
    public function update_feed($id)
    {
        $data["feed"] = $this->rss_model->get_feed($id);
        if (empty($data["feed"])) {
            redirect($this->agent->referrer());
        }

        $data['title'] = trans("update_rss_feed");

        //define category ids
        $category = $this->category_model->get_category($data["feed"]->category_id);
        $data['parent_category_id'] = $data["feed"]->category_id;
        $data['subcategory_id'] = 0;
        if (!empty($category) && $category->parent_id != 0) {
            $parent_category = $this->category_model->get_category($category->parent_id);
            if (!empty($parent_category)) {
                $data['parent_category_id'] = $parent_category->id;
                $data['subcategory_id'] = $category->id;
            }
        }

        $data['parent_categories'] = $this->category_model->get_categories_by_lang($data['feed']->lang_id);
        $data['subcategories'] = $this->category_model->get_subcategories_by_parent_id($data['parent_category_id']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/rss/update_feed', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Update RSS Feed Post
     */
    public function update_feed_post()
    {
        $id = $this->input->post('id', true);
        if ($this->rss_model->update_feed($id)) {
            $this->rss_model->update_feed_posts_button($id);
            $this->session->set_flashdata('success', trans("feed") . " " . trans("msg_suc_updated"));
            reset_cache_data_on_change();
            redirect(admin_url() . 'feeds');
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    /**
     * Get Feed Posts
     */
    public function check_feed_posts()
    {
        $id = $this->input->post('id', true);
        $this->rss_model->add_feed_posts($id);
        $this->session->set_flashdata('success', trans("feed") . " " . trans("msg_suc_updated"));
        reset_cache_data_on_change();
        redirect($this->agent->referrer());
    }

    /**
     * Delete Feed
     */
    public function delete_feed_post()
    {
        if (!check_user_permission('rss_feeds')) {
            exit();
        }
        $id = $this->input->post('id', true);
        if ($this->rss_model->delete_feed($id)) {
            $this->session->set_flashdata('success', trans("feed") . " " . trans("msg_suc_deleted"));
            reset_cache_data_on_change();
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    //delete feed image
    public function delete_feed_image()
    {
        if (!check_user_permission('rss_feeds')) {
            exit();
        }
        $id = $this->input->post('feed_id', true);
        $this->rss_model->delete_feed_image($id);
    }
}