<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_model extends CI_Model
{
	//input values
	public function input_values()
	{
		$data = array(
			'lang_id' => $this->input->post('lang_id', true),
			'title' => $this->input->post('title', true),
			'slug' => $this->input->post('slug', true),
			'page_description' => $this->input->post('page_description', true),
			'page_keywords' => $this->input->post('page_keywords', true),
			'page_content' => $this->input->post('page_content', false),
			'page_order' => $this->input->post('page_order', true),
			'parent_id' => $this->input->post('parent_id', true),
			'page_active' => $this->input->post('page_active', true),
			'title_active' => $this->input->post('title_active', true),
			'breadcrumb_active' => $this->input->post('breadcrumb_active', true),
			'right_column_active' => $this->input->post('right_column_active', true),
			'need_auth' => $this->input->post('need_auth', true),
			'location' => $this->input->post('location', true)
		);
		return $data;
	}

	//add page
	public function add()
	{
		$data = $this->page_model->input_values();

		if (empty($data["slug"])) {
			//slug for title
			$data["slug"] = str_slug($data["title"]);

			if (empty($data["slug"])) {
				$data["slug"] = "page-" . uniqid();
			}
		}
		$data["created_at"] = date('Y-m-d H:i:s');

		return $this->db->insert('pages', $data);
	}

	//update page
	public function update($id)
	{
		//set values
		$data = $this->page_model->input_values();

		if (empty($data["slug"])) {
			//slug for title
			$data["slug"] = str_slug($data["title"]);

			if (empty($data["slug"])) {
				$data["slug"] = "page-" . uniqid();
			}
		}

		$page = $this->get_page_by_id($id);
		if (!empty($page)) {
			$this->db->where('id', $id);
			return $this->db->update('pages', $data);
		}
		return false;
	}

	//get all pages
	public function get_all_pages()
	{
		$this->db->order_by('page_order');
		$query = $this->db->get('pages');
		return $query->result();
	}

	//get pages
	public function get_pages()
	{
		$this->db->where('pages.lang_id', $this->selected_lang->id);
		$this->db->order_by('page_order');
		$query = $this->db->get('pages');
		return $query->result();
	}

	//get pages
	public function get_pages_by_lang($lang_id)
	{
		$this->db->where('pages.lang_id', $lang_id);
		$this->db->order_by('page_order');
		$query = $this->db->get('pages');
		return $query->result();
	}

	//get subpages
	public function get_subpages($parent_id)
	{
		$this->db->where('parent_id', $parent_id);
		$this->db->where('page_active', 1);
		$this->db->order_by('page_order');
		$query = $this->db->get('pages');
		return $query->result();
	}

	//get pages sitemap
	public function get_pages_sitemap()
	{
		$this->db->order_by('pages.id');
		$query = $this->db->get('pages');
		return $query->result();
	}

	//get top menu pages
	public function get_top_menu_pages()
	{
		$this->db->where('pages.lang_id', $this->selected_lang->id);
		$this->db->order_by('page_order');
		$this->db->where('location', 'top');
		$query = $this->db->get('pages');
		return $query->result();
	}

	//get main menu pages
	public function get_main_menu_pages()
	{
		$this->db->where('pages.lang_id', $this->selected_lang->id);
		$this->db->order_by('page_order');
		$this->db->where('location', 'main');
		$query = $this->db->get('pages');
		return $query->result();
	}

	//get footer pages
	public function get_footer_pages()
	{
		$this->db->where('pages.lang_id', $this->selected_lang->id);
		$this->db->order_by('page_order');
		$this->db->where('location', 'footer');
		$query = $this->db->get('pages');
		return $query->result();
	}

	//get page
	public function get_page($slug)
	{
		$this->db->where('slug', $slug);
		$query = $this->db->get('pages');
		return $query->row();
	}

	//get page by lang
	public function get_page_by_lang($slug, $lang_id)
	{
		$this->db->where('lang_id', $lang_id);
		$this->db->where('slug', $slug);
		$query = $this->db->get('pages');
		return $query->row();
	}

	//get page by id
	public function get_page_by_id($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('pages');
		return $query->row();
	}

	//check page name
	public function check_page_name()
	{
		$title = $this->input->post('title', true);
		$slug = $this->input->post('slug', true);

		if (empty($slug)) {
			//slug for title
			$slug = str_slug($title);
		}

		$languages = $this->language_model->get_languages();
		if (!empty($languages)) {
			foreach ($languages as $language) {
				if ($language->short_form == trim($slug)) {
					return false;
				}
			}
		}
		return true;
	}

	//delete page
	public function delete($id)
	{
		$page = $this->get_page_by_id($id);
		if (!empty($page)) {
			$this->db->where('id', $id);
			return $this->db->delete('pages');
		}
		return false;
	}
}
