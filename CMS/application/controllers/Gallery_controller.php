<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery_controller extends Admin_Core_Controller
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
	 * Gallery
	 */
	public function gallery()
	{
		$data['title'] = trans("gallery");
		$data['images'] = $this->gallery_model->get_all_images();
		$data['albums'] = $this->gallery_category_model->get_albums_by_selected_lang();
		$data['lang_search_column'] = 3;
        

		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/gallery/gallery', $data);
		$this->load->view('admin/includes/_footer');
	}

	/**
	 * Add Image Post
	 */
	public function add_gallery_image_post()
	{
		//validate inputs
		$this->form_validation->set_rules('title', trans("title"), 'xss_clean|max_length[500]');
		$this->form_validation->set_rules('album_id', trans("album"), 'required');

		if ($this->form_validation->run() === false) {
			$this->session->set_flashdata('errors_form', validation_errors());
			$this->session->set_flashdata('form_data', $this->gallery_model->input_values());
			redirect($this->agent->referrer());
		} else {
			if ($this->gallery_model->add()) {
				$this->session->set_flashdata('success_form', trans("image") . " " . trans("msg_suc_added"));
				redirect($this->agent->referrer());
			} else {
				$this->session->set_flashdata('form_data', $this->gallery_model->input_values());
				$this->session->set_flashdata('error_form', trans("msg_error"));
				redirect($this->agent->referrer());
			}
		}
	}

	/**
	 * Update Image
	 */
	public function update_gallery_image($id)
	{
		$data['title'] = trans("update_image");

		//get post
		$data['image'] = $this->gallery_model->get_image($id);
        
		if (empty($data['image'])) {
			redirect($this->agent->referrer());
		}
		$data['albums'] = $this->gallery_category_model->get_albums_by_lang($data['image']->lang_id);
		$data['categories'] = $this->gallery_category_model->get_categories_by_album($data['image']->album_id);

		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/gallery/update', $data);
		$this->load->view('admin/includes/_footer');
	}

	/**
	 * Update Image Post
	 */
	public function update_gallery_image_post()
	{
		//validate inputs
		$this->form_validation->set_rules('title', trans("title"), 'xss_clean|max_length[500]');
		$this->form_validation->set_rules('album_id', trans("album"), 'required');

		if ($this->form_validation->run() === false) {
			$this->session->set_flashdata('errors', validation_errors());
			$this->session->set_flashdata('form_data', $this->gallery_model->input_values());
			redirect($this->agent->referrer());
		} else {

			$id = $this->input->post('id', true);

			if ($this->gallery_model->update($id)) {
				$this->session->set_flashdata('success', trans("image") . " " . trans("msg_suc_updated"));
				redirect(admin_url() . 'gallery');
			} else {
				$this->session->set_flashdata('form_data', $this->gallery_model->input_values());
				$this->session->set_flashdata('error', trans("msg_error"));
				redirect($this->agent->referrer());
			}
		}
	}


	/**
	 * Delete Image Post
	 */
	public function delete_gallery_image_post()
	{
		$id = $this->input->post('id', true);

		if ($this->gallery_model->delete($id)) {
			$this->session->set_flashdata('success', trans("image") . " " . trans("msg_suc_deleted"));
		} else {
			$this->session->set_flashdata('error', trans("msg_error"));
		}
	}

	/**
	 * Albums
	 */
	public function gallery_albums()
	{
		prevent_author();

		$data['title'] = trans("albums");
		$data['categories'] = $this->gallery_category_model->get_albums();
		$data['lang_search_column'] = 2;
        
		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/gallery/albums', $data);
		$this->load->view('admin/includes/_footer');
	}

	/**
	 * Add Album Post
	 */
	public function add_gallery_album_post()
	{
		prevent_author();

		//validate inputs
		$this->form_validation->set_rules('name', trans("album_name"), 'required|xss_clean|max_length[200]');

		if ($this->form_validation->run() === false) {
			$this->session->set_flashdata('errors_form', validation_errors());
			redirect($this->agent->referrer());
		} else {
			if ($this->gallery_category_model->add_album()) {
				$this->session->set_flashdata('success_form', trans("album") . " " . trans("msg_suc_added"));
				redirect($this->agent->referrer());
			} else {
				$this->session->set_flashdata('error_form', trans("msg_error"));
				redirect($this->agent->referrer());
			}
		}
	}

	/**
	 * Update Gallery Album
	 */
	public function update_gallery_album($id)
	{
		prevent_author();

		$data['title'] = trans("update_album");

		//get album
		$data['album'] = $this->gallery_category_model->get_album($id);
		if (empty($data['album'])) {
			redirect($this->agent->referrer());
		}

		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/gallery/update_album', $data);
		$this->load->view('admin/includes/_footer');
	}


	/**
	 * Update Gallery Album Post
	 */
	public function update_gallery_album_post()
	{
		prevent_author();

		//validate inputs
		$this->form_validation->set_rules('name', trans("album_name"), 'required|xss_clean|max_length[200]');

		if ($this->form_validation->run() === false) {
			$this->session->set_flashdata('errors', validation_errors());
			redirect($this->agent->referrer());
		} else {
			$id = $this->input->post('id', true);
			if ($this->gallery_category_model->update_album($id)) {
				$this->session->set_flashdata('success', trans("album") . " " . trans("msg_suc_updated"));
				redirect(admin_url() . 'gallery-albums');
			} else {
				$this->session->set_flashdata('error', trans("msg_error"));
				redirect($this->agent->referrer());
			}
		}
	}


	/**
	 * Delete Gallery Album Post
	 */
	public function delete_gallery_album_post()
	{

		prevent_author();

		$id = $this->input->post('id', true);

		//check if album has categories
		if ($this->gallery_category_model->get_album_category_count($id) > 0) {
			$this->session->set_flashdata('error', trans("msg_delete_album"));
			exit();
		}
		if ($this->gallery_category_model->delete_album($id)) {
			$this->session->set_flashdata('success', trans("album") . " " . trans("msg_suc_deleted"));
			exit();
		} else {
			$this->session->set_flashdata('error', trans("msg_error"));
			exit();
		}
	}

	//get albums by lang
	public function gallery_albums_by_lang()
	{
		$lang_id = $this->input->post('lang_id', true);
		if (!empty($lang_id)):
			$albums = $this->gallery_category_model->get_albums_by_lang($lang_id);
			foreach ($albums as $item) {
				echo '<option value="' . $item->id . '">' . $item->name . '</option>';
			}
		endif;
	}

	//set as album cover
	public function set_as_album_cover()
	{
		$image_id = $this->input->post('image_id', true);
		$this->gallery_model->set_as_album_cover($image_id);
	}

}
