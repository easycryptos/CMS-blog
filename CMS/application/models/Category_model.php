<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model
{
	//input values
	public function input_values()
	{
		$data = array(
			'lang_id' => $this->input->post('lang_id', true),
			'name' => $this->input->post('name', true),
			'slug' => $this->input->post('slug', true),
			'parent_id' => $this->input->post('parent_id', true),
			'description' => $this->input->post('description', true),
			'keywords' => $this->input->post('keywords', true),
			'category_order' => $this->input->post('category_order', true),
			'show_on_menu' => $this->input->post('show_on_menu', true),
		);
		return $data;
	}

	//add category
	public function add_category()
	{
		$data = $this->input_values();

		if (!empty($data["slug"])) {
			//slug for title
			$data["slug"] = remove_special_characters(trim($data["slug"]), true);
		} else {
			$data["slug"] = str_slug(trim($data["name"]));
		}

		$data['created_at'] = date('Y-m-d H:i:s');

		return $this->db->insert('categories', $data);
	}

	//add subcategory
	public function add_subcategory()
	{
		$data = $this->input_values();

		if (!empty($data["slug"])) {
			//slug for title
			$data["slug"] = remove_special_characters(trim($data["slug"]), true);
		} else {
			$data["slug"] = str_slug(trim($data["name"]));
		}

		$data['created_at'] = date('Y-m-d H:i:s');

		return $this->db->insert('categories', $data);
	}

	//update slug
	public function update_slug($id)
	{
		$category = $this->get_category($id);

		if (empty($category->slug) || $category->slug == "-") {
			$data = array(
				'slug' => $category->id
			);
			$this->db->where('id', $id);
			$this->db->update('categories', $data);
		} else {
			if ($this->check_is_slug_unique($category->slug, $id) == true) {
				$data = array(
					'slug' => $category->slug . "-" . $category->id
				);

				$this->db->where('id', $id);
				$this->db->update('categories', $data);
			}
		}
	}

	//check slug
	public function check_is_slug_unique($slug, $id)
	{
		$this->db->where('categories.slug', $slug);
		$this->db->where('categories.id !=', $id);
		$query = $this->db->get('categories');
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}


	//get category
	public function get_category($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('categories');
		return $query->row();
	}

	//get category by slug
	public function get_category_by_slug($slug)
	{
		$this->db->where('slug', $slug);
		$query = $this->db->get('categories');
		return $query->row();
	}

	//check category slug
	public function check_category_slug($slug, $id)
	{
		$this->db->where('slug', $slug);
		$this->db->where('id !=', $id);
		$query = $this->db->get('categories');
		return $query->row();
	}

	//get all top categories
	public function get_all_categories()
	{
		$this->db->where('parent_id', 0);
		$this->db->order_by('category_order');
		$query = $this->db->get('categories');
		return $query->result();
	}

	//get sitemap categories
	public function get_sitemap_categories()
	{
		$this->db->select('categories.*, categories.parent_id as category_parent_id, (SELECT slug FROM categories WHERE id = category_parent_id) as parent_slug');
		$this->db->order_by('category_order');
		$query = $this->db->get('categories');
		return $query->result();
	}

	//get top categories
	public function get_categories()
	{
		$this->db->select('categories.*, categories.parent_id as category_parent_id, (SELECT slug FROM categories WHERE id = category_parent_id) as parent_slug');
		$this->db->where('categories.lang_id', $this->selected_lang->id);
		$this->db->where('parent_id', 0);
		$this->db->order_by('category_order');
		$query = $this->db->get('categories');
		return $query->result();
	}

	//get top categories
	public function get_categories_by_lang($lang_id)
	{
		$this->db->select('categories.*, categories.parent_id as category_parent_id, (SELECT slug FROM categories WHERE id = category_parent_id) as parent_slug');
		$this->db->where('categories.lang_id', $lang_id);
		$this->db->where('parent_id', 0);
		$this->db->order_by('category_order');
		$query = $this->db->get('categories');
		return $query->result();
	}

	//get subcategories
	public function get_subcategories()
	{
		$this->db->select('categories.*, categories.parent_id as category_parent_id, (SELECT slug FROM categories WHERE id = category_parent_id) as parent_slug');
		$this->db->where('categories.lang_id', $this->selected_lang->id);
		$this->db->where('parent_id !=', 0);
		$query = $this->db->get('categories');
		return $query->result();
	}

	//get all subcategories
	public function get_all_subcategories()
	{
		$this->db->where('parent_id !=', 0);
		$query = $this->db->get('categories');
		return $query->result();
	}

	//get subcategories by id
	public function get_subcategories_by_parent_id($parent_id)
	{
		$this->db->select('categories.*, categories.parent_id as category_parent_id, (SELECT slug FROM categories WHERE id = category_parent_id) as parent_slug');
		$this->db->where('show_on_menu', 1);
		$this->db->where('parent_id', $parent_id);
		$query = $this->db->get('categories');
		return $query->result();
	}

	//get all subcategories by id
	public function get_all_subcategories_by_parent_id($parent_id)
	{
		$this->db->select('categories.*, categories.parent_id as category_parent_id, (SELECT slug FROM categories WHERE id = category_parent_id) as parent_slug');
		$this->db->where('parent_id', $parent_id);
		$query = $this->db->get('categories');
		return $query->result();
	}

	//get category count
	public function get_category_count()
	{
		$query = $this->db->get('categories');
		return $query->num_rows();
	}

	//update category
	public function update_category($id)
	{
		$data = $this->input_values();

		//slug for title
		if (empty($data["slug"])) {
			$data["slug"] = str_slug($data["name"]);
		}

		$this->db->where('id', $id);
		return $this->db->update('categories', $data);
	}

	//get category array
	public function get_category_array($id)
	{
		$category = $this->get_category($id);
		$tree = array(
			'parent_category' => '',
			'subcategory' => ''
		);
		if (!empty($category)) {
			if ($category->parent_id == 0) {
				$tree['parent_category'] = $category;
			} else {
				$parent = $this->get_category($category->parent_id);
				$tree['parent_category'] = $parent;
				$tree['subcategory'] = $category;
			}
		}
		return $tree;
	}

	public function get_category_tree($id)
	{
		$tree = array();
		$category = $this->get_category($id);
		if ($category->parent_id == 0) {
			array_push($tree, $category->id);
			$subcategories = $this->get_subcategories_by_parent_id($category->id);
			foreach ($subcategories as $subcategory) {
				array_push($tree, $subcategory->id);
			}
		} else {
			array_push($tree, $category->id);
		}
		return $tree;
	}

	public function get_category_tree_ids_string($id)
	{
		$tree = $this->get_category_tree($id);
		$ids = '';
		foreach ($tree as $item) {
			$ids .= $item . ", ";
		}
		$ids = trim($ids);
		$ids = trim($ids, ',');
		return $ids;
	}

	//delete category
	public function delete_category($id)
	{
		$category = $this->get_category($id);

		if (!empty($category)) {
			$this->db->where('id', $id);
			return $this->db->delete('categories');
		} else {
			return false;
		}
	}

}
