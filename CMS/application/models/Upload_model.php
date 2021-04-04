<?php
defined('BASEPATH') or exit('No direct script access allowed');

//include image resize library
require_once APPPATH . "third_party/intervention-image/vendor/autoload.php";

use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;

class Upload_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->quality = 85;
    }

    //upload temp image
    public function upload_temp_image($file_name, $response)
    {
        if (isset($_FILES[$file_name])) {
            if (empty($_FILES[$file_name]['name'])) {
                return null;
            }
        }
        $config['upload_path'] = './uploads/temp/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['file_name'] = 'img_temp_' . generate_unique_id();
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($file_name)) {
            $data = array('upload_data' => $this->upload->data());
            if (isset($data['upload_data']['full_path'])) {
                if ($response == 'array') {
                    return $data['upload_data'];
                } else {
                    return $data['upload_data']['full_path'];
                }
            }
            return null;
        } else {
            return null;
        }
    }

    //post gif image upload
    public function post_gif_image_upload($file_name)
    {
        $directory = $this->create_upload_directory('images');
        rename(FCPATH . 'uploads/temp/' . $file_name, FCPATH . 'uploads/images/' . $directory . $file_name);
        return 'uploads/images/' . $directory . $file_name;
    }

    //post big image upload
    public function post_big_image_upload($path)
    {
        $new_name = $this->create_upload_directory('images') . 'image_750x_' . uniqid() . '.jpg';
        $new_path = 'uploads/images/' . $new_name;
        $img = Image::make($path)->orientate();
        $img->resize(750, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img->save(FCPATH . $new_path, $this->quality);
        return $new_path;
    }

    //post mid image upload
    public function post_mid_image_upload($path)
    {
        $new_name = $this->create_upload_directory('images') . 'image_750x415_' . uniqid() . '.jpg';
        $new_path = 'uploads/images/' . $new_name;
        $img = Image::make($path)->orientate();
        $img->fit(750, 415);
        $img->save(FCPATH . $new_path, $this->quality);
        return $new_path;
    }

    //post small image upload
    public function post_small_image_upload($path)
    {
        $new_name = $this->create_upload_directory('images') . 'image_100x75_' . uniqid() . '.jpg';
        $new_path = 'uploads/images/' . $new_name;
        $img = Image::make($path)->orientate();
        $img->fit(100, 75);
        $img->save(FCPATH . $new_path, $this->quality);
        return $new_path;
    }

    //post slider image upload
    public function post_slider_image_upload($path)
    {
        $new_name = $this->create_upload_directory('images') . 'image_650x433_' . uniqid() . '.jpg';
        $new_path = 'uploads/images/' . $new_name;
        $img = Image::make($path)->orientate();
        $img->fit(650, 433);
        $img->save(FCPATH . $new_path, $this->quality);
        return $new_path;
    }

    //gallery big image upload
    public function gallery_big_image_upload($path)
    {
        $new_name = $this->create_upload_directory('gallery') . 'image_1920x_' . uniqid() . '.jpg';
        $new_path = 'uploads/gallery/' . $new_name;
        $img = Image::make($path)->orientate();
        $img->resize(1920, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img->save(FCPATH . $new_path, $this->quality);
        return $new_path;
    }

    //gallery small image upload
    public function gallery_small_image_upload($path)
    {
        $new_name = $this->create_upload_directory('gallery') . 'image_500x_' . uniqid() . '.jpg';
        $new_path = 'uploads/gallery/' . $new_name;
        $img = Image::make($path)->orientate();
        $img->resize(500, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save(FCPATH . $new_path, $this->quality);
        return $new_path;
    }

    //gallery gif image upload
    public function gallery_gif_image_upload($file_name)
    {
        $directory = $this->create_upload_directory('gallery');
        rename(FCPATH . 'uploads/temp/' . $file_name, FCPATH . 'uploads/gallery/' . $directory . $file_name);
        return 'uploads/gallery/' . $directory . $file_name;
    }

    //logo image upload
    public function logo_upload($file_name)
    {
        $config['upload_path'] = './uploads/logo/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['file_name'] = 'logo_' . uniqid();
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($file_name)) {
            $data = array('upload_data' => $this->upload->data());
            if (isset($data['upload_data']['full_path'])) {
                return 'uploads/logo/' . $data['upload_data']['file_name'];
            }
            return null;
        } else {
            return null;
        }
    }

    //favicon image upload
    public function favicon_upload($file_name)
    {
        $config['upload_path'] = './uploads/logo/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['file_name'] = 'favicon_' . uniqid();
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($file_name)) {
            $data = array('upload_data' => $this->upload->data());
            if (isset($data['upload_data']['full_path'])) {
                return 'uploads/logo/' . $data['upload_data']['file_name'];
            }
            return null;
        } else {
            return null;
        }
    }

    //avatar image upload
    public function avatar_upload($user_id, $path)
    {
        $new_name = 'avatar_' . $user_id . '_' . uniqid() . '.jpg';
        $new_path = 'uploads/profile/' . $new_name;
        $img = Image::make($path)->orientate();
        $img->fit(200, 200);
        $img->save(FCPATH . $new_path, $this->quality);
        return $new_path;
    }

    //ad upload
    public function ad_upload($file_name)
    {
        $config['upload_path'] = './uploads/blocks/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['file_name'] = 'block_' . uniqid();
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($file_name)) {
            $data = array('upload_data' => $this->upload->data());
            if (isset($data['upload_data']['full_path'])) {
                return 'uploads/blocks/' . $data['upload_data']['file_name'];
            }
            return null;
        } else {
            return null;
        }
    }

    //upload file
    public function upload_file($file_name)
    {
        $name = @pathinfo(@$_FILES[$file_name]['name'], PATHINFO_FILENAME);
        $name = str_slug($name);
        if (empty($name)) {
            $name = "file_" . uniqid();
        }
        $config['upload_path'] = './uploads/files/';
        $config['allowed_types'] = '*';
        $config['file_name'] = $name;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($file_name)) {
            $data = array('upload_data' => $this->upload->data());
            if (isset($data['upload_data']['full_path'])) {
                return $data['upload_data']['file_name'];
            }
            return null;
        } else {
            return null;
        }
    }

    //get file original name
    public function get_file_original_name($data)
    {
        if (!empty($data['client_name'])) {
            return pathinfo($data['client_name'], PATHINFO_FILENAME);
        }
        return '';
    }

    //delete temp image
    public function delete_temp_image($path)
    {
        if (file_exists($path)) {
            @unlink($path);
        }
    }

    //create upload directory
    public function create_upload_directory($folder)
    {
        $directory = date("Ym");
        $directory_path = FCPATH . 'uploads/' . $folder . '/' . $directory . '/';

        //If the directory doesn't already exists.
        if (!is_dir($directory_path)) {
            //Create directory.
            @mkdir($directory_path, 0755, true);
        }
        //add index.html if does not exist
        if (!file_exists($directory_path . "index.html")) {
            @copy(FCPATH . "uploads/index.html", $directory_path . "index.html");
        }
        return $directory . "/";
    }
}
