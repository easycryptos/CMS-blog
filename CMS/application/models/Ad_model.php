<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ad_model extends CI_Model
{
    public function input_values()
    {
        $data = array(
            'ad_code_728' => $this->input->post('ad_code_728', false),
            'ad_code_468' => $this->input->post('ad_code_468', false),
            'ad_code_234' => $this->input->post('ad_code_234', false),
        );

        return $data;
    }

    public function input_url_values()
    {
        $data = array(
            'url_ad_code_728' => $this->input->post('url_ad_code_728', false),
            'url_ad_code_468' => $this->input->post('url_ad_code_468', false),
            'url_ad_code_234' => $this->input->post('url_ad_code_234', false),
        );

        return $data;
    }

    public function update_ad_spaces($ad_space)
    {
        $data = $this->input_values();
        $data_url = $this->input_url_values();

        if ($ad_space == "sidebar_top" || $ad_space == "sidebar_bottom") {

            $data["ad_code_300"] = $this->input->post('ad_code_300', false);
            $url_ad_code_300 = $this->input->post('url_ad_code_300', false);

            $this->load->model('upload_model');
            $path = $this->upload_model->ad_upload('file_ad_code_300');
            if (!empty($path)) {
                $data["ad_code_300"] = $this->create_ad_code($url_ad_code_300, $path);
            }

        } else {

            $this->load->model('upload_model');
            $path = $this->upload_model->ad_upload('file_ad_code_728');
            if (!empty($path)) {
                $data["ad_code_728"] = $this->create_ad_code($data_url["url_ad_code_728"], $path);
            }
            $path = $this->upload_model->ad_upload('file_ad_code_468');
            if (!empty($path)) {
                $data["ad_code_468"] = $this->create_ad_code($data_url["url_ad_code_468"], $path);
            }
        }

        $this->load->model('upload_model');
        $path = $this->upload_model->ad_upload('file_ad_code_234');
        if (!empty($path)) {
            $data["ad_code_234"] = $this->create_ad_code($data_url["url_ad_code_234"], $path);
        }

        $this->db->where('ad_space', $ad_space);
        return $this->db->update('ad_spaces', $data);

    }

    //get ads
    public function get_ads()
    {
        $query = $this->db->get('ad_spaces');
        return $query->result();
    }

    //get ad codes
    public function get_ad_codes($ad_space)
    {
        $this->db->where('ad_space', $ad_space);
        $query = $this->db->get('ad_spaces');
        return $query->row();
    }

    //create ad code
    public function create_ad_code($url, $image_path)
    {
        return '<a href="' . $url . '"><img src="' . base_url() . $image_path . '" alt=""></a>';
    }

	//update google adsense code
	public function update_google_adsense_code()
	{
		$data = array(
			'google_adsense_code' => $this->input->post('google_adsense_code', false)
		);
		$this->db->where('id', 1);
		return $this->db->update('general_settings', $data);
	}

}
