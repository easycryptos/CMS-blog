<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Navigation_model extends CI_Model
{
	//input values
	public function input_values()
	{
		$data = array(
			'lang_id' => $this->input->post('lang_id', true),
			'title' => $this->input->post('title', true),
			'link' => $this->input->post('link', true),
			'page_order' => $this->input->post('page_order', true),
			'page_active' => $this->input->post('page_active', true),
			'parent_id' => $this->input->post('parent_id', true),
			'location' => "header"
		);
		return $data;
	}

	//add link
	public function add_link()
	{
		$data = $this->input_values();

		//slug for title
		if (empty($data["slug"])) {
			$data["slug"] = str_slug($data["title"]);
		}

		if (empty($data['link'])) {
			$data['link'] = "#";
		}

		return $this->db->insert('pages', $data);
	}

	//update link
	public function update_link($id)
	{
		$data = $this->input_values();
		//slug for title
		if (empty($data["slug"])) {
			$data["slug"] = str_slug($data["title"]);
		}

		$this->db->where('id', $id);
		return $this->db->update('pages', $data);
	}

	//get parent link
	public function get_parent_link($parent_id, $type)
	{
		if ($type == "page") {
			$this->db->where('id', $parent_id);
			$query = $this->db->get('pages');
			return $query->row();
		}
		if ($type == "category") {
			$this->db->where('id', $parent_id);
			$query = $this->db->get('categories');
			return $query->row();
		}
	}

    //get menu links
    public function get_menu_links($lang_id)
    {
        $sql = "SELECT * FROM (
        (SELECT categories.id AS item_id, categories.lang_id AS item_lang_id, categories.name AS item_name, categories.slug AS item_slug, categories.category_order AS item_order, 'header' 
        AS item_location, 'category' AS item_type, '#' AS item_link, categories.parent_id AS item_parent_id,
        (SELECT slug FROM categories WHERE id = item_parent_id) as item_parent_slug
        FROM categories WHERE categories.lang_id = ? AND categories.show_on_menu = 1) 
        UNION
        (SELECT pages.id AS item_id, pages.lang_id AS item_lang_id, pages.title AS item_name, pages.slug AS item_slug, pages.page_order AS item_order, pages.location AS item_location, 'page' 
        AS item_type, pages.link AS item_link, pages.parent_id AS item_parent_id,
        (SELECT slug FROM pages WHERE id = item_parent_id) as item_parent_slug 
        FROM pages WHERE pages.lang_id = ? AND pages.page_active = 1)) AS menu_items ORDER BY item_order, item_name";
        $query = $this->db->query($sql, array($lang_id, $lang_id));
        return $query->result();
    }

    //get all menu links
    public function get_all_menu_links()
    {
        $sql = "SELECT * FROM (
        (SELECT categories.id AS item_id, categories.lang_id AS item_lang_id, categories.name AS item_name, categories.slug AS item_slug, categories.category_order AS item_order, 'header' 
        AS item_location, 'category' AS item_type, '#' AS item_link, categories.parent_id AS item_parent_id, categories.show_on_menu AS item_visibility,
        (SELECT slug FROM categories WHERE id = item_parent_id) as item_parent_slug 
        FROM categories) 
        UNION
        (SELECT pages.id AS item_id, pages.lang_id AS item_lang_id, pages.title AS item_name, pages.slug AS item_slug, pages.page_order AS item_order, pages.location AS item_location, 'page' 
        AS item_type, pages.link AS item_link, pages.parent_id AS item_parent_id, pages.page_active AS item_visibility,
        (SELECT slug FROM pages WHERE id = item_parent_id) as item_parent_slug 
        FROM pages)) AS menu_items ORDER BY item_order";
        $query = $this->db->query($sql);
        return $query->result();
    }

	//update menu limit
	public function update_menu_limit()
	{
		$data = array(
			'menu_limit' => $this->input->post('menu_limit', true),
		);

		$this->db->where('id', 1);
		return $this->db->update('general_settings', $data);
	}
}
