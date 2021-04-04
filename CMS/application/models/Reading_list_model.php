<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reading_list_model extends CI_Model
{

    //add to reading list
    public function add_to_reading_list($post_id)
    {
        //active user id
        $user_id = $this->auth_model->get_user_id();

        if (empty($user_id) || empty($post_id)) {
            redirect($this->agent->referrer());
        }

        $data = array(
            'post_id' => $post_id,
            'user_id' => $user_id
        );

        return $this->db->insert('reading_lists', $data);
    }

    //delete from reading list
    public function delete_from_reading_list($post_id)
    {
        //active user id
        $user_id = $this->auth_model->get_user_id();

        if (empty($user_id) || empty($post_id)) {
            redirect($this->agent->referrer());
        }

        $this->db->where('post_id', $post_id);
        $this->db->where('user_id', $user_id);
        return $this->db->delete('reading_lists');
    }

    //get paginated posts by tag
    public function get_paginated_reading_list($limit, $offset)
    {
        //active user id
        $user_id = $this->auth_model->get_user_id();
        if (empty($user_id)) {
            redirect(lang_base_url());
        }

        $this->db->join('reading_lists', 'posts.id = reading_lists.post_id');
        $this->db->join('users', 'posts.user_id = users.id');
        $this->db->join('categories', 'posts.category_id = categories.id');
		$this->db->select('posts.* , users.username as username, users.slug as user_slug, categories.name as category_name, categories.slug as category_slug, categories.parent_id as category_parent_id, 
		(SELECT slug FROM categories WHERE id = category_parent_id) as parent_category_slug,  (SELECT COUNT(comments.id) FROM comments WHERE comments.post_id = posts.id AND comments.parent_id = 0 AND status = 1) as comment_count');
		$this->db->where('reading_lists.user_id', $user_id);
		$this->db->where('posts.lang_id', $this->selected_lang->id);
        $this->db->order_by('posts.id', 'DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get('posts');
        return $query->result();

    }


    //get reading list post count
    public function get_reading_list_count()
    {
        //active user id
        $user_id = $this->auth_model->get_user_id();
        if (empty($user_id)) {
            redirect(lang_base_url());
        }

        $this->db->join('reading_lists', 'posts.id = reading_lists.post_id');
        $this->db->join('users', 'posts.user_id = users.id');
        $this->db->join('categories', 'posts.category_id = categories.id');
		$this->db->select('posts.* , users.username as username, users.slug as user_slug, categories.name as category_name, categories.slug as category_slug, categories.parent_id as category_parent_id, (SELECT slug FROM categories WHERE id = category_parent_id) as parent_category_slug');
        $this->db->where('reading_lists.user_id', $user_id);
        $this->db->where('posts.lang_id', $this->selected_lang->id);
        $this->db->order_by('posts.id', 'DESC');
        $query = $this->db->get('posts');
        return $query->num_rows();
    }

    //check post is in the reading list or not
    public function is_post_in_reading_list($post_id)
    {
        //active user id
        $user_id = $this->auth_model->get_user_id();

        if (empty($user_id)) {
            return false;
        }

        $this->db->where('post_id', $post_id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('reading_lists');

        if($query->num_rows() > 0){
            //in list
            return true;
        }else{
            return false;
        }
    }


}
