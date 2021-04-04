<?php defined('BASEPATH') or exit('No direct script access allowed');

class Rss_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'feed_name' => $this->input->post('feed_name', true),
            'feed_url' => $this->input->post('feed_url', true),
            'post_limit' => $this->input->post('post_limit', true),
            'category_id' => $this->input->post('category_id', true),
            'image_saving_method' => $this->input->post('image_saving_method', true),
            'generate_keywords_from_title' => $this->input->post('generate_keywords_from_title', true),
            'auto_update' => $this->input->post('auto_update', true),
            'read_more_button' => $this->input->post('read_more_button', true),
            'read_more_button_text' => $this->input->post('read_more_button_text', true),
            'add_posts_as_draft' => $this->input->post('add_posts_as_draft', true)
        );
        return $data;
    }

    //add feed
    public function add_feed()
    {
        $data = $this->input_values();
        $subcategory_id = $this->input->post('subcategory_id', true);
        if (!empty($subcategory_id)) {
            $data['category_id'] = $subcategory_id;
        }
        $data["is_cron_updated"] = 0;
        $data["user_id"] = $this->auth_user->id;
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('rss_feeds', $data);
    }

    //update feed
    public function update_feed($id)
    {
        $feed = $this->get_feed($id);
        if (!empty($feed)) {
            $data = $this->input_values();

            $subcategory_id = $this->input->post('subcategory_id', true);
            if (!empty($subcategory_id)) {
                $data['category_id'] = $subcategory_id;
            }

            $this->db->where('id', $feed->id);
            return $this->db->update('rss_feeds', $data);
        } else {
            return false;
        }
    }

    //update feed posts button
    public function update_feed_posts_button($feed_id)
    {
        $feed = $this->get_feed($feed_id);
        if (!empty($feed)) {
            $posts = $this->post_admin_model->get_posts_by_feed_id($feed_id);
            if (!empty($posts)) {
                foreach ($posts as $post) {
                    $data = array(
                        'show_post_url' => $feed->read_more_button
                    );
                    $this->db->where('id', $post->id);
                    $this->db->update('posts', $data);
                }
            }
        }
    }

    //get feed
    public function get_feed($id)
    {
        $sql = "SELECT * FROM rss_feeds WHERE id = ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->row();
    }

    //get feeds
    public function get_feeds()
    {
        $query = $this->db->query("SELECT * FROM rss_feeds");
        return $query->result();
    }

    //get feeds cron
    public function get_feeds_cron()
    {
        $query = $this->db->query("SELECT * FROM rss_feeds WHERE auto_update = 1 ORDER BY is_cron_updated, id LIMIT 3");
        return $query->result();
    }

    //get feeds not updated
    public function get_feeds_not_updated()
    {
        $query = $this->db->query("SELECT * FROM rss_feeds WHERE is_cron_updated = 0");
        return $query->result();
    }

    //get feed posts
    public function get_feed_posts($feed_id)
    {
        $sql = "SELECT * FROM feed_posts WHERE feed_id =  ?";
        $query = $this->db->query($sql, array(clean_number($feed_id)));
        return $query->result();
    }

    //delete feed
    public function delete_feed($id)
    {
        $feed = $this->get_feed($id);
        if (!empty($feed)) {
            $this->db->where('id', $feed->id);
            return $this->db->delete('rss_feeds');
        }
        return false;
    }

    //add rss feed posts
    public function add_feed_posts($feed_id)
    {
        $this->load->library('rss_parser');
        $feed = $this->get_feed($feed_id);
        if (!empty($feed)) {
            $response = $this->rss_parser->get_feeds($feed->feed_url);
            $i = 0;
            if (!empty($response)) {
                foreach ($response as $item) {
                    if ($feed->post_limit == $i) {
                        break;
                    }
                    $title = $this->character_convert($item->get_title());
                    $description = $this->character_convert($item->get_description());
                    $content = $this->character_convert($item->get_content());
                    $title_hash = md5($title);
                    if ($this->post_admin_model->check_post_exists($title, $title_hash) == false) {
                        $data = array();
                        $data['lang_id'] = $feed->lang_id;
                        $data['title'] = $title;
                        $data['title_slug'] = str_slug($title);
                        $data['title_hash'] = $title_hash;
                        $data['summary'] = strip_tags($description);
                        if (empty($data['summary'])) {
                            $summary = trim(strip_tags($content));
                            $data['summary'] = character_limiter($summary, 240, '...');
                        }
                        $data['content'] = $content;
                        $data['keywords'] = generate_keywords($data['title']);
                        $data['user_id'] = $feed->user_id;
                        $data['category_id'] = $feed->category_id;
                        $data['is_slider'] = 0;
                        $data['is_picked'] = 0;
                        $data['hit'] = 0;
                        $data['slider_order'] = 1;
                        $data['optional_url'] = "";
                        $data['post_type'] = "post";
                        $data['video_url'] = "";
                        $data['video_embed_code'] = "";
                        $data['image_url'] = "";
                        $data['need_auth'] = 0;
                        $data['feed_id'] = $feed->id;
                        $data['post_url'] = $item->get_link();
                        $data['show_post_url'] = $feed->read_more_button;
                        $data['visibility'] = 1;
                        if ($feed->add_posts_as_draft == 1) {
                            $data['status'] = 0;
                        } else {
                            $data['status'] = 1;
                        }
                        $data['created_at'] = date('Y-m-d H:i:s');
                        //add image
                        if ($feed->image_saving_method == "download") {
                            $data_image = $this->rss_parser->get_image($item, true);
                            if (!empty($data_image) && is_array($data_image)) {
                                $data['image_big'] = $data_image['image_big'];
                                $data['image_mid'] = $data_image['image_mid'];
                                $data['image_small'] = $data_image['image_small'];
                                $data['image_slider'] = $data_image['image_slider'];
                                $data['image_mime'] = "jpg";
                                $data_image['file_name'] = $data['title_slug'];
                                $data_image['user_id'] = $feed->user_id;
                                $this->db->insert('images', $data_image);
                            }
                        } else {
                            $data['image_url'] = $this->rss_parser->get_image($item, false);
                        }
                        $this->db->insert('posts', $data);
                        $this->post_admin_model->update_slug($this->db->insert_id());
                    }
                    $i++;
                }

                //delete dublicated posts
                $sql = "SELECT title_hash FROM posts GROUP BY title_hash HAVING COUNT(title_hash) > 1";
                $query = $this->db->query($sql);
                $post_title_hashs = $query->result();

                if (!empty($post_title_hashs)) {
                    foreach ($post_title_hashs as $title_hash) {
                        $this->db->where('title_hash', $title_hash->title_hash);
                        $this->db->order_by('id', 'DESC');
                        $this->db->limit(1);
                        $this->db->delete('posts');
                    }
                }

                return true;
            }
        }
    }

    public function character_convert($str)
    {
        $str = trim($str);
        $str = str_replace("&amp;", "&", $str);
        $str = str_replace("&lt;", "<", $str);
        $str = str_replace("&gt;", ">", $str);
        $str = str_replace("&quot;", '"', $str);
        $str = str_replace("&apos;", "'", $str);
        return $str;
    }

}
