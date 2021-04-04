<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Comment_model extends CI_Model
{
    //add comment
    public function add_comment()
    {
        $data = array(
            'parent_id' => $this->input->post('parent_id', true),
            'post_id' => $this->input->post('post_id', true),
            'user_id' => 0,
            'name' => $this->input->post('name', true),
            'email' => $this->input->post('email', true),
            'comment' => $this->input->post('comment', true),
            'status' => 1,
            'created_at' => date("Y-m-d H:i:s")
        );

        if ($this->auth_check) {
            $data['user_id'] = $this->auth_user->id;
        }
        if ($this->general_settings->comment_approval_system == 1) {
            $data["status"] = 0;
        }
        if (!empty($data['post_id']) && !empty(trim($data['comment']))) {
            if ($data['user_id'] != 0) {
                $user = $this->auth_model->get_user($data['user_id']);
                if (!empty($user)) {
                    $data['name'] = $user->username;
                    $data['email'] = $user->email;
                }
            }
            $this->db->insert('comments', $data);
        }
    }

    //get comment
    public function get_comment($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('comments');
        return $query->row();
    }

    //post comment count
    public function post_comment_count($post_id)
    {
        $this->db->join('posts', 'comments.post_id = posts.id');
        $this->db->where('post_id', $post_id);
        $this->db->where('parent_id', 0);
        $this->db->where('comments.status', 1);
        $query = $this->db->get('comments');
        return $query->num_rows();
    }

    //get comments
    public function get_comments($post_id, $limit)
    {
        $this->db->join('posts', 'comments.post_id = posts.id');
        $this->db->where('post_id', $post_id);
        $this->db->where('parent_id', 0);
        $this->db->where('comments.status', 1);
        $this->db->select('comments.*');
        $this->db->limit($limit);
        $this->db->order_by('comments.id', 'DESC');
        $query = $this->db->get('comments');
        return $query->result();
    }

    //get approved comments
    public function get_approved_comments()
    {
        $this->db->join('posts', 'comments.post_id = posts.id');
        $this->db->select('comments.*');
        $this->db->where('comments.status', 1);
        $this->db->order_by('comments.id', 'DESC');
        $query = $this->db->get('comments');
        return $query->result();
    }

    //get pending comments
    public function get_pending_comments()
    {
        $this->db->join('posts', 'comments.post_id = posts.id');
        $this->db->select('comments.*');
        $this->db->where('comments.status', 0);
        $this->db->order_by('comments.id', 'DESC');
        $query = $this->db->get('comments');
        return $query->result();
    }

    //get last comments
    public function get_last_comments($limit)
    {
        $this->db->join('posts', 'comments.post_id = posts.id');
        $this->db->select('comments.* , posts.title_slug as post_slug');
        $this->db->where('comments.status', 1);
        $this->db->order_by('comments.id', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('comments');
        return $query->result();
    }

    //get last pending comments
    public function get_last_pedding_comments($limit)
    {
        $this->db->join('posts', 'comments.post_id = posts.id');
        $this->db->select('comments.* , posts.title_slug as post_slug');
        $this->db->where('comments.status', 0);
        $this->db->order_by('comments.id', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('comments');
        return $query->result();
    }

    //get subcomments
    public function get_subcomments($comment_id)
    {
        $this->db->join('posts', 'comments.post_id = posts.id');
        $this->db->where('parent_id', $comment_id);
        $this->db->where('comments.status', 1);
        $this->db->select('comments.*');
        $this->db->order_by('comments.id', 'DESC');
        $query = $this->db->get('comments');
        return $query->result();
    }

    //get post comment count
    public function get_post_comment_count($post_id)
    {
        $this->db->join('posts', 'comments.post_id = posts.id');
        $this->db->where('post_id', $post_id);
        $this->db->where('parent_id', 0);
        $this->db->where('comments.status', 1);
        $query = $this->db->get('comments');
        return $query->num_rows();
    }

    //approve comment
    public function approve_comment($id)
    {
        $comment = $this->get_comment($id);
        if (!empty($comment)) {
            $data = array(
                'status' => 1
            );
            $this->db->where('id', $comment->id);
            return $this->db->update('comments', $data);
        }
        return false;
    }

    //delete comment
    public function delete_comment($id)
    {
        $subcomments = $this->get_subcomments($id);
        if (!empty($subcomments)) {
            foreach ($subcomments as $comment) {
                $this->delete_subcomments($comment->id);
                $this->db->where('id', $comment->id);
                $this->db->delete('comments');
            }
        }

        $this->db->where('id', $id);
        return $this->db->delete('comments');
    }

    //delete sub comments
    public function delete_subcomments($id)
    {
        $subcomments = $this->get_subcomments($id);

        if (!empty($subcomments)) {
            foreach ($subcomments as $comment) {
                $this->db->where('id', $comment->id);
                $this->db->delete('comments');
            }
        }

    }

    //delete multi comments
    public function delete_multi_comments($comment_ids)
    {
        if (!empty($comment_ids)) {
            foreach ($comment_ids as $id) {
                $subcomments = $this->get_subcomments($id);

                if (!empty($subcomments)) {
                    foreach ($subcomments as $comment) {
                        $this->delete_subcomments($comment->id);
                        $this->db->where('id', $comment->id);
                        $this->db->delete('comments');
                    }
                }

                $this->db->where('id', $id);
                $this->db->delete('comments');
            }
        }
    }

    //approve multi comments
    public function approve_multi_comments($comment_ids)
    {
        if (!empty($comment_ids)) {
            foreach ($comment_ids as $id) {
                $this->approve_comment($id);
            }
        }
    }

}
