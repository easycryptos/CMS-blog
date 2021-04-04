<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery_category_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'album_id' => $this->input->post('album_id', true),
            'name' => $this->input->post('name', true)
        );
        return $data;
    }

    //add category
    public function add()
    {
        $data = $this->input_values();
		$data["created_at"] = date('Y-m-d H:i:s');

        return $this->db->insert('gallery_categories', $data);
    }

    //get all gallery categories
    public function get_all_categories()
    {
        $query = $this->db->get('gallery_categories');
        return $query->result();
    }

    //get gallery categories
    public function get_categories_by_selected_lang()
    {
        $this->db->where('gallery_categories.lang_id', $this->selected_lang->id);
        $query = $this->db->get('gallery_categories');
        return $query->result();
    }

    //get gallery categories by lang
    public function get_categories_by_lang($lang_id)
    {
        $this->db->where('gallery_categories.lang_id', $lang_id);
        $query = $this->db->get('gallery_categories');
        return $query->result();
    }

    //get gallery categories by album
    public function get_categories_by_album($album_id)
    {
        $this->db->where('album_id', $album_id);
        $query = $this->db->get('gallery_categories');
        return $query->result();
    }

    //get category count
    public function get_category_count()
    {
        $this->db->where('gallery_categories.lang_id', $this->selected_lang->id);
        $query = $this->db->get('gallery_categories');
        return $query->num_rows();
    }

    //get category
    public function get_category($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('gallery_categories');
        return $query->row();
    }

    //get next category
    public function get_next_category($id)
    {
        $sql = "SELECT * FROM gallery_categories WHERE gallery_categories.lang_id=? AND gallery_categories.id != ? ORDER BY gallery_categories.id > ? LIMIT 1";
        $query = $this->db->query($sql, array($this->selected_lang->id, $id, $id));
        return $query->row();
    }

    //get previous category
    public function get_previous_category($id)
    {
        $sql = "SELECT * FROM gallery_categories WHERE gallery_categories.lang_id=? AND gallery_categories.id != ? ORDER BY gallery_categories.id < ? LIMIT 1";
        $query = $this->db->query($sql, array($this->selected_lang->id, $id, $id));
        return $query->row();
    }

    //update category
    public function update($id)
    {
        $data = $this->input_values();

        $this->db->where('id', $id);
        return $this->db->update('gallery_categories', $data);
    }

    //delete category
    public function delete($id)
    {
        $category = $this->get_category($id);

        if (!empty($category)) {
            $this->db->where('id', $id);
            return $this->db->delete('gallery_categories');
        } else {
            return false;
        }

    }

    /*
     * ------------------------------------------------------------------------------
     * GALLERY ALBUMS
     * ------------------------------------------------------------------------------
     */
    //add album
    public function add_album()
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'name' => $this->input->post('name', true)
        );
		$data['created_at'] = date('Y-m-d H:i:s');

        return $this->db->insert('gallery_albums', $data);
    }

    //update album
    public function update_album($id)
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'name' => $this->input->post('name', true)
        );
        $this->db->where('id', $id);
        return $this->db->update('gallery_albums', $data);
    }


    //get albums
    public function get_albums()
    {
        $query = $this->db->get('gallery_albums');
        return $query->result();
    }

    //get albums by selected lang
    public function get_albums_by_selected_lang()
    {
        $this->db->where('lang_id', $this->selected_lang->id);
        $query = $this->db->get('gallery_albums');
        return $query->result();
    }

    //get albums by lang
    public function get_albums_by_lang($lang_id)
    {
        $this->db->where('lang_id', $lang_id);
        $query = $this->db->get('gallery_albums');
        return $query->result();
    }

    //get album category count
    public function get_album_category_count($album_id)
    {
        $this->db->where('album_id', $album_id);
        $this->db->where('lang_id', $this->selected_lang->id);
        $query = $this->db->get('gallery_categories');
        return $query->num_rows();
    }

    //get album
    public function get_album($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('gallery_albums');
        return $query->row();
    }

    //delete album
    public function delete_album($id)
    {
        $album = $this->get_album($id);
        if (!empty($album)) {
            $this->db->where('id', $id);
            return $this->db->delete('gallery_albums');
        } else {
            return false;
        }
    }

}
