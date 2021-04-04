<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile_model extends CI_Model
{
    //update profile
    public function update_profile($data, $user_id)
    {
        $this->load->model('upload_model');
        $temp_path = $this->upload_model->upload_temp_image('file', 'path');
        if (!empty($temp_path)) {
            $data["avatar"] = $this->upload_model->avatar_upload($this->auth_user->id, $temp_path);
            $this->upload_model->delete_temp_image($temp_path);
            //delete old
            delete_file_from_server($this->auth_user->avatar);
        }

        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    //update update social accounts
    public function update_social_accounts()
    {
        $data = array(
            'facebook_url' => add_https($this->input->post('facebook_url', true)),
            'twitter_url' => add_https($this->input->post('twitter_url', true)),
            'instagram_url' => add_https($this->input->post('instagram_url', true)),
            'pinterest_url' => add_https($this->input->post('pinterest_url', true)),
            'linkedin_url' => add_https($this->input->post('linkedin_url', true)),
            'vk_url' => add_https($this->input->post('vk_url', true)),
            'telegram_url' => add_https($this->input->post('telegram_url', true)),
            'youtube_url' => add_https($this->input->post('youtube_url', true))
        );

        $this->db->where('id', $this->auth_user->id);
        return $this->db->update('users', $data);
    }

    //update visual settings
    public function visual_settings()
    {
        $data = array(
            'site_mode' => $this->input->post('site_mode', true),
            'site_color' => $this->input->post('site_color', true)
        );
        $this->db->where('id', clean_number($this->auth_user->id));
        return $this->db->update('users', $data);
    }

    //change password input values
    public function change_password_input_values()
    {
        $data = array(
            'old_password' => $this->input->post('old_password', true),
            'password' => $this->input->post('password', true),
            'password_confirm' => $this->input->post('password_confirm', true)
        );
        return $data;
    }

    //change password
    public function change_password()
    {
        $this->load->library('bcrypt');
        $user = $this->auth_user;
        if (!empty($user)) {
            $data = $this->change_password_input_values();

            if ($this->input->post('is_pass_exist', true) == 1) {
                //password does not match stored password.
                if (!$this->bcrypt->check_password($data['old_password'], $user->password)) {
                    $this->session->set_flashdata('error', trans("wrong_password_error"));
                    $this->session->set_flashdata('form_data', $this->change_password_input_values());
                    redirect($this->agent->referrer());
                }
            }

            $data = array(
                'password' => $this->bcrypt->hash_password($data['password'])
            );
            $this->db->where('id', $user->id);
            return $this->db->update('users', $data);
        } else {
            return false;
        }
    }

    //follow user
    public function follow_unfollow_user()
    {
        $data = array(
            'following_id' => $this->input->post('following_id', true),
            'follower_id' => user()->id
        );

        $follow = $this->get_follow($data["following_id"], $data["follower_id"]);
        if (empty($follow)) {
            //add follower
            $this->db->insert('followers', $data);
        } else {
            $this->db->where('id', $follow->id);
            $this->db->delete('followers');
        }
    }

    //follow
    public function get_follow($following_id, $follower_id)
    {
        $this->db->where('following_id', $following_id);
        $this->db->where('follower_id', $follower_id);
        $query = $this->db->get('followers');
        return $query->row();
    }

    //is user follows
    public function is_user_follows($following_id, $follower_id)
    {
        $follow = $this->get_follow($following_id, $follower_id);
        if (empty($follow)) {
            return false;
        } else {
            return true;
        }
    }

    //get followers
    public function get_followers($following_id)
    {
        $this->db->join('users', 'followers.follower_id = users.id');
        $this->db->select('users.*');
        $this->db->where('following_id', $following_id);
        $query = $this->db->get('followers');
        return $query->result();
    }

    //get followers count
    public function get_followers_count($following_id)
    {
        $this->db->join('users', 'followers.follower_id = users.id');
        $this->db->select('users.*');
        $this->db->where('following_id', $following_id);
        $query = $this->db->get('followers');
        return $query->num_rows();
    }

    //get following users
    public function get_following_users($follower_id)
    {
        $this->db->join('users', 'followers.following_id = users.id');
        $this->db->select('users.*');
        $this->db->where('follower_id', $follower_id);
        $query = $this->db->get('followers');
        return $query->result();
    }

    //get following users
    public function get_following_users_count($follower_id)
    {
        $this->db->join('users', 'followers.following_id = users.id');
        $this->db->select('users.*');
        $this->db->where('follower_id', $follower_id);
        $query = $this->db->get('followers');
        return $query->num_rows();
    }
}
