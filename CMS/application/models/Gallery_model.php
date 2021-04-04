<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gallery_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'album_id' => $this->input->post('album_id', true),
            'category_id' => 0,
            'title' => $this->input->post('title', true),
            'path_big' => $this->input->post('path_big', true),
            'path_small' => $this->input->post('path_small', true)
        );
        $category_id = $this->input->post('category_id', true);
        if (!empty($category_id)) {
            $data['category_id'] = $category_id;
        }
        $data["created_at"] = date('Y-m-d H:i:s');

        return $data;
    }

    //add image
    public function add()
    {
        $data = $this->input_values();
        $data['is_album_cover'] = 0;

        if (!empty($_FILES['files'])) {
            $this->load->model('upload_model');
            $file_count = count($_FILES['files']['name']);
            for ($i = 0; $i < $file_count; $i++) {
                if (isset($_FILES['files']['name'])) {
                    //file
                    $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['files']['size'][$i];
                    //upload
                    $temp_data = $this->upload_model->upload_temp_image('file', 'array');
                    if (!empty($temp_data)) {
                        $temp_path = $temp_data['full_path'];
                        if ($temp_data['image_type'] == 'gif') {
                            $gif_path = $this->upload_model->gallery_gif_image_upload($temp_data['file_name']);
                            $data["path_big"] = $gif_path;
                            $data["path_small"] = $gif_path;
                        } else {
                            $data["path_big"] = $this->upload_model->gallery_big_image_upload($temp_path);
                            $data["path_small"] = $this->upload_model->gallery_small_image_upload($temp_path);
                        }
                    }
                    $this->upload_model->delete_temp_image($temp_path);
                    $this->db->insert('photos', $data);
                }
            }
            return true;
        }

        return false;
    }

    //get gallery images
    public function get_images()
    {
        $this->db->where('photos.lang_id', $this->selected_lang->id);
        $this->db->order_by('photos.id', 'DESC');
        $query = $this->db->get('photos');
        return $query->result();
    }

    //get all gallery images
    public function get_all_images()
    {
        $this->db->order_by('photos.id', 'DESC');
        $query = $this->db->get('photos');
        return $query->result();
    }

    //get gallery images by category
    public function get_images_by_category($category_id)
    {
        $this->db->join('gallery_categories', 'photos.category_id = gallery_categories.id');
        $this->db->select('photos.* , gallery_categories.name as category_name');
        $this->db->where('photos.lang_id', $this->selected_lang->id);
        $this->db->where('category_id', $category_id);
        $this->db->order_by('photos.id', 'DESC');
        $query = $this->db->get('photos');
        return $query->result();
    }

    //get gallery images by album
    public function get_images_by_album($album_id)
    {
        $this->db->where('album_id', $album_id);
        $this->db->order_by('photos.id', 'DESC');
        $query = $this->db->get('photos');
        return $query->result();
    }

    //get category image count
    public function get_category_image_count($category_id)
    {
        $this->db->where('category_id', $category_id);
        $this->db->where('photos.lang_id', $this->selected_lang->id);
        $query = $this->db->get('photos');
        return $query->num_rows();
    }

    //set as album cover
    public function set_as_album_cover($id)
    {
        $image = $this->get_image($id);
        if (!empty($image)) {
            //reset all
            $data = array(
                'is_album_cover' => 0
            );
            $this->db->where('album_id', $image->album_id);
            $this->db->update('photos', $data);
            //set new
            $data = array(
                'is_album_cover' => 1
            );
            $this->db->where('id', $id);
            $this->db->update('photos', $data);
        }
    }

    //get gallery album cover image
    public function get_cover_image($album_id)
    {
        $this->db->where('album_id', $album_id);
        $this->db->where('is_album_cover', 1);
        $this->db->order_by('photos.id', 'DESC');
        $query = $this->db->get('photos');
        $row = $query->row();
        if (empty($row)) {
            $this->db->where('album_id', $album_id);
            $this->db->order_by('photos.id', 'DESC');
            $query = $this->db->get('photos');
            $row = $query->row();
        }
        return $row;
    }

    //get image
    public function get_image($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('photos');
        return $query->row();
    }

    //update image
    public function update($id)
    {
        $data = $this->input_values();
        $this->load->model('upload_model');
        $temp_data = $this->upload_model->upload_temp_image('file', 'array');
        if (!empty($temp_data)) {
            $temp_path = $temp_data['full_path'];
            if ($temp_data['image_type'] == 'gif') {
                $gif_path = $this->upload_model->gallery_gif_image_upload($temp_data['file_name']);
                $data["path_big"] = $gif_path;
                $data["path_small"] = $gif_path;
            } else {
                $data["path_big"] = $this->upload_model->gallery_big_image_upload($temp_path);
                $data["path_small"] = $this->upload_model->gallery_small_image_upload($temp_path);
            }
            $this->upload_model->delete_temp_image($temp_path);
        }
        $this->db->where('id', $id);
        return $this->db->update('photos', $data);
    }


    //delete image
    public function delete($id)
    {
        $image = $this->get_image($id);

        if (!empty($image)) {
            //delete image
            delete_image_from_server($image->path_big);
            delete_image_from_server($image->path_small);

            $this->db->where('id', $id);
            return $this->db->delete('photos');
        } else {
            return false;
        }

    }
}
