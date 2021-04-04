<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Library feed reader
 */
require APPPATH . "third_party/simplepie/autoloader.php";
require APPPATH . "third_party/simplepie/idn/idna_convert.class.php";
require APPPATH . "third_party/rss-parser/Feed.php";
require APPPATH . "third_party/rss-parser/embed/autoloader.php";

// Load all required Feed classes
use YuzuruS\Rss\Feed;


class Rss_parser
{
    /**
     * @return  feeds
     **/
    public function get_feeds($url)
    {
        header('Content-type:text/html; charset=utf-8');
        $feed = new SimplePie();
        $feed->set_feed_url($url);
        $feed->enable_cache(false);
        $feed->init();
        $feed->handle_content_type();
        return $feed->get_items();
    }

    //get image
    public function get_image($item, $download = false)
    {
        if ($download == true) {
            //download image
            $ci =& get_instance();
            $ci->load->model('upload_model');
            $data = array(
                'image_big' => "",
                'image_mid' => "",
                'image_small' => "",
                'image_slider' => ""
            );
            $img_url = $this->get_image_url_from_feed($item);
            if (empty($img_url)) {
                return $data;
            }
            $save_to = FCPATH . "uploads/temp/temp.jpg";
            @copy($img_url, $save_to);
            if (!empty($save_to) && file_exists($save_to)) {
                $data['image_big'] = $ci->upload_model->post_big_image_upload($save_to);
                $data['image_mid'] = $ci->upload_model->post_mid_image_upload($save_to);
                $data['image_small'] = $ci->upload_model->post_small_image_upload($save_to);
                $data['image_slider'] = $ci->upload_model->post_slider_image_upload($save_to);
                @unlink($save_to);
                return $data;
            }
        } else {
            return $this->get_image_url_from_feed($item);
        }
    }

    //get image URL from feed
    public function get_image_url_from_feed($item)
    {
        //enclosure image
        $img_url = $this->get_post_image_from_enclosure($item);
        if (!empty($img_url) && (strpos($img_url, 'http') !== false)) {
            return $img_url;
        }

        //og image
        $img_url = $this->get_image_from_og($item);
        if (!empty($img_url) && (strpos($img_url, 'http') !== false)) {
            return $img_url;
        }

        //text image
        $img_url = "";
        $images = $this->get_image_from_text($item);
        if (!empty($images)) {
            $img_url = @$images[0];
        }
        if (!empty($img_url) && (strpos($img_url, 'http') !== false)) {
            return $img_url;
        }

        //embed og image
        $img_url = $this->get_image_from_embed_og($item);
        if (!empty($img_url) && (strpos($img_url, 'http') !== false)) {
            return $img_url;
        }

        return null;
    }

    //get post image from enclosure
    public function get_post_image_from_enclosure($item)
    {
        $img_url = "";
        if (!empty($item->get_enclosure())) {
            if (!empty($item->get_enclosure()->get_link())) {
                $img_url = $item->get_enclosure()->get_link();
            }
        }
        return $img_url;
    }

    //get post image from og tag
    public function get_image_from_og($item)
    {
        if (!empty($item->get_link())) {
            $meta_og_img = null;
            $response = Feed::httpRequest($item->get_link(), NULL, NULL, NULL);
            if (!empty($response)) {
                $html = new DOMDocument();
                @$html->loadHTML($response);
                foreach ($html->getElementsByTagName('meta') as $meta) {
                    if ($meta->getAttribute('property') == 'og:image') {
                        $meta_og_img = $meta->getAttribute('content');
                    }
                }
            }
            return $meta_og_img;
        }
        return "";
    }

    //get post image from description
    public function get_image_from_text($item)
    {
        try {
            $text = $item->get_description();
            return Feed::getImgFromText($text);
        } catch (Exception $e) {
            return false;
        }
    }

    //get post image from og tag embed
    public function get_image_from_embed_og($item)
    {
        try {
            $og_img = "";
            if (!empty($item->get_link())) {
                $og_img = Feed::getImgFromOg($item->get_link());
            }
            return $og_img;
        } catch (Exception $e) {
            return false;
        }
    }

}