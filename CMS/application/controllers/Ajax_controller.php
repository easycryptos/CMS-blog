<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ajax_controller extends Home_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Run Internal Cron
     */
    public function run_internal_cron()
    {
        //delete old sessions
        $this->settings_model->delete_old_sessions();

        //add last update
        $this->db->where('id', 1);
        $this->db->update('general_settings', ['last_cron_update' => date('Y-m-d H:i:s')]);
    }
}
