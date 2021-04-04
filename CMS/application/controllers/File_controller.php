<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_controller extends Admin_Core_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->auth_check) {
			exit();
		}
		$this->file_count = 60;
		$this->file_per_page = 60;
	}

	/*
	*------------------------------------------------------------------------------------------
	* IMAGES
	*------------------------------------------------------------------------------------------
	*/

	/**
	 * Upload Image File
	 */
	public function upload_image_file()
	{
		$this->file_model->upload_image();
	}

	/**
	 * Get Images
	 */
	public function get_images()
	{
		$images = $this->file_model->get_images($this->file_count);
		$this->print_images($images);
	}

	/**
	 * Select Image File
	 */
	public function select_image_file()
	{
		$file_id = $this->input->post('file_id', true);

		$file = $this->file_model->get_image($file_id);
		if (!empty($file)) {
			echo base_url() . $file->image_mid;
		}
	}

	/**
	 * Laod More Images
	 */
	public function load_more_images()
	{
		$min = $this->input->post('min', true);
		$images = $this->file_model->get_more_images($min, $this->file_per_page);
		$this->print_images($images);
	}

	/**
	 * Search Images
	 */
	public function search_image_file()
	{
		$search = trim($this->input->post('search', true));
		$images = $this->file_model->search_images($search);
		$this->print_images($images);
	}

	/**
	 * Print Images
	 */
	public function print_images($images)
	{
		foreach ($images as $image):
			echo '<div class="col-file-manager" id="img_col_id_' . $image->id . '">';
			echo '<div class="file-box" data-file-id="' . $image->id . '" data-file-path="' . $image->image_mid . '" data-file-path-editor="' . $image->image_big . '">';
			echo '<div class="image-container">';
			echo '<img src="' . base_url() . $image->image_slider . '" alt="" class="img-responsive">';
			echo '</div>';
			if (!empty($image->file_name)):
				echo '<span class="file-name">' . limit_character($image->file_name . "." . $image->image_mime, 25, "..") . '</span>';
			endif;
			echo '</div> </div>';
		endforeach;
	}

	/**
	 * Delete File
	 */
	public function delete_image_file()
	{
		$file_id = $this->input->post('file_id', true);
		$this->file_model->delete_image($file_id);
	}

	/*
	*------------------------------------------------------------------------------------------
	* FILES
	*------------------------------------------------------------------------------------------
	*/

	/**
	 * Upload File
	 */
	public function upload_file()
	{
		$this->file_model->upload_file();
	}

	/**
	 * Get Files
	 */
	public function get_files()
	{
		$files = $this->file_model->get_files($this->file_count);
		$this->print_files($files);
	}

	/**
	 * Laod More Files
	 */
	public function load_more_files()
	{
		$min = $this->input->post('min', true);
		$files = $this->file_model->get_more_files($min, $this->file_per_page);
		$this->print_files($files);
	}

	/**
	 * Search Files
	 */
	public function search_file()
	{
		$search = trim($this->input->post('search', true));
		$files = $this->file_model->search_files($search);
		$this->print_files($files);
	}

	/**
	 * Print Files
	 */
	public function print_files($files)
	{
		foreach ($files as $file):
			echo '<div class="col-file-manager" id="file_col_id_' . $file->id . '">';
			echo '<div class="file-box" data-file-id="' . $file->id . '" data-file-name="' . $file->file_name . '">';
			echo '<div class="image-container icon-container">';
			echo '<div class="file-icon file-icon-lg" data-type="' . @pathinfo($file->file_name, PATHINFO_EXTENSION) . '"></div>';
			echo '</div>';
			echo '<span class="file-name">' . limit_character($file->file_name, 25, "..") . '</span>';
			echo '</div> </div>';
		endforeach;
	}

	/**
	 * Delete File
	 */
	public function delete_file()
	{
		$file_id = $this->input->post('file_id', true);
		$this->file_model->delete_file($file_id);
	}
}
