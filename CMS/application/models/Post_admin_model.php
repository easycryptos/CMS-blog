<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Post_admin_model extends CI_Model
{

    //input values
    public function input_values()
    {
        $data = array(
            'post_type' => $this->input->post('post_type', true),
            'lang_id' => $this->input->post('lang_id', true),
            'title' => $this->input->post('title', true),
            'title_slug' => $this->input->post('title_slug', true),
            'summary' => $this->input->post('summary', true),
            'keywords' => $this->input->post('keywords', true),
            'category_id' => $this->input->post('category_id', true),
            'content' => $this->input->post('content', false),
            'optional_url' => $this->input->post('optional_url', true),
            'need_auth' => $this->input->post('need_auth', true),
            'is_slider' => $this->input->post('is_slider', true),
            'is_picked' => $this->input->post('is_picked', true)
        );
        return $data;
    }

    //add post
    public function add_post()
    {
        $data = $this->set_data();

        $subcategory_id = $this->input->post('subcategory_id', true);
        if (!empty($subcategory_id)) {
            $data["category_id"] = $subcategory_id;
        }

        $data['user_id'] = $this->auth_user->id;
        if ($this->general_settings->approve_posts_before_publishing == 1 && $this->auth_user->role != 'admin') {
            $data['visibility'] = 0;
        } else {
            $data['visibility'] = 1;
        }

        $data['status'] = $this->input->post('status', true);
        $data['feed_id'] = 0;
        $data["created_at"] = date('Y-m-d H:i:s');

        return $this->db->insert('posts', $data);
    }

    //update post
    public function update_post($id)
    {
        $data = $this->set_data();

        $data['user_id'] = $this->input->post('user_id', true);

        $subcategory_id = $this->input->post('subcategory_id', true);
        if (!empty($subcategory_id)) {
            $data["category_id"] = $subcategory_id;
        }

        $data["created_at"] = $this->input->post('date_published', true);

        $publish = $this->input->post('publish', true);
        if (!empty($publish) && $publish == 1) {
            $data["status"] = 1;
        }

        if ($this->auth_user->role == 'admin') {
            $data['visibility'] = $this->input->post('visibility', true);
        } else {
            if ($this->general_settings->approve_posts_before_publishing == 1) {
                $data['visibility'] = 0;
            } else {
                $data['visibility'] = 1;
            }
        }

        $this->db->where('id', $id);
        return $this->db->update('posts', $data);
    }

    //set post data
    public function set_data()
    {
        $data = $this->input_values();

        if (!isset($data['is_slider'])) {
            $data['is_slider'] = 0;
        }
        if (!isset($data['is_picked'])) {
            $data['is_picked'] = 0;
        }
        if (!isset($data['need_auth'])) {
            $data['need_auth'] = 0;
        }
        if (!empty($data["title_slug"])) {
            //slug for title
            $data["title_slug"] = remove_special_characters(trim($data["title_slug"]), true);
        } else {
            $data["title_slug"] = str_slug(trim($data["title"]));
        }

        if (empty($this->input->post('image_url', true))) {
            //add post image
            $image = $this->file_model->get_image($this->input->post('post_image_id', true));
            if (!empty($image)) {
                $data["image_url"] = "";
                $data["image_big"] = $image->image_big;
                $data["image_mid"] = $image->image_mid;
                $data["image_small"] = $image->image_small;
                $data["image_slider"] = $image->image_slider;
                $data["image_mime"] = $image->image_mime;
            }
        } else {
            $data["image_url"] = $this->input->post('image_url', true);
            $data["image_big"] = "";
            $data["image_mid"] = "";
            $data["image_small"] = "";
            $data["image_slider"] = "";
            $data["image_mime"] = "";
        }

        if ($data['post_type'] == "video") {
            $data['video_url'] = $this->input->post('video_url', true);
            $data["video_embed_code"] = $this->input->post('video_embed_code', true);
        } else {
            $data['video_url'] = '';
            $data["video_embed_code"] = '';
        }
        return $data;
    }

    //update slug
    public function update_slug($id)
    {
        $post = $this->get_post($id);
        $slug = $post->title_slug;
        $new_slug = $post->title_slug;
        //check page
        $page = $this->page_model->get_page($slug);
        if (!empty($page)) {
            $new_slug = $slug . "-" . $post->id;
        }
        if ($this->check_is_slug_unique($slug, $id) == true) {
            $new_slug = $slug . "-" . $post->id;
        }
        $data = array(
            'title_slug' => $new_slug
        );
        $this->db->where('id', $id);
        return $this->db->update('posts', $data);
    }

    //check slug
    public function check_is_slug_unique($slug, $id)
    {
        $this->db->where('posts.title_slug', $slug);
        $this->db->where('posts.id !=', $id);
        $query = $this->db->get('posts');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //check post exists
    public function check_is_post_exists($title)
    {
        $this->db->where('posts.title', $title);
        $query = $this->db->get('posts');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //get post
    public function get_post($id)
    {
        $this->db->where('posts.id', $id);
        $query = $this->db->get('posts');
        return $query->row();
    }

    //get posts count
    public function get_posts_count()
    {
        if ($this->auth_user->role == "author") {
            $this->db->where('posts.user_id', $this->auth_user->id);
        }
        $this->db->where('posts.visibility', 1);
        $this->db->where('posts.status', 1);
        $query = $this->db->get('posts');
        return $query->num_rows();
    }

    //get pending posts count
    public function get_pending_posts_count()
    {
        if ($this->auth_user->role == "author") {
            $this->db->where('posts.user_id', $this->auth_user->id);
        }
        $this->db->where('posts.visibility', 0);
        $this->db->where('posts.status', 1);
        $query = $this->db->get('posts');
        return $query->num_rows();
    }

    //get drafts count
    public function get_drafts_count()
    {
        if ($this->auth_user->role == "author") {
            $this->db->where('posts.user_id', $this->auth_user->id);
        }
        $this->db->where('posts.status', 0);
        $query = $this->db->get('posts');
        return $query->num_rows();
    }

    //filter by values
    public function filter_posts()
    {
        $data = array(
            'lang_id' => $this->input->get('lang_id', true),
            'post_type' => $this->input->get('post_type', true),
            'author' => $this->input->get('author', true),
            'category' => $this->input->get('category', true),
            'subcategory' => $this->input->get('subcategory', true),
            'q' => $this->input->get('q', true),
        );

        $category_id = null;
        if (!empty($data['category'])) {
            $category_id = $data['category'];
        }
        if (!empty($data['subcategory'])) {
            $category_id = $data['subcategory'];
        }
        if (!empty($category_id)) {
            $category_ids = $this->category_model->get_category_tree_ids_string($category_id);
            $this->db->where("posts.category_id IN (" . $category_ids . ")", NULL, FALSE);
        }

        $data['q'] = trim($data['q']);
        $data['user_id'] = "";
        //check if author
        if ($this->auth_user->role == "author"):
            $data['user_id'] = $this->auth_user->id;
        else:
            if (!empty($data['author'])) {
                $data['user_id'] = $data['author'];
            }
        endif;

        if (!empty($data['lang_id'])) {
            $this->db->where('posts.lang_id', $data['lang_id']);
        }
        if (!empty($data['post_type'])) {
            if ($data['post_type'] == 'video') {
                $this->db->where('posts.post_type', 'video');
            } else {
                $this->db->where('posts.post_type', 'post');
            }
        }

        if (!empty($data['q'])) {
            $this->db->like('posts.title', $data['q']);
        }
        if (!empty($data['user_id'])) {
            $this->db->where('posts.user_id', $data['user_id']);
        }
    }

    //filter by list
    public function filter_posts_list($list)
    {
        if (!empty($list)) {
            if ($list == "slider_posts") {
                $this->db->where('posts.is_slider', 1);
            }
            if ($list == "our_picks") {
                $this->db->where('posts.is_picked', 1);
            }
        }
    }

    //get paginated posts
    public function get_paginated_posts($per_page, $offset, $list)
    {
        $this->filter_posts();
        $this->filter_posts_list($list);
        $this->db->where('posts.visibility', 1);
        $this->db->where('posts.status', 1);
        $this->db->order_by('posts.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('posts');
        return $query->result();
    }

    //get paginated posts count
    public function get_paginated_posts_count($list)
    {
        $this->filter_posts();
        $this->filter_posts_list($list);
        $this->db->where('posts.visibility', 1);
        $this->db->where('posts.status', 1);
        $query = $this->db->get('posts');
        return $query->num_rows();
    }

    //get sitemap posts
    public function get_sitemap_posts()
    {
        $this->db->where('posts.visibility', 1);
        $this->db->where('posts.status', 1);
        $this->db->order_by('posts.created_at', 'DESC');
        $query = $this->db->get('posts');
        return $query->result();
    }

    //get paginated pending posts
    public function get_paginated_pending_posts($per_page, $offset)
    {
        $this->filter_posts();
        $this->db->where('posts.visibility', 0);
        $this->db->where('posts.status', 1);
        $this->db->order_by('posts.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('posts');
        return $query->result();
    }

    //get paginated pending posts count
    public function get_paginated_pending_posts_count()
    {
        $this->filter_posts();
        $this->db->where('posts.visibility', 0);
        $this->db->where('posts.status', 1);
        $query = $this->db->get('posts');
        return $query->num_rows();
    }

    //get paginated drafts
    public function get_paginated_drafts($per_page, $offset)
    {
        $this->filter_posts();
        $this->db->where('posts.status !=', 1);
        $this->db->order_by('posts.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('posts');
        return $query->result();
    }

    //get paginated drafts count
    public function get_paginated_drafts_count()
    {
        $this->filter_posts();
        $this->db->where('posts.status !=', 1);
        $query = $this->db->get('posts');
        return $query->num_rows();
    }

    //get post count by category
    public function get_post_count_by_category($category_id)
    {
        $this->db->where('posts.category_id', $category_id);
        $this->db->where('posts.visibility', 1);
        $this->db->where('posts.status', 1);
        $query = $this->db->get('posts');
        return $query->num_rows();
    }

    //check post exists
    public function check_post_exists($title, $title_hash)
    {
        $sql = "SELECT * FROM posts WHERE title = ? OR title_hash = ?";
        $query = $this->db->query($sql, array($title, $title_hash));
        if (!empty($query->row())) {
            return true;
        }
        return false;
    }

    //get posts by feed id
    public function get_posts_by_feed_id($feed_id)
    {
        $this->db->where('feed_id', clean_number($feed_id));
        $query = $this->db->get('posts');
        return $query->result();
    }

    //get feed posts count
    public function get_feed_posts_count($feed_id)
    {
        $this->db->select('COUNT(posts.id) as count');
        $this->db->where('feed_id', clean_number($feed_id));
        $query = $this->db->get('posts');
        return $query->row()->count;
    }


    //add or remove post from slider
    public function post_add_remove_slider($id)
    {
        //get post
        $post = $this->get_post($id);

        if (!empty($post)) {
            $result = "";
            if ($post->is_slider == 1) {
                //remove from slider
                $data = array(
                    'is_slider' => 0,
                );
                $result = "removed";
            } else {
                //add to slider
                $data = array(
                    'is_slider' => 1,
                );
                $result = "added";
            }

            $this->db->where('id', $id);
            $this->db->update('posts', $data);
            return $result;
        }
    }

    //approve post
    public function approve_post($id)
    {
        $data = array(
            'visibility' => 1,
        );

        $this->db->where('id', $id);
        return $this->db->update('posts', $data);
    }

    //publish post
    public function publish_post($id)
    {
        $sql = "UPDATE posts SET created_at = CURRENT_TIMESTAMP() WHERE id = ?";
        return $this->db->query($sql, array($id));
    }

    //publish draft
    public function publish_draft($id)
    {
        $data = array(
            'status' => 1,
        );

        $this->db->where('id', $id);
        return $this->db->update('posts', $data);
    }

    //add or remove post from picked
    public function post_add_remove_picked($id)
    {
        //get post
        $post = $this->get_post($id);

        if (!empty($post)) {
            $result = "";
            if ($post->is_picked == 1) {
                //remove from picked
                $data = array(
                    'is_picked' => 0,
                );
                $result = "removed";
            } else {
                //add to picked
                $data = array(
                    'is_picked' => 1,
                );
                $result = "added";
            }

            $this->db->where('id', $id);
            $this->db->update('posts', $data);
            return $result;
        }
    }

    //save home slider post order
    public function save_home_slider_post_order($id, $order)
    {
        //get post
        $post = $this->get_post($id);

        if (!empty($post)):
            $data = array(
                'slider_order' => $order,
            );
            $this->db->where('id', $id);
            $this->db->update('posts', $data);
        endif;
    }

    //delete post
    public function delete_post($id)
    {
        $post = $this->get_post($id);

        if (!empty($post)):
            $this->db->where('id', $id);
            return $this->db->delete('posts');
        else:
            return false;
        endif;
    }

    //delete multi post
    public function delete_multi_posts($post_ids)
    {
        if (!empty($post_ids)) {
            foreach ($post_ids as $id) {
                $post = $this->get_post($id);

                if (!empty($post)) {

                    //delete post tags
                    $this->tag_model->delete_post_tags($id);

                    $this->db->where('id', $id);
                    $this->db->delete('posts');
                }
            }
        }

    }
}
