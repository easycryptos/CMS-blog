<?php
defined('BASEPATH') or exit('No direct script access allowed');

class File_model extends CI_Model
{
    /*
    *------------------------------------------------------------------------------------------
    * IMAGES
    *------------------------------------------------------------------------------------------
    */

    //upload image
    public function upload_image()
    {
        $this->load->model('upload_model');
        $temp_data = $this->upload_model->upload_temp_image('file', 'array');
        if (!empty($temp_data)) {
            $temp_path = $temp_data['full_path'];
            if ($temp_data['image_type'] == 'gif') {
                $gif_path = $this->upload_model->post_gif_image_upload($temp_data['file_name']);
                $data["image_big"] = $gif_path;
                $data["image_mid"] = $gif_path;
                $data["image_small"] = $gif_path;
                $data["image_slider"] = $gif_path;
                $data["image_mime"] = 'gif';
                $data["file_name"] = $this->upload_model->get_file_original_name($temp_data);
            } else {
                $data["image_big"] = $this->upload_model->post_big_image_upload($temp_path);
                $data["image_mid"] = $this->upload_model->post_mid_image_upload($temp_path);
                $data["image_small"] = $this->upload_model->post_small_image_upload($temp_path);
                $data["image_slider"] = $this->upload_model->post_slider_image_upload($temp_path);
                $data["image_mime"] = 'jpg';
                $data["file_name"] = $this->upload_model->get_file_original_name($temp_data);
            }
            $this->insert_image($data);
            $this->upload_model->delete_temp_image($temp_path);
        }
    }

    //get image
    public function get_image($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('images');
        return $query->row();
    }

    //get images
    public function get_images($count)
    {
        if ($this->general_settings->file_manager_show_all_files != 1) {
            $this->db->where('user_id', $this->auth_user->id);
        }
        $this->db->order_by('id', 'DESC');
        $this->db->limit($count);
        $query = $this->db->get('images');
        return $query->result();
    }

    //get more images
    public function get_more_images($last_id, $limit)
    {
        if ($this->general_settings->file_manager_show_all_files != 1) {
            $this->db->where('user_id', $this->auth_user->id);
        }
        $this->db->where('id <', $last_id);
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('images');
        return $query->result();
    }

    //search images
    public function search_images($search)
    {
        if ($this->general_settings->file_manager_show_all_files != 1) {
            $this->db->where('user_id', $this->auth_user->id);
        }
        $this->db->like('file_name', $search);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('images');
        return $query->result();
    }

    //delete image
    public function delete_image($id)
    {
        $image = $this->get_image($id);
        if ($this->general_settings->file_manager_show_all_files != 1) {
            if ($image->user_id != $this->auth_user->id) {
                return false;
            }
        }
        if (!empty($image)) {
            //delete image from server
            delete_file_from_server($image->image_big);
            delete_file_from_server($image->image_mid);
            delete_file_from_server($image->image_small);
            delete_file_from_server($image->image_slider);

            $this->db->where('id', $id);
            $this->db->delete('images');
        }
    }

    //add image to database
    function insert_image($data)
    {
        $ci =& get_instance();
        $ci->load->database();
        // Connect to the database
        $mysqli = new mysqli($ci->db->hostname, $ci->db->username, $ci->db->password, $ci->db->database);

        $image_big = $ci->security->xss_clean($data["image_big"]);
        $image_mid = $ci->security->xss_clean($data["image_mid"]);
        $image_small = $ci->security->xss_clean($data["image_small"]);
        $image_slider = $ci->security->xss_clean($data["image_slider"]);
        $image_mime = $ci->security->xss_clean($data["image_mime"]);
        $file_name = $ci->security->xss_clean($data["file_name"]);

        // Check for errors
        if (!mysqli_connect_errno()) {
            $mysqli->query("INSERT INTO `images` (`image_big`, `image_mid`, `image_small`, `image_slider`, `image_mime`, `file_name`, `user_id`) 
								   VALUES (" . $ci->db->escape($image_big) . "," . $ci->db->escape($image_mid) . "," . $ci->db->escape($image_small) . "," . $ci->db->escape($image_slider) . "," . $ci->db->escape($image_mime) . "," . $ci->db->escape($file_name) . "," . clean_number($this->auth_user->id) . ");");
        }
        // Close the connection
        $mysqli->close();
    }

    /*
    *------------------------------------------------------------------------------------------
    * FILES
    *------------------------------------------------------------------------------------------
    */

    //upload file
    public function upload_file()
    {
        $this->load->model('upload_model');
        $file_name = $this->upload_model->upload_file('file');
        if (!empty($file_name)) {
            $data["file_name"] = $file_name;
            $this->insert_file($data);
        }
    }

    //add file to database
    function insert_file($data)
    {
        $ci =& get_instance();
        $ci->load->database();
        // Connect to the database
        $mysqli = new mysqli($ci->db->hostname, $ci->db->username, $ci->db->password, $ci->db->database);

        $file_name = $ci->security->xss_clean($data["file_name"]);
        // Check for errors
        if (!mysqli_connect_errno()) {
            $mysqli->query("INSERT INTO `files` (`file_name`, `user_id`) VALUES (" . $ci->db->escape($file_name) . "," . clean_number($this->auth_user->id) . ");");
        }
        // Close the connection
        $mysqli->close();
    }

    //get files
    public function get_files($count)
    {
        if ($this->general_settings->file_manager_show_all_files != 1) {
            $this->db->where('user_id', $this->auth_user->id);
        }
        $this->db->order_by('id', 'DESC');
        $this->db->limit($count);
        $query = $this->db->get('files');
        return $query->result();
    }

    //get file
    public function get_file($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('files');
        return $query->row();
    }

    //get more files
    public function get_more_files($last_id, $limit)
    {
        if ($this->general_settings->file_manager_show_all_files != 1) {
            $this->db->where('user_id', $this->auth_user->id);
        }
        $this->db->where('id <', $last_id);
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('files');
        return $query->result();
    }

    //search files
    public function search_files($search)
    {
        if ($this->general_settings->file_manager_show_all_files != 1) {
            $this->db->where('user_id', $this->auth_user->id);
        }
        $this->db->like('file_name', $search);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('files');
        return $query->result();
    }

    //delete file
    public function delete_file($id)
    {
        $file = $this->get_file($id);
        if ($this->general_settings->file_manager_show_all_files != 1) {
            if ($file->user_id != $this->auth_user->id) {
                return false;
            }
        }
        if (!empty($file)) {
            //delete file from server
            delete_file_from_server(FILES_DIRECTORY . $file->file_name);
            $this->db->where('id', $id);
            $this->db->delete('files');
        }
    }
}
