<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'username' => remove_forbidden_characters($this->input->post('username', true)),
            'email' => remove_forbidden_characters($this->input->post('email', true)),
            'password' => $this->input->post('password', true)
        );
        return $data;
    }

    //login
    public function login()
    {
        $data = $this->input_values();
        $user = $this->get_user_by_username($data['username']);
        if (empty($user)) {
            $user = $this->get_user_by_email($data['username']);
        }
        if (!empty($user)) {
            //check password
            if (!$this->bcrypt->check_password($data['password'], $user->password)) {
                return false;
            }
            if ($user->status == 0) {
                return "banned";
            }
            if ($user->role != "admin" && $user->role != "author" && $this->general_settings->registration_system != 1) {
                return false;
            }
            //set user data
            $user_data = array(
                'inf_ses_id' => $user->id,
                'inf_ses_username' => $user->username,
                'inf_ses_email' => $user->email,
                'inf_ses_role' => $user->role,
                'inf_ses_logged_in' => true,
                'inf_ses_app_key' => $this->config->item('app_key'),
            );
            $this->session->set_userdata($user_data);
            return "success";
        } else {
            return false;
        }
    }

    //login with facebook
    public function login_with_facebook($fb_user)
    {
        if (!empty($fb_user)) {
            $user = $this->get_user_by_email($fb_user->email);
            //check if user registered
            if (empty($user)) {
                if (empty($fb_user->name)) {
                    $fb_user->name = "user-" . uniqid();
                }
                $username = $this->generate_uniqe_username($fb_user->name);
                $slug = $this->generate_uniqe_slug($username);
                //add user to database
                $data = array(
                    'facebook_id' => $fb_user->id,
                    'email' => $fb_user->email,
                    'token' => generate_unique_id(),
                    'username' => $username,
                    'slug' => $slug,
                    'avatar' => "https://graph.facebook.com/" . $fb_user->id . "/picture?type=large",
                    'user_type' => "facebook",
                    'last_seen' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                );
                if (!empty($data['email'])) {
                    $this->db->insert('users', $data);
                    $user = $this->get_user_by_email($fb_user->email);
                    $this->login_direct($user);
                }
            } else {
                //login
                $this->login_direct($user);
            }
        }
    }

    //login with google
    public function login_with_google($g_user)
    {
        if (!empty($g_user)) {
            $user = $this->get_user_by_email($g_user->email);
            //check if user registered
            if (empty($user)) {
                if (empty($g_user->name)) {
                    $g_user->name = "user-" . uniqid();
                }
                $username = $this->generate_uniqe_username($g_user->name);
                $slug = $this->generate_uniqe_slug($username);
                //add user to database
                $data = array(
                    'google_id' => $g_user->id,
                    'email' => $g_user->email,
                    'token' => generate_unique_id(),
                    'username' => $username,
                    'slug' => $slug,
                    'avatar' => $g_user->avatar,
                    'user_type' => "google",
                    'last_seen' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                );
                if (!empty($data['email'])) {
                    $this->db->insert('users', $data);
                    $user = $this->get_user_by_email($g_user->email);
                    $this->login_direct($user);
                }
            } else {
                //login
                $this->login_direct($user);
            }
        }
    }

    //login direct
    public function login_direct($user)
    {
        //set user data
        $user_data = array(
            'inf_ses_id' => $user->id,
            'inf_ses_username' => $user->username,
            'inf_ses_email' => $user->email,
            'inf_ses_role' => $user->role,
            'inf_ses_logged_in' => true,
            'inf_ses_app_key' => $this->config->item('app_key'),
        );
        $this->session->set_userdata($user_data);
    }

    //register
    public function register()
    {
        $data = $this->auth_model->input_values();
        //secure password
        $data['password'] = $this->bcrypt->hash_password($data['password']);
        $data['slug'] = $this->generate_uniqe_slug($data["username"]);
        $data['token'] = generate_unique_id();
        $data['last_seen'] = date('Y-m-d H:i:s');
        $data["created_at"] = date('Y-m-d H:i:s');
        if ($this->db->insert('users', $data)) {
            $id = $this->db->insert_id();
            $user = $this->get_user($id);
            //set user data
            $user_data = array(
                'inf_ses_id' => $user->id,
                'inf_ses_username' => $user->username,
                'inf_ses_email' => $user->email,
                'inf_ses_role' => $user->role,
                'inf_ses_logged_in' => true,
                'inf_ses_app_key' => $this->config->item('app_key'),
            );
            $this->session->set_userdata($user_data);
            return true;
        } else {
            return false;
        }
    }

    //add user
    public function add_user()
    {
        $this->load->library('bcrypt');
        $data = $this->auth_model->input_values();
        $data['role'] = $this->input->post('role', true);
        $data['token'] = generate_unique_id();
        //secure password
        $data['password'] = $this->bcrypt->hash_password($data['password']);
        $data['slug'] = $this->generate_uniqe_slug($data["username"]);
        $data['last_seen'] = date('Y-m-d H:i:s');
        $data["created_at"] = date('Y-m-d H:i:s');

        return $this->db->insert('users', $data);
    }

    //generate uniqe username
    public function generate_uniqe_username($username)
    {
        $new_username = $username;
        if (!empty($this->get_user_by_username($new_username))) {
            $new_username = $username . " 1";
            if (!empty($this->get_user_by_username($new_username))) {
                $new_username = $username . " 2";
                if (!empty($this->get_user_by_username($new_username))) {
                    $new_username = $username . " 3";
                    if (!empty($this->get_user_by_username($new_username))) {
                        $new_username = $username . "-" . uniqid();
                    }
                }
            }
        }
        return $new_username;
    }

    //generate uniqe slug
    public function generate_uniqe_slug($username)
    {
        $slug = str_slug($username);
        if (!empty($this->get_user_by_slug($slug))) {
            $slug = str_slug($username . "-1");
            if (!empty($this->get_user_by_slug($slug))) {
                $slug = str_slug($username . "-2");
                if (!empty($this->get_user_by_slug($slug))) {
                    $slug = str_slug($username . "-3");
                    if (!empty($this->get_user_by_slug($slug))) {
                        $slug = str_slug($username . "-" . uniqid());
                    }
                }
            }
        }
        return $slug;
    }

    //logout
    public function logout()
    {
        //unset user data
        $this->session->unset_userdata('inf_ses_id');
        $this->session->unset_userdata('inf_ses_username');
        $this->session->unset_userdata('inf_ses_email');
        $this->session->unset_userdata('inf_ses_role');
        $this->session->unset_userdata('inf_ses_logged_in');
        $this->session->unset_userdata('inf_ses_app_key');
    }

    //update user
    public function update_user($id)
    {
        $user = $this->auth_model->get_user($id);
        $data = array(
            'email' => $this->input->post('email', true),
            'slug' => $this->input->post('slug', true)
        );

        $this->load->model('upload_model');
        $temp_path = $this->upload_model->upload_temp_image('file', 'path');
        if (!empty($temp_path)) {
            $data["avatar"] = $this->upload_model->avatar_upload($id, $temp_path);
            $this->upload_model->delete_temp_image($temp_path);
            //delete old
            delete_image_from_server($user->avatar);
        }

        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    //reset password
    public function reset_password($token)
    {
        $user = $this->get_user_by_token($token);
        if (!empty($user)) {
            $this->load->library('bcrypt');
            $new_password = $this->input->post('password', true);
            $data = array(
                'password' => $this->bcrypt->hash_password($new_password),
                'token' => generate_unique_id()
            );
            //change password
            $this->db->where('id', $user->id);
            return $this->db->update('users', $data);
        }
        return false;
    }

    //update author
    public function update_author($id)
    {
        $user = $this->get_user($id);

        $data = array(
            'username' => $this->input->post('username', true),
            'slug' => $this->input->post('slug', true),
            'about_me' => $this->input->post('about_me', true),
            'email' => $this->input->post('email', true),
            'facebook_url' => $this->input->post('facebook_url', true),
            'twitter_url' => $this->input->post('twitter_url', true),
            'instagram_url' => $this->input->post('instagram_url', true),
            'pinterest_url' => $this->input->post('pinterest_url', true),
            'linkedin_url' => $this->input->post('linkedin_url', true),
            'vk_url' => $this->input->post('vk_url', true),
            'youtube_url' => $this->input->post('youtube_url', true),
        );

        $this->load->model('upload_model');
        $temp_path = $this->upload_model->upload_temp_image('file', 'path');
        if (!empty($temp_path)) {
            $data["avatar"] = $this->upload_model->avatar_upload($id, $temp_path);
            $this->upload_model->delete_temp_image($temp_path);
            //delete old
            delete_image_from_server($user->avatar);
        }

        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    //change user role
    public function change_user_role($id, $role)
    {
        $data = array(
            'role' => $role
        );

        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    //delete user
    public function delete_user($id)
    {
        $user = $this->get_user($id);

        if (!empty($user)) {
            $this->db->where('id', $id);
            return $this->db->delete('users');
        } else {
            return false;
        }
    }

    //ban user
    public function ban_user($id)
    {
        $user = $this->get_user($id);

        if (!empty($user)) {

            $data = array(
                'status' => 0
            );

            $this->db->where('id', $id);
            return $this->db->update('users', $data);
        } else {
            return false;
        }
    }

    //remove user ban
    public function remove_user_ban($id)
    {
        $user = $this->get_user($id);

        if (!empty($user)) {

            $data = array(
                'status' => 1
            );

            $this->db->where('id', $id);
            return $this->db->update('users', $data);
        } else {
            return false;
        }
    }

    //is logged in
    public function is_logged_in()
    {
        $user = $this->get_logged_user();
        //check if user logged in
        if ($this->session->userdata('inf_ses_logged_in') == true && $this->session->userdata('inf_ses_app_key') == $this->config->item('app_key') && !empty($user)) {

            if ($user->status == 0) {
                $this->logout();
                return false;
            } else {
                return true;
            }

        } else {
            $this->logout();
            return false;
        }
    }

    //is admin
    public function is_admin()
    {
        //check logged in
        if (!$this->is_logged_in()) {
            return false;
        }

        //check role
        if ($this->session->userdata('inf_ses_role') == 'admin') {
            return true;
        } else {
            return false;
        }
    }

    //is author
    public function is_author()
    {
        //check logged in
        if (!$this->is_logged_in()) {
            return false;
        }

        //check role
        if ($this->session->userdata('inf_ses_role') == 'author') {
            return true;
        } else {
            return false;
        }
    }

    //function get user
    public function get_logged_user()
    {
        if ($this->session->userdata('inf_ses_logged_in') == true) {
            $query = $this->db->get_where('users', array('id' => $this->get_user_id()));
            return $query->row();
        }
    }

    //get user by id
    public function get_user($id)
    {
        $query = $this->db->get_where('users', array('id' => $id));
        return $query->row();
    }


    //get user by slug
    public function get_user_by_slug($slug)
    {
        $query = $this->db->get_where('users', array('slug' => $slug));
        return $query->row();
    }

    //get user by username
    public function get_user_by_username($username)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get user by email
    public function get_user_by_email($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get user by token
    public function get_user_by_token($token)
    {
        $this->db->where('token', $token);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get users
    public function get_users()
    {
        $query = $this->db->get('users');
        return $query->result();
    }

    //get authors
    public function get_authors()
    {
        $this->db->where('role !=', 'user');
        $query = $this->db->get('users');
        return $query->result();
    }

    //get last users
    public function get_last_users()
    {
        $this->db->limit(7);
        $this->db->order_by('users.id', 'DESC');
        $query = $this->db->get('users');
        return $query->result();
    }

    //get logged user id
    public function get_user_id()
    {
        return $this->session->userdata('inf_ses_id');
    }

    //get logged username
    public function get_username()
    {
        return $this->session->userdata('inf_ses_username');
    }

    //user count
    public function get_user_count()
    {
        $query = $this->db->get('users');
        return $query->num_rows();
    }


    //check if email is unique
    public function is_unique_email($email, $user_id = 0)
    {
        $user = $this->auth_model->get_user_by_email($email);

        //if id doesnt exists
        if ($user_id == 0) {
            if (empty($user)) {
                return true;
            } else {
                return false;
            }
        }

        if ($user_id != 0) {
            if (!empty($user) && $user->id != $user_id) {
                //email taken
                return false;
            } else {
                return true;
            }
        }
    }

    //check if username is unique
    public function is_unique_username($username, $user_id = 0)
    {
        $user = $this->get_user_by_username($username);

        //if id doesnt exists
        if ($user_id == 0) {
            if (empty($user)) {
                return true;
            } else {
                return false;
            }
        }

        if ($user_id != 0) {
            if (!empty($user) && $user->id != $user_id) {
                //username taken
                return false;
            } else {
                return true;
            }
        }
    }

    //check slug
    public function check_is_slug_unique($slug, $id)
    {
        $this->db->where('users.slug', $slug);
        $this->db->where('users.id !=', $id);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //update last seen time
    public function update_last_seen()
    {
        if ($this->is_logged_in()) {
            //update last seen
            $data = array(
                'last_seen' => date("Y-m-d H:i:s"),
            );
            $this->db->where('id', $this->auth_user->id);
            $this->db->update('users', $data);
        }
    }


}
