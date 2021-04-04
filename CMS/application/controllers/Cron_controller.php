<?php defined('BASEPATH') or exit('No direct script access allowed');

class Cron_controller extends Home_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Update Sitemap
     */
    public function update_sitemap()
    {
        $this->load->model('sitemap_model');
        $this->sitemap_model->update_sitemap();
    }

    /**
     * Check Feed Posts
     */
    public function check_feed_posts()
    {
        //load the library
        $this->load->library('rss_parser');

        //unset all feeds
        $feeds_not_updated = $this->rss_model->get_feeds_not_updated();
        if (empty($feeds_not_updated)) {
            //update feeds
            $this->db->update('rss_feeds', ['is_cron_updated' => 0]);
        }

        //add posts
        $feeds = $this->rss_model->get_feeds_cron();
        if (!empty($feeds)) {
            foreach ($feeds as $feed) {
                if (!empty($feed->feed_url)) {
                    $this->rss_model->add_feed_posts($feed->id);
                    //update feed
                    $data = array(
                        'is_cron_updated' => 1
                    );
                    $this->db->where('id', $feed->id);
                    $this->db->update('rss_feeds', $data);
                }
            }
            reset_cache_data_on_change();
        }


        echo "Feeds have been checked.";
    }
}
