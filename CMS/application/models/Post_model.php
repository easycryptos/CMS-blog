<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends CI_Model
{
	public function set_filter_query()
	{
		$this->db->join('users', 'posts.user_id = users.id');
		$this->db->join('categories', 'posts.category_id = categories.id');
		$this->db->select('posts.* , users.username as username, users.slug as user_slug, categories.name as category_name, categories.slug as category_slug, categories.parent_id as category_parent_id, 
		(SELECT slug FROM categories WHERE id = category_parent_id) as parent_category_slug, (SELECT COUNT(comments.id) FROM comments WHERE comments.post_id = posts.id AND comments.parent_id = 0 AND status = 1) as comment_count');
		$this->db->where('posts.visibility', 1);
		$this->db->where('posts.status', 1);
		$this->db->where('posts.lang_id', $this->selected_lang->id);
	}

	//get post
	public function get_post($slug)
	{
		$this->set_filter_query();
		$this->db->where('posts.title_slug', $slug);
		$query = $this->db->get('posts');
		return $query->row();
	}

	//get post by id
	public function get_post_by_id($id)
	{
		$this->db->where('posts.id', $id);
		$query = $this->db->get('posts');
		return $query->row();
	}

	//get all posts
	public function get_posts()
	{
		$this->set_filter_query();
		$this->db->order_by('posts.created_at', 'DESC');
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get all posts
	public function get_paginated_posts($per_page, $offset)
	{
		$this->set_filter_query();
		$this->db->order_by('posts.created_at', 'DESC');
		$this->db->limit($per_page, $offset);
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get post count
	public function get_post_count()
	{
		$this->set_filter_query();
		$query = $this->db->get('posts');
		return $query->num_rows();
	}

	//get slider posts
	public function get_slider_posts()
	{
		$this->set_filter_query();
		$this->db->where('is_slider', 1);
		$this->db->order_by('slider_order');
		$this->db->limit(20);
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get popular posts
	public function get_popular_posts($limit)
	{
		$this->set_filter_query();
		$this->db->order_by('hit', 'DESC');
		$this->db->limit($limit);
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get picked posts
	public function get_our_picks($limit)
	{
		$this->set_filter_query();
		$this->db->where('is_picked', 1);
		$this->db->order_by('posts.created_at', 'DESC');
		$this->db->limit($limit);
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get random posts
	public function get_random_posts($limit)
	{
		$this->set_filter_query();
		$this->db->order_by('rand()');
		$this->db->limit($limit);
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get category post count
	public function get_post_count_by_category($category_id)
	{
		$category_ids = $this->category_model->get_category_tree_ids_string($category_id);
		$this->set_filter_query();
		$this->db->where("posts.category_id IN (" . $category_ids . ")", NULL, FALSE);
		$this->db->where('posts.visibility', 1);
		$this->db->where('posts.status', 1);
		$query = $this->db->get('posts');
		return $query->num_rows();
	}

	//get posts by category
	public function get_posts_by_category($category_id)
	{
		$category_ids = $this->category_model->get_category_tree_ids_string($category_id);
		$this->set_filter_query();
		$this->db->where("posts.category_id IN (" . $category_ids . ")", NULL, FALSE);
		$this->db->order_by('posts.created_at', 'DESC');
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get paginated category posts
	public function get_paginated_category_posts($category_id, $per_page, $offset)
	{
		$category_ids = $this->category_model->get_category_tree_ids_string($category_id);
		$this->set_filter_query();
		$this->db->where("posts.category_id IN (" . $category_ids . ")", NULL, FALSE);
		$this->db->order_by('posts.created_at', 'DESC');
		$this->db->limit($per_page, $offset);
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get posts by user
	public function get_paginated_user_posts($user_id, $per_page, $offset)
	{
		$this->set_filter_query();
		$this->db->where('posts.user_id', $user_id);
		$this->db->order_by('posts.created_at', 'DESC');
		$this->db->limit($per_page, $offset);
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get post count by user
	public function get_post_count_by_user($user_id)
	{
		$this->set_filter_query();
		$this->db->where('posts.user_id', $user_id);
		$query = $this->db->get('posts');
		return $query->num_rows();
	}

	//get related posts
	public function get_related_posts($category_id, $post_id)
	{
		$this->set_filter_query();
		$this->db->where('posts.id !=', $post_id);
		$this->db->where('posts.category_id', $category_id);
		$this->db->order_by('rand()');
		$this->db->limit(3);
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get post count by tag
	public function get_tag_post_count($tag_slug)
	{
		$this->set_filter_query();
		$this->db->join('tags', 'posts.id = tags.post_id');
		$this->db->where('tags.tag_slug', $tag_slug);
		$query = $this->db->get('posts');
		return $query->num_rows();
	}

	//get posts by tag
	public function get_paginated_tag_posts($tag_slug, $per_page, $offset)
	{
		$this->set_filter_query();
		$this->db->join('tags', 'posts.id = tags.post_id');
		$this->db->where('tags.tag_slug', $tag_slug);
		$this->db->order_by('posts.created_at', 'DESC');
		$this->db->limit($per_page, $offset);
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get search posts
	public function get_paginated_search_posts($q, $per_page, $offset)
	{
		$this->set_filter_query();
		$this->db->group_start();
		$this->db->like('posts.title', $q);
		$this->db->or_like('posts.content', $q);
		$this->db->or_like('posts.summary', $q);
		$this->db->group_end();
		$this->db->order_by('posts.created_at', 'DESC');
		$this->db->limit($per_page, $offset);
		$query = $this->db->get('posts');
		return $query->result();
	}

	//get search post count
	public function get_search_post_count($q)
	{
		$this->set_filter_query();
		$this->db->group_start();
		$this->db->like('posts.title', $q);
		$this->db->or_like('posts.content', $q);
		$this->db->or_like('posts.summary', $q);
		$this->db->group_end();
		$query = $this->db->get('posts');
		return $query->num_rows();
	}

	//increase post hit
	public function increase_post_hit($post)
	{
		if (!empty($post)):
			if (!isset($_COOKIE['inf_post_' . $post->id])) :
				//increase hit
				helper_setcookie('inf_post_' . $post->id, '1');

				$data = array(
					'hit' => $post->hit + 1
				);

				$this->db->where('id', $post->id);
				$this->db->update('posts', $data);

			endif;
		endif;
	}
}
